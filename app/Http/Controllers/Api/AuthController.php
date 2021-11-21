<?php

namespace App\Http\Controllers\Api;
use App\Http\Repositories\Eloquent\AuthRepo;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\ResetCodeRequest;
use App\Http\Requests\ResetRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthProfileImageRequest;
use App\Http\Requests\Api\AuthProfileRequest;
use App\Http\Requests\Api\FCMRequest;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SearchResource;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\PaginateRequest;

use App\Mail\Password;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $repo;

    public function __construct(AuthRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new User();
        $columns = Schema::getColumnListing($model->getTable());
        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);
        }

        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? UserResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ],  __('app.data_returned_successfully'));
    }
    public function forgotEmail(ResetRequest $request)
    {
       try {

            $email=$request->email;
            $user=User::where('email',$email)->first();
            if($user){
                $code=$this->repo->generateRandomString(6);
                Mail::to($email)->send(new Password($code));
                User::where("email", $request->email)->update([
                    "reset_code" => $code
                ]);
            }

            return responseSuccess([], 'Reset password link sent on your email id.');
        } catch (\Swift_TransportException $ex) {
            return responseFail($ex->getMessage(), 400);
        } catch (\Exception $ex) {
            return responseFail($ex->getMessage(), 400);
        }
    }

    public function forgot(ResetRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $otpCode = $this->repo->generateRandomString(4);
                User::where("email", $request->email)->update([
                    "reset_code" => $otpCode
                ]);
                $message = "Your Reset Password OTP Code is " . $otpCode;
                    return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);

                // $smsResult = $this->repo->sendSMS($request->phone, $message);
                // if ($smsResult->getStatusCode() != 200 || $smsResult["code"] != 1901) {
                //     return responseFail("Cannot send reset code please try again later", 400);
                // } else {
                //     return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);
                // }
            } else {

                return responseFail("Your number not found please register first", 400);
            }
        } catch (\Exception $ex) {
            return responseFail($ex->getMessage(), 400);
        }
    }

    public function checkcode(ResetRequest $request)
    {
        try {

            $found = User::where("email", $request->email)->where("reset_code", $request->code)->first();

            if ($found) {
                return responseSuccess([], 'Success code is correct', 200);
            }
            return responseFail("Error Code you enter not correct", 400);
        } catch (\Exception $ex) {
            return responseFail($ex->getMessage(), 400);
        }
    }

    public function reset(ResetCodeRequest $request)
    {
        try {
            $user = User::where("reset_code", $request->reset_code)->update([
                'password' => Hash::make($request->password),
            ]);
            if ($user) {
                $user = User::where("reset_code", $request->reset_code)->update([
                    'reset_code' => null,
                ]);
                return responseSuccess([], __('app.data_Updated_successfully'), 200);
            } else {
                return responseFail("Cannot reset  password please try again later", 400);
            }
        } catch (\Exception $ex) {
            return responseFail($ex->getMessage(), 400);
        }
    }

    public function login(AuthLoginRequest $request)
    {
        return $this->repo->login($request->all());
    }

    public function register(AuthRegisterRequest $request)
    {
        $data = $request->all();

        $data = $this->repo->register($data);

        if ($data) {
            return $this->repo->login($request->all());
        } else {
            return responseFail("Cannot Add user", 401);
        }
    }

    public function updateFcmToken(FCMRequest $token)
    {
        $user = User::find(auth()->user()->id);
        if ($user) {
            $user->update(['fcm_token' => $token->token]);
            return responseSuccess([], __('app.data_Updated_successfully'));

        }
        return responseFail("Cannot send Notification", 401);
    }

    public function profile(AuthProfileRequest $request)
    {

        $currentUser = $this->repo->findOrFail(auth()->user()->id);

        $data = $this->repo->update($request->all(), $currentUser);

        if ($data) {
            return responseSuccess(new UserResource($currentUser->refresh()), __('app.data_Updated_successfully'));
        } else {
            return responseFail("Cannot Update user", 401);
        }
    }

    public function profileImage(AuthProfileImageRequest $request)
    {

        $currentUser = $this->repo->findOrFail(auth()->user()->id);
        $file = request()->file('photo');
        $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/users/', $fileName);
        $path = url('/storage') . '/' . str_replace('public/', '', $path);
        $input['image'] = $fileName;

        $data = $this->repo->update($input, $currentUser);

        if ($data) {
            return responseSuccess(new UserResource($currentUser->refresh()), __('app.data_Updated_successfully'));
        } else {
            return responseFail("Cannot Update user", 401);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $currentUser = $this->repo->findOrFail(auth()->user()->id);
        $data = $this->repo->update(['password' => Hash::make($request->password)], $currentUser);
        if ($data) {
            return responseSuccess([], __('app.data_Updated_successfully'));
        } else {
            return responseFail("Cannot Update user", 401);
        }

    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function user()
    {
        $data = $this->repo->currentUser();
        if ($data) {
            return responseSuccess(new UserResource($data), 'retrieved data successfully');
        } else {
            return responseFail("Cannot find user", 401);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate();
            return responseSuccess([], 'User logged out successfully', 200);
        } catch (JWTException $exception) {
            return responseFail('Sorry, the user cannot be logged out', 400);
        }

    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    public function guard()
    {
        return auth('api')->guard();
    }
}

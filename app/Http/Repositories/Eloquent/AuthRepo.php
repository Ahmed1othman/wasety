<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\AuthRepoInterface;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepo extends AbstractRepo implements AuthRepoInterface
{
    use AuthenticatesUsers;

    protected function credentials(AuthLoginRequest $request)
    {
        return [
            'uid' => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    public function username()
    {
        return 'userName';
    }

    public function __construct()
    {

        parent::__construct(User::class);

    }

    public function login(array $data)
    {
        try {
            $user=User::where("email",$data['email'])->first();
            if($user && Hash::check($data['password'],$user->password)){
                if($user->type=='admin'){
                    return responseFail(__('You Don\'t have permission to login'), 403);
                }
                $userValid['email']=$data['email'];
                $userValid['password']=$data['password'];
                if (! $token = JWTAuth::attempt($userValid)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return $this->createNewToken($token);
            }else{
                return responseFail(__('could not find user'), 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'could_not_create_token',
            ], 500);
        }
    }


    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => new UserResource(auth()->user())
        ]);
    }

    public function logout($request)
    {

        return $request->user()->token()->revoke();
    }

    public function currentUser()
    {
        return Auth::user();
    }

    public function register(array $data)
    {
        unset($data['password_confirmation']);
        $data['password']= Hash::make($data['password']);
       return User::create($data);
    }

    public function sendEmail($message,$email)
    {
        // Send Email Code here ................
        return true;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\OfferRepo;
use App\Http\Requests\Api\OfferRequest;
use App\Http\Requests\Api\AcceptOfferRequest;
use App\Http\Requests\Api\HireOfferRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\OfferResource;
use App\Http\Resources\SearchResource;
use App\Models\NotificationApi;
use App\Models\Offer;
use App\Models\Project;
use App\Models\User;
use App\Notifications\Offer as NotificationsOffer;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

class OfferController extends Controller
{
    protected $repo;

    public function __construct(OfferRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(Request $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Offer();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? OfferResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], __('app.data_returned_successfully'));
    }

    public function get($id)
    {
        $data = $this->repo->findOrFail($id);

        return responseSuccess([
            'data' => new OfferResource($data),
        ], __('app.data_returned_successfully'));
    }

    public function store(OfferRequest $request)
    {

        try {
            if(info('due')){
                $dues=$request->value*(Float)info('due')/100;
            }else{
                $dues=$request->value;
            }
            $project=Project::findOrFail($request->project_id);
            $offer=Offer::where('user_id',auth()->id())->where('project_id',$request->project_id)->where('status','!=','rejected')->where('status','!=','canceld')->first();
            if(!$offer) {
                $input = [
                    'title' => $request->title,
                    'value' => $request->value,
                    'status' => 'pending',
                    'dues' => $dues,
                    'user_id' => auth()->id(),
                    'project_id' => $request->project_id,
                    'details' => $request->details,
                ];
                $data = $this->repo->create($input);

                if ($data) {
                    $row = new NotificationApi();
                    $row->type = "alert";
                    $row->title = __('admin/app.you_have_new_offer_for_your_project');
                    $row->data = $data;
                    $row->user_id = $project->user_id;
                    $row->save();
                    return responseSuccess(new OfferResource($data));
                } else {
                    return responseFail(__('app.some_thing_error'));
                }
            }else{
                return responseFail(__('app.you_cannot_create_more_than_one_offer_for_same_project'));
            }
        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }
    public function acceptOffer(AcceptOfferRequest $request)
    {
        try {
            $offer=$this->repo->findOrFail($request->id);
            $offer->status=$request->status;
            $offer->save();
            $project=Project::find($offer->project_id);
            if(!$project){
                  return responseFail(__('admin/app.project_not_available'));
            }
            if($request->status == 'accepted'){
                $project->status='implementation';
                $project->offer_id=$request->id;
                $project->save();
                Offer::where('project_id',$offer->project_id)->where('status','pending')->update(['status'=>'rejected']);
                $usersids=Offer::where('project_id',$offer->project_id)->where('status','pending')->pluck('user_id');

                for($i=0;$i<count($usersids);$i++) {
                    $row = new NotificationApi();
                    $row->type = "alert";
                    $row->title = __('admin/app.your_offer_has_been_rejectd');
                    $row->data = $offer;
                    $row->user_id = $usersids[$i];
                    $row->save();
                }
                $row = new NotificationApi();
                $row->type = "alert";
                $row->title = __('admin/app.your_offer_has_been_accepted');
                $row->data = $offer;
                $row->user_id = $offer->user_id;
                $row->save();
            $admin = User::where('type','admin')->where('active',1)->get();
            Notification::send($admin, new NotificationsOffer($offer->id,'implementation'));
            }
            return responseSuccess(new OfferResource($offer));

        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }
    public function hireOffer(HireOfferRequest $request)
    {

        try {
            $user=User::findOrfail($request->user_id);
            $project=Project::findOrfail($request->id);

            if(info('due')){
                $dues=$user->coin_price*$project->amount*(Float)info('due')/100;
            }else{
                $dues=$user->coin_price*$project->amount;
            }
            $offer=Offer::where('user_id',$request->user_id)->where('project_id',$request->id)->where('status','!=','rejected')->where('status','!=','canceld')->first();
            if(!$offer) {
                $input = [
                    'value' => $request->value,
                    'status' => 'accepted',
                    'dues' => $dues,
                    'user_id' => auth()->id(),
                    'project_id' => $request->project_id,
                    'details' => $request->details,
                ];
                $data = $this->repo->create($input);

                if ($data) {
                    $row = new NotificationApi();
                    $row->type = "alert";
                    $row->title = __('admin/app.you_are_hired_by_project');
                    $row->data = $project;
                    $row->user_id = $request->user_id;
                    $row->save();

                    $project->status='hire';
                    $project->offer_id=$request->id;
                    $project->save();
                    return responseSuccess(new OfferResource($data));
                } else {
                    return responseFail(__('app.some_thing_error'));
                }
            }else{
                return responseFail(__('app.you_cannot_hire_this_dealer_aready_created_offer_for_your_project'));
            }
        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }
    public function delearAcceptOffer(AcceptOfferRequest $request)
    {

        try {
            $offer=$this->repo->findOrFail($request->id);
            $offer->status=$request->status;
            $offer->save();
            $project=Project::find($offer->project_id);
            if($request->status == 'accepted'){
                $project->status='implementation';
                $project->save();
                $offer->status='accepted';
                $row = new NotificationApi();
                $row->type = "alert";
                $row->title = __('admin/app.your_offer_has_been_accepted');
                $row->data = $project;
                $row->user_id = $project->user_id;
                $row->save();
                $admin = User::where('type','admin')->where('active',1)->get();
                Notification::send($admin, new NotificationsOffer($offer->id,'implementation'));
            }
            return responseSuccess(new OfferResource($offer));
        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }


    public function update($id, OfferRequest $request)
    {
        try {

            $item = $this->repo->findOrFail($id);

            if(websiteInfo('due')){
                $dues=$request->value*(Float)websiteInfo('due')/100;
            }else{
                $dues=$request->value;
            }

            $input = [
                'title' => $request->title,
                'value' => $request->value,
                'dues' => $dues,
                'user_id' => auth()->id(),
                'project_id' => $request->project_id,
                'details' => $request->details,
            ];
            $data = $this->repo->update($input, $item);

            if ($data) {
                return responseSuccess(new OfferResource($item->refresh()), __('app.data_Updated_successfully'));
            } else {
                return responseFail(__('app.some_thing_error'));
            }
        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }

    public function bulkDelete(BulkDeleteRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $this->repo->bulkDelete($request->ids);
            if ($data) {

                DB::commit();
                return responseSuccess([], __('app.data_deleted_successfully'));
            } else {
                return responseFail(__('app.some_thing_error'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return responseFail(__('app.some_thing_error'));
        }
    }

    public function bulkRestore(BulkDeleteRequest $request)
    {
        try {
            $data = $this->repo->bulkRestore($request->ids);
            if ($data) {
                return responseSuccess([], __('app.data_restored_successfully'));
            } else {
                return responseFail(__('app.some_thing_error'));
            }
        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\ProjectRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\ProjectRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SearchResource;
use App\Models\Project;
use App\Notifications\Project as ProjectNotification;
use App\Models\User;
use App\Notifications\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class ProjectController extends Controller
{
    protected $repo;

    public function __construct(ProjectRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Project();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? ProjectResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ],  __('app.data_returned_successfully'));
    }

    public function get($Project)
    {
        $data = $this->repo->findOrFail($Project);

        return responseSuccess([
            'data' => new ProjectResource($data),
        ],  __('app.data_returned_successfully'));
    }

    public function store(ProjectRequest $request)
    {
        try{
            $data=[
                'title' => $request->title,
                'status' => 'pending',
                'amount' => $request->amount,
                'user_id' => auth()->id(),
                'description' => $request->description
            ];
            $file=request()->file('photo');
            if($file)
            {
                $data['photo'] = $this->repo->storeFile($file,'projects');
            }
            $data=$this->repo->create($data);

            if ($data) {
                $admin = User::where('type','admin')->where('active',1)->get();

                Notification::send($admin, new ProjectNotification($data->id,'request'));

                return responseSuccess(new ProjectResource($data), 'data saved successfully');
            } else {
                return responseFail(__('app.some_thing_error'));
            }
        } catch (\Exception $e) {
            return responseFail(__('app.some_thing_error'));
        }
    }

    public function update($project, ProjectRequest $request)
    {

        $item = $this->repo->findOrFail($project);
        if($item->user_id!=auth()->id()){
             return responseFail(__('app.   '));
        }
        $data=[
            'title' => $request->title??$request->title,
            'amount' => $request->amount??$request->amount,
            'description' => $request->description??$request->description
        ];
        if(request()->hasFile('photo')) {
            $file = request()->file('photo');
            if ($file) {
                File::delete('public/projects/images/' . $item->photo);
              $data['photo'] = $this->repo->storeFile($file,'projects');
            }
        }
            $data = $this->repo->update($data, $item);

        if ($data) {
        return responseSuccess(new ProjectResource($item->refresh()), __('app.data_Updated_successfully'));
        } else {
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
        DB::beginTransaction();
        try {
            $data = $this->repo->bulkRestore($request->ids);
            if ($data) {

                DB::commit();
                return responseSuccess([], __('app.data_restored_successfully'));
            } else {
                return responseFail(__('app.some_thing_error'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return responseFail(__('app.some_thing_error'));
        }
    }

}

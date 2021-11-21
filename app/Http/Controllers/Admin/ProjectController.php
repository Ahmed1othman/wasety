<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\ProjectRepo;
use App\Http\Requests\Admin\ProjectRequest ;
use App\Models\Project;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File as FacadesFile;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;
    protected $namespaceName;
    protected $modelName;



    public function __construct(ProjectRepo $repo)
    {
       $this->repo = $repo;
       $this->modelName = 'projects';
       $this->namespaceName = 'admin';

    }
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
       $data=$this->repo->getAll();
        $title=$this->modelName;
        return view($this->namespaceName.'.'.$this->modelName.'.index', compact('data','title'));
    }

    public function create()
    {

    }

    public function projectsRequest ()
    {

        $data=$this->repo->findWhere('status','pending');
        $title='projects_request';

        return view($this->namespaceName.'.'.$this->modelName.'.requests', compact('data','title'));
    }

    public function implementationProject ()
    {
        $data=$this->repo->findWhere('status','implementation');

        $title='projects_implementation';

        return view($this->namespaceName.'.'.$this->modelName.'.implementation', compact('data','title'));
    }

    public function deliveryProject ()
    {
        $data=$this->repo->findWhere('status','delivery');
        $title='projects_delivery';
        return view($this->namespaceName.'.'.$this->modelName.'.delivery', compact('data','title'));
    }

    public function historyProject ()
    {
        $data=Project::whereIn('status',['canceld','rejected','completed'])->get();
        $title='projects_history';
        return view($this->namespaceName.'.'.$this->modelName.'.history', compact('data','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request)
    {

      try {
            $data=$request->all();

            foreach($data as $key=>$val){
                $file=request()->file($key);
                if($file){
                    $data[$key]=$this->repo->storeFile($file,$this->modelName);
                }
            }
            $this->repo->create($data);
            session()->flash('Add', __('admin/app.success_message'));
            return redirect($this->modelName);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error',__('app.some_thing_error'));
        }
    }

    /**
     * update the Permission for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit($id)
    {

    }

    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(ProjectRequest $request,$id)
    {

        try {
            $data=$request->all();
            $item=$this->repo->findOrFail($request->id);

            foreach($data as $key=>$val){
                $file=request()->file($key);
                if($file){
                    FacadesFile::delete('public/'.$this->modelName.'/' . $item->photo);
                    $data[$key]=$this->repo->storeFile($file,$this->modelName);
                }
            }
            $this->repo->update($data,$item);
            session()->flash('Edit', __('admin/app.success_message'));
            return redirect($this->modelName);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error',__('app.some_thing_error'));
        }
    }

    public function changeStatus(Request $request)
    {
        try{
            $item=$this->repo->findOrFail($request->id);
            $data['active']=$request->active;
            $data= $this->repo->changeStatus($data,$item);
            if ($data) {
                $response = ['code' => 1, 'msg' => __('admin/app.success_message')];
            } else {
                $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
            }
            return json_encode($response);

       } catch (\Exception $e) {
           DB::rollback();
           $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
           return json_encode($response);
       }
    }
    public function adminChangeStatus($id,Request $request)
    {
        try{
            $item=$this->repo->findOrFail($id);
            $data['status']=$request->status;

            $data= $this->repo->changeStatus($data,$item);
            if ($data) {
                $response = ['code' => 1, 'msg' => __('admin/app.success_message')];

            } else {
                $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
            }
            return json_encode($response);

       } catch (\Exception $e) {
           DB::rollback();
           $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
           return json_encode($response);
       }
    }
    public function rejectProject($id)
    {
        try{
            $item=$this->repo->findOrFail($id);
            $data['status']='rejected';
            $data['active']=false;

            $data= $this->repo->changeStatus($data,$item);
            if ($data) {
                $response = ['code' => 1, 'msg' => __('admin/app.success_message')];

            } else {
                $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
            }
            return json_encode($response);

       } catch (\Exception $e) {
           DB::rollback();
           $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
           return json_encode($response);
       }
    }

    /**
     * Delete more than one permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $data=$this->repo->bulkDelete([$id]);
        if (!$data ) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }

    public function markAsRead($id,$status)
    {

        $userunreadNotifications = auth()->user()->unreadNotifications;

        foreach ($userunreadNotifications as $notification){
            if($id==$notification->id){
                $notification->markAsRead();
            }
        }

        return redirect()->route($this->modelName.'.'.$status);
    }

}



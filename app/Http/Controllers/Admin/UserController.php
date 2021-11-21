<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\UserRepo;
use App\Http\Requests\Api\AuthProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $repo;
    protected $namespaceName;
    protected $modelName;


    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
        $this->modelName = 'users';
        $this->namespaceName = 'admin';
    }

    public function index()
    {
        $data = $this->repo->getWhereOperand('type','!=','admin');
        $title = $this->modelName;
        return view($this->namespaceName . '.' . $this->modelName . '.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = User::where('status', '!=', 'acceptable')->get();
        $title = $this->modelName;
        return view($this->namespaceName . '.' . $this->modelName . '.Request user.requestusers', compact('data', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthenticatedSessionController $request)
    {
        try {
            $data = $request->all();
            foreach ($data as $key => $val) {
                $file = request()->file($key);
                if ($file) {
                    $data[$key] = $this->repo->storeFile($file, $this->modelName);
                }
            }
            $this->repo->create($data);
            session()->flash('Add', __('admin/app.success_message'));
            return redirect($this->modelName);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('app.some_thing_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $row = $this->repo->findOrFail($id);
        return view($this->namespaceName . '.' . $this->modelName . '.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthProfileRequest $request, $id)
    {
       try{
        $data=$request->all();
        $item=$this->repo->findOrFail($request->id);
        foreach($data as $key=>$val){
            $file=request()->file($key);
            if($file){
                File::delete('public/'.$this->modelName.'/' . $item->photo);
                $data[$key]=$this->repo->storeFile($file,$this->modelName);
            }
        }
        if($request->password){
            $data['password'] = Hash::make($request->password);
            unset($data['password_confirmation']);
        }
        $this->repo->update($data,$item);
        session()->flash('Add', __('admin/app.success_message'));
        return redirect($this->modelName);

       } catch (\Exception $e) {
           DB::rollback();
           $response = ['code' => 0, 'msg' => __('admin/app.some_thing_error')];
           return json_encode($response);
       }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->repo->bulkDelete([$id]);
        if (!$data) {
            return __('app.users.cannotdelete');
        }
        return 1;
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
 


}

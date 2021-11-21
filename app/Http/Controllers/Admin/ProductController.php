<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\ProductRepo;
use App\Http\Requests\Admin\ProductRequest ;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File as FacadesFile;

class ProductController extends Controller
{

    protected $repo;
    protected $namespaceName;
    protected $modelName;

    public function __construct(ProductRepo $repo)
    {
       $this->repo = $repo;
       $this->modelName = 'products';
       $this->namespaceName = 'admin';
    }

    public function index()
    {
       $data=$this->repo->getAll();
        $title=$this->modelName;
        return view($this->namespaceName.'.'.$this->modelName.'.index', compact('data','title'));
    }

    public function create()
    {

    }

    public function store(ProductRequest $request)
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

    public function update(ProductRequest $request,$id)
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

    public function destroy($id)
    {
        $data=$this->repo->bulkDelete([$id]);
        if (!$data ) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }



}



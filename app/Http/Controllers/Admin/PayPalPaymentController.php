<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\PaymentRepo;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Payment;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File as FacadesFile;

class PayPalPaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;


    public function __construct(PaymentRepo $repo)
    {

        $this->repo = $repo;

    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $data = $this->repo->getAll();
        return view('admin.payments.index', compact('data'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(PaymentRequest $request)
    {
        try{
            $input=$request->all();
            unset($input['_token']);

            foreach($input as $key=>$val){
                $payments=Payment::where('option',$key)->first();
                if(request()->hasFile($key)) {
                    $file = request()->file($key);
                    if ($file) {
                        if($payments){
                            FacadesFile::delete('public/payments/' . $payments->value);
                        }
                        $item['value'] =  $this->repo->storeFile($file,'payments');
                    }
                }else{
                    $item['value']=$val;
                }
                if($payments){
                    $data =$payments? $this->repo->update($item, $payments):$this->repo->create($item);
                }
             }

            if ($data) {
                session()->flash('Add', __('admin/app.success_message'));
                return redirect('payments');
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('danger', __('admin/app.some_thing_error'));
            return redirect('payments');
        }

    }

    /**
     * update the Permission for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit($payments)
    {

    }


    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(PaymentRequest $request, $id)
    {

        try{
            $front = $this->repo->findOrFail($id);

            if(request()->hasFile('value')) {
                $file = request()->file('value');
                if ($file) {
                    FacadesFile::delete('public/front/' . $front->value);
                    $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/front', $fileName);
                    $input['value'] =  $fileName;
                }
            }else{
                $input['value']=$request->value;
            }


            $data = $this->repo->update($input, $front);
            if ($data) {
                session()->flash('Add', __('admin/app.success_message'));
                return redirect('payments');
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('danger', __('admin/app.some_thing_error'));
            return redirect('payments');
        }

    }


    /**
     * Delete more than one permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($payments)
    {
        $payments = $this->repo->bulkDelete([$payments]);
        if (!$payments) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }


}



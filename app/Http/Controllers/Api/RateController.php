<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\RateRepo;
use App\Http\Requests\Api\RateRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\RateResource;
use App\Http\Resources\SearchResource;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Schema;

class RateController extends Controller
{
    protected $repo;

    public function __construct(RateRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(Request $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Rate();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? RateResource::collection($data) : SearchResource::collection($data),
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
            'data' => new RateResource($data),
        ], __('app.data_returned_successfully'));
    }

    public function store(RateRequest $request)
    {

        // try {
            $input = [
                'value' => $request->value,
                'message' => $request->message,
                'user_id' => auth()->id(),
                'rateable_id' => $request->id,
            ];

            if (strtolower($request->type) == "user") {
                $input['rateable_type'] = 'App\Models\User';
            }
            if (strtolower($request->type) == "project") {
                $input['rateable_type'] = 'App\Models\Project';
            }

            $fileUpload = request()->file('photo');
            if ($fileUpload) {
                $input['photo'] = $this->repo->storeFile($fileUpload, 'rates');
            }
            $data = $this->repo->create($input);

            $product = $input['rateable_type']::findorFail($data->rateable_id);
            if ($product) {
                $all_product_rates = 0;
                foreach ($product->rateable as $rate) {
                    $all_product_rates += $rate->value;
                }
                
                $product->rate = $all_product_rates / count($product->rateable);
                $product->save();
            }

            if ($data) {
                return responseSuccess(new RateResource($data));
            } else {
                return responseFail(__('app.some_thing_error'));
            }

        // } catch (\Exception $e) {
        //     return responseFail(__('app.some_thing_error'));
        // }

    }

    public function update($id, RateRequest $request)
    {
        $item = $this->repo->findOrFail($id);
        $input = [
            'value' => $request->value ?? $item->value,
            'message' => $request->message ?? $item->message,
            'rateable_id' => $request->id,
            'user_id' => auth()->id(),
        ];

        if ($request->type == "user") {
            $input['rateable_type'] = 'App\Models\User';
        }

        $fileUpload = request()->file('photo');
        if ($fileUpload) {
            FacadesFile::delete('public/rates/' . $item->photo);
            $input['photo'] = $this->repo->storeFile($fileUpload, 'rates');
        }
        $data = $this->repo->update($input, $item);

        if ($data) {
            return responseSuccess(new RateResource($item->refresh()), __('app.data_Updated_successfully'));
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

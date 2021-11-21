<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\ProductRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\ProductRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SearchResource;
use App\Models\Product;
use App\Notifications\Product as ProductNotification;
use App\Models\User;
use App\Notifications\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    protected $repo;

    public function __construct(ProductRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Product();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? ProductResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ],  __('app.data_returned_successfully'));
    }

    public function get($Product)
    {
        $data = $this->repo->findOrFail($Product);

        return responseSuccess([
            'data' => new ProductResource($data),
        ],  __('app.data_returned_successfully'));
    }

   
}

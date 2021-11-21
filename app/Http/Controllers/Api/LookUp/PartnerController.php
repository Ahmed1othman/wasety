<?php

namespace App\Http\Controllers\Api\LookUp;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\PartnerRepo;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\SearchResource;
use App\Models\Partner;
use Illuminate\Support\Facades\Schema;
class PartnerController extends Controller
{
    protected $repo;

    public function __construct(PartnerRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Partner();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? PartnerResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ],  __('app.data_returned_successfully'));
    }


}

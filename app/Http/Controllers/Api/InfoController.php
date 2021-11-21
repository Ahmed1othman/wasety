<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\InfoRepo;
use App\Http\Resources\InfoResource;
use App\Http\Resources\SearchResource;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InfoController extends Controller
{
    protected $repo;

    public function __construct(InfoRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Info();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);
        $infoResource=[];
            foreach($data as $info){
                if($info->type=='image'){
                    $infoResource[$info->option]= $info->value != null ? asset('storage/info/'.$info->value ) : null;
               }else{
                   $infoResource[$info->option]=$info->value;
                }
            }
        return responseSuccess([
            'data' => ($infoResource),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ],  __('app.data_returned_successfully'));
    }

}

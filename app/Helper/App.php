<?php

use App\Models\Info;

if (!function_exists('websiteInfo')) {
    function websiteInfo($key)
    {
       $info=Info::where('option',$key)->first();
        if($info){
            if($info->type=='image'){
                 return $info->value != null ? asset('storage/info/'.$info->value ) : null;
            }
            return $info->value;
        }
        return false;
    }

}


function responseSuccess($data = [], $msg = null, $code = 200)
{
    return response()->json([
        "success" => true,
        "message" => $msg,
        "data" => $data
    ], 200);
}



function responseFail( $error_msg = null , $code = 400, $result = null)
{
    return response()->json([
        "message" => $error_msg,
        "errors" => $result,
        "code"=>$code
    ], 400);
}


function responseValidation($errors = null, $code = 403)
{
    return response()->json([
        "status" => false,
        "errors" => $errors,
    ], 403);
}

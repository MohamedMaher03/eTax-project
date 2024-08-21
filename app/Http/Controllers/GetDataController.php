<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class GetDataController extends Controller
{
    public function getConfigurations(){
        $configurations = Configuration::all();
        
        return response()->json($configurations);
    }

    public function getConfigbyKey($key){
        $configuration = Configuration::where("key", $key)->first();
        if(!$configuration){
            return ApiResponse::notFound("Key not found");
        }
        return response()->json($configuration);
    }
}
<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Configuration;
use App\Models\Organization;
use App\Models\User;
use App\Models\Package;
use App\Models\UserReviser;

class LoadingController extends Controller
{
    public function getResource()
    {
        $users = User::all();
        $configurations = Configuration::all();
        $packages = Package::all();
        $organizations = Organization::all();
        $userRevisers = UserReviser::all();

        $resource = [
            [
                "key" => "users",
                "value"=> $users,
            ],
            [
                "key"=> "configurations",
                "value"=> $configurations,
            ],
            [
                "key"=> "packages",
                "value"=> $packages,
            ],
            [
                "key"=> "organizations",
                "value"=> $organizations,
            ],
            [
                "key"=> "userRevisers",
                "value"=> $userRevisers,
            ]];

        if (!$resource) {
            return ApiResponse::notFound('Resource Error: not found');
        }

        return response()->json($resource);
    }
}
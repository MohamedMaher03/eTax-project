<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function buyPackage($id)
    {
        $user = auth()->user();


        $package = Package::find($id);

        if(!$package){
            return response()->json([
               'status' => 'failed',
               'message' => 'Package not found'
            ],404);
        }
        $operationCount=$package->operations_count;

        $organization = Organization::where('user_id', $user->id)->first();
        if (!$organization) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Organization not found'
            ], 404);
        }
        //$organization=Organization::find(11);;
        $organizationCount=$organization->operations_count;
        $organizationCount+=$operationCount;
        $organization->update(['operations_count'=>$organizationCount]);
        return response()->json([
            'status' => 'success',
            'message' => 'Package buy successfully'
        ]);
    }
}

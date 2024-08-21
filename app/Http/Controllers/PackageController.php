<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Organization;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function getAllpackage(){
        $packages = Package::all();
        return response()->json([
            'packages'=>$packages
        ]);
    }
    public function buyPackage($id)
    {
        try {
            $user = auth()->user();

            $package = Package::find($id);
            if (!$package) {
                return ApiResponse::error('Package not found');
            }

            $organization = Organization::where('user_id', $user->id)->first();
            if (!$organization) {
                return ApiResponse::error('Organization not found');
            }

            $organization->operations_count += $package->operations_count;
            $organization->save();

            return ApiResponse::success('Package bought successfully');
        } catch (\Exception $e) {
            return ApiResponse::generalError();
        }
    }
}

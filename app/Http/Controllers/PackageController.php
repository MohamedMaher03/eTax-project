<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packages;

class PackageController extends Controller
{
    public function getAllData()
    {
        // get all data
        $package = Packages::all();

        // return data as json
        return response()->json($package);
    }
}

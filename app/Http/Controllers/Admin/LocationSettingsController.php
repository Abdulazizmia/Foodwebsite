<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationSettingsController extends Controller
{
    public function location_index()
    {
        return view('admin-views.business-settings.location-index');
    }

    public function location_setup(Request $request)
    {
        DB::table('branches')->updateOrInsert(['id' => 1], [
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
            'coverage' => $request['coverage'] ? $request['coverage'] : 0,
        ]);

        Toastr::success('Settings updated!');
        return back();
    }
}

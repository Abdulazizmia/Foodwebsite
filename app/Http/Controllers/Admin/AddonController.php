<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\AddOn;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $addons = AddOn::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $addons = new AddOn();
        }

        $addons = $addons->orderBy('name')->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.addon.index', compact('addons', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:add_ons',
        ], [
            'name.required' => 'Name is required!',
        ]);

        $addon = new AddOn();
        $addon->name = $request->name[array_search('en', $request->lang)];
        $addon->price = $request->price;
        $addon->save();

        $data = [];
        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                array_push($data, Array(
                    'translationable_type'  => 'App\Model\AddOn',
                    'translationable_id'    => $addon->id,
                    'locale'                => $key,
                    'key'                   => 'name',
                    'value'                 => $request->name[$index],
                ));
            }
        }
        if(count($data))
        {
            Translation::insert($data);
        }

        Toastr::success('Addon added successfully!');
        return back();
    }

    public function edit($id)
    {
        $addon = AddOn::withoutGlobalScopes()->with('translations')->find($id);
        return view('admin-views.addon.edit', compact('addon'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ], [
            'name.required' => 'Name is required!',
        ]);

        $addon = AddOn::find($id);
        $addon->name = $request->name[array_search('en', $request->lang)];
        $addon->price = $request->price;
        $addon->save();

        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                Translation::updateOrInsert(
                    ['translationable_type'  => 'App\Model\AddOn',
                        'translationable_id'    => $addon->id,
                        'locale'                => $key,
                        'key'                   => 'name'],
                    ['value'                 => $request->name[$index]]
                );
            }
        }
        Toastr::success('Addon updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $addon = AddOn::find($request->id);
        $addon->delete();
        Toastr::success('Addon removed!');
        return back();
    }
}

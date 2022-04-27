<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Attribute;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $attributes = Attribute::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $attributes = new Attribute();
        }


        $attributes = $attributes->orderBy('name')->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.attribute.index', compact('attributes', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Name is required!',
        ]);

        $attribute = new Attribute;
        $attribute->name = $request->name[array_search('en', $request->lang)];
        $attribute->save();

        $data = [];
        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                array_push($data, Array(
                    'translationable_type'  => 'App\Model\Attribute',
                    'translationable_id'    => $attribute->id,
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

        Toastr::success('Attribute added successfully!');
        return back();
    }

    public function edit($id)
    {
        $attribute = Attribute::withoutGlobalScopes()->with('translations')->find($id);
        return view('admin-views.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Name is required!',
        ]);

        $attribute = Attribute::find($id);
        $attribute->name = $request->name[array_search('en', $request->lang)];
        $attribute->save();

        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                Translation::updateOrInsert(
                    ['translationable_type'  => 'App\Model\Attribute',
                        'translationable_id'    => $attribute->id,
                        'locale'                => $key,
                        'key'                   => 'name'],
                    ['value'                 => $request->name[$index]]
                );
            }
        }

        Toastr::success('Attribute updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $attribute = Attribute::find($request->id);
        $attribute->delete();
        Toastr::success('Attribute removed!');
        return back();
    }
}

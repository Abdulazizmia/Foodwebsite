<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\Category;
use App\Model\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    function index()
    {
        $products = Product::orderBy('name')->get();
        $categories = Category::where(['parent_id'=>0])->orderBy('name')->get();
        return view('admin-views.banner.index', compact('products', 'categories'));
    }

    function list()
    {
        $banners=Banner::latest()->paginate(Helpers::getPagination());
        return view('admin-views.banner.list',compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ], [
            'title.required' => 'Title is required!',
        ]);

        $banner = new Banner;
        $banner->title = $request->title;
        if ($request['item_type'] == 'product') {
            $banner->product_id = $request->product_id;
        } elseif ($request['item_type'] == 'category') {
            $banner->category_id = $request->category_id;
        }
        $banner->image = Helpers::upload('banner/', 'png', $request->file('image'));
        $banner->save();
        Toastr::success('Banner added successfully!');
        return redirect('admin/banner/list');
    }

    public function edit($id)
    {
        $products = Product::orderBy('name')->get();
        $banner = Banner::find($id);
        $categories = Category::where(['parent_id'=>0])->orderBy('name')->get();
        return view('admin-views.banner.edit', compact('banner', 'products', 'categories'));
    }

    public function status(Request $request)
    {
        $banner = Banner::find($request->id);
        $banner->status = $request->status;
        $banner->save();
        Toastr::success('Banner status updated!');
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Title is required!',
        ]);

        $banner = Banner::find($id);
        $banner->title = $request->title;
        if ($request['item_type'] == 'product') {
            $banner->product_id = $request->product_id;
            $banner->category_id = null;
        } elseif ($request['item_type'] == 'category') {
            $banner->product_id = null;
            $banner->category_id = $request->category_id;
        }
        $banner->image = $request->has('image') ? Helpers::update('banner/', $banner->image,'png', $request->file('image')):$banner->image;
        $banner->save();
        Toastr::success('Banner updated successfully!');
        return redirect('admin/banner/list');
    }

    public function delete(Request $request)
    {
        $banner = Banner::find($request->id);
        Helpers::delete('banner/' . $banner['image']);
        $banner->delete();
        Toastr::success('Banner removed!');
        return back();
    }
}

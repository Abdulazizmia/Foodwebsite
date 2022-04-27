<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\PointTransitions;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function add_point(Request $request, $id)
    {
        User::where(['id' => $id])->increment('point', $request['point']);
        DB::table('point_transitions')->insert([
            'user_id' => $id,
            'description' => 'admin added this point',
            'type' => 'point_in',
            'amount' => $request['point'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if ($request->ajax()) {
            return response()->json([
                'updated_point' => User::where(['id' => $id])->first()->point
            ]);
        }
    }

    public function set_point_modal_data($id)
    {
        $customer = User::find($id);
        return response()->json([
            'view' => view('admin-views.customer.partials._add-point-modal-content', compact('customer'))->render()
        ]);
    }

    public function customer_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customers = User::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $customers = new User();
        }

        $customers = $customers->with(['orders'])->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.customer.list', compact('customers', 'search'));
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $customers = User::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })->get();
        return response()->json([
            'view' => view('admin-views.customer.partials._table', compact('customers'))->render(),
        ]);
    }

    public function view($id)
    {
        $customer = User::find($id);
        if (isset($customer)) {
            $orders = Order::latest()->where(['user_id' => $id])->paginate(Helpers::getPagination());
            return view('admin-views.customer.customer-view', compact('customer', 'orders'));
        }
        Toastr::error('Customer not found!');
        return back();
    }

    public function AddPoint(Request $request, $id)
    {
        $point = User::where(['id' => $id])->first()->point;

        $requestPoint = $request['point'];
        $point += $requestPoint;
        // dd($point);
        User::where(['id' => $id])->update([
            'point' => $point,
        ]);
        $p_trans = [
            'user_id' => $request['id'],
            'description' => 'admin Added point',
            'type' => 'point_in',
            'amount' => $request['point'],
            'created_at' => now(),
            'updated_at' => now(),

        ];
        DB::table('point_transitions')->insert($p_trans);

        Toastr::success('Point Added Successfully !');
        return back();

    }

    public function transaction(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $customer_ids = User::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%");
                }
            })->pluck('id')->toArray();

            $transition = PointTransitions::whereIn('id', $customer_ids);
            $query_param = ['search' => $request['search']];
        }else{
            $transition = new PointTransitions();
        }

        // $transition = DB::table('point_transitions')->get();
        $transition = $transition->with(['customer'])->latest()->paginate(Helpers::getPagination())->appends($query_param);
        return view('admin-views.customer.transaction-table', compact('transition', 'search'));
    }

    public function customer_transaction($id)
    {
        $transition = PointTransitions::with(['customer'])->where(['user_id' => $id])->latest()->paginate(Helpers::getPagination());
        return view('admin-views.customer.transaction-table', compact('transition'));
    }
}

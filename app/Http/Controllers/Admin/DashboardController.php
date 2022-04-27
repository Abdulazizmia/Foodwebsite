<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\Category;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $top_sell = OrderDetail::with(['product'])
            ->select('product_id', DB::raw('SUM(quantity) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(6)
            ->get();

        $most_rated_products = Review::with(['product'])
            ->select(['product_id',
                DB::raw('AVG(rating) as ratings_average'),
                DB::raw('COUNT(rating) as total'),
            ])
            ->groupBy('product_id')
            ->orderBy("total", 'desc')
            ->take(6)
            ->get();

        $top_customer = Order::with(['customer'])
            ->select('user_id', DB::raw('COUNT(user_id) as count'))
            ->groupBy('user_id')
            ->orderBy("count", 'desc')
            ->take(6)
            ->get();

        $data = self::order_stats_data();

        $data['customer'] = User::count();
        $data['product'] = Product::count();
        $data['order'] = Order::count();
        $data['category'] = Category::count();
        $data['branch'] = Branch::count();

        $data['top_sell'] = $top_sell;
        $data['most_rated_products'] = $most_rated_products;
        $data['top_customer'] = $top_customer;

        $earning=[];
        for ($i=1;$i<=12;$i++){
            $from = date('Y-'.$i.'-01');
            $to = date('Y-'.$i.'-30');
            $earning[$i] = Order::where(['order_status' => 'delivered'])->whereBetween('created_at', [$from, $to])->sum('order_amount');
        }

        return view('admin-views.dashboard', compact('data', 'earning'));
    }

    public function order_stats(Request $request)
    {
        session()->put('statistics_type', $request['statistics_type']);
        $data = self::order_stats_data();

        return response()->json([
            'view' => view('admin-views.partials._dashboard-order-stats', compact('data'))->render()
        ], 200);
    }

    public function order_stats_data() {
        $today = session()->has('statistics_type') && session('statistics_type') == 'today' ? 1 : 0;
        $this_month = session()->has('statistics_type') && session('statistics_type') == 'this_month' ? 1 : 0;

        $pending = Order::where(['order_status' => 'pending'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', \Carbon\Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
        $confirmed = Order::where(['order_status' => 'confirmed'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
        $processing = Order::where(['order_status' => 'processing'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
        $out_for_delivery = Order::where(['order_status' => 'out_for_delivery'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
        $delivered = Order::where(['order_status' => 'delivered'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
        $all = Order::all()->count();
        $returned = Order::where(['order_status' => 'returned'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();
        $failed = Order::where(['order_status' => 'failed'])
            ->when($today, function ($query) {
                return $query->whereDate('created_at', Carbon::today());
            })
            ->when($this_month, function ($query) {
                return $query->whereMonth('created_at', Carbon::now());
            })
            ->count();

        $data = [
            'pending' => $pending,
            'confirmed' => $confirmed,
            'processing' => $processing,
            'out_for_delivery' => $out_for_delivery,
            'delivered' => $delivered,
            'all' => $all,
            'returned' => $returned,
            'failed' => $failed
        ];

        return $data;
    }

}

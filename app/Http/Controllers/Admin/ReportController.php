<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function order_index()
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        return view('admin-views.report.order-index');
    }

    public function earning_index()
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        return view('admin-views.report.earning-index');
    }

    public function set_date(Request $request)
    {
        session()->put('from_date', date('Y-m-d', strtotime($request['from'])));
        session()->put('to_date', date('Y-m-d', strtotime($request['to'])));
        return back();
    }

    public function driver_report()
    {
        $orders = Order::with(['customer', 'branch'])->paginate(25);
        return view('admin-views.report.driver-index', compact('orders'));
    }

    public function driver_filter(Request $request)
    {
        $fromDate = Carbon::parse($request->formDate)->startOfDay();
        $toDate = Carbon::parse($request->toDate)->endOfDay();
        $orders = Order::where(['delivery_man_id' => $request['delivery_man']])->where(['order_status' => 'delivered'])
            ->whereBetween('created_at', [$fromDate, $toDate])->get();
        return response()->json([
            'view' => view('admin-views.order.partials._table', compact('orders'))->render(),
            'delivered_qty'=>Order::where(['delivery_man_id'=>$request['delivery_man'],'order_status'=>'delivered'])->count()
        ]);

    }

    public function product_report()
    {
        return view('admin-views.report.product-report');
    }

    public function product_report_filter(Request $request)
    {
        $orders = Order::where(['branch_id' => $request['branch_id']])
            ->whereBetween('created_at', [$request->from, $request->to])->get();

        $data = [];
        $total_sold = 0;
        $total_qty = 0;
        foreach ($orders as $order) {
            foreach ($order->details as $detail) {
                if ($detail['product_id'] == $request['product_id']) {
                    $price = Helpers::variation_price(json_decode($detail->product_details, true), $detail['variations']) - $detail['discount_on_product'];
                    $ord_total = $price * $detail['quantity'];
                    array_push($data, [
                        'order_id' => $order['id'],
                        'date' => $order['created_at'],
                        'customer' => $order->customer,
                        'price' => $ord_total,
                        'quantity' => $detail['quantity'],
                    ]);
                    $total_sold += $ord_total;
                    $total_qty += $detail['quantity'];
                }
            }
        }

        session()->put('export_data', $data);

        return response()->json([
            'order_count' => count($data),
            'item_qty' => $total_qty,
            'order_sum' => $total_sold,
            'view' => view('admin-views.report.partials._table', compact('data'))->render(),
        ]);

    }

    public function export_product_report()
    {
        $data = session('export_data');
        $pdf = PDF::loadView('admin-views.report.partials._report', compact('data'));
        return $pdf->download('report_'.rand(00001,99999) . '.pdf');
    }

    public function sale_report()
    {
        return view('admin-views.report.sale-report');
    }

    public function sale_filter(Request $request)
    {
        if ($request['branch_id'] == 'all') {
            $orders = Order::whereBetween('created_at', [$request->from, $request->to])->pluck('id')->toArray();
        } else {
            $orders = Order::where(['branch_id' => $request['branch_id']])
                ->whereBetween('created_at', [$request->from, $request->to])->pluck('id')->toArray();
        }

        $data = [];
        $total_sold = 0;
        $total_qty = 0;

        foreach (OrderDetail::whereIn('order_id', $orders)->get() as $detail) {
            $price = $detail['price'] - $detail['discount_on_product'];
            $ord_total = $price * $detail['quantity'];
            array_push($data, [
                'order_id' => $detail['order_id'],
                'date' => $detail['created_at'],
                'price' => $ord_total,
                'quantity' => $detail['quantity'],
            ]);
            $total_sold += $ord_total;
            $total_qty += $detail['quantity'];
        }

        return response()->json([
            'order_count' => count($data),
            'item_qty' => $total_qty,
            'order_sum' => $total_sold,
            'view' => view('admin-views.report.partials._table', compact('data'))->render(),
        ]);
    }

    public function export_sale_report()
    {
        $data = session('export_sale_data');
        $pdf = PDF::loadView('admin-views.report.partials._report', compact('data'));
        return $pdf->download('sale_report_'.rand(00001,99999) . '.pdf');
    }
}

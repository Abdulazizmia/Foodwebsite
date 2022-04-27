<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title>Invoice</title>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/theme.minc619.css?v=1.0">
</head>

<body class="footer-offset">

<main id="content" role="main" class="main pointer-event">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">
                <h2 class="float-right">#INVOICE</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <img width="150"
                     src="{{asset('storage/app/public/restaurant')}}/{{\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value}}">
                <br><br>
                <strong>Phone : {{\App\Model\BusinessSetting::where(['key'=>'phone'])->first()->value}}</strong><br>
                <strong>Email : {{\App\Model\BusinessSetting::where(['key'=>'email_address'])->first()->value}}</strong><br>
                <strong>Address : {{\App\Model\BusinessSetting::where(['key'=>'address'])->first()->value}}</strong><br><br>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                @if($order->customer)
                    <strong class="float-right">Order ID : {{$order['id']}}</strong><br>
                    <strong class="float-right">Customer Name
                        : {{$order->customer['f_name'].' '.$order->customer['l_name']}}</strong><br>
                    <strong class="float-right">Phone
                        : {{$order->customer['phone']}}</strong><br>
                    <strong class="float-right">Delivery Address
                        : {{$order->delivery_address?$order->delivery_address['address']:''}}</strong><br>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header" style="display: block!important;">
                        <div class="row">
                            <div class="col-12 pb-2 border-bottom">
                                <h4 class="card-header-title">
                                    Order details
                                    <span
                                        class="badge badge-soft-dark rounded-circle ml-1">{{$order->details->count()}}</span>
                                </h4>
                            </div>
                            <div class="col-6 pt-2">
                                <h6 style="color: #8a8a8a;">
                                    Order Note : {{$order['order_note']}}
                                </h6>
                            </div>
                            <div class="col-6 pt-2">
                                <div class="text-right">
                                    <h6 class="text-capitalize" style="color: #8a8a8a;">
                                        Payment Method : {{str_replace('_',' ',$order['payment_method'])}}
                                    </h6>
                                    <h6 class="" style="color: #8a8a8a;">
                                        @if($order['transaction_reference']==null)
                                            Reference Code :
                                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                    data-target=".bd-example-modal-sm">
                                                Add
                                            </button>
                                        @else
                                            Reference Code : {{$order['transaction_reference']}}
                                        @endif
                                    </h6>
                                    <h6 class="text-capitalize" style="color: #8a8a8a;">Order Type
                                        : {{str_replace('_',' ',$order['order_type'])}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                    @php($sub_total=0)
                    @php($total_tax=0)
                    @php($total_dis_on_pro=0)
                    @php($add_ons_cost=0)
                    @foreach($order->details as $detail)
                        @if($detail->product)
                            @php($add_on_qtys=json_decode($detail['add_on_qtys'],true))
                            <!-- Media -->
                                <div class="media">
                                    <div class="avatar avatar-xl mr-3">
                                        <img class="img-fluid"
                                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                             src="{{asset('storage/app/public/product')}}/{{$detail->product['image']}}"
                                             alt="Image Description">
                                    </div>

                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <strong> {{$detail->product['name']}}</strong><br>

                                                @if(count(json_decode($detail['variation'],true))>0)
                                                    <strong><u>Variation : </u></strong>
                                                    @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                        <div class="font-size-sm text-body">
                                                            <span>{{$key1}} :  </span>
                                                            <span class="font-weight-bold">{{$variation}}</span>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @foreach(json_decode($detail['add_on_ids'],true) as $key2 =>$id)
                                                    @php($addon=\App\Model\AddOn::find($id))
                                                    @if($key2==0)<strong><u>Addons : </u></strong>@endif

                                                    @if($add_on_qtys==null)
                                                        @php($add_on_qty=1)
                                                    @else
                                                        @php($add_on_qty=$add_on_qtys[$key2])
                                                    @endif

                                                    <div class="font-size-sm text-body">
                                                        <span>{{$addon['name']}} :  </span>
                                                        <span class="font-weight-bold">
                                                            {{$add_on_qty}} x {{$addon['price']}} {{\App\CentralLogics\Helpers::currency_symbol()}}
                                                        </span>
                                                    </div>
                                                    @php($add_ons_cost+=$addon['price']*$add_on_qty)
                                                @endforeach
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                @if($detail['discount_on_product']!=0)
                                                    <h5>
                                                        <strike>
                                                            {{\App\CentralLogics\Helpers::variation_price(json_decode($detail['product_details'],true),$detail['variation'])
                                                            ." ".\App\CentralLogics\Helpers::currency_symbol()}}
                                                        </strike>
                                                    </h5>
                                                @endif
                                                <h6>{{$detail['price']-$detail['discount_on_product'] ." ".\App\CentralLogics\Helpers::currency_symbol()}}</h6>
                                            </div>
                                            <div class="col col-md-1 align-self-center">
                                                <h5>{{$detail['quantity']}}</h5>
                                            </div>

                                            <div class="col col-md-3 align-self-center text-right">
                                                @php($amount=($detail['price']-$detail['discount_on_product'])*$detail['quantity'])
                                                <h5>{{$amount." ".\App\CentralLogics\Helpers::currency_symbol()}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @php($sub_total+=$amount)
                            @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
                            <!-- End Media -->
                                <hr>
                            @endif
                        @endforeach

                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-sm-right">
                                    <dt class="col-sm-6">Items Price:</dt>
                                    <dd class="col-sm-6">{{$sub_total." ".\App\CentralLogics\Helpers::currency_symbol()}}</dd>
                                    <dt class="col-sm-6">Tax / VAT:</dt>
                                    <dd class="col-sm-6">{{$total_tax." ".\App\CentralLogics\Helpers::currency_symbol()}}</dd>
                                    <dt class="col-sm-6">Addon Cost:</dt>
                                    <dd class="col-sm-6">
                                        {{$add_ons_cost." ".\App\CentralLogics\Helpers::currency_symbol()}}
                                        <hr>
                                    </dd>

                                    <dt class="col-sm-6">Subtotal:</dt>
                                    <dd class="col-sm-6">
                                        {{$sub_total+$total_tax+$add_ons_cost." ".\App\CentralLogics\Helpers::currency_symbol()}}</dd>
                                    <dt class="col-sm-6">Coupon Discount:</dt>
                                    <dd class="col-sm-6">
                                        - {{$order['coupon_discount_amount']." ".\App\CentralLogics\Helpers::currency_symbol()}}</dd>
                                    <dt class="col-sm-6">Delivery Fee:</dt>
                                    <dd class="col-sm-6">
                                        @if($order['order_type']=='take_away')
                                            @php($del_c=0)
                                        @else
                                            @php($del_c=$order['delivery_charge'])
                                        @endif
                                        {{$del_c." ".\App\CentralLogics\Helpers::currency_symbol()}}
                                        <hr>
                                    </dd>

                                    <dt class="col-sm-6">Total:</dt>
                                    <dd class="col-sm-6">{{$sub_total+$del_c+$total_tax+$add_ons_cost-$order['coupon_discount_amount']." ".\App\CentralLogics\Helpers::currency_symbol()}}</dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="row justify-content-between align-items-center">
            <div class="col">
                <p class="font-size-sm mb-0">
                    &copy; {{\App\Model\BusinessSetting::where(['key'=>'restaurant_name'])->first()->value}}. <span
                        class="d-none d-sm-inline-block">{{\App\Model\BusinessSetting::where(['key'=>'footer_text'])->first()->value}}</span>
                </p>
            </div>
        </div>
    </div>
</main>

<script src="{{asset('public/assets/admin')}}/js/demo.js"></script>
<!-- JS Implementing Plugins -->
<!-- JS Front -->
<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script>
    window.print();
</script>
</body>
</html>

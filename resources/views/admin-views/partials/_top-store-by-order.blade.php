<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title">
        <i class="tio-company"></i> {{\App\CentralLogics\translate('top_store_by_order_received')}}
    </h5>
    <i class="tio-award-outlined" style="font-size: 45px"></i>
</div>
<!-- End Header -->

<!-- Body -->
<div class="card-body">
    <div class="row">
        @foreach($top_store_by_order_received as $key=>$item)
            @php($shop=\App\Model\Shop::where('seller_id',$item['seller_id'])->first())
            @if(isset($shop))
                <div class="col-6 col-md-4 mt-2"
                     onclick="location.href='{{route('admin.sellers.view',$item['seller_id'])}}'"
                     style="padding-left: 6px;padding-right: 6px;cursor: pointer">
                    <div class="grid-card" style="min-height: 170px">
                        <label class="label_1">Orders : {{$item['count']}}</label>
                        <center class="mt-6">
                            <img style="border-radius: 50%;width: 60px;height: 60px;border:2px solid #80808082;"
                                 onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                 src="{{asset('storage/app/public/shop/'.$shop->image  ?? '' )}}">
                        </center>
                        <div class="text-center mt-2">
                            <span style="font-size: 10px">{{$shop['name']??'Not exist'}}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
<!-- End Body -->

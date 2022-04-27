<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset">
                <div class="navbar-brand-wrapper justify-content-between">
                    <!-- Logo -->

                    @php($restaurant_logo=\App\Model\BusinessSetting::where(['key'=>'logo'])->first()->value)
                    <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="Front">
                        <img class="navbar-brand-logo"
                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                             src="{{asset('storage/app/public/restaurant/'.$restaurant_logo)}}"
                             alt="Logo">
                        <img class="navbar-brand-logo-mini"
                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                             src="{{asset('storage/app/public/restaurant/'.$restaurant_logo)}}" alt="Logo">
                    </a>

                    <!-- End Logo -->

                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                            class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content text-capitalize">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('branch')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('branch.dashboard')}}" title="Dashboards">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('dashboard')}}
                                </span>
                            </a>
                        </li>
                        <!-- End Dashboards -->

                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CentralLogics\translate('pos')}} {{\App\CentralLogics\translate('system')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                    <!-- POS -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('branch/pos/*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-shopping nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CentralLogics\translate('POS')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('branch/pos/*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('branch/pos/')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.pos.index')}}"
                                       title="{{\App\CentralLogics\translate('pos')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CentralLogics\translate('pos')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/pos/orders')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.pos.orders')}}" title="{{\App\CentralLogics\translate('orders')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CentralLogics\translate('orders')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Model\Order::where('branch_id', auth('branch')->id())->Pos()->count()}}
                                        </span>
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- End POS -->

                        <li class="nav-item">
                            <small class="nav-subtitle" title="Pages">{{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <!-- Pages -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('branch/orders*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                               title="Pages">
                                <i class="tio-shopping-cart nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CentralLogics\translate('order')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('branch*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('branch/orders/list/all')?'active':''}}">
                                    <a class="nav-link" href="{{route('branch.orders.list',['all'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('all')}}
                                            <span class="badge badge-info badge-pill ml-1">
                                                {{\App\Model\Order::where(['branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/pending')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['pending'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('pending')}}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'pending','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/confirmed')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['confirmed'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('confirmed')}}
                                                <span class="badge badge-soft-success badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'confirmed','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/processing')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['processing'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('processing')}}
                                                <span class="badge badge-warning badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'processing','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/out_for_delivery')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['out_for_delivery'])}}"
                                       title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('out_for_delivery')}}
                                                <span class="badge badge-warning badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'out_for_delivery','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/delivered')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['delivered'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('delivered')}}
                                                <span class="badge badge-success badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'delivered','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/returned')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['returned'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('returned')}}
                                                <span class="badge badge-soft-danger badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'returned','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('branch/orders/list/failed')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['failed'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('failed')}}
                                            <span class="badge badge-danger badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'failed','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('branch/orders/list/canceled')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['canceled'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('canceled')}}
                                                <span class="badge badge-soft-dark badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','<=',\Carbon\Carbon::now()->format('Y-m-d'))->where(['order_status'=>'canceled','branch_id'=>auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('branch/orders/list/schedule')?'active':''}}">
                                    <a class="nav-link " href="{{route('branch.orders.list',['schedule'])}}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CentralLogics\translate('scheduled')}}
                                                <span class="badge badge-soft-info badge-pill ml-1">
                                                {{\App\Model\Order::whereDate('delivery_date','>',\Carbon\Carbon::now()->format('Y-m-d'))->where(['branch_id' => auth('branch')->id()])->count()}}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- End Pages -->

                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


{{--<script>
    $(document).ready(function () {
        $('.navbar-vertical-content').animate({
            scrollTop: $('#scroll-here').offset().top
        }, 'slow');
    });
</script>--}}

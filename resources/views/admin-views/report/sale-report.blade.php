@extends('layouts.admin.app')

@section('title','Sale Report')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="media mb-3">
                <!-- Avatar -->
                <div class="avatar avatar-xl avatar-4by3 mr-2">
                    <img class="avatar-img" src="{{asset('public/assets/admin')}}/svg/illustrations/credit-card.svg"
                         alt="Image Description">
                </div>
                <!-- End Avatar -->

                <div class="media-body">
                    <div class="row">
                        <div class="col-lg mb-3 mb-lg-0">
                            <h1 class="page-header-title">{{\App\CentralLogics\translate('sale')}} {{\App\CentralLogics\translate('report')}} {{\App\CentralLogics\translate('overview')}}</h1>

                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span>{{\App\CentralLogics\translate('admin')}}:</span>
                                    <a href="#">{{auth('admin')->user()->f_name.' '.auth('admin')->user()->l_name}}</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-auto">
                            <div class="d-flex">
                                <a class="btn btn-icon btn-primary rounded-circle" href="{{route('admin.dashboard')}}">
                                    <i class="tio-home-outlined"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Media -->

            <!-- Nav -->
            <!-- Nav -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="tio-chevron-left"></i>
              </a>
            </span>

                <span class="hs-nav-scroller-arrow-next" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="tio-chevron-right"></i>
              </a>
            </span>

                <ul class="nav nav-tabs page-header-tabs" id="projectsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:">{{\App\CentralLogics\translate('overview')}}</a>
                    </li>
                </ul>
            </div>
            <!-- End Nav -->
        </div>
        <!-- End Page Header -->

        <div>
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <div class="col-lg-12 pt-3">
                        <form action="javascript:" id="search-form" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="custom-select custom-select" name="branch_id" id="branch_id"
                                            required>
                                        <option selected disabled>Select Branch</option>
                                        <option value="all">All</option>
                                        @foreach(\App\Model\Branch::all() as $branch)
                                            <option
                                                value="{{$branch['id']}}" {{session('branch_filter')==$branch['id']?'selected':''}}>{{$branch['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-3">
                                    <input type="date" name="from" id="from_date"
                                           class="form-control" required>
                                </div>
                                <div class="col-3">
                                    <input type="date" name="to" id="to_date"
                                           class="form-control" required>
                                </div>
                                <div class="col-2">
                                    <button type="submit"
                                            class="btn btn-primary btn-block">{{\App\CentralLogics\translate('show')}}</button>
                                </div>

                                <div class="col-md-6 pt-4">
                                    <strong>
                                        {{\App\CentralLogics\translate('total')}} {{\App\CentralLogics\translate('orders')}} : <span
                                            id="order_count"> </span>
                                    </strong><br>
                                    <strong>
                                        {{\App\CentralLogics\translate('total')}} {{\App\CentralLogics\translate('item')}} {{\App\CentralLogics\translate('qty')}}
                                        : <span
                                            id="item_count"> </span>
                                    </strong><br>
                                    <strong>{{\App\CentralLogics\translate('total')}}  {{\App\CentralLogics\translate('amount')}} : <span
                                            id="order_amount"></span>{{ \App\CentralLogics\Helpers::currency_symbol() }}
                                    </strong>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- End Header -->

                <!-- Table -->
                <div class="table-responsive" id="set-rows">
                    @include('admin-views.report.partials._table',['data'=>[]])
                </div>
                <!-- End Table -->

            </div>
            <!-- End Row -->
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        $('#search-form').on('submit', function () {
            $.post({
                url: "{{route('admin.report.sale-report-filter')}}",
                data: $('#search-form').serialize(),

                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#order_count').html(data.order_count);
                    $('#order_amount').html(data.order_sum);
                    $('#item_count').html(data.item_qty);
                    $('#set-rows').html(data.view);
                    $('.card-footer').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });

    </script>
    <script>
        $('#from_date,#to_date').change(function () {
            let fr = $('#from_date').val();
            let to = $('#to_date').val();
            if (fr != '' && to != '') {
                if (fr > to) {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    toastr.error('Invalid date range!', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('input').addClass('form-control');
        });

        // INITIALIZATION OF DATATABLES
        // =======================================================
        var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
            dom: 'Bfrtip',
            language: {
                zeroRecords: '<div class="text-center p-4">' +
                    '<img class="mb-3" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                    '<p class="mb-0">No data to show</p>' +
                    '</div>'
            }
        });
    </script>
@endpush

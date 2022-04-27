@extends('layouts.admin.app')

@section('title','Dashboard')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .grid-card {
            border: 2px solid #00000012;
            border-radius: 10px;
            padding: 10px;
        }

        .label_1 {
            position: absolute;
            font-size: 10px;
            background: #FF4C29;
            color: #ffffff;
            width: 80px;
            padding: 2px;
            font-weight: bold;
            border-radius: 6px;
            text-align: center;
        }

        .center-div {
            text-align: center;
            border-radius: 6px;
            padding: 6px;
            border: 2px solid #8080805e;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header"
             style="padding-bottom: 0!important;border-bottom: 0!important;margin-bottom: 1.25rem!important;">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CentralLogics\translate('welcome')}}, {{auth('admin')->user()->f_name}}.</h1>
                    <p>{{\App\CentralLogics\translate('welcome_message')}}</p>
                </div>
                <div class="col-sm mb-2 mb-sm-0" style="height: 25px">
                    <label class="badge badge-soft-success float-right">
                        Software Version : {{ env('SOFTWARE_VERSION') }}
                    </label>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card card-body mb-3 mb-lg-5">
            <div class="row gx-2 gx-lg-3 mb-2">
                <div class="col-9">
                    <h4><i style="font-size: 30px"
                           class="tio-chart-bar-4"></i>{{\App\CentralLogics\translate('dashboard_order_statistics')}}</h4>
                </div>
                <div class="col-3">
                    <select class="custom-select" name="statistics_type" onchange="order_stats_update(this.value)">
                        <option value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                            Overall Statistics
                        </option>
                        <option value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                            Today's Statistics
                        </option>
                        <option value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                            This Month's Statistics
                        </option>
                    </select>
                </div>
            </div>
            <div class="row gx-2 gx-lg-3" id="order_stats">
                @include('admin-views.partials._dashboard-order-stats',['data'=>$data])
            </div>
        </div>
        <!-- End Card -->

        <div class="row gx-2 gx-lg-3 mb-3 mb-lg-5">
            <div class="col-lg-12">

                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12 mb-3 border-bottom">
                                <h5 class="card-header-title float-left mb-2">
                                    <i style="font-size: 30px" class="tio-chart-pie-1"></i>
                                    Earning statistics for business analytics
                                </h5>
                                <!-- Legend Indicators -->
                                <h5 class="card-header-title float-right mb-2">Monthly Earning
                                    <i style="font-size: 30px" class="tio-chart-bar-2"></i>
                                </h5>
                                <!-- End Legend Indicators -->
                            </div>
                            <div class="col-md-4 graph-border-1">
                                <div class="mt-2 center-div">
                                      <span class="h6 mb-0">
                                          <i class="legend-indicator" style="background-color: #B6C867!important;"></i>
                                         {{ \App\CentralLogics\translate('earnings') }} : {{ array_sum($earning) ." ".\App\CentralLogics\Helpers::currency_symbol() }}
                                      </span>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->

                        <!-- Bar Chart -->
                        <div class="chartjs-custom">
                            <canvas id="updatingData" style="height: 20rem;"
                                    data-hs-chartjs-options='{
                            "type": "bar",
                            "data": {
                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                              "datasets": [
                             {
                                "data": [{{$earning[1]}},{{$earning[2]}},{{$earning[3]}},{{$earning[4]}},{{$earning[5]}},{{$earning[6]}},{{$earning[7]}},{{$earning[8]}},{{$earning[9]}},{{$earning[10]}},{{$earning[11]}},{{$earning[12]}}],
                                "backgroundColor": "#B6C867",
                                "borderColor": "#B6C867"
                              }]
                            },
                            "options": {
                              "scales": {
                                "yAxes": [{
                                  "gridLines": {
                                    "color": "#e7eaf3",
                                    "drawBorder": false,
                                    "zeroLineColor": "#e7eaf3"
                                  },
                                  "ticks": {
                                    "beginAtZero": true,
                                    "stepSize": 50000,
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 10,
                                    "postfix": " {{ \App\CentralLogics\Helpers::currency_symbol() }}"
                                  }
                                }],
                                "xAxes": [{
                                  "gridLines": {
                                    "display": false,
                                    "drawBorder": false
                                  },
                                  "ticks": {
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 5
                                  },
                                  "categoryPercentage": 0.5,
                                  "maxBarThickness": "10"
                                }]
                              },
                              "cornerRadius": 2,
                              "tooltips": {
                                "prefix": " ",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false
                              },
                              "hover": {
                                "mode": "nearest",
                                "intersect": true
                              }
                            }
                          }'></canvas>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->

        <div class="row gx-2 gx-lg-3 mb-3 mb-lg-5">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">
                            <i class="tio-company"></i> Total Business Overview
                        </h5>
                        <i class="tio-chart-pie-1" style="font-size: 45px"></i>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body" id="business-overview-board">
                        <!-- Chart -->
                        <div class="chartjs-custom mx-auto">
                            <canvas id="business-overview" class="mt-2"></canvas>
                        </div>
                        <!-- End Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6">
                <div class="card h-100">
                    @include('admin-views.partials._top-selling-products',['top_sell'=>$data['top_sell']])
                </div>
            </div>
        </div>
        <!-- End Row -->

        <div class="row gx-2 gx-lg-3 mb-3 mb-lg-5">
            <div class="col-lg-6  mb-3 mb-lg-0">
                <div class="card h-100">
                    @include('admin-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']])
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100">
                    @include('admin-views.partials._top-customer',['top_customer'=>$data['top_customer']])
                </div>
            </div>
        </div>
        <!-- End Row -->
        @endsection

        @push('script')
            <script src="{{asset('public/assets/admin')}}/vendor/chart.js/dist/Chart.min.js"></script>
            <script src="{{asset('public/assets/admin')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
            <script src="{{asset('public/assets/admin')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
        @endpush


        @push('script_2')
            <script>
                var ctx = document.getElementById('business-overview');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'Customer ( {{$data['customer']}} )',
                            'Product ( {{$data['product']}} )',
                            'Order ( {{$data['order']}} )',
                            'Category ( {{$data['category']}} )',
                            'Branch ( {{$data['branch']}} )',
                        ],
                        datasets: [{
                            label: 'Business',
                            data: ['{{$data['customer']}}', '{{$data['product']}}', '{{$data['order']}}', '{{$data['category']}}', '{{$data['branch']}}'],
                            backgroundColor: [
                                '#E1E8EB',
                                '#346751',
                                '#343A40',
                                '#7D5A50',
                                '#C84B31',
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <script>
                function order_stats_update(type) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('admin.order-stats')}}",
                        type: "post",
                        data: {
                            statistics_type: type,
                        },
                        beforeSend: function () {
                            $('#loading').show()
                        },
                        success: function (data) {
                            $('#order_stats').html(data.view)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        },
                        complete: function () {
                            $('#loading').hide()
                        }
                    });
                }
            </script>

            <script>
                // INITIALIZATION OF CHARTJS
                // =======================================================
                Chart.plugins.unregister(ChartDataLabels);

                $('.js-chart').each(function () {
                    $.HSCore.components.HSChartJS.init($(this));
                });

                var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

                // CALL WHEN TAB IS CLICKED
                // =======================================================
                $('[data-toggle="chart-bar"]').click(function (e) {
                    let keyDataset = $(e.currentTarget).attr('data-datasets')

                    if (keyDataset === 'lastWeek') {
                        updatingChart.data.labels = ["Apr 22", "Apr 23", "Apr 24", "Apr 25", "Apr 26", "Apr 27", "Apr 28", "Apr 29", "Apr 30", "Apr 31"];
                        updatingChart.data.datasets = [
                            {
                                "data": [120, 250, 300, 200, 300, 290, 350, 100, 125, 320],
                                "backgroundColor": "#377dff",
                                "hoverBackgroundColor": "#377dff",
                                "borderColor": "#377dff"
                            },
                            {
                                "data": [250, 130, 322, 144, 129, 300, 260, 120, 260, 245, 110],
                                "backgroundColor": "#e7eaf3",
                                "borderColor": "#e7eaf3"
                            }
                        ];
                        updatingChart.update();
                    } else {
                        updatingChart.data.labels = ["May 1", "May 2", "May 3", "May 4", "May 5", "May 6", "May 7", "May 8", "May 9", "May 10"];
                        updatingChart.data.datasets = [
                            {
                                "data": [200, 300, 290, 350, 150, 350, 300, 100, 125, 220],
                                "backgroundColor": "#377dff",
                                "hoverBackgroundColor": "#377dff",
                                "borderColor": "#377dff"
                            },
                            {
                                "data": [150, 230, 382, 204, 169, 290, 300, 100, 300, 225, 120],
                                "backgroundColor": "#e7eaf3",
                                "borderColor": "#e7eaf3"
                            }
                        ]
                        updatingChart.update();
                    }
                })


                // INITIALIZATION OF BUBBLE CHARTJS WITH DATALABELS PLUGIN
                // =======================================================
                $('.js-chart-datalabels').each(function () {
                    $.HSCore.components.HSChartJS.init($(this), {
                        plugins: [ChartDataLabels],
                        options: {
                            plugins: {
                                datalabels: {
                                    anchor: function (context) {
                                        var value = context.dataset.data[context.dataIndex];
                                        return value.r < 20 ? 'end' : 'center';
                                    },
                                    align: function (context) {
                                        var value = context.dataset.data[context.dataIndex];
                                        return value.r < 20 ? 'end' : 'center';
                                    },
                                    color: function (context) {
                                        var value = context.dataset.data[context.dataIndex];
                                        return value.r < 20 ? context.dataset.backgroundColor : context.dataset.color;
                                    },
                                    font: function (context) {
                                        var value = context.dataset.data[context.dataIndex],
                                            fontSize = 25;

                                        if (value.r > 50) {
                                            fontSize = 35;
                                        }

                                        if (value.r > 70) {
                                            fontSize = 55;
                                        }

                                        return {
                                            weight: 'lighter',
                                            size: fontSize
                                        };
                                    },
                                    offset: 2,
                                    padding: 0
                                }
                            }
                        },
                    });
                });
            </script>
    @endpush

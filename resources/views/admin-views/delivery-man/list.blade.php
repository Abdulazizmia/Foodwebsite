@extends('layouts.admin.app')

@section('title','Deliveryman List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{\App\CentralLogics\translate('deliveryman')}} {{\App\CentralLogics\translate('list')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="flex-start">
                            <h5 class="card-header-title">Delivery Man Table</h5>
                            <h5 class="card-header-title text-primary mx-1">({{ $delivery_men->total() }})</h5>
                        </div>
                        <a href="{{route('admin.delivery-man.add')}}" class="btn btn-primary pull-right"><i
                                class="tio-add-circle"></i> {{\App\CentralLogics\translate('add')}} {{\App\CentralLogics\translate('deliveryman')}}</a>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CentralLogics\translate('#')}}</th>
                                <th style="width: 30%">{{\App\CentralLogics\translate('name')}}</th>
                                <th style="width: 25%">{{\App\CentralLogics\translate('image')}}</th>
                                <th>{{\App\CentralLogics\translate('phone')}}</th>
                                <th>{{\App\CentralLogics\translate('action')}}</th>
                            </tr>
                            <tr>
                                <th colspan="3"></th>
                                <th>
                                    <form action="{{url()->current()}}" method="GET">
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                                   placeholder="Search" aria-label="Search" value="{{$search}}" required>
                                            <button type="submit" class="btn btn-primary">search</button>

                                        </div>
                                        <!-- End Search -->
                                    </form>

                                    {{-- Ajax search --}}
{{--                                    <form action="javascript:" id="search-form">--}}
{{--                                        <!-- Search -->--}}
{{--                                        <div class="input-group input-group-merge input-group-flush">--}}
{{--                                            <div class="input-group-prepend">--}}
{{--                                                <div class="input-group-text">--}}
{{--                                                    <i class="tio-search"></i>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <input id="datatableSearch_" type="search" name="search" class="form-control"--}}
{{--                                                   placeholder="Search" aria-label="Search" required>--}}
{{--                                            <button type="submit" class="btn btn-primary">{{\App\CentralLogics\translate('search')}}</button>--}}

{{--                                        </div>--}}
{{--                                        <!-- End Search -->--}}
{{--                                    </form>--}}
                                </th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($delivery_men as $key=>$dm)
                                <tr>
                                    <td>{{$delivery_men->firstitem()+$key}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{$dm['f_name'].' '.$dm['l_name']}}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
                                            <img width="60" style="border-radius: 50%"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('storage/app/public/delivery-man')}}/{{$dm['image']}}">
                                        </div>
                                        {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
                                    </td>
                                    <td>
                                        {{$dm['phone']}}
                                    </td>
                                    <td>
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.delivery-man.edit',[$dm['id']])}}">{{\App\CentralLogics\translate('edit')}}</a>
                                                <a class="dropdown-item" href="javascript:"
                                                   onclick="form_alert('delivery-man-{{$dm['id']}}','Want to remove this information ?')">{{\App\CentralLogics\translate('delete')}}</a>
                                                <form action="{{route('admin.delivery-man.delete',[$dm['id']])}}"
                                                      method="post" id="delivery-man-{{$dm['id']}}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </div>
                                        <!-- End Dropdown -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $delivery_men->links() !!}
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.delivery-man.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush

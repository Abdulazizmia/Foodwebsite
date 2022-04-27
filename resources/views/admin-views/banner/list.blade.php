@extends('layouts.admin.app')

@section('title','Banner List')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{\App\CentralLogics\translate('banner')}} {{\App\CentralLogics\translate('list')}} <span class="text-primary">({{ $banners->total() }})</span></h1>
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
                        <h5 class="card-header-title"></h5>
                        <a href="{{route('admin.banner.add-new')}}" class="btn btn-primary pull-right"><i
                                class="tio-add-circle"></i> {{\App\CentralLogics\translate('add')}} {{\App\CentralLogics\translate('new')}} {{\App\CentralLogics\translate('banner')}}</a>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CentralLogics\translate('#')}}</th>
                                <th style="width: 30%">{{\App\CentralLogics\translate('title')}}</th>
                                <th style="width: 25%">{{\App\CentralLogics\translate('image')}}</th>
                                <th>{{\App\CentralLogics\translate('status')}}</th>
                                <th style="width: 100px">{{\App\CentralLogics\translate('action')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($banners as $key=>$banner)
                                <tr>
                                    <td>{{$banners->firstitem()+$key}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{$banner['title']}}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="height: 100px; width: 100px; overflow-x: hidden;overflow-y: hidden">
                                            <img src="{{asset('storage/app/public/banner')}}/{{$banner['image']}}" style="width: 100px"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                        </div>
                                    </td>
                                    <td>
                                        @if($banner['status']==1)
                                            <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                 onclick="location.href='{{route('admin.banner.status',[$banner['id'],0])}}'">
                                                <span class="legend-indicator bg-success"></span>Active
                                            </div>
                                        @else
                                            <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                 onclick="location.href='{{route('admin.banner.status',[$banner['id'],1])}}'">
                                                <span class="legend-indicator bg-danger"></span>Disabled
                                            </div>
                                        @endif
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
                                                   href="{{route('admin.banner.edit',[$banner['id']])}}">{{\App\CentralLogics\translate('edit')}}</a>
                                                <a class="dropdown-item" href="javascript:"
                                                   onclick="form_alert('banner-{{$banner['id']}}','Want to delete this banner')">{{\App\CentralLogics\translate('delete')}}</a>
                                                <form action="{{route('admin.banner.delete',[$banner['id']])}}"
                                                      method="post" id="banner-{{$banner['id']}}">
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
                        <table>
                            <tfoot>
                            {!! $banners->links() !!}
                            </tfoot>
                        </table>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')

@endpush

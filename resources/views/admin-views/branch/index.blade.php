@extends('layouts.admin.app')

@section('title','Add new branch')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{\App\CentralLogics\translate('add')}} {{\App\CentralLogics\translate('new')}} {{\App\CentralLogics\translate('branch')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.branch.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="New branch" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('email')}}</label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="EX : example@example.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('latitude')}}</label>
                                <input type="text" name="latitude" class="form-control" placeholder="Ex : -132.44442"
                                       required>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('longitude')}}</label>
                                <input type="text" name="longitude" class="form-control" placeholder="Ex : 94.233"
                                       required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="input-label" for="">
                                    <i class="tio-info-outined"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="This value is the radius from your restaurant location, and customer can order food inside  the circle calculated by this radius."></i>
                                    {{\App\CentralLogics\translate('coverage')}} ( {{\App\CentralLogics\translate('km')}} )
                                </label>
                                <input type="number" name="coverage" min="1" max="1000" class="form-control"
                                       placeholder="Ex : 3"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('address')}}</label>
                                <input type="text" name="address" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('password')}}</label>
                                <input type="text" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{\App\CentralLogics\translate('submit')}}</button>
                </form>
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <hr>
                <div class="card">
                    <!-- Page Header -->
                    <div class="page-header p-2">
                        <div class="row align-items-center">
                            <div class="col-sm mb-2 mb-sm-0">
                                <h1 class="page-header-title"><i class="tio-filter-list"></i> {{\App\CentralLogics\translate('branch')}} {{\App\CentralLogics\translate('list')}} <span class="text-primary">({{ $branches->total() }})</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CentralLogics\translate('#')}}</th>
                                <th style="width: 50%">{{\App\CentralLogics\translate('name')}}</th>
                                <th style="width: 50%">{{\App\CentralLogics\translate('email')}}</th>
                                <th style="width: 10%">{{\App\CentralLogics\translate('action')}}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    <input type="text" id="column1_search" class="form-control form-control-sm"
                                           placeholder="Search branch">
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($branches as $key=>$branch)
                                <tr>
                                    <td>{{$branches->firstitem()+$key}}</td>
                                    <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{$branch['name']}} @if($branch['id']==1)
                                            <label class="badge badge-danger">{{\App\CentralLogics\translate('main')}}</label>
                                        @else
                                            <label class="badge badge-info">{{\App\CentralLogics\translate('sub')}}</label>
                                        @endif
                                    </span>
                                    </td>
                                    <td>{{$branch['email']}}</td>
                                    <td>
                                        @if(env('APP_MODE')!='demo' || $branch['id']!=1)
                                        <!-- Dropdown -->
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="tio-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.branch.edit',[$branch['id']])}}">{{\App\CentralLogics\translate('edit')}}</a>
                                                    @if($branch['id']!=1)
                                                        <a class="dropdown-item" href="javascript:"
                                                           onclick="form_alert('branch-{{$branch['id']}}','Want to delete this branch ?')">{{\App\CentralLogics\translate('delete')}}</a>
                                                        <form action="{{route('admin.branch.delete',[$branch['id']])}}"
                                                              method="post" id="branch-{{$branch['id']}}">
                                                            @csrf @method('delete')
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- End Dropdown -->
                                        @else
                                            <label class="badge badge-danger">Not Permitted</label>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <table>
                            <tfoot>
                            {!! $branches->links() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')

@endpush

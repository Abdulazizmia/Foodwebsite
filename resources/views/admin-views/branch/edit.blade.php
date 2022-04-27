@extends('layouts.admin.app')

@section('title','Update Branch')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize"><i class="tio-edit"></i> {{\App\CentralLogics\translate('branch')}} {{\App\CentralLogics\translate('update')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        @php($branch_count=\App\Model\Branch::count())
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.branch.update',[$branch['id']])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('name')}}</label>
                                <input type="text" name="name" value="{{$branch['name']}}" class="form-control" placeholder="New branch" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('email')}}</label>
                                <input type="email" name="email" value="{{$branch['email']}}" class="form-control"
                                       placeholder="EX : example@example.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('latitude')}}</label>
                                <input type="text" name="latitude" value="{{$branch['latitude']}}" class="form-control" placeholder="Ex : -132.44442"
                                       {{$branch_count>1?'required':''}}>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('longitude')}}</label>
                                <input type="text" name="longitude" value="{{$branch['longitude']}}" class="form-control" placeholder="Ex : 94.233"
                                    {{$branch_count>1?'required':''}}>
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
                                <input type="number" name="coverage" min="1" value="{{$branch['coverage']}}" max="1000" class="form-control" placeholder="Ex : 3"
                                    {{$branch_count>1?'required':''}}>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="">{{\App\CentralLogics\translate('address')}}</label>
                                <input type="text" name="address" value="{{$branch['address']}}" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('password')}} <span class="" style="color: red;font-size: small">* ( input if you want to reset. )</span></label>
                                <input type="text" name="password" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{\App\CentralLogics\translate('update')}}</button>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')

@endpush

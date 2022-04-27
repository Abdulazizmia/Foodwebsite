@extends('layouts.admin.app')

@section('title','Map API Settings')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CentralLogics\translate('map')}} {{\App\CentralLogics\translate('API')}} {{\App\CentralLogics\translate('setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.map_api_settings'):'javascript:'}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @php($key=\App\Model\BusinessSetting::where('key','map_api_key')->first()->value)
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('map')}} {{\App\CentralLogics\translate('API')}} {{\App\CentralLogics\translate('key')}}</label>
                                <textarea name="map_api_key" class="form-control">{{env('APP_MODE')!='demo'?$key:''}}</textarea>
                            </div>
                            <hr>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary">{{\App\CentralLogics\translate('submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush

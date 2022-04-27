@extends('layouts.admin.app')

@section('title','FCM Settings')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CentralLogics\translate('firebase')}} {{\App\CentralLogics\translate('push')}} {{\App\CentralLogics\translate('notification')}} {{\App\CentralLogics\translate('setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.update-fcm'):'javascript:'}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @php($key=\App\Model\BusinessSetting::where('key','push_notification_key')->first()->value)
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{\App\CentralLogics\translate('server')}} {{\App\CentralLogics\translate('key')}}</label>
                                <textarea name="push_notification_key" class="form-control"
                                          required>{{env('APP_MODE')!='demo'?$key:''}}</textarea>
                            </div>

                            <div class="row" style="display: none">
                                @php($project_id=\App\Model\BusinessSetting::where('key','fcm_project_id')->first()->value)
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">FCM Project ID</label>
                                        <input type="text" value="{{$project_id}}"
                                               name="fcm_project_id" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary">{{\App\CentralLogics\translate('submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>

            <hr>
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">

                <div class="card">
                    <div class="card-header">
                        <h2>{{\App\CentralLogics\translate('push')}} {{\App\CentralLogics\translate('messages')}}</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.business-settings.update-fcm-messages')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                @php($opm=\App\Model\BusinessSetting::where('key','order_pending_message')->first()->value)
                                @php($data=json_decode($opm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="pending_status">
                                            <input type="checkbox" name="pending_status" class="toggle-switch-input"
                                                   value="1" id="pending_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                            <span
                                                class="d-block">{{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('pending')}} {{\App\CentralLogics\translate('message')}}</span>
                                          </span>
                                        </label>
                                        <textarea name="pending_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($ocm=\App\Model\BusinessSetting::where('key','order_confirmation_msg')->first()->value)
                                @php($data=json_decode($ocm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="confirm_status">
                                            <input type="checkbox" name="confirm_status" class="toggle-switch-input"
                                                   value="1" id="confirm_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block"> {{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('confirmation')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="confirm_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($oprm=\App\Model\BusinessSetting::where('key','order_processing_message')->first()->value)
                                @php($data=json_decode($oprm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="processing_status">
                                            <input type="checkbox" name="processing_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="processing_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('processing')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="processing_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($ofdm=\App\Model\BusinessSetting::where('key','out_for_delivery_message')->first()->value)
                                @php($data=json_decode($ofdm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="out_for_delivery">
                                            <input type="checkbox" name="out_for_delivery_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="out_for_delivery" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('out_for_delivery')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>
                                        <textarea name="out_for_delivery_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($odm=\App\Model\BusinessSetting::where('key','order_delivered_message')->first()->value)
                                @php($data=json_decode($odm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivered_status">
                                            <input type="checkbox" name="delivered_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="delivered_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('delivered')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivered_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($dba=\App\Model\BusinessSetting::where('key','delivery_boy_assign_message')->first()->value)
                                @php($data=json_decode($dba,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">

                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivery_boy_assign">
                                            <input type="checkbox" name="delivery_boy_assign_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="delivery_boy_assign" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CentralLogics\translate('deliveryman')}} {{\App\CentralLogics\translate('assign')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivery_boy_assign_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($dbs=\App\Model\BusinessSetting::where('key','delivery_boy_start_message')->first()->value)
                                @php($data=json_decode($dbs,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivery_boy_start_status">
                                            <input type="checkbox" name="delivery_boy_start_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="delivery_boy_start_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block"> {{\App\CentralLogics\translate('deliveryman')}} {{\App\CentralLogics\translate('start')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivery_boy_start_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($dbc=\App\Model\BusinessSetting::where('key','delivery_boy_delivered_message')->first()->value)
                                @php($data=json_decode($dbc,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">

                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivery_boy_delivered">
                                            <input type="checkbox" name="delivery_boy_delivered_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="delivery_boy_delivered" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CentralLogics\translate('deliveryman')}} {{\App\CentralLogics\translate('delivered')}} {{\App\CentralLogics\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivery_boy_delivered_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($data=\App\CentralLogics\Helpers::get_business_settings('returned_message'))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="returned_status">
                                            <input type="checkbox" name="returned_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="returned_status" {{(isset($data['status']) && $data['status']==1)?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                            <span class="toggle-switch-content">
                                                    <span
                                                        class="d-block">{{\App\CentralLogics\translate('Order_returned_message')}}</span>
                                                  </span>
                                        </label>
                                        <textarea name="returned_message"
                                                  class="form-control">{{$data['message']??''}}</textarea>
                                    </div>
                                </div>

                                @php($data=\App\CentralLogics\Helpers::get_business_settings('failed_message'))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="failed_status">
                                            <input type="checkbox" name="failed_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="failed_status" {{(isset($data['status']) && $data['status']==1)?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                            <span class="toggle-switch-content">
                                                    <span
                                                        class="d-block">{{\App\CentralLogics\translate('Order_failed_message')}}</span>
                                                  </span>
                                        </label>

                                        <textarea name="failed_message"
                                                  class="form-control">{{$data['message']??''}}</textarea>
                                    </div>
                                </div>

                                @php($data=\App\CentralLogics\Helpers::get_business_settings('canceled_message'))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="canceled_status">
                                            <input type="checkbox" name="canceled_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="canceled_status" {{(isset($data['status']) && $data['status']==1)?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                  </span>
                                            <span class="toggle-switch-content">
                                                    <span
                                                        class="d-block">{{\App\CentralLogics\translate('Order_canceled_message')}}</span>
                                                  </span>
                                        </label>

                                        <textarea name="canceled_message"
                                                  class="form-control">{{$data['message']??''}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">{{\App\CentralLogics\translate('submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush

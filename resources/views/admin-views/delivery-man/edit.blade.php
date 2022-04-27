@extends('layouts.admin.app')

@section('title','Update delivery-man')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i> {{\App\CentralLogics\translate('update')}} {{\App\CentralLogics\translate('deliveryman')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.delivery-man.update',[$delivery_man['id']])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('first')}} {{\App\CentralLogics\translate('name')}}</label>
                                <input type="text" value="{{$delivery_man['f_name']}}" name="f_name"
                                       class="form-control" placeholder="New delivery-man"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('last')}} {{\App\CentralLogics\translate('name')}}</label>
                                <input type="text" value="{{$delivery_man['l_name']}}" name="l_name"
                                       class="form-control" placeholder="Last Name"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('email')}}</label>
                                <input type="email" value="{{$delivery_man['email']}}" name="email" class="form-control"
                                       placeholder="Ex : ex@example.com"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('phone')}}</label>
                                <input type="text" name="phone" value="{{$delivery_man['phone']}}" class="form-control"
                                       placeholder="Ex : 017********"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('branch')}}</label>
                                <select name="branch_id" class="form-control">
                                    <option value="0" {{$delivery_man['branch_id']==0?'selected':''}}>{{\App\CentralLogics\translate('all')}}</option>
                                    @foreach(\App\Model\Branch::all() as $branch)
                                        <option value="{{$branch['id']}}" {{$delivery_man['branch_id']==$branch['id']?'selected':''}}>{{$branch['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('identity')}} {{\App\CentralLogics\translate('type')}}</label>
                                <select name="identity_type" class="form-control">
                                    <option
                                        value="passport" {{$delivery_man['identity_type']=='passport'?'selected':''}}>
                                        {{\App\CentralLogics\translate('passport')}}
                                    </option>
                                    <option
                                        value="driving_license" {{$delivery_man['identity_type']=='driving_license'?'selected':''}}>
                                        {{\App\CentralLogics\translate('driving')}} {{\App\CentralLogics\translate('license')}}
                                    </option>
                                    <option value="nid" {{$delivery_man['identity_type']=='nid'?'selected':''}}>{{\App\CentralLogics\translate('nid')}}
                                    </option>
                                    <option
                                        value="restaurant_id" {{$delivery_man['identity_type']=='restaurant_id'?'selected':''}}>
                                        {{\App\CentralLogics\translate('restaurant')}} {{\App\CentralLogics\translate('id')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('identity')}} {{\App\CentralLogics\translate('number')}}</label>
                                <input type="text" name="identity_number" value="{{$delivery_man['identity_number']}}"
                                       class="form-control"
                                       placeholder="Ex : DH-23434-LS"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('identity')}} {{\App\CentralLogics\translate('image')}}</label>
                                <div>
                                    <div class="row" id="coba"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('identity')}} {{\App\CentralLogics\translate('images')}} : </label>
                            </div>
                        </div>
                        <br>

                        @foreach(json_decode($delivery_man['identity_image'],true) as $img)
                            <div class="col-md-4 col-12 mb-2">
                                <img height="150" src="{{asset('storage/app/public/delivery-man').'/'.$img}}">
                            </div>
                        @endforeach
                        <hr>
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1">{{\App\CentralLogics\translate('password')}}</label>
                        <input type="text" name="password" class="form-control" placeholder="Ex : password">
                    </div>

                    <div class="form-group">
                        <label>{{\App\CentralLogics\translate('deliveryman')}} {{\App\CentralLogics\translate('image')}}</label><small style="color: red">* ( {{\App\CentralLogics\translate('ratio')}} 1:1 )</small>
                        <div class="custom-file">
                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                            <label class="custom-file-label" for="customFileEg1">{{\App\CentralLogics\translate('choose')}} {{\App\CentralLogics\translate('file')}}</label>
                        </div>
                        <hr>
                        <center>
                            <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                 src="{{asset('storage/app/public/delivery-man').'/'.$delivery_man['image']}}" alt="delivery-man image"/>
                        </center>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">{{\App\CentralLogics\translate('submit')}}</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>

    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-2',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/admin/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush

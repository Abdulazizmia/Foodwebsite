@extends('layouts.admin.app')

@section('title','Settings')

@push('css_or_js')
    <style>
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #banner-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #banner-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }

        @media (max-width: 500px) {
            #banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }


        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CentralLogics\translate('restaurant')}} {{\App\CentralLogics\translate('setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row">
            <div class="col-md-8 mb-3 mt-3">
                <div class="card">
                    <div class="card-body" style="padding-bottom: 12px">
                        <div class="row">
                            @php($config=\App\CentralLogics\Helpers::get_business_settings('maintenance_mode'))
                            <div class="col-6">
                                <h5>
                                    <i class="tio-settings-outlined"></i>
                                    {{\App\CentralLogics\translate('maintenance_mode')}}
                                </h5>
                            </div>
                            <div class="col-6">
                                <label class="switch ml-3 float-right">
                                    <input type="checkbox" class="status" onclick="maintenance_mode()"
                                        {{isset($config) && $config?'checked':''}}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  mb-3 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center"><i class="tio-money"></i> Currency Symbol Position</h5>
                        <i class="tio-dollar"></i>
                    </div>
                    <div class="card-body">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('currency_symbol_position'))
                        <div class="form-row">
                            <div class="col-sm mb-2 mb-sm-0">
                                <!-- Custom Radio -->
                                <div class="form-control">
                                    <div class="custom-control custom-radio custom-radio-reverse"
                                         onclick="currency_symbol_position('{{route('admin.business-settings.currency-position',['left'])}}')">
                                        <input type="radio" class="custom-control-input"
                                               name="projectViewNewProjectTypeRadio"
                                               id="projectViewNewProjectTypeRadio1" {{(isset($config) && $config=='left')?'checked':''}}>
                                        <label class="custom-control-label media align-items-center"
                                               for="projectViewNewProjectTypeRadio1">
                                            <i class="tio-agenda-view-outlined text-muted mr-2"></i>
                                            <span class="media-body">
                                               {{\App\CentralLogics\Helpers::currency_symbol()}} Left
                                              </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- End Custom Radio -->
                            </div>

                            <div class="col-sm mb-2 mb-sm-0">
                                <!-- Custom Radio -->
                                <div class="form-control">
                                    <div class="custom-control custom-radio custom-radio-reverse"
                                         onclick="currency_symbol_position('{{route('admin.business-settings.currency-position',['right'])}}')">
                                        <input type="radio" class="custom-control-input"
                                               name="projectViewNewProjectTypeRadio"
                                               id="projectViewNewProjectTypeRadio2" {{(isset($config) && $config=='right')?'checked':''}}>
                                        <label class="custom-control-label media align-items-center"
                                               for="projectViewNewProjectTypeRadio2">
                                            <i class="tio-table text-muted mr-2"></i>
                                            <span class="media-body">
                                        Right {{\App\CentralLogics\Helpers::currency_symbol()}}
                                      </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- End Custom Radio -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <center>
                    <h4><i class="tio-settings"></i>General settings form</h4>
                    <hr>
                </center>
                <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                    <form action="{{route('admin.business-settings.update-setup')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @php($name=\App\Model\BusinessSetting::where('key','restaurant_name')->first()->value)
                        <div class="form-group">
                            <label class="input-label"
                                   for="exampleFormControlInput1">{{\App\CentralLogics\translate('restaurant')}} {{\App\CentralLogics\translate('name')}}</label>
                            <input type="text" name="restaurant_name" value="{{$name}}" class="form-control"
                                   placeholder="New Restaurant" required>
                        </div>

                        <div class="row">
                            @php($open=\App\Model\BusinessSetting::where('key','restaurant_open_time')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('opening')}} {{\App\CentralLogics\translate('time')}}</label>
                                    <input type="time" value="{{$open}}"
                                           name="restaurant_open_time" class="form-control"
                                           placeholder="Ex : 10:30 am" required>
                                </div>
                            </div>
                            @php($close=\App\Model\BusinessSetting::where('key','restaurant_close_time')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('closing')}} {{\App\CentralLogics\translate('time')}}</label>
                                    <input type="time" value="{{$close}}"
                                           name="restaurant_close_time" class="form-control" placeholder="5:45 pm"
                                           required>
                                </div>
                            </div>
                            @php($currency_code=\App\Model\BusinessSetting::where('key','currency')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('currency')}}</label>
                                    <select name="currency" class="form-control js-select2-custom">
                                        @foreach(\App\Model\Currency::orderBy('currency_code')->get() as $currency)
                                            <option
                                                value="{{$currency['currency_code']}}" {{$currency_code==$currency['currency_code']?'selected':''}}>
                                                {{$currency['currency_code']}} ( {{$currency['currency_symbol']}} )
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="input-label" for="country">{{\App\CentralLogics\translate('country')}}</label>
                                    <select id="country" name="country" class="form-control  js-select2-custom">
                                        <option value="AF">Afghanistan</option>
                                        <option value="AX">Åland Islands</option>
                                        <option value="AL">Albania</option>
                                        <option value="DZ">Algeria</option>
                                        <option value="AS">American Samoa</option>
                                        <option value="AD">Andorra</option>
                                        <option value="AO">Angola</option>
                                        <option value="AI">Anguilla</option>
                                        <option value="AQ">Antarctica</option>
                                        <option value="AG">Antigua and Barbuda</option>
                                        <option value="AR">Argentina</option>
                                        <option value="AM">Armenia</option>
                                        <option value="AW">Aruba</option>
                                        <option value="AU">Australia</option>
                                        <option value="AT">Austria</option>
                                        <option value="AZ">Azerbaijan</option>
                                        <option value="BS">Bahamas</option>
                                        <option value="BH">Bahrain</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="BB">Barbados</option>
                                        <option value="BY">Belarus</option>
                                        <option value="BE">Belgium</option>
                                        <option value="BZ">Belize</option>
                                        <option value="BJ">Benin</option>
                                        <option value="BM">Bermuda</option>
                                        <option value="BT">Bhutan</option>
                                        <option value="BO">Bolivia, Plurinational State of</option>
                                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                        <option value="BA">Bosnia and Herzegovina</option>
                                        <option value="BW">Botswana</option>
                                        <option value="BV">Bouvet Island</option>
                                        <option value="BR">Brazil</option>
                                        <option value="IO">British Indian Ocean Territory</option>
                                        <option value="BN">Brunei Darussalam</option>
                                        <option value="BG">Bulgaria</option>
                                        <option value="BF">Burkina Faso</option>
                                        <option value="BI">Burundi</option>
                                        <option value="KH">Cambodia</option>
                                        <option value="CM">Cameroon</option>
                                        <option value="CA">Canada</option>
                                        <option value="CV">Cape Verde</option>
                                        <option value="KY">Cayman Islands</option>
                                        <option value="CF">Central African Republic</option>
                                        <option value="TD">Chad</option>
                                        <option value="CL">Chile</option>
                                        <option value="CN">China</option>
                                        <option value="CX">Christmas Island</option>
                                        <option value="CC">Cocos (Keeling) Islands</option>
                                        <option value="CO">Colombia</option>
                                        <option value="KM">Comoros</option>
                                        <option value="CG">Congo</option>
                                        <option value="CD">Congo, the Democratic Republic of the</option>
                                        <option value="CK">Cook Islands</option>
                                        <option value="CR">Costa Rica</option>
                                        <option value="CI">Côte d'Ivoire</option>
                                        <option value="HR">Croatia</option>
                                        <option value="CU">Cuba</option>
                                        <option value="CW">Curaçao</option>
                                        <option value="CY">Cyprus</option>
                                        <option value="CZ">Czech Republic</option>
                                        <option value="DK">Denmark</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="DM">Dominica</option>
                                        <option value="DO">Dominican Republic</option>
                                        <option value="EC">Ecuador</option>
                                        <option value="EG">Egypt</option>
                                        <option value="SV">El Salvador</option>
                                        <option value="GQ">Equatorial Guinea</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="EE">Estonia</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                        <option value="FO">Faroe Islands</option>
                                        <option value="FJ">Fiji</option>
                                        <option value="FI">Finland</option>
                                        <option value="FR">France</option>
                                        <option value="GF">French Guiana</option>
                                        <option value="PF">French Polynesia</option>
                                        <option value="TF">French Southern Territories</option>
                                        <option value="GA">Gabon</option>
                                        <option value="GM">Gambia</option>
                                        <option value="GE">Georgia</option>
                                        <option value="DE">Germany</option>
                                        <option value="GH">Ghana</option>
                                        <option value="GI">Gibraltar</option>
                                        <option value="GR">Greece</option>
                                        <option value="GL">Greenland</option>
                                        <option value="GD">Grenada</option>
                                        <option value="GP">Guadeloupe</option>
                                        <option value="GU">Guam</option>
                                        <option value="GT">Guatemala</option>
                                        <option value="GG">Guernsey</option>
                                        <option value="GN">Guinea</option>
                                        <option value="GW">Guinea-Bissau</option>
                                        <option value="GY">Guyana</option>
                                        <option value="HT">Haiti</option>
                                        <option value="HM">Heard Island and McDonald Islands</option>
                                        <option value="VA">Holy See (Vatican City State)</option>
                                        <option value="HN">Honduras</option>
                                        <option value="HK">Hong Kong</option>
                                        <option value="HU">Hungary</option>
                                        <option value="IS">Iceland</option>
                                        <option value="IN">India</option>
                                        <option value="ID">Indonesia</option>
                                        <option value="IR">Iran, Islamic Republic of</option>
                                        <option value="IQ">Iraq</option>
                                        <option value="IE">Ireland</option>
                                        <option value="IM">Isle of Man</option>
                                        <option value="IL">Israel</option>
                                        <option value="IT">Italy</option>
                                        <option value="JM">Jamaica</option>
                                        <option value="JP">Japan</option>
                                        <option value="JE">Jersey</option>
                                        <option value="JO">Jordan</option>
                                        <option value="KZ">Kazakhstan</option>
                                        <option value="KE">Kenya</option>
                                        <option value="KI">Kiribati</option>
                                        <option value="KP">Korea, Democratic People's Republic of</option>
                                        <option value="KR">Korea, Republic of</option>
                                        <option value="KW">Kuwait</option>
                                        <option value="KG">Kyrgyzstan</option>
                                        <option value="LA">Lao People's Democratic Republic</option>
                                        <option value="LV">Latvia</option>
                                        <option value="LB">Lebanon</option>
                                        <option value="LS">Lesotho</option>
                                        <option value="LR">Liberia</option>
                                        <option value="LY">Libya</option>
                                        <option value="LI">Liechtenstein</option>
                                        <option value="LT">Lithuania</option>
                                        <option value="LU">Luxembourg</option>
                                        <option value="MO">Macao</option>
                                        <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                        <option value="MG">Madagascar</option>
                                        <option value="MW">Malawi</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="MV">Maldives</option>
                                        <option value="ML">Mali</option>
                                        <option value="MT">Malta</option>
                                        <option value="MH">Marshall Islands</option>
                                        <option value="MQ">Martinique</option>
                                        <option value="MR">Mauritania</option>
                                        <option value="MU">Mauritius</option>
                                        <option value="YT">Mayotte</option>
                                        <option value="MX">Mexico</option>
                                        <option value="FM">Micronesia, Federated States of</option>
                                        <option value="MD">Moldova, Republic of</option>
                                        <option value="MC">Monaco</option>
                                        <option value="MN">Mongolia</option>
                                        <option value="ME">Montenegro</option>
                                        <option value="MS">Montserrat</option>
                                        <option value="MA">Morocco</option>
                                        <option value="MZ">Mozambique</option>
                                        <option value="MM">Myanmar</option>
                                        <option value="NA">Namibia</option>
                                        <option value="NR">Nauru</option>
                                        <option value="NP">Nepal</option>
                                        <option value="NL">Netherlands</option>
                                        <option value="NC">New Caledonia</option>
                                        <option value="NZ">New Zealand</option>
                                        <option value="NI">Nicaragua</option>
                                        <option value="NE">Niger</option>
                                        <option value="NG">Nigeria</option>
                                        <option value="NU">Niue</option>
                                        <option value="NF">Norfolk Island</option>
                                        <option value="MP">Northern Mariana Islands</option>
                                        <option value="NO">Norway</option>
                                        <option value="OM">Oman</option>
                                        <option value="PK">Pakistan</option>
                                        <option value="PW">Palau</option>
                                        <option value="PS">Palestinian Territory, Occupied</option>
                                        <option value="PA">Panama</option>
                                        <option value="PG">Papua New Guinea</option>
                                        <option value="PY">Paraguay</option>
                                        <option value="PE">Peru</option>
                                        <option value="PH">Philippines</option>
                                        <option value="PN">Pitcairn</option>
                                        <option value="PL">Poland</option>
                                        <option value="PT">Portugal</option>
                                        <option value="PR">Puerto Rico</option>
                                        <option value="QA">Qatar</option>
                                        <option value="RE">Réunion</option>
                                        <option value="RO">Romania</option>
                                        <option value="RU">Russian Federation</option>
                                        <option value="RW">Rwanda</option>
                                        <option value="BL">Saint Barthélemy</option>
                                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                        <option value="KN">Saint Kitts and Nevis</option>
                                        <option value="LC">Saint Lucia</option>
                                        <option value="MF">Saint Martin (French part)</option>
                                        <option value="PM">Saint Pierre and Miquelon</option>
                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                        <option value="WS">Samoa</option>
                                        <option value="SM">San Marino</option>
                                        <option value="ST">Sao Tome and Principe</option>
                                        <option value="SA">Saudi Arabia</option>
                                        <option value="SN">Senegal</option>
                                        <option value="RS">Serbia</option>
                                        <option value="SC">Seychelles</option>
                                        <option value="SL">Sierra Leone</option>
                                        <option value="SG">Singapore</option>
                                        <option value="SX">Sint Maarten (Dutch part)</option>
                                        <option value="SK">Slovakia</option>
                                        <option value="SI">Slovenia</option>
                                        <option value="SB">Solomon Islands</option>
                                        <option value="SO">Somalia</option>
                                        <option value="ZA">South Africa</option>
                                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                                        <option value="SS">South Sudan</option>
                                        <option value="ES">Spain</option>
                                        <option value="LK">Sri Lanka</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SR">Suriname</option>
                                        <option value="SJ">Svalbard and Jan Mayen</option>
                                        <option value="SZ">Swaziland</option>
                                        <option value="SE">Sweden</option>
                                        <option value="CH">Switzerland</option>
                                        <option value="SY">Syrian Arab Republic</option>
                                        <option value="TW">Taiwan, Province of China</option>
                                        <option value="TJ">Tajikistan</option>
                                        <option value="TZ">Tanzania, United Republic of</option>
                                        <option value="TH">Thailand</option>
                                        <option value="TL">Timor-Leste</option>
                                        <option value="TG">Togo</option>
                                        <option value="TK">Tokelau</option>
                                        <option value="TO">Tonga</option>
                                        <option value="TT">Trinidad and Tobago</option>
                                        <option value="TN">Tunisia</option>
                                        <option value="TR">Turkey</option>
                                        <option value="TM">Turkmenistan</option>
                                        <option value="TC">Turks and Caicos Islands</option>
                                        <option value="TV">Tuvalu</option>
                                        <option value="UG">Uganda</option>
                                        <option value="UA">Ukraine</option>
                                        <option value="AE">United Arab Emirates</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="US">United States</option>
                                        <option value="UM">United States Minor Outlying Islands</option>
                                        <option value="UY">Uruguay</option>
                                        <option value="UZ">Uzbekistan</option>
                                        <option value="VU">Vanuatu</option>
                                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                                        <option value="VN">Viet Nam</option>
                                        <option value="VG">Virgin Islands, British</option>
                                        <option value="VI">Virgin Islands, U.S.</option>
                                        <option value="WF">Wallis and Futuna</option>
                                        <option value="EH">Western Sahara</option>
                                        <option value="YE">Yemen</option>
                                        <option value="ZM">Zambia</option>
                                        <option value="ZW">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="alert alert-warning sticky-top" id="alert_box" style="display:none;">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    <strong>Warning!</strong> {{\App\CentralLogics\translate('language_warning')}} For documentaion <a
                                        href="https://documentation.6amtech.com/efood/docs/1.0/app-setup#section3" target="_blank">click
                                        here</a>.
                                </div>
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('product')}} {{\App\CentralLogics\translate('and')}} {{\App\CentralLogics\translate('category')}} {{\App\CentralLogics\translate('translation')}}</label>
                                    <select name="language[]" id="language" data-maximum-selection-length="3"
                                            class="form-control js-select2-custom" required multiple=true>
                                        <option value="en">English(default)</option>
                                        <option value="af">Afrikaans</option>
                                        <option value="sq">Albanian - shqip</option>
                                        <option value="am">Amharic - አማርኛ</option>
                                        <option value="ar">Arabic - العربية</option>
                                        <option value="an">Aragonese - aragonés</option>
                                        <option value="hy">Armenian - հայերեն</option>
                                        <option value="ast">Asturian - asturianu</option>
                                        <option value="az">Azerbaijani - azərbaycan dili</option>
                                        <option value="eu">Basque - euskara</option>
                                        <option value="be">Belarusian - беларуская</option>
                                        <option value="bn">Bengali - বাংলা</option>
                                        <option value="bs">Bosnian - bosanski</option>
                                        <option value="br">Breton - brezhoneg</option>
                                        <option value="bg">Bulgarian - български</option>
                                        <option value="ca">Catalan - català</option>
                                        <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                                        <option value="zh">Chinese - 中文</option>
                                        <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
                                        <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
                                        <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
                                        <option value="co">Corsican</option>
                                        <option value="hr">Croatian - hrvatski</option>
                                        <option value="cs">Czech - čeština</option>
                                        <option value="da">Danish - dansk</option>
                                        <option value="nl">Dutch - Nederlands</option>
                                        <option value="en-AU">English (Australia)</option>
                                        <option value="en-CA">English (Canada)</option>
                                        <option value="en-IN">English (India)</option>
                                        <option value="en-NZ">English (New Zealand)</option>
                                        <option value="en-ZA">English (South Africa)</option>
                                        <option value="en-GB">English (United Kingdom)</option>
                                        <option value="en-US">English (United States)</option>
                                        <option value="eo">Esperanto - esperanto</option>
                                        <option value="et">Estonian - eesti</option>
                                        <option value="fo">Faroese - føroyskt</option>
                                        <option value="fil">Filipino</option>
                                        <option value="fi">Finnish - suomi</option>
                                        <option value="fr">French - français</option>
                                        <option value="fr-CA">French (Canada) - français (Canada)</option>
                                        <option value="fr-FR">French (France) - français (France)</option>
                                        <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
                                        <option value="gl">Galician - galego</option>
                                        <option value="ka">Georgian - ქართული</option>
                                        <option value="de">German - Deutsch</option>
                                        <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
                                        <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
                                        <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein)</option>
                                        <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
                                        <option value="el">Greek - Ελληνικά</option>
                                        <option value="gn">Guarani</option>
                                        <option value="gu">Gujarati - ગુજરાતી</option>
                                        <option value="ha">Hausa</option>
                                        <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                                        <option value="he">Hebrew - עברית</option>
                                        <option value="hi">Hindi - हिन्दी</option>
                                        <option value="hu">Hungarian - magyar</option>
                                        <option value="is">Icelandic - íslenska</option>
                                        <option value="id">Indonesian - Indonesia</option>
                                        <option value="ia">Interlingua</option>
                                        <option value="ga">Irish - Gaeilge</option>
                                        <option value="it">Italian - italiano</option>
                                        <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
                                        <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)</option>
                                        <option value="ja">Japanese - 日本語</option>
                                        <option value="kn">Kannada - ಕನ್ನಡ</option>
                                        <option value="kk">Kazakh - қазақ тілі</option>
                                        <option value="km">Khmer - ខ្មែរ</option>
                                        <option value="ko">Korean - 한국어</option>
                                        <option value="ku">Kurdish - Kurdî</option>
                                        <option value="ky">Kyrgyz - кыргызча</option>
                                        <option value="lo">Lao - ລາວ</option>
                                        <option value="la">Latin</option>
                                        <option value="lv">Latvian - latviešu</option>
                                        <option value="ln">Lingala - lingála</option>
                                        <option value="lt">Lithuanian - lietuvių</option>
                                        <option value="mk">Macedonian - македонски</option>
                                        <option value="ms">Malay - Bahasa Melayu</option>
                                        <option value="ml">Malayalam - മലയാളം</option>
                                        <option value="mt">Maltese - Malti</option>
                                        <option value="mr">Marathi - मराठी</option>
                                        <option value="mn">Mongolian - монгол</option>
                                        <option value="ne">Nepali - नेपाली</option>
                                        <option value="no">Norwegian - norsk</option>
                                        <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                                        <option value="nn">Norwegian Nynorsk - nynorsk</option>
                                        <option value="oc">Occitan</option>
                                        <option value="or">Oriya - ଓଡ଼ିଆ</option>
                                        <option value="om">Oromo - Oromoo</option>
                                        <option value="ps">Pashto - پښتو</option>
                                        <option value="fa">Persian - فارسی</option>
                                        <option value="pl">Polish - polski</option>
                                        <option value="pt">Portuguese - português</option>
                                        <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
                                        <option value="pt-PT">Portuguese (Portugal) - português (Portugal)</option>
                                        <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                                        <option value="qu">Quechua</option>
                                        <option value="ro">Romanian - română</option>
                                        <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                                        <option value="rm">Romansh - rumantsch</option>
                                        <option value="ru">Russian - русский</option>
                                        <option value="gd">Scottish Gaelic</option>
                                        <option value="sr">Serbian - српски</option>
                                        <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                                        <option value="sn">Shona - chiShona</option>
                                        <option value="sd">Sindhi</option>
                                        <option value="si">Sinhala - සිංහල</option>
                                        <option value="sk">Slovak - slovenčina</option>
                                        <option value="sl">Slovenian - slovenščina</option>
                                        <option value="so">Somali - Soomaali</option>
                                        <option value="st">Southern Sotho</option>
                                        <option value="es">Spanish - español</option>
                                        <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
                                        <option value="es-419">Spanish (Latin America) - español (Latinoamérica)</option>
                                        <option value="es-MX">Spanish (Mexico) - español (México)</option>
                                        <option value="es-ES">Spanish (Spain) - español (España)</option>
                                        <option value="es-US">Spanish (United States) - español (Estados Unidos)</option>
                                        <option value="su">Sundanese</option>
                                        <option value="sw">Swahili - Kiswahili</option>
                                        <option value="sv">Swedish - svenska</option>
                                        <option value="tg">Tajik - тоҷикӣ</option>
                                        <option value="ta">Tamil - தமிழ்</option>
                                        <option value="tt">Tatar</option>
                                        <option value="te">Telugu - తెలుగు</option>
                                        <option value="th">Thai - ไทย</option>
                                        <option value="ti">Tigrinya - ትግርኛ</option>
                                        <option value="to">Tongan - lea fakatonga</option>
                                        <option value="tr">Turkish - Türkçe</option>
                                        <option value="tk">Turkmen</option>
                                        <option value="tw">Twi</option>
                                        <option value="uk">Ukrainian - українська</option>
                                        <option value="ur">Urdu - اردو</option>
                                        <option value="ug">Uyghur</option>
                                        <option value="uz">Uzbek - o‘zbek</option>
                                        <option value="vi">Vietnamese - Tiếng Việt</option>
                                        <option value="wa">Walloon - wa</option>
                                        <option value="cy">Welsh - Cymraeg</option>
                                        <option value="fy">Western Frisian</option>
                                        <option value="xh">Xhosa</option>
                                        <option value="yi">Yiddish</option>
                                        <option value="yo">Yoruba - Èdè Yorùbá</option>
                                        <option value="zu">Zulu - isiZulu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('time_zone')}}</label>
                                    <select name="time_zone" id="time_zone" data-maximum-selection-length="3"
                                            class="form-control js-select2-custom">
                                        <option value='Pacific/Midway'>(UTC-11:00) Midway Island</option>
                                        <option value='Pacific/Samoa'>(UTC-11:00) Samoa</option>
                                        <option value='Pacific/Honolulu'>(UTC-10:00) Hawaii</option>
                                        <option value='US/Alaska'>(UTC-09:00) Alaska</option>
                                        <option value='America/Los_Angeles'>(UTC-08:00) Pacific Time (US &amp; Canada)
                                        </option>
                                        <option value='America/Tijuana'>(UTC-08:00) Tijuana</option>
                                        <option value='US/Arizona'>(UTC-07:00) Arizona</option>
                                        <option value='America/Chihuahua'>(UTC-07:00) Chihuahua</option>
                                        <option value='America/Chihuahua'>(UTC-07:00) La Paz</option>
                                        <option value='America/Mazatlan'>(UTC-07:00) Mazatlan</option>
                                        <option value='US/Mountain'>(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                        <option value='America/Managua'>(UTC-06:00) Central America</option>
                                        <option value='US/Central'>(UTC-06:00) Central Time (US &amp; Canada)</option>
                                        <option value='America/Mexico_City'>(UTC-06:00) Guadalajara</option>
                                        <option value='America/Mexico_City'>(UTC-06:00) Mexico City</option>
                                        <option value='America/Monterrey'>(UTC-06:00) Monterrey</option>
                                        <option value='Canada/Saskatchewan'>(UTC-06:00) Saskatchewan</option>
                                        <option value='America/Bogota'>(UTC-05:00) Bogota</option>
                                        <option value='US/Eastern'>(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                        <option value='US/East-Indiana'>(UTC-05:00) Indiana (East)</option>
                                        <option value='America/Lima'>(UTC-05:00) Lima</option>
                                        <option value='America/Bogota'>(UTC-05:00) Quito</option>
                                        <option value='Canada/Atlantic'>(UTC-04:00) Atlantic Time (Canada)</option>
                                        <option value='America/Caracas'>(UTC-04:30) Caracas</option>
                                        <option value='America/La_Paz'>(UTC-04:00) La Paz</option>
                                        <option value='America/Santiago'>(UTC-04:00) Santiago</option>
                                        <option value='Canada/Newfoundland'>(UTC-03:30) Newfoundland</option>
                                        <option value='America/Sao_Paulo'>(UTC-03:00) Brasilia</option>
                                        <option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Buenos Aires</option>
                                        <option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Georgetown</option>
                                        <option value='America/Godthab'>(UTC-03:00) Greenland</option>
                                        <option value='America/Noronha'>(UTC-02:00) Mid-Atlantic</option>
                                        <option value='Atlantic/Azores'>(UTC-01:00) Azores</option>
                                        <option value='Atlantic/Cape_Verde'>(UTC-01:00) Cape Verde Is.</option>
                                        <option value='Africa/Casablanca'>(UTC+00:00) Casablanca</option>
                                        <option value='Europe/London'>(UTC+00:00) Edinburgh</option>
                                        <option value='Etc/Greenwich'>(UTC+00:00) Greenwich Mean Time : Dublin</option>
                                        <option value='Europe/Lisbon'>(UTC+00:00) Lisbon</option>
                                        <option value='Europe/London'>(UTC+00:00) London</option>
                                        <option value='Africa/Monrovia'>(UTC+00:00) Monrovia</option>
                                        <option value='UTC'>(UTC+00:00) UTC</option>
                                        <option value='Europe/Amsterdam'>(UTC+01:00) Amsterdam</option>
                                        <option value='Europe/Belgrade'>(UTC+01:00) Belgrade</option>
                                        <option value='Europe/Berlin'>(UTC+01:00) Berlin</option>
                                        <option value='Europe/Berlin'>(UTC+01:00) Bern</option>
                                        <option value='Europe/Bratislava'>(UTC+01:00) Bratislava</option>
                                        <option value='Europe/Brussels'>(UTC+01:00) Brussels</option>
                                        <option value='Europe/Budapest'>(UTC+01:00) Budapest</option>
                                        <option value='Europe/Copenhagen'>(UTC+01:00) Copenhagen</option>
                                        <option value='Europe/Ljubljana'>(UTC+01:00) Ljubljana</option>
                                        <option value='Europe/Madrid'>(UTC+01:00) Madrid</option>
                                        <option value='Europe/Paris'>(UTC+01:00) Paris</option>
                                        <option value='Europe/Prague'>(UTC+01:00) Prague</option>
                                        <option value='Europe/Rome'>(UTC+01:00) Rome</option>
                                        <option value='Europe/Sarajevo'>(UTC+01:00) Sarajevo</option>
                                        <option value='Europe/Skopje'>(UTC+01:00) Skopje</option>
                                        <option value='Europe/Stockholm'>(UTC+01:00) Stockholm</option>
                                        <option value='Europe/Vienna'>(UTC+01:00) Vienna</option>
                                        <option value='Europe/Warsaw'>(UTC+01:00) Warsaw</option>
                                        <option value='Africa/Lagos'>(UTC+01:00) West Central Africa</option>
                                        <option value='Europe/Zagreb'>(UTC+01:00) Zagreb</option>
                                        <option value='Europe/Athens'>(UTC+02:00) Athens</option>
                                        <option value='Europe/Bucharest'>(UTC+02:00) Bucharest</option>
                                        <option value='Africa/Cairo'>(UTC+02:00) Cairo</option>
                                        <option value='Africa/Harare'>(UTC+02:00) Harare</option>
                                        <option value='Europe/Helsinki'>(UTC+02:00) Helsinki</option>
                                        <option value='Europe/Istanbul'>(UTC+02:00) Istanbul</option>
                                        <option value='Asia/Jerusalem'>(UTC+02:00) Jerusalem</option>
                                        <option value='Europe/Helsinki'>(UTC+02:00) Kyiv</option>
                                        <option value='Africa/Johannesburg'>(UTC+02:00) Pretoria</option>
                                        <option value='Europe/Riga'>(UTC+02:00) Riga</option>
                                        <option value='Europe/Sofia'>(UTC+02:00) Sofia</option>
                                        <option value='Europe/Tallinn'>(UTC+02:00) Tallinn</option>
                                        <option value='Europe/Vilnius'>(UTC+02:00) Vilnius</option>
                                        <option value='Asia/Baghdad'>(UTC+03:00) Baghdad</option>
                                        <option value='Asia/Kuwait'>(UTC+03:00) Kuwait</option>
                                        <option value='Europe/Minsk'>(UTC+03:00) Minsk</option>
                                        <option value='Africa/Nairobi'>(UTC+03:00) Nairobi</option>
                                        <option value='Asia/Riyadh'>(UTC+03:00) Riyadh</option>
                                        <option value='Europe/Volgograd'>(UTC+03:00) Volgograd</option>
                                        <option value='Asia/Tehran'>(UTC+03:30) Tehran</option>
                                        <option value='Asia/Muscat'>(UTC+04:00) Abu Dhabi</option>
                                        <option value='Asia/Baku'>(UTC+04:00) Baku</option>
                                        <option value='Europe/Moscow'>(UTC+04:00) Moscow</option>
                                        <option value='Asia/Muscat'>(UTC+04:00) Muscat</option>
                                        <option value='Europe/Moscow'>(UTC+04:00) St. Petersburg</option>
                                        <option value='Asia/Tbilisi'>(UTC+04:00) Tbilisi</option>
                                        <option value='Asia/Yerevan'>(UTC+04:00) Yerevan</option>
                                        <option value='Asia/Kabul'>(UTC+04:30) Kabul</option>
                                        <option value='Asia/Karachi'>(UTC+05:00) Islamabad</option>
                                        <option value='Asia/Karachi'>(UTC+05:00) Karachi</option>
                                        <option value='Asia/Tashkent'>(UTC+05:00) Tashkent</option>
                                        <option value='Asia/Calcutta'>(UTC+05:30) Chennai</option>
                                        <option value='Asia/Kolkata'>(UTC+05:30) Kolkata</option>
                                        <option value='Asia/Calcutta'>(UTC+05:30) Mumbai</option>
                                        <option value='Asia/Calcutta'>(UTC+05:30) New Delhi</option>
                                        <option value='Asia/Calcutta'>(UTC+05:30) Sri Jayawardenepura</option>
                                        <option value='Asia/Katmandu'>(UTC+05:45) Kathmandu</option>
                                        <option value='Asia/Almaty'>(UTC+06:00) Almaty</option>
                                        <option value='Asia/Dhaka'>(UTC+06:00) Dhaka</option>
                                        <option value='Asia/Yekaterinburg'>(UTC+06:00) Ekaterinburg</option>
                                        <option value='Asia/Rangoon'>(UTC+06:30) Rangoon</option>
                                        <option value='Asia/Bangkok'>(UTC+07:00) Bangkok</option>
                                        <option value='Asia/Bangkok'>(UTC+07:00) Hanoi</option>
                                        <option value='Asia/Jakarta'>(UTC+07:00) Jakarta</option>
                                        <option value='Asia/Novosibirsk'>(UTC+07:00) Novosibirsk</option>
                                        <option value='Asia/Hong_Kong'>(UTC+08:00) Beijing</option>
                                        <option value='Asia/Chongqing'>(UTC+08:00) Chongqing</option>
                                        <option value='Asia/Hong_Kong'>(UTC+08:00) Hong Kong</option>
                                        <option value='Asia/Krasnoyarsk'>(UTC+08:00) Krasnoyarsk</option>
                                        <option value='Asia/Kuala_Lumpur'>(UTC+08:00) Kuala Lumpur</option>
                                        <option value='Australia/Perth'>(UTC+08:00) Perth</option>
                                        <option value='Asia/Singapore'>(UTC+08:00) Singapore</option>
                                        <option value='Asia/Taipei'>(UTC+08:00) Taipei</option>
                                        <option value='Asia/Ulan_Bator'>(UTC+08:00) Ulaan Bataar</option>
                                        <option value='Asia/Urumqi'>(UTC+08:00) Urumqi</option>
                                        <option value='Asia/Irkutsk'>(UTC+09:00) Irkutsk</option>
                                        <option value='Asia/Tokyo'>(UTC+09:00) Osaka</option>
                                        <option value='Asia/Tokyo'>(UTC+09:00) Sapporo</option>
                                        <option value='Asia/Seoul'>(UTC+09:00) Seoul</option>
                                        <option value='Asia/Tokyo'>(UTC+09:00) Tokyo</option>
                                        <option value='Australia/Adelaide'>(UTC+09:30) Adelaide</option>
                                        <option value='Australia/Darwin'>(UTC+09:30) Darwin</option>
                                        <option value='Australia/Brisbane'>(UTC+10:00) Brisbane</option>
                                        <option value='Australia/Canberra'>(UTC+10:00) Canberra</option>
                                        <option value='Pacific/Guam'>(UTC+10:00) Guam</option>
                                        <option value='Australia/Hobart'>(UTC+10:00) Hobart</option>
                                        <option value='Australia/Melbourne'>(UTC+10:00) Melbourne</option>
                                        <option value='Pacific/Port_Moresby'>(UTC+10:00) Port Moresby</option>
                                        <option value='Australia/Sydney'>(UTC+10:00) Sydney</option>
                                        <option value='Asia/Yakutsk'>(UTC+10:00) Yakutsk</option>
                                        <option value='Asia/Vladivostok'>(UTC+11:00) Vladivostok</option>
                                        <option value='Pacific/Auckland'>(UTC+12:00) Auckland</option>
                                        <option value='Pacific/Fiji'>(UTC+12:00) Fiji</option>
                                        <option value='Pacific/Kwajalein'>(UTC+12:00) International Date Line West</option>
                                        <option value='Asia/Kamchatka'>(UTC+12:00) Kamchatka</option>
                                        <option value='Asia/Magadan'>(UTC+12:00) Magadan</option>
                                        <option value='Pacific/Fiji'>(UTC+12:00) Marshall Is.</option>
                                        <option value='Asia/Magadan'>(UTC+12:00) New Caledonia</option>
                                        <option value='Asia/Magadan'>(UTC+12:00) Solomon Is.</option>
                                        <option value='Pacific/Auckland'>(UTC+12:00) Wellington</option>
                                        <option value='Pacific/Tongatapu'>(UTC+13:00) Nuku'alofa</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @php($phone=\App\Model\BusinessSetting::where('key','phone')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('phone')}}</label>
                                    <input type="text" value="{{$phone}}"
                                           name="phone" class="form-control"
                                           placeholder="" required>
                                </div>
                            </div>
                            @php($email=\App\Model\BusinessSetting::where('key','email_address')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('email')}}</label>
                                    <input type="email" value="{{$email}}"
                                           name="email" class="form-control" placeholder=""
                                           required>
                                </div>
                            </div>
                            @php($address=\App\Model\BusinessSetting::where('key','address')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('address')}}</label>
                                    <input type="text" value="{{$address}}"
                                           name="address" class="form-control" placeholder=""
                                           required>
                                </div>
                            </div>

                            @php($mov=\App\Model\BusinessSetting::where('key','minimum_order_value')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('min')}} {{\App\CentralLogics\translate('order')}} {{\App\CentralLogics\translate('value')}}
                                        ( {{\App\CentralLogics\Helpers::currency_symbol()}} )</label>
                                    <input type="number" min="1" value="{{$mov}}"
                                           name="minimum_order_value" class="form-control" placeholder=""
                                           required>
                                </div>
                            </div>
                            @php($value=\App\Model\BusinessSetting::where('key','point_per_currency')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1"> <strong>1
                                            ( {{\App\CentralLogics\Helpers::currency_symbol()}} )
                                            = {{$value}} {{\App\CentralLogics\translate('internal')}} {{\App\CentralLogics\translate('points')}}</strong>
                                    </label>
                                    <input type="number" min="1" value="{{$value}}"
                                           name="point_per_currency" class="form-control" placeholder=""
                                           required>
                                </div>
                            </div>

                            @php($pagination_limit=\App\Model\BusinessSetting::where('key','pagination_limit')->first()->value)
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('pagination')}} {{\App\CentralLogics\translate('settings')}}</label>
                                    <input type="text" value="{{$pagination_limit}}"
                                           name="pagination_limit" class="form-control" placeholder=""
                                           required>
                                </div>
                            </div>

                            @php($footer_text=\App\Model\BusinessSetting::where('key','footer_text')->first()->value)
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('footer')}} {{\App\CentralLogics\translate('text')}}</label>
                                    <input type="text" value="{{$footer_text}}"
                                           name="footer_text" class="form-control" placeholder=""
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                @php($pv=\App\CentralLogics\Helpers::get_business_settings('phone_verification'))
                                <div class="form-group">
                                    <label>{{\App\CentralLogics\translate('phone')}} {{\App\CentralLogics\translate('verification')}} ( OTP
                                        )</label><small style="color: red">*</small>
                                    <div class="input-group input-group-md-down-break">
                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="1"
                                                       name="phone_verification"
                                                       id="phone_verification_on" {{(isset($pv) && $pv==1)?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="phone_verification_on">{{\App\CentralLogics\translate('on')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->

                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="0"
                                                       name="phone_verification"
                                                       id="phone_verification_off" {{(isset($pv) && $pv==0)?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="phone_verification_off">{{\App\CentralLogics\translate('off')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                @php($sp=\App\CentralLogics\Helpers::get_business_settings('self_pickup'))
                                <div class="form-group">
                                    <label>{{\App\CentralLogics\translate('self_pickup')}}</label><small style="color: red">*</small>
                                    <div class="input-group input-group-md-down-break">
                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="1"
                                                       name="self_pickup"
                                                       id="sp1" {{$sp==1?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="sp1">{{\App\CentralLogics\translate('on')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->

                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="0"
                                                       name="self_pickup"
                                                       id="sp2" {{$sp==0?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="sp2">{{\App\CentralLogics\translate('off')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                @php($sp=\App\CentralLogics\Helpers::get_business_settings('delivery'))
                                <div class="form-group">
                                    <label>{{\App\CentralLogics\translate('delivery')}}</label><small style="color: red">*</small>
                                    <div class="input-group input-group-md-down-break">
                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="1"
                                                       name="delivery"
                                                       id="dl1" {{$sp==1?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="dl1">{{\App\CentralLogics\translate('on')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->

                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="0"
                                                       name="delivery"
                                                       id="dl2" {{$sp==0?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="dl2">{{\App\CentralLogics\translate('off')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                @php($ev=\App\Model\BusinessSetting::where('key','email_verification')->first()->value)
                                <div class="form-group">
                                    <label>{{\App\CentralLogics\translate('email')}} {{\App\CentralLogics\translate('verification')}}</label><small
                                        style="color: red">*</small>
                                    <div class="input-group input-group-md-down-break">
                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="1"
                                                       name="email_verification"
                                                       id="email_verification_on" {{$ev==1?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="email_verification_on">{{\App\CentralLogics\translate('on')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->

                                        <!-- Custom Radio -->
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="0"
                                                       name="email_verification"
                                                       id="email_verification_off" {{$ev==0?'checked':''}}>
                                                <label class="custom-control-label"
                                                       for="email_verification_off">{{\App\CentralLogics\translate('off')}}</label>
                                            </div>
                                        </div>
                                        <!-- End Custom Radio -->
                                    </div>
                                </div>
                            </div>

                            @php($config=\App\CentralLogics\Helpers::get_business_settings('delivery_management'))
                            <div class="col-md-6 col-12">
                                @php($delivery=\App\Model\BusinessSetting::where('key','delivery_charge')->first()->value)
                                <div class="form-group">
                                    <label class="input-label"
                                           for="exampleFormControlInput1">{{\App\CentralLogics\translate('delivery')}} {{\App\CentralLogics\translate('charge')}}</label>
                                    <input type="number" min="0" step=".01" id="delivery_charge" name="delivery_charge" value="{{$delivery}}"
                                           class="form-control" placeholder="Ex: 100" required {{$config['status']==1?'disabled':''}}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body" style="padding: 20px">
                                        <h5 class="text-center">{{\App\CentralLogics\translate('delivery')}} {{\App\CentralLogics\translate('management')}}</h5>
                                        @csrf
                                        <div class="form-group mb-2 mt-2">
                                            <input type="radio" id="shipping_by_distance_status" name="shipping_status" value="1" {{$config['status']==1?'checked':''}}>
                                            <label style="padding-left: 10px">{{\App\CentralLogics\translate('delivery')}} {{\App\CentralLogics\translate('charge')}} {{\App\CentralLogics\translate('by_distance')}}</label>
                                            <br>
                                        </div>
                                        <div class="form-group mb-2">
                                            <input type="radio" id="default_delivery_status" name="shipping_status" value="0" {{$config['status']==0?'checked':''}}>
                                            <label
                                                style="padding-left: 10px">{{\App\CentralLogics\translate('default')}} {{\App\CentralLogics\translate('delivery')}} {{\App\CentralLogics\translate('charge')}}</label>
                                            <br>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label style="padding-left: 10px">{{\App\CentralLogics\translate('minimum')}} {{\App\CentralLogics\translate('shipping')}} {{\App\CentralLogics\translate('charge')}}</label>
                                            <input type="number" min="0" step=".01" id="min_shipping_charge" name="min_shipping_charge" value="{{$config['min_shipping_charge']}}" class="form-control" placeholder="100" {{$config['status']==0?'disabled':''}}>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label style="padding-left: 10px">{{\App\CentralLogics\translate('shipping')}} {{\App\CentralLogics\translate('charge')}} / {{\App\CentralLogics\translate('kilometer')}}</label>
                                            <input type="number" min="0" step=".01" id="shipping_per_km" name="shipping_per_km" value="{{$config['shipping_per_km']}}" class="form-control" placeholder="20" {{$config['status']==0?'disabled':''}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php($logo=\App\Model\BusinessSetting::where('key','logo')->first()->value)
                        <div class="form-group mt-3">
                            <label>{{\App\CentralLogics\translate('logo')}}</label><small style="color: red">*
                                ( {{\App\CentralLogics\translate('ratio')}} 3:1 )</small>
                            <div class="custom-file">
                                <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label"
                                       for="customFileEg1">{{\App\CentralLogics\translate('choose')}} {{\App\CentralLogics\translate('file')}}</label>
                            </div>
                            <hr>
                            <center>
                                <img style="height: 100px;border: 1px solid; border-radius: 10px;" id="viewer"
                                     onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                     src="{{asset('storage/app/public/restaurant/'.$logo)}}" alt="logo image"/>
                            </center>
                        </div>
                        <hr>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{\App\CentralLogics\translate('submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        @php($time_zone=\App\Model\BusinessSetting::where('key','time_zone')->first())
        @php($time_zone = $time_zone->value ?? null)
        $('[name=time_zone]').val("{{$time_zone}}");

        @php($language=\App\Model\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        let language = <?php echo($language); ?>;
        $('[id=language]').val(language);

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
        $("#language").on("change", function () {
            $("#alert_box").css("display", "block");
        });
    </script>

    <script>
        @if(env('APP_MODE')=='demo')
        function maintenance_mode() {
            toastr.info('Disabled for demo version!')
        }
        @else
        function maintenance_mode() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Be careful before you turn on/off maintenance mode',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '{{route('admin.business-settings.maintenance-mode')}}',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })
        };
        @endif

        function currency_symbol_position(route) {
            $.get({
                url: route,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    toastr.success(data.message);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $(document).on('ready', function () {
            @php($country=\App\CentralLogics\Helpers::get_business_settings('country')??'BD')
            $("#country option[value='{{$country}}']").attr('selected', 'selected').change();
        })
    </script>

    <script>
        $('#shipping_by_distance_status').on('click',function(){
            $("#delivery_charge").prop('disabled', true);
            $("#min_shipping_charge").prop('disabled', false);
            $("#shipping_per_km").prop('disabled', false);
        });

        $('#default_delivery_status').on('click',function(){
            $("#delivery_charge").prop('disabled', false);
            $("#min_shipping_charge").prop('disabled', true);
            $("#shipping_per_km").prop('disabled', true);
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#phone_verification_on").click(function () {
                if ($('#email_verification_on').prop("checked") == true) {
                    $('#email_verification_off').prop("checked", true);
                    $('#email_verification_on').prop("checked", false);
                    const message = "Both Phone & Email verification can't be active at a time";
                    toastr.info(message);
                }
            });
            $("#email_verification_on").click(function () {
                if ($('#phone_verification_on').prop("checked") == true) {
                    $('#phone_verification_off').prop("checked", true);
                    $('#phone_verification_on').prop("checked", false);
                    const message = "Both Phone & Email verification can't be active at a time";
                    toastr.info(message);
                }
            });
        });
    </script>
@endpush

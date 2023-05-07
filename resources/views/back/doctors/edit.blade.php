@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
    <!---Internal Fancy uploader css-->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
@section('title')
    تعديل معلوتات الطبيب
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاقسام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                معلومات الطبيب</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>خطا</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-primary btn-sm" href="{{ route('doctors.index') }}">رجوع</a>
                </div>
            </div><br>

            <form action="{{ route('doctors.update', $doctorAll->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-forms.input hidden="" name="subgrp" :value="$section" />
                <x-forms.input hidden="" name="doctor_id" :value="$doctorAll->id" />
                <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <x-forms.input label="اسم الطبيب:"  requiredInput="*" class="required" name="name_ar" :value="$doctorAll->name_ar" />
                        </div>
                    </div>

                <div class="row mg-b-20">

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.input label="رقم الهاتف: " requiredInput="*" class="required" name="phone_number" :value="$doctorAll->phone_number" />
                    </div>
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">ايميله : </span></x-forms.label>
                        <select name="user_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($users as $key => $value1)
                                <option value="{{ $value1->id }}" @if($value1->id==$doctorAll->user_id)selected @endif >{{ $value1->email }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">الجنس : </span></x-forms.label>
                        <select name="sex" class="form-control select2">
                            <option value="1" @if($doctorAll->sex=='1')selected @endif>ذكر</option>
                            <option value="2" @if($doctorAll->sex=='2')selected @endif>انثى</option>
                        </select>
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">حالة العمل: </span></x-forms.label>
                        <select name="act" class="form-control select2">
                            <option value="1" @if($doctorAll->act=='1')selected @endif>ضمن الدوام</option>
                            <option value="2" @if($doctorAll->act=='2')selected @endif>خارج الدوام</option>
                        </select>
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.input label="مدة المعاينة بدقيقة: " requiredInput="*" class="required" name="slot_time" :value="$doctorAll->slot_time"/>

                    </div>
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <div class="row mg-b-20">
                            <div class=" col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <x-forms.input label=" دوام من الساعة: " type="time" requiredInput="*" class="required" name="from_time" :value="$doctorAll->from_time" />
                            </div>
                            <div class=" col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <x-forms.input label="الي الساعة: " type="time" requiredInput="*" class="required" name="to_time" :value="$doctorAll->to_time" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">وصف عن الطبيب : </span></x-forms.label>

                            <textarea class="form-control" name="specialization_ar" style="height: 215px;" placeholder="Textarea" rows="3">{{$doctorAll->specialization_ar}}</textarea>

                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        @if ($doctorAll->photo)
                            <x-forms.input label="صورة الطبيب " requiredInput="*" name="photo" type="file" class="dropify" data-default-file="{{asset('img/'.$doctorAll->photo)}}" data-height="200" />
                        @else
                            <x-forms.input label="صورة الطبيب " requiredInput="*" name="photo" type="file" class="dropify" data-height="200" />
                        @endif
                    </div>
                </div>

                <div class="mg-t-30">
                    <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
@endsection

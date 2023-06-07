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

@stop

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <div class="my-auto">
                    <div class="d-flex">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style2">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/' . $page='dashboard') }}">الصفحة الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active">تعديل الاعلان</li>
                            </ol></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span></button>
            <strong>Well done!</strong> {{ session('success') }}.
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mg-b-0" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span></button>
            <strong>Oh snap!</strong> {{ session('error') }}.
        </div>
    @endif


    <div class="card">
        <div class="card-body">
            <form action="{{ route('ads.update',$id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-12" id="fnWrapper">
                        <div style="background-color: #e4efff;
    width: 190px;
    padding-right: 18px;
    padding-top: 9px;
    /* padding-bottom: 0px; */
    border-radius: 33px;
    margin-bottom: 16px;">
                            <input type="radio" required value="1" @if($ad->statue == 1) checked @endif style="margin-left: 5px;width: 15px;height: 15px;" name="statue">
                            <label for="outline" style="margin-left: 11px;color: #069f06;font-size: 18px;">معروض</label>
                            <input type="radio" required value="0" @if($ad->statue == 0) checked @endif style="margin-left: 5px;width: 15px;height: 15px;" name="statue">
                            <label for="outline" style="margin-left: 20px;color: #cf0000;font-size: 18px;">مخفي</label>
                        </div>
                    </div>
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">نص الأعلان : </span></x-forms.label>

                        <textarea class="form-control" name="text" style="height: 215px;" placeholder="Textarea" rows="3">{{$ad->text}}</textarea>

                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        @if ($ad->img)
                            <x-forms.input label="صورة الأعلان :" requiredInput="*" name="img" type="file" class="dropify" data-default-file="{{asset('img/'.$ad->img)}}" data-height="200" />
                        @else
                            <x-forms.input label="صورة الأعلان :" requiredInput="*" name="img" type="file" class="dropify" data-height="200" />
                        @endif
                    </div>
                </div>

                <div class="mg-t-30">
                    <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
@endsection
@section('js')
    <!-- Internal Treeview js -->
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

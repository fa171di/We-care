@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

@section('title')
    تعديل مستخدم
@stop


@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/' . $page='dashboard') }}">الصفحة الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/' . $page='patients') }}">المرضى</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('visits.show', $info->patient) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('services.show', $visit) }}">ملف الزيارة</a>
                        </li>
                        <li class="breadcrumb-item active">تعديل مؤشرات النمو</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">مؤشرات النمو</div>
                </div>
            </div><br>

            <form id="info" action="{{route('patients_info.update','test')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                    <x-forms.input id="" hidden="" name="id" :value="$info->id" />
                    <x-forms.input id="" hidden="" name="visit" :value="$visit" />
                    <x-forms.input id="" hidden="" name="sex" :value="$info->sex" />
                    <x-forms.input id="" hidden="" name="birth_date" :value="$info->birth_date" />
                    <x-forms.input id="" hidden="" name="patient" :value="$info->patient" />
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-4" id="fnWrapper">
                            <x-forms.input label="الطول: " id="height" :value="$info->height" class="required" name="height"  />
                        </div>
                        <div class="parsley-input col-md-4" id="fnWrapper">
                            <x-forms.input label="طول الاب: " id="father_height" :value="$info->father_height" class="required" name="father_height"  />
                        </div>
                        <div class="parsley-input col-md-4" id="fnWrapper">
                            <x-forms.input label="طول الام: "  id="mother_height" :value="$info->mother_height" class="required" name="mother_height"  />
                        </div>
                    </div>

                <div class="mg-t-30">
                    <button id="vSubmit" class="btn btn-main-primary pd-x-20" type="submit">اضافة</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
<script>
    $('#info').submit(function(e){
        e.preventDefault();

        var height = $("#height").val();
        var father_height = $("#father_height").val();
        var mother_height = $("#mother_height").val();

        if(height=='') {
            alert("You have to fill in the field.");
            return false;
        }
        if(father_height=='') {
            alert("You have to fill in the field.");
            return false;
        }
        if(mother_height=='') {
            alert("You have to fill in the field.");
            return false;
        }
    }
</script>
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

@endsection

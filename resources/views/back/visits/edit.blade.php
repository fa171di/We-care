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
                        <li class="breadcrumb-item active">
                            <a href="{{ route('visits.show', $visit->patient) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item active">تعديل الزيارة</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

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
                    <form action="{{ route('visits.update', $visit->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="user_id" id="user_id" value="{{$visit->patient}}">

                        <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <x-forms.label id=""><span class="">اختر عيادة</span></x-forms.label>
                                    <select name="clinic" class="form-control select2" requiredInput="*">
                                        <option></option>
                                        @foreach ($clinics as $key => $value)
                                            <option value="{{$value->id}}" @if($value->id == $visit->clinic ) selected @endif >{{ $value->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <x-forms.label id=""><span class="">ادخل ملاحظة </span></x-forms.label>
                                <textarea class="form-control" style="height: 41px;" placeholder="Textarea" rows="3" name="note">{{$visit->note}}</textarea>
                            </div>
                        </div>
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <x-forms.input label="التكلفة: "  oninvalid="this.setCustomValidity('يجب ان تدخل رقم')" onchange="this.setCustomValidity('')" inputmode="numeric" pattern="[0-9]*"  :value="$visit->price" name="price"  />
                            </div>
                        </div>
                        <div class="mg-t-30">
                            <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
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

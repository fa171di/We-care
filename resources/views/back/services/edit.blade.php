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
                            <a href="{{ route('visits.show', $patient) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('services.show', $visit) }}">ملف الزيارة</a>
                        </li>
                        <li class="breadcrumb-item active">تعديل الخدمات</li>
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
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الخدمات المقدمة</div>
                </div>
            </div><br>

            <form id="servicesForm" action={{route('services.update', 'test')}}"" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-forms.input id="visit" hidden="" name="visit" :value="$visit" />
                <x-forms.input id="patient" hidden="" name="patient" :value="$patient" />
                <x-forms.input id="clinic" hidden="" name="clinic" :value="$clinic" />
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">الخدمات</span></x-forms.label>
                        <select id="services" name="services[]" multiple class="form-control select2">
                            @foreach ($services1 as $key => $value)
                                @if (in_array($value->id,$arr))
                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                @else
                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mg-t-30">
                    <button id="ServiceSubmit" class="btn btn-main-primary pd-x-20" type="submit">اضافة</button>
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

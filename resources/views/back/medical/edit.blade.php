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
                            <a href="{{ route('visits.show', $id) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('services.show', $visit) }}">ملف الزيارة</a>
                        </li>
                        <li class="breadcrumb-item active">تعديل السوابق المرضية</li>
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
    <div id="mediacl_insert" class="short">
        <div class="card-body">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">اضافة معلومات للسوابق المرضية</div>
                </div>
            </div><br>

            <form id="medicalForm" action="{{route('medical.update','text')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-forms.input hidden="" name="patient" :value="$id" />
                <x-forms.input hidden="" name="visit" :value="$visit" />
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">الحساسيات</span></x-forms.label>
                        <select id="medical1" name="med1[]" multiple class="form-control select2">
                            @foreach ($medicalH as $key => $value)
                                @if($value->cat == 1)
                                    @if (in_array($value->id,$arr))
                                        <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                    @else
                                        <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                        <textarea class="form-control" name="note1" style="height: 41px;" placeholder="Textarea" rows="3"></textarea>
                    </div>

                </div>
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">السوابق الجراحية</span></x-forms.label>
                        <select id="medical2" name="med2[]" multiple class="form-control select2">
                            @foreach ($medicalH as $key => $value)
                                @if($value->cat == 2)
                                    @if (in_array($value->id,$arr))
                                        <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                    @else
                                        <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                        <textarea class="form-control" name="note2" style="height: 41px;" placeholder="Textarea" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">الأمراض المزمنة</span></x-forms.label>
                        <select id="medical3" name="med3[]" multiple class="form-control select2">
                            @foreach ($medicalH as $key => $value)
                                @if($value->cat == 3)
                                    @if (in_array($value->id,$arr))
                                        <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                    @else
                                        <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                        <textarea class="form-control" name="note3" style="height: 41px;" placeholder="Textarea" rows="3"></textarea>
                    </div>

                </div>
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">الادوية الدائمة</span></x-forms.label>
                        <select id="medical4" name="med4[]" multiple class="form-control select2">
                            @foreach ($medicalH as $key => $value)
                                @if($value->cat == 4)
                                    @if (in_array($value->id,$arr))
                                        <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                    @else
                                        <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                        <textarea class="form-control" name="note4" style="height: 41px;" placeholder="Textarea" rows="3"></textarea>
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">العادات</span></x-forms.label>
                        <select id="medical5" name="med5[]" multiple class="form-control select2">
                            @foreach ($medicalH as $key => $value)
                                @if($value->cat == 5)
                                    @if (in_array($value->id,$arr))
                                        <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                    @else
                                        <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                        <textarea class="form-control" name="note5" style="height: 41px;" placeholder="Textarea" rows="3"></textarea>
                    </div>
                </div>
                <div class="mg-t-30">
                    <button class="btn btn-main-primary pd-x-20" type="submit">حفظ</button>
                </div>
            </form>
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

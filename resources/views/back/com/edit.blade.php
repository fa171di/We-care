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
                        <li class="breadcrumb-item active">تعديل الشكايات</li>
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
                    <div class="row row-sm">
                        <div style="left: 15px;" class="col-xl-1">
                            <a class="menuicon"><i style="color: blue;font-size: 28px;"
                                                   class="las la-plus"></i></a>
                        </div>
                        <div style="right: -63px;" class="col-xl-11">
                            <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الشكاية الرئيسية</div>
                        </div>
                    </div>
                </div>
            </div><br>

            <form id="" action="{{route('com.update','com')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-forms.input id="" hidden="" name="visit" :value="$visit" />
                <x-forms.input id="" hidden="" name="patient" :value="$id" />
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-8" id="minusCom">
                        @if($com->isNotEmpty())
                            @foreach ($com as $key => $value)
                                <div style="position: relative">
                                    <textarea class="form-control" name="com[]" style="height: 41px;"
                                              placeholder="Textarea" rows="3">{{$value->val}}</textarea>
                                    <i style="color: red;position: absolute;left: 10px;font-size: 30px;bottom: 5px;"
                                       class="las la-minus"></i>
                                </div>
                            @endforeach
                        @else
                            <div style="position: relative">
                                    <textarea class="form-control" name="com[]" style="height: 41px;"
                                              placeholder="Textarea" rows="3"></textarea>
                                <i style="color: red;position: absolute;left: 10px;font-size: 30px;bottom: 5px;"
                                   class="las la-minus"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mg-t-30">
                    <button id="comSubmit" class="btn btn-main-primary pd-x-20" type="submit">اضافة</button>
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

    $("#minusCom").on('click','i',function(e){
        e.preventDefault();
        $(this).closest("div").remove();
    });

    $(".menuicon").click(function() {
        const box = document.getElementById('minusCom');

        const directChildren = box.children.length;
        const finalNum = directChildren + 1;
        console.log(finalNum);
        added_row = '<div style="position: relative"><textarea class="form-control" name="com[]" style="height: 41px;"placeholder="Textarea" rows="3"></textarea> <i style="color: red;position: absolute;left: 10px;font-size: 30px;bottom: 5px;"class="las la-minus"></i></div>';
        //To finally append this long string to your table through it's ID:
        $('#minusCom').append(added_row)
    });
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

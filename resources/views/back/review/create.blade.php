@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">

    <!-- Internal RatingThemes css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/ratings.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-1to10.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-movie.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-square.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-pill.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-reversed.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-horizontal.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/css-stars.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bootstrap-stars.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/fontawesome-stars-o.css')}}">

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
                            <a href="{{ url('/' . $page='departments') }}">الاختصاصات</a>
                        </li>
                        <li class="breadcrumb-item">الاطباء</li>
                        <li class="breadcrumb-item active">اضافة مراجعة</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->


    <div class="card custom-card">
        <div class="card-body">
            <div>
                <h6 class="card-title mb-1">Star Rating</h6>
            </div>
            <form id="" action="{{route('review.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <x-forms.input id="" hidden="" name="doctor" :value="$doctor"/>
                <x-forms.input id="" hidden="" name="typeUser" :value="1"/>

                <div class="rating-stars block" id="rating">
                    <input type="number" readonly="readonly" class="rating-value" name="rating"
                           id="rating-stars-value" value="1">
                    <div class="rating-stars-container">
                        <div class="rating-star">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="rating-star">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="rating-star">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="rating-star">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="rating-star">
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="mg-t-30">
                    <button id="comSubmit" class="btn btn-main-secondary pd-x-20" type="submit">اضافة</button>
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
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Rating js-->
    <script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/rating/ratings.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

@endsection

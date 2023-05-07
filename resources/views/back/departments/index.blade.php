@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    الاطباء
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصفحة الرئيسية</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                الاختصاصات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم اضافة الاختصاص بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات الاختصاص بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الاختصاص بنجاح",
                type: "error"
            });
        }

    </script>
@endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">

                                <a class="btn btn-primary btn-sm" href="{{ route('doctors.create') }}"> اضافة اختصاص</a>

                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body row row-sm">
                <div class="row">
                    @foreach ($departments as $key => $value)
                        <div class="col-md-6 col-xl-3 col-md-4 " style="margin-bottom: 25px;">
                            <a href="{{route('doctors.show', $value->id)}}" class="">
                                <div style="
    border-right-color: green;
    border-right-width: 4px;
    border-bottom-color: #b3aaaa;
    border-left-color: #b3aaaa;
    border-top-color: #b3aaaa;" class="p-3 p-3 bg-gray-0 bd bd-1"><strong
                                        style="color: #3c3939;">{{$value->name_ar}}</strong></div>
                            </a>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection

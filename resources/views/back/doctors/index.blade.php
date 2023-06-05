@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/css.css') }}" rel="stylesheet" />
@section('title')
    الاطباء
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
            <li class="breadcrumb-item active">الاطباء</li>
                </ol></nav>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

    @if (session('success'))
        <div class="alert alert-outline-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span></button>
            <strong>Well done!</strong> {{ session('success') }}.
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-outline-danger mg-b-0" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span></button>
            <strong>Oh snap!</strong> {{ session('error') }}.
        </div>
    @endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">

                                <a class="btn btn-info btn-sm" href="{{ route('doctors.create',['section' => $doctors]) }}"> <i class="las la-pen"></i> اضافة طبيب </a>

                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body row row-sm" style="">
                @foreach ($doctor as $key => $value)
                <div  class="col-xl-3 col-lg-3 col-md-12 love" style="">
                    <div class="love1 card  ">
                        <img class="card-img-top w-100" src="{{URL::asset('assets/img/photos/7.jpg')}}" alt="">
                        <div class="card-body">
                            <h4 class="card-title">
                                <b style="    width: 138px;
    display: inline-block;">
                                {{ $value->getsSex() }} {{ $value->name_ar }}
                                </b>
                            <b class="" style="">
                                <a href="{{ route('doctors.edit', ['doctor' => $value->id, 'section' => $value->subgrp])}}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>

                                <form action="{{route('doctors.destroy', $value->id)}}"
                                      style="display:inline" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="input" id="user_id" value="{{ $value->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                            class="las la-trash"></i></button>
                                </form>
                            </b>
                            </h4>
                            <p class="card-text">
                                <b style="font-weight: 500;display: inline-block;
    width: 163px;">{{ $value->specialization_ar }}.</b>
                                <a class="hoverIcon btn btn-sm" style="border-width: 1px;
    color: #0dbd0a;
    border-color: #23c320;
    width: 46px;
    border-radius: 14px;">المزيد</a>
                            </p>
                        </div>
                    </div>
                    <div class="divClass card">
                        <div class="card-body" style="background-color: #deeeff;    width: 254px;
    height: 249px;">
                            <h4 class="card-title mb-3">{{ $value->getsSex() }} {{ $value->name_ar }}</h4>
                            <div class="media-list pb-0">
                                <div class="media">
                                    <div class="media-body">
                                        <div>
                                            <label>هاتف العمل :</label> <span class="tx-medium">{{ $value->phone_number }}</span>
                                        </div>
                                        <div>
                                            <label>حالة العمل :</label> <span class="tx-medium">{{ $value->getAct() }}</span>
                                        </div>
                                        <div>
                                            <label>ايميل العمل :</label> <span class="tx-medium">{{$value->user->email}}</span>
                                        </div>
                                        <div>
                                            <label>تاريخ الانضمام :</label> <span class="tx-medium">{{ $value->created_at }}</span>
                                        </div>
                                        <div>
                                            <label>حالته ضمن النظام :</label>
                                            @if ($value->user->Status == 'مفعل')
                                                <span class="label text-success" style="display: inline-block;
    margin-right: 17px;">
                                                <div class="dot-label bg-success ml-1"></div>{{$value->user->Status}}
                                            </span>
                                            @else
                                                <span class="label text-danger" style="display: inline-block;
    margin-right: 17px;">
                                                <div class="dot-label bg-danger ml-1"></div>{{$value->user->Status}}
                                            </span>
                                            @endif
                                        </div>

                                        <div>
                                            <label>مشهور :</label>
                                            @if ($value->famous == 1)
                                                <span class="label text-success" style="display: inline-block;
    margin-right: 17px;">
                                                <div class="dot-label bg-success ml-1"></div>{{$value->getFamous()}}
                                            </span>
                                            @else
                                                <span class="label text-danger" style="display: inline-block;
    margin-right: 17px;">
                                                <div class="dot-label bg-danger ml-1"></div>{{$value->getFamous()}}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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

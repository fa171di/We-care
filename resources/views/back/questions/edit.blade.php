@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
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
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/' .  $page='questions/'.\Illuminate\Support\Facades\Auth::user()->doctor->subgrp) }}">جميع الأسئلة و الأجوبة</a>
                                </li>
                                <li class="breadcrumb-item active">تعديل السؤال</li>
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
            <form action="{{ route('questions.update',$qu->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-2" id="fnWrapper">
                        <x-forms.label id=""><span class="">نوع المستخدم</span></x-forms.label>
                        <select name="section" class="form-control select2">
                            <option></option>
                            @foreach ($section as $key => $value)
                                <option value="{{ $value->id }}" @if($qu->section == $value->id) selected @endif />{{ $value->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-input col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">السؤال : </span></x-forms.label>

                        <textarea class="form-control" name="Question" style="height: 215px;" placeholder="Textarea" rows="3">{{$qu->Question}}</textarea>

                    </div>

                    <div class="parsley-input col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <x-forms.label id=""><span class="">الجواب : </span></x-forms.label>

                        <textarea class="form-control" name="answer" style="height: 215px;" placeholder="Textarea" rows="3">{{$qu->answer}}</textarea>

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
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

@endsection

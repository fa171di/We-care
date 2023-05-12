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
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                الاطباء</span>
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
                msg: " تم اضافة الطبيب بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات الطبيب بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الطبيب بنجاح",
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

                                <a class="btn btn-primary btn-sm" href="{{ route('doctors.create',['section' => $doctors]) }}"> اضافة طبيب</a>

                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body row row-sm">
                @foreach ($doctor as $key => $value)
                    <div class="col-sm-12 col-lg-5 col-xl-5">
                        <div class="">
                            <a class="main-header-arrow" href="" id="ChatBodyHide"><i class="icon ion-md-arrow-back"></i></a>
                            <div class="main-content-body main-content-body-contacts card custom-card">
                                <div class="main-contact-info-header pt-3">
                                    <div class="media">
                                        <div class="main-img-user">
                                            <img alt="avatar" src="{{URL::asset('assets/img/faces/6.jpg')}}"> <a href=""><i class="fe fe-camera"></i></a>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="main-profile-name">{{ $value->getsSex() }} {{ $value->name_ar }}</h5>
                                            <p class="main-profile-name-text">{{ $value->specialization_ar }}</p>
                                        </div>
                                    </div>
                                    <div class="main-contact-action btn-list pt-3 pr-3">
                                        <a href="{{route('doctors.edit', ['doctor' => $value->id, 'section' => $value->subgrp])}}" class="btn ripple btn-primary-gradient text-white btn-icon" data-placement="top" data-toggle="tooltip" title="Edit Profile"><i class="fe fe-edit"></i></a>
                                        <form action="{{ route('doctors.destroy', $value->id) }}"
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn ripple btn-danger-gradient text-white btn-icon"><i class="fe fe-trash-2"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="main-contact-info-body p-4">
                                    <div>
                                        <h6>وصف :</h6>
                                        <p>{{ $value->specialization_ar }}.</p>
                                    </div>
                                    <div class="media-list pb-0">
                                        <div class="media">
                                            <div class="media-body">
                                                <div>
                                                    <label>هاتف العمل :</label> <span class="tx-medium">{{ $value->phone_number }}</span>
                                                </div>
                                                <div>
                                                    <label>حالةالعمل :</label> <span class="tx-medium">{{ $value->getAct() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="media-body">
                                                <div>
                                                    <label>ايميل العمل :</label> <span class="tx-medium">{{$value->user->email}}</span>
                                                </div>
                                                <div>
                                                    <label>تاريخ الانضمام :</label> <span class="tx-medium">{{ $value->created_at }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="media-body">
                                                <div>
                                                    <label>حالته ضمن النظام :</label>
                                                    @if ($value->user->Status == 'مفعل')
                                                        <span class="label text-success d-flex">
                                                <div class="dot-label bg-success ml-1"></div>{{$value->user->Status}}
                                            </span>
                                                    @else
                                                        <span class="label text-danger d-flex">
                                                <div class="dot-label bg-danger ml-1"></div>{{$value->user->Status}}
                                            </span>
                                                    @endif
                                                </div>

                                                <div>
                                                    <label>مميز :</label>
                                                    @if ($value->famous == 1)
                                                        <span class="label text-success d-flex">
                                                <div class="dot-label bg-success ml-1"></div>{{$value->getFamous()}}
                                            </span>
                                                    @else
                                                        <span class="label text-danger d-flex">
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

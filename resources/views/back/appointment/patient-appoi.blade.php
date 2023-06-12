@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css"/>

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
                        <li class="breadcrumb-item active">الحجوزات</li>
                    </ol>
                </nav>
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
                        <h4 class="card-title mg-b-0">STRIPED ROWS</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <form action="{{ url("filter_App") }}" method="post" class="row">
                        @csrf
                        @method('POST')
                        <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <x-forms.label id=""><span class=""></span></x-forms.label>
                            <x-forms.input placeholder=" اسم الطبيب" name="name"
                                           class="form-control  nice-select  custom-select"/>
                        </div>

                        <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <x-forms.label id=""><span class=""></span></x-forms.label>
                            <select name="Status" id="select-beast"
                                    class="form-control  nice-select  custom-select">
                                <option value=0>معلق</option>
                                <option value=1> مؤكد</option>
                                <option value=2> ملغي</option>
                            </select>
                        </div>
                        <div class="parsley-input col-md-3 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <x-forms.label id=""><span class=""></span></x-forms.label>
                            <select name="date" id="select-beast"
                                    class="form-control  nice-select  custom-select">
                                <option value=0>اليوم</option>
                                <option value=1> القادمة</option>
                            </select>
                        </div>
                        <div class="parsley-input col-md-3 mg-md-t-0">
                            <x-forms.label id=""><span class="">     </span></x-forms.label>
                            <button class="btn btn-dark btn-" dir="ltr">Filter</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>اسم الطبيب</span></th>
                                <th class="wd-lg-8p"><span>اليوم</span></th>
                                <th class="wd-lg-8p"><span>الوقت</span></th>
                                <th class="wd-lg-8p"><span> الحالة</span></th>
                                <th class="wd-lg-8p"><span>العمليات</span></th>
                            </tr>
                            </thead>
                            <tbody id="deletePatent">
                            @if($appointments != null)
                            @foreach ($appointments as $key => $value)
                                <tr>
                                    <td>{{$value->doctor->name}}</td>
                                    <td>{{$value->appointment_date}}</td>
                                    <td>{{$value->timeSlot->from}}</td>
                                    <td>
                                        @if($value->status == 0)
                                            <i class="btn btn-sm btn-warning">معلق</i>
                                        @elseif($value->status == 1)
                                            <i class="btn btn-sm btn-success">مؤكد</i>
                                        @elseif($value->status == 2)
                                            <i class="btn btn-sm btn-danger">ملغي</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->status != 2)
                                            <a href="{{ route('patients.edit', $value->id) }}"
                                               class="btn btn-sm btn-info"
                                               title="تعديل الحجز"><i class="las la-pen"></i></a>
                                        @endif
                                        @if($value->status == 0)
                                            <a href="{{ url('confirm-appointment/'. $value->id) }}"
                                               class="btn btn-sm btn-success"
                                               title="تأكيد"><i>تأكيد</i></a>
                                        @endif
                                        @if($value->status == 1)
                                            <a href="{{ url('cancel-appointment/'. $value->id) }}"
                                               class="btn btn-sm btn-danger"
                                               title="الغاء"><i>الغاء</i></a>
                                        @endif
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="user_id" value="{{ $value->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="las la-trash"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
@endsection
@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script>
        $('#deletePatent').on('submit', 'form', function (e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            $.ajax({
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('patients.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function (data) {
                    alert(data.result);
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        });
    </script>
@endsection

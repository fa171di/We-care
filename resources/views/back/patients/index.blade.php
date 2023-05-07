@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />

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
                المرضى</span>
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
                msg: " تم اضافة المريض بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات المريض بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف المريض بنجاح",
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
                    <h4 class="card-title mg-b-0">STRIPED ROWS</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
                    <x-forms.input name="f_name" placeholder="الاسم الاول" class="mx-2" :value="request('f_name')" />
                    <x-forms.input name="l_name" placeholder="الكنية" class="mx-2" :value="request('l_name')" />
                    <x-forms.input name="mobile" placeholder="الموبايل" class="mx-2" :value="request('phone')" />
                    <button class="btn btn-dark mx-2">Filter</button>
                </form>
                <p class="tx-12 tx-gray-500 mb-2">Example of Valex Striped Rows.. <a href="">Learn more</a></p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mg-b-0 text-md-nowrap">
                        <thead>
                        <tr>
                            <th class="border-bottom-0">الاسم</th>
                            <th class="border-bottom-0">اسم الاب</th>
                            <th class="border-bottom-0">الاسم الام</th>
                            <th class="border-bottom-0">الموبايل</th>
                            <th class="border-bottom-0">العمر</th>
                            <th class="border-bottom-0">الجنس</th>
                            <th class="border-bottom-0">الهاتف</th>
                            <th class="border-bottom-0">زمرة الدم</th>
                            <th class="border-bottom-0">مدينة</th>
                            <th class="border-bottom-0">المنطقة</th>
                            <th class="border-bottom-0">القومية</th>
                            <th class="border-bottom-0">العنوان</th>
                            <th class="border-bottom-0">الايميل</th>
                            <th class="border-bottom-0">طول الاب</th>
                            <th class="border-bottom-0">طول الام</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($patien as $key => $value)
                            <tr>
                                <td>{{$value->l_name}} {{$value->f_name}}</td>
                                <td>{{$value->ft_name}}</td>
                                <td>{{$value->mother_name}}</td>
                                <td>{{$value->mobile}}</td>
                                <td>{{$value->age()}}</td>
                                <td>{{$value->getSex()}}</td>
                                <td>{{$value->phone}}</td>
                                <td>{{$value->blood}}</td>
                                <td>{{$value->gnr_m_cities->name?? '----'}}</td>
                                <td>{{$value->gnr_m_areas->name ?? '----'}}</td>
                                <td>{{$value->gnr_m_nationality->name_ar?? '----'}}</td>
                                <td>{{$value->address}}</td>
                                <td>{{$value->user->email}}</td>
                                <td>{{$value->gnr_m_patients_medical_info->father_height?? '----'}}</td>
                                <td>{{$value->gnr_m_patients_medical_info->mother_height?? '----'}}</td>
                                <td>
                                        <a href="{{ route('patients.edit', $value->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-pen"></i></a>

                                    <a href="{{ route('visits.show', $value->id) }}" class="btn btn-sm btn-primary"
                                       title="اظهار جميع الزيارات"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-success" data-effect="effect-scale"
                                           data-user_id="{{ $value->id }}" data-username="{{ $value->ft_name }}"
                                           data-toggle="modal" href="#modaldemo8" title="اضافة زيارة"><i
                                                class="las la-pen-fancy"></i></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="margin-top: 30px;">
                        {{$patien->withQueryString()->links()}}
                    </div>

                </div><!-- bd -->
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    <!--/div-->

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة زيارة</h6>
                    <button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('visits.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <p>هل تريد اضافة زيارة؟</p><br>
                        <input type="hidden" name="user_id" id="user_id" value="">

                        <x-forms.label id=""><span class="">اختر عيادة</span></x-forms.label>
                        <select name="clinic" class="form-control select2">
                            <option></option>
                            @foreach ($clinics as $key => $value)
                                <option value="{{ $key }}"/>{{ $value->name_ar }}</option>
                            @endforeach
                        </select>

                        <x-forms.label id=""><span class="">ادخل ملاحظة </span></x-forms.label>
                        <input class="form-control" name="note" id="" type="text">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
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
    $('#modaldemo8').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var user_id = button.data('user_id')
        var modal = $(this)
        modal.find('.modal-body #user_id').val(user_id);
    })
</script>
@endsection

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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/' . $page='dashboard') }}">الصفحة الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">المرضى</li>
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
                <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
                    <x-forms.input name="f_name" placeholder="الاسم الاول" class="mx-2" :value="request('f_name')" />
                    <x-forms.input name="l_name" placeholder="الكنية" class="mx-2" :value="request('l_name')" />
                    <x-forms.input name="mobile" placeholder="الموبايل" class="mx-2" :value="request('phone')" />
                    <button class="btn btn-dark mx-2">Filter</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive border-top userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                        <thead>
                        <tr>
                            <th class="wd-lg-8p"><span>نوع</span></th>
                            <th class="wd-lg-8p"><span>الاسم</span></th>
                            <th class="wd-lg-8p"><span>اسم الاب</span></th>
                            <th class="wd-lg-8p"><span>الاسم الام</span></th>
                            <th class="wd-lg-8p"><span>الحالة اجتماعية</span></th>
                            <th class="wd-lg-8p"><span>الموبايل</span></th>
                            <th class="wd-lg-8p"><span>العمر</span></th>
                            <th class="wd-lg-8p"><span>الجنس</span></th>
                            <th class="wd-lg-8p"><span>الهاتف</span></th>
                            <th class="wd-lg-8p"><span>زمرة الدم</span></th>
                            <th class="wd-lg-8p"><span>مدينة</span></th>
                            <th class="wd-lg-8p"><span>المنطقة</span></th>
                            <th class="wd-lg-8p"><span>القومية</span></th>
                            <th class="wd-lg-8p"><span>العنوان</span></th>
                            <th class="wd-lg-8p"><span>حساب محفظتي</span></th>
                            <th class="wd-lg-8p"><span>الايميل</span></th>
                            <th class="wd-lg-8p"><span>العمليات</span></th>
                        </tr>
                        </thead>
                        <tbody id="deletePatent">
                        @foreach ($patien as $key => $value)
                            <tr>
                                <td>{{$value->getTitle()}}</td>
                                <td>{{$value->f_name}}</td>
                                <td>{{$value->ft_name}}</td>
                                <td>{{$value->mother_name}}</td>
                                <td>{{$value->getMarital_status()}}</td>
                                <td>{{$value->mobile}}</td>
                                <td>{{$value->age()}}</td>
                                <td>{{$value->getSex()}}</td>
                                <td>{{$value->phone}}</td>
                                <td>{{$value->blood}}</td>
                                <td>{{$value->gnr_m_cities->name?? '----'}}</td>
                                <td>{{$value->gnr_m_areas->name ?? '----'}}</td>
                                <td>{{$value->gnr_m_nationality->name_ar?? '----'}}</td>
                                <td>{{$value->address}}</td>
                                <td>{{$value->digital_wallet}}</td>
                                <td>{{$value->user->email}}</td>
                                <td>
                                    <a href="{{ route('wallet.edit', $value->id) }}" class="btn btn-sm btn-indigo"
                                       title="عمليات الحساب"><i class="las la-wallet"></i></a>

                                    <a href="{{ route('patients.edit', $value->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل المريض"><i class="las la-pen"></i></a>

                                    <a href="{{ route('visits.show', $value->id) }}" class="btn btn-sm btn-success"
                                       title="اظهار جميع الزيارات"><i class="las la-pen"></i></a>

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
                        <select name="clinic" class="form-control select2" requiredInput="*">
                            <option></option>
                            @foreach ($clinics as $key => $value)
                                <option value="{{$value->id}}"/>{{ $value->name_ar }}</option>
                            @endforeach
                        </select>

                        <x-forms.label id=""><span class="">ادخل ملاحظة </span></x-forms.label>
                        <input class="form-control" name="note" id="" type="text">
                        <x-forms.input label="التكلفة: " oninvalid="this.setCustomValidity('يجب ان تدخل رقم')" onchange="this.setCustomValidity('')" inputmode="numeric" pattern="[0-9]*"  class="" name="price"  />


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
    $('#deletePatent').on('submit','form',function(e) {
        e.preventDefault();
        $(this).closest("tr").remove();
        $.ajax({
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('patients.destroy','test')}}",
            data: $(this).serialize()
            ,
            success: function(data) {
                alert(data.result);
            },
            error: function(xhr, status, error) {
                console.error(xhr);}});
    });
</script>
@endsection

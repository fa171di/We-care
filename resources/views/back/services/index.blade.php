@extends('layouts.master')
@section('css')

@section('title')
    المستخدمين
@stop

<!-- Internal Data table css -->

<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>

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
                            <a href="{{ route('visits.show', $patientId) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item active">ملف الزيارة</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('services.edit',['service'=>$patientId,'clinic' =>$clinic,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الخدمات المقدمة</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($services->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">رقم الخدمة</th>
                                <th class="wd-10p border-bottom-0">عيادة</th>
                                <th class="wd-15p border-bottom-0">الخدمة</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="serversDelete">
                            @foreach ($services as $key => $pat)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $pat->gnr_m_clinics->name_ar }}</td>
                                    <td>{{ $pat->name_ar }}</td>
                                    <td>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="user_id" value="{{ $pat->id }}">
                                            <input type="hidden" name="visit" id="username" value="{{ $visitID }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('medical.edit',['medical'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">السوابق المرضية</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($patient->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            <thead>

                            <tr>
                                @foreach ($cln_m_medical_his_cats as $key => $pat)
                                    <th class="wd-10p border-bottom-0">{{$pat->name_ar}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <ul>
                                        @foreach ($patient as $key => $pat)
                                            @if($pat->cat == 1)
                                                <li>{{$pat->name_ar}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($patient as $key => $pat)
                                            @if($pat->cat == 2)
                                                <li>{{$pat->name_ar}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($patient as $key => $pat)
                                            @if($pat->cat == 3)
                                                <li>{{$pat->name_ar}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($patient as $key => $pat)
                                            @if($pat->cat == 4)
                                                <li>{{$pat->name_ar}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($patient as $key => $pat)
                                            @if($pat->cat == 5)
                                                <li>{{$pat->name_ar}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف المستخدم</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('services.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <input class="form-control" name="username" id="username" type="text" readonly>
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
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('com.edit',['com'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الشكاية الرئيسية</div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    @if($com->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                <th class="wd-10p border-bottom-0">الشكاية</th>
                                <th class="wd-15p border-bottom-0">تاريخ</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="DeleteCom">
                            @foreach ($com as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="user_id" value="{{ $pat->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('str.edit',['str'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">القصة المرضية</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($str->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                <th class="wd-10p border-bottom-0">القصة المرضية</th>
                                <th class="wd-15p border-bottom-0">تاريخ</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="DeleteStr">
                            @foreach ($str as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="user_id" value="{{ $pat->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('cln.edit',['cln'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">فحص سريري</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($cln->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                <th class="wd-10p border-bottom-0">نتيجة الفحص</th>
                                <th class="wd-15p border-bottom-0">تاريخ</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="DeleteCln">
                            @foreach ($cln as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="user_id" value="{{ $pat->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('dia.edit',['dium'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">التشخيص</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($dia != "" || $dia10 != "")
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                                <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                    <th class="wd-10p border-bottom-0">التشخيص بالعربي</th>
                                    <th class="wd-15p border-bottom-0">التشخيص بالانكليزي</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                                </thead>
                                <tbody id="Deletedia">
                                @if($dia10 != "")
                                    @if($dia10->isNotEmpty())
                                        @foreach ($dia10 as $pat)
                                            <tr>
                                                <td>{{$pat->pivot->doctors->name_ar}}</td>
                                                <td>{{ $pat->name_ar }}</td>
                                                <td>{{$pat->name_en}}</td>
                                                <td>
                                                    <form action=""
                                                          style="display:inline" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="dia10" id="user_id" value="{{ $pat->id }}">
                                                        <input type="hidden" name="visit" id="user_id" value="{{ $visitID }}">
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="las la-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                @if($dia != "")
                                    @if($dia->isNotEmpty())
                                        @foreach ($dia as $key => $pat)
                                            <tr>
                                                <td>{{$pat->doctors->name_ar}}</td>
                                                <td>{{ $pat->val }}</td>
                                                <td></td>
                                                <td>
                                                    <form action=""
                                                          style="display:inline" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="dia" id="user_id" value="{{ $pat->id }}">
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="las la-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                </tbody>
                        </table>
                    </div>
                    @elseif($dia != "" && $dia10 != "")
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->

    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('note.edit',['note'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الملاحظات</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($note->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                <th class="wd-10p border-bottom-0">الملاحظة</th>
                                <th class="wd-15p border-bottom-0">تاريخ</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="DeleteNot">
                            @foreach ($note as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="user_id" value="{{ $pat->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-12">
                        <div class="row row-sm">
                            <div style="left: 15px;" class="col-xl-1">
                                <a href="{{ route('patients_info.edit',['patients_info'=>$patientId,'visit'=>$visitID]) }}" class="btn btn-sm btn-info"
                                   title="تعديل"><i class="las la-pen"></i></a>
                            </div>
                            <div style="right: -47px;" class="col-xl-11">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">مؤشرات النمو</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    @if($patients_medical_info !== null)
                        <div class="table-responsive hoverable-table">
                            <ul class="list-group list-group-horizontal-lg">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if($patients_medical_info->sex == 1)
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: dodgerblue" width="30"
                                             height="30" fill="currentColor" class="bi bi-gender-male"
                                             viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: hotpink" width="30"
                                             height="30" fill="currentColor" class="bi bi-gender-female"
                                             viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5z"/>
                                        </svg>
                                    @endif
                                    {{$patients_medical_info->age()}}<span style="padding-right: 5px;"> سنة </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="color: grey" width="30"
                                         height="30" fill="currentColor" class="bi bi-person-fill"
                                         viewBox="0 0 16 16">
                                        <path
                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                    </svg>
                                    {{$patients_medical_info->height}}
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$patients_medical_info->father_height}}
                                    <i style="font-size: 36px;color: dodgerblue;" class="las la-male"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$patients_medical_info->mother_height}}
                                    <i style="font-size: 36px;color: hotpink;" class="las la-female"></i>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div style="width: 100%;background-color: #e2ecf5;
    text-align: center;
    height: 43px;
    padding-top: 10px;">لايوجد معلومات</div>
                    @endif
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف المستخدم</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('services.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <input class="form-control" name="username" id="username" type="text" readonly>
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


    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#serversDelete').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            //var formData =$(this).serialize();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('services.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    $(this).closest("tr").remove();
                    alert(data.result);
                    //console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
        $('#DeleteCom').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            //var formData =$(this).serialize();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('com.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    //$(this).closest("tr").remove();
                    alert(data.result);
                    //console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
        $('#DeleteStr').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            //var formData =$(this).serialize();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('str.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    //$(this).closest("tr").remove();
                    alert(data.result);
                    //console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
        $('#DeleteCln').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            //var formData =$(this).serialize();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('cln.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    //$(this).closest("tr").remove();
                    alert(data.result);
                    //console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
        $('#Deletedia').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            //var formData =$(this).serialize();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('dia.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    //$(this).closest("tr").remove();
                    alert(data.result);
                    //console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
        $('#DeleteNot').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            //var formData =$(this).serialize();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('note.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    //$(this).closest("tr").remove();
                    alert(data.result);
                    //console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });

    </script>


@endsection

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
                <h4 class="content-title mb-0 my-auto">خدمات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                خدمات الزيارة للمريض</span>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الخدمات المقدمة</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة شكاية</a>
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
                                <th class="wd-15p border-bottom-0">السعر</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($services as $key => $pat)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $pat->gnr_m_clinics->name_ar }}</td>
                                    <td>{{ $pat->name_ar }}</td>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                           data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                class="las la-trash"></i></a>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">السوابق المرضية</div>
                            <a class="btn btn-primary btn-sm" href="">تعديل</a>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الشكاية الرئيسية</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة شكاية</a>
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
                            <tbody>
                            @foreach ($com as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                           data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                class="las la-trash"></i></a>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">القصة المرضية</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة شكاية</a>
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
                            <tbody>
                            @foreach ($str as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                           data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                class="las la-trash"></i></a>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">فحص سريري</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة فحص</a>
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
                            <tbody>
                            @foreach ($cln as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                           data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                class="las la-trash"></i></a>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">التشخيص</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة تشخيص</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($dia[1]->isNotEmpty())
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="" data-page-length='50'
                               style=" text-align: center;">
                            @if($dia[0] == "icd10")
                                <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                    <th class="wd-10p border-bottom-0">الكود</th>
                                    <th class="wd-10p border-bottom-0">التشخيص بالعربي</th>
                                    <th class="wd-15p border-bottom-0">التشخيص بالانكليزي</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dia[1] as $pat)
                                    <tr>
                                        <td>{{$pat->pivot->doctors->name_ar}}</td>
                                        <td>{{$pat->code}}</td>
                                        <td>{{ $pat->name_ar }}</td>
                                        <td>{{$pat->name_en}}</td>
                                        <td>
                                            <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                               title="تعديل"><i class="las la-pen"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                               data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                               data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                    class="las la-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            @else
                                <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">الطبيب المسوؤل</th>
                                    <th class="wd-10p border-bottom-0">التشخيص</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dia[1] as $key => $pat)
                                    <tr>
                                        <td>{{$pat->doctors->name_ar}}</td>
                                        <td>{{ $pat->val }}</td>
                                        <td>
                                            <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                               title="تعديل"><i class="las la-pen"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                               data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                               data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                    class="las la-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            @endif
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الملاحظات</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة ملاحظة</a>
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
                            <tbody>
                            @foreach ($note as $key => $pat)
                                <tr>
                                    <td>{{$pat->doctors->name_ar}}</td>
                                    <td>{{ $pat->val }}</td>
                                    <td>{{$pat->date()}}</td>
                                    <td>
                                        <a href="{{ route('services.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-user_id="{{ $pat->id }}" data-username="{{ $pat->name }}"
                                           data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                class="las la-trash"></i></a>
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
                    <div class="col-sm-1 col-md-2">
                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">مؤشرات النمو</div>
                        <a class="btn btn-primary btn-sm" href="">اضافة</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($patients_medical_info !== null)
                        <div class="table-responsive hoverable-table">
                            <table class="table table-hover" id="" data-page-length='50'
                                   style=" text-align: center;">
                                <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">تاريخ الولادة</th>
                                    <th class="wd-10p border-bottom-0">طول الام</th>
                                    <th class="wd-15p border-bottom-0">طول الاب</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$patients_medical_info->birth_date}}</td>
                                        <td>{{ $patients_medical_info->father_height }}</td>
                                        <td>{{$patients_medical_info->mother_height}}</td>
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
        $('#modaldemo8').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        })
    </script>


@endsection

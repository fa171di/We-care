@extends('layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />

@section('title')
    اضافة مستخدم
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
                            <a href="{{ url('/' . $page='patients') }}">المرضى</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('visits.show', $patient) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item active">انشاء ملف للزيارة</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <form action="{{route('MedicalFile.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <x-forms.input hidden="" name="visit" :value="$visit"/>
                <x-forms.input hidden="" name="patient" :value="$patient"/>
                <x-forms.input id="" hidden="" name="sex" :value="$patientinfo->sex"/>
                <x-forms.input id="" hidden="" name="birth_date" :value="$patientinfo->birth_date"/>
                <x-forms.input id="ServiceClinic" hidden="" name="clinic" :value="$clinic"/>

                <div class="card">
                    <div class="card-header pb-0">
                        <div class="col-sm-1 col-md-2">
                            <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">السوابق المرضية
                            </div>
                            <a class="btn btn-primary btn-sm butMed" href="#">ادخال معلومات اضافية</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($patientM->isNotEmpty())
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
                                                @foreach ($patientM as $key => $pat)
                                                    @if($pat->cat == 1)
                                                        <li>{{$pat->name_ar}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($patientM as $key => $pat)
                                                    @if($pat->cat == 2)
                                                        <li>{{$pat->name_ar}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($patientM as $key => $pat)
                                                    @if($pat->cat == 3)
                                                        <li>{{$pat->name_ar}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($patientM as $key => $pat)
                                                    @if($pat->cat == 4)
                                                        <li>{{$pat->name_ar}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($patientM as $key => $pat)
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
    padding-top: 10px;">لايوجد معلومات
                            </div>
                        @endif
                    </div>

                    <div id="mediacl_insert" class="short">
                        <div class="card-body">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">
                                    <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">اضافة معلومات للسوابق المرضية
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div id="medicalForm">
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">الحساسيات</span></x-forms.label>
                                        <select id="medical1" name="med1[]" multiple class="form-control select2">
                                            @foreach ($medicalH as $key => $value)
                                                @if($value->cat == 1)
                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                                        <textarea class="form-control" name="note1" style="height: 41px;"
                                                  placeholder="Textarea" rows="3">Textarea</textarea>
                                    </div>

                                </div>
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">السوابق الجراحية</span></x-forms.label>
                                        <select id="medical2" name="med2[]" multiple class="form-control select2">
                                            @foreach ($medicalH as $key => $value)
                                                @if($value->cat == 2)
                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                                        <textarea class="form-control" name="note2" style="height: 41px;"
                                                  placeholder="Textarea" rows="3">Textarea</textarea>
                                    </div>
                                </div>
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">الأمراض المزمنة</span></x-forms.label>
                                        <select id="medical3" name="med3[]" multiple class="form-control select2">
                                            @foreach ($medicalH as $key => $value)
                                                @if($value->cat == 3)
                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                                        <textarea class="form-control" name="note3" style="height: 41px;"
                                                  placeholder="Textarea" rows="3">Textarea</textarea>
                                    </div>

                                </div>
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">الادوية الدائمة</span></x-forms.label>
                                        <select id="medical4" name="med4[]" multiple class="form-control select2">
                                            @foreach ($medicalH as $key => $value)
                                                @if($value->cat == 4)
                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                                        <textarea class="form-control" name="note4" style="height: 41px;"
                                                  placeholder="Textarea" rows="3">Textarea</textarea>
                                    </div>
                                </div>
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">العادات</span></x-forms.label>
                                        <select id="medical5" name="med5[]" multiple class="form-control select2">
                                            @foreach ($medicalH as $key => $value)
                                                @if($value->cat == 5)
                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <x-forms.label id=""><span class="">ملاحظة :  </span></x-forms.label>

                                        <textarea class="form-control" name="note5" style="height: 41px;"
                                                  placeholder="Textarea" rows="3">Textarea</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div class="row row-sm">
                                    <div style="left: 15px;" class="col-xl-1">
                                        <a class="menuicon"><i style="color: blue;font-size: 28px;"
                                                               class="las la-plus"></i></a>
                                    </div>
                                    <div style="right: -63px;" class="col-xl-11">
                                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الشكاية الرئيسية</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mg-b-20">
                                    <div class="parsley-input col-md-8" id="textareaNew">
                                        <div class="parent" style="position: relative;">
                                            <textarea class="form-control" name="com[]" style="height: 41px;"
                                                      placeholder="Textarea" rows="3"></textarea>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div class="row row-sm">
                                    <div style="left: 15px;" class="col-xl-1">
                                        <a class="strIcon"><i style="color: blue;font-size: 28px;"
                                                              class="las la-plus"></i></a>
                                    </div>
                                    <div style="right: -63px;" class="col-xl-11">
                                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">القصة المرضية</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-b-20">
                                    <div class="parsley-input col-md-8" id="strNew">
                                        <div class="parent" style="position: relative;">
                                            <textarea class="form-control" name="str[]" style="height: 41px;"
                                                      placeholder="Textarea" rows="3"></textarea>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div class="row row-sm">
                                    <div style="left: 15px;" class="col-xl-1">
                                        <a class="clnIcon"><i style="color: blue;font-size: 28px;"
                                                              class="las la-plus"></i></a>
                                    </div>
                                    <div style="right: -63px;" class="col-xl-11">
                                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">فحص سريري</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-8" id="clnNew">
                                <div class="parent" style="position: relative;">
                                    <textarea class="form-control" name="cln[]" style="height: 41px;"
                                              placeholder="Textarea" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">التشخيص
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-3" id="fnWrapper">
                                <x-forms.label id=""><span class="">اضغط لعرض التشخيصات الخاصة به:</span>
                                </x-forms.label>
                                <ul id="icd10display">
                                    <th><a href="#" id="1" class="btn btn-sm btn-outline-secondary">أمراض انتانية
                                            وطفيلية محددة</a></th>
                                    <th><a href="#" id="2" class="btn btn-sm btn-outline-secondary">أمراض تنشؤية</a>
                                    </th>
                                    <th><a href="#" id="3" class="btn btn-sm btn-outline-secondary">أمراض الدم والأعضاء
                                            المنتجة للدم واضطرابات محددة تصيب الآلية المناعية</a></th>
                                    <th><a href="#" id="4" class="btn btn-sm btn-outline-secondary">الأمراض الغدية
                                            الصماوية,التغذوية , والاستقلابية</a></th>
                                    <th><a href="#" id="5" class="btn btn-sm btn-outline-secondary">الاضطرابات العقلية
                                            والسلوكية</a></th>
                                    <th><a href="#" id="6" class="btn btn-sm btn-outline-secondary">أمراض الجهاز
                                            العصبي</a></th>
                                    <th><a href="#" id="7" class="btn btn-sm btn-outline-secondary">أمراض العين
                                            وملحقاتها</a></th>
                                    <th><a href="#" id="8" class="btn btn-sm btn-outline-secondary">أمراض الأذن والناتئ
                                            الخشائي</a></th>
                                    <th><a href="#" id="9" class="btn btn-sm btn-outline-secondary">أمراض الجهاز
                                            الدوراني</a></th>
                                    <th><a href="#" id="10" class="btn btn-sm btn-outline-secondary">أمراض الجهاز
                                            التنفسي</a></th>
                                    <th><a href="#" id="11" class="btn btn-sm btn-outline-secondary">أمراض الجهاز
                                            الهضمي</a></th>
                                    <th><a href="#" id="12" class="btn btn-sm btn-outline-secondary">أمراض الجلد والنسيج
                                            تحت الجلد</a></th>

                                    <th><a href="#" id="13" class="btn btn-sm btn-outline-secondary">أمراض الجهاز العضلي
                                            الهيكلي والنسيج الضام</a></th>
                                    <th><a href="#" id="14" class="btn btn-sm btn-outline-secondary">أمراض الجهاز البولي
                                            التناسلي</a></th>
                                    <th><a href="#" id="15" class="btn btn-sm btn-outline-secondary">الحمل,الولادة
                                            والنفاس</a></th>
                                    <th><a href="#" id="16" class="btn btn-sm btn-outline-secondary">حالات نوعية تحصل في
                                            الفترة حول الولادة</a></th>
                                    <th><a href="#" id="17" class="btn btn-sm btn-outline-secondary">تشوهات خلقية, أسواء
                                            تشكل وشذوذات صبغية</a></th>
                                    <th><a href="#" id="18" class="btn btn-sm btn-outline-secondary">أعراض ,علامات
                                            وموجودات سريرية ومخبرية غير طبيعية ,غير مصنفة في مكان آخر</a></th>
                                    <th><a href="#" id="19" class="btn btn-sm btn-outline-secondary">أذية,تسمم وعقابيل
                                            أخرى محددة من أسباب خارجية</a></th>
                                    <th><a href="#" id="20" class="btn btn-sm btn-outline-secondary">رموز لأغراض
                                            خاصة</a></th>
                                    <th><a href="#" id="21" class="btn btn-sm btn-outline-secondary">أسباب خارجية
                                            للمراضة والوفاة</a></th>
                                    <th><a href="#" id="22" class="btn btn-sm btn-outline-secondary">عوامل مؤثرة في
                                            الوضع الصحي والاتصال بالخدمات الصحية</a></th>
                                </ul>
                            </div>
                            <div class="parsley-input col-md-5" id="fnWrapper">
                                <x-forms.label id=""><span class="">اختر تشخيص :</span></x-forms.label>
                                <select id="addDiaList" name="dia1[]" multiple class="form-control select2">
                                </select>
                            </div>

                            <div class="parsley-input col-md-4" id="fnWrapper">
                                <div id="icd10SelectInput">
                                    <x-forms.label id=""><span class="">التشخيصات :</span></x-forms.label>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div class="row row-sm">
                                    <div style="left: 15px;" class="col-xl-1">
                                        <a class="noteIcon"><i style="color: blue;font-size: 28px;"
                                                               class="las la-plus"></i></a>
                                    </div>
                                    <div style="right: -63px;" class="col-xl-11">
                                        <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الملاحظات</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-b-20">
                                    <div class="parsley-input col-md-8" id="noteNew">
                                        <div class="parent" style="position: relative;">
                                            <textarea class="form-control" name="note[]" style="height: 41px;"
                                                      placeholder="Textarea" rows="3"></textarea>
                                        </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">مؤشرات النمو
                                </div>
                            </div>
                        </div>
                        <br>

                        @if(empty($patientInfoExiste))

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-4" id="fnWrapper">
                                    <x-forms.input label="الطول: " oninvalid="this.setCustomValidity('يجب ان تدخل رقم')"
                                                   onchange="this.setCustomValidity('')" inputmode="numeric"
                                                   pattern="[0-9]*" requiredInput="*" class="required" name="height"/>
                                </div>
                                <div class="parsley-input col-md-4" id="fnWrapper">
                                    <x-forms.input label="طول الاب: "
                                                   oninvalid="this.setCustomValidity('يجب ان تدخل رقم')"
                                                   onchange="this.setCustomValidity('')" inputmode="numeric"
                                                   pattern="[0-9]*" requiredInput="*" class="required"
                                                   name="father_height"/>
                                </div>
                                <div class="parsley-input col-md-4" id="fnWrapper">
                                    <x-forms.input label="طول الام: "
                                                   oninvalid="this.setCustomValidity('يجب ان تدخل رقم')"
                                                   onchange="this.setCustomValidity('')" inputmode="numeric"
                                                   pattern="[0-9]*" requiredInput="*" class="required"
                                                   name="mother_height"/>
                                </div>
                            </div>
                        @else
                            <div class="table-responsive hoverable-table">
                                <ul class="list-group list-group-horizontal-lg">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @if($patientInfoExiste->sex == 1)
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
                                        {{$patientInfoExiste->age()}}<span style="padding-right: 5px;"> سنة </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color: grey" width="30"
                                             height="30" fill="currentColor" class="bi bi-person-fill"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                        </svg>
                                        {{$patientInfoExiste->height}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$patientInfoExiste->father_height}}
                                        <i style="font-size: 36px;color: dodgerblue;" class="las la-male"></i>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$patientInfoExiste->mother_height}}
                                        <i style="font-size: 36px;color: hotpink;" class="las la-female"></i>
                                    </li>
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الخدمات المقدمة
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-8" id="fnWrapper">
                                <x-forms.label id=""><span class="">الخدمات</span></x-forms.label>
                                <select id="services" name="services[]" multiple class="form-control select2">
                                    @foreach ($services as $key => $value)
                                        <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mg-t-30">
                    <button id="vSubmit" class="btn btn-main-primary pd-x-20" type="submit">اضافة</button>
                </div>
            </form>
        </div>
    </div>




    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')


    <script>
        $(".butMed").click(function() {
            $('#mediacl_insert').toggleClass('short tall');
        });
        $(".menuicon").click(function() {
            const box = document.getElementById('textareaNew');

            const directChildren = box.children.length;
            const finalNum = directChildren + 1;
            console.log(finalNum);
            added_row = '<div class="parent" style="position: relative;">'+
                    '<textarea class="form-control" name="com[]" style="height: 41px;" placeholder="Textarea" rows="3"></textarea></div>'
            //To finally append this long string to your table through it's ID:
            $('#textareaNew').append(added_row)
        });

        $(".strIcon").click(function() {
            added_row = '<div class="parent" style="position: relative;">'+
                '<textarea class="form-control" name="str[]" style="height: 41px;" placeholder="Textarea" rows="3"></textarea></div>'
            //To finally append this long string to your table through it's ID:
            $('#strNew').append(added_row)
        });

        $(".clnIcon").click(function() {
            added_row = '<div class="parent" style="position: relative;">'+
                '<textarea class="form-control" name="cln[]" style="height: 41px;" placeholder="Textarea" rows="3"></textarea></div>'
            //To finally append this long string to your table through it's ID:
            $('#clnNew').append(added_row)
        });
        $(".noteIcon").click(function() {
            added_row = '<div class="parent" style="position: relative;">'+
                '<textarea class="form-control" name="note[]" style="height: 41px;" placeholder="Textarea" rows="3"></textarea></div>'
            //To finally append this long string to your table through it's ID:
            $('#noteNew').append(added_row)
        });

        $(".menuicon111").click(function(event) {
            event.preventDefault();
            console.log($(this));
            $(this).parents('.parent').remove();
        });


        $(document).on('submit','#servicesForm',function(e){
            e.preventDefault();

            var services = $("#services").val();
            var clinic = $("#ServiceClinic").val();
            var visit = $("#ServiceVisit").val();

            if(services=='') {
                alert("Please chose service.");
                return false;
            }
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('services.store')}}",
                data:{
                    services: services,
                    clinic: clinic,
                    visit: visit,
                },
                success: function(data) {
                    alert(data.result);
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });

    </script>
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

    <script>
        $(document).ready(function() {
            $("#addDiaList").change(function(){

            });
        });

        let selected2 = [];
        $(document).on("change",'#addDiaList',function(){
            let selected = [];
            var txtSelectedValuesObj = document.getElementById('addDiaList');
            var options = txtSelectedValuesObj && txtSelectedValuesObj.options;
            var opt;

            for (var i=0, iLen=options.length; i<iLen; i++) {
                opt = options[i];
                if (opt.selected) {
                    selected.push(opt.value);
                    if (!selected2.includes(opt.value)) {
                        diaSelect =
                            '<div id="parantDia' + opt.value + '" class="parantDia">'
                            + '<input type="text"  class="form-control" value="' + opt.text + '" name="diaSelected[]" style="height: 27px;">'
                            + '<input  hidden="" type="text" value="' + opt.value + '" name="icd10SelectedID[]" style="height: 27px;">'
                            + '</div>'

                        $('#icd10SelectInput').append(diaSelect)
                        selected2.push(opt.value);
                    }
                }
            }
            //console.log("befor:  "+selected2);
                for(var i = 0; i <= selected2.length; i++){
                opt = selected2[i];
                if (!selected.includes(opt)) {
                    $("#parantDia"+opt).remove();
                    //console.log("opt:  "+opt + "   opt.value :");
                    selected2.splice(i, 1);
                }
            }
           // console.log("after:  "+selected2);

        });
        $("#icd10display").on('click','a',function(e){
            e.preventDefault();
            var dia1 = 1;
            $.ajax({
                method:"GET",
                url: "/dia",
                data:{
                    dia: $(this).attr('id'),
                },
                success: function(data) {
                    // alert("sssssssss");
                    $('#addDiaList').empty();
                    for (const obj of data) {
                        added_row = '<option value='+obj.id+'>'+obj.name_ar+'</option>';
                        $('#addDiaList').append(added_row);
                    }

                    console.log(data[0].id +" "+data[0].name_ar);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
    </script>
@endsection


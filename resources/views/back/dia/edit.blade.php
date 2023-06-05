@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">

@section('title')
    تعديل مستخدم
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('visits.show', $id) }}">زيارات المريض</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('services.show', $visit) }}">ملف الزيارة</a>
                        </li>
                        <li class="breadcrumb-item active">تعديل التشخيص</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <div class="card" id="tabs-style4">
        <div class="card-body">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <div style="font-size: large;padding-bottom: 8px;
    background-color: #ecf0fa;
        padding-top: 8px;
    padding-right: 12px;
    right: -13px;
    position: relative;" class="content-title mb-0 my-auto">التشخيص المرضي</div>
                </div>
            </div><br>

            <form id="" action="{{route('dia.update','dia')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-forms.input id="" hidden="" name="visit" :value="$visit" />
                <x-forms.input id="" hidden="" name="patient" :value="$id" />
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-9" id="minusCom">
                        @if($dia->isNotEmpty())
                            @foreach ($dia as $key => $value)
                                <div style="position: relative">
                                    <textarea class="form-control" name="dia[]" style="height: 41px;"
                                              placeholder="Textarea" rows="3">{{$value->val}}</textarea>
                                    <i style="color: red;position: absolute;left: 10px;font-size: 30px;bottom: 5px;"
                                       class="las la-minus"></i>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-9">
                            <div style="font-size: medium;
    padding-bottom: 10px;
    color: #65778f;" class="content-title mb-0 my-auto">اضافة او تعديل التشخيص </div>
                            <div class="text-wrap">
                                <div class="example">
                                    <div class="d-md-flex">
                                        <div class="" style="width: 297px;">
                                            <div class="panel panel-primary tabs-style-4">
                                                <div class="tab-menu-heading">
                                                    <div class="tabs-menu " style="overflow: auto;
    height: 274px; width: 292px">
                                                        <!-- Tabs -->
                                                        <ul class="nav panel-tabs ml-3">
                                                            <li class=""><a href="#tab1" class="active" data-toggle="tab"><i class="fa fa-laptop"></i> أمراض انتانية وطفيلية محددة</a></li>
                                                            <li><a href="#tab2" data-toggle="tab"><i class="fa fa-cube"></i> أمراض تنشؤية</a></li>
                                                            <li><a href="#tab3" data-toggle="tab"><i class="fa fa-cogs"></i> أمراض الدم والأعضاء المنتجة للدم واضطرابات محددة تصيب الآلية المناعية</a></li>
                                                            <li><a href="#tab4" data-toggle="tab"><i class="fa fa-tasks"></i> الأمراض الغدية الصماوية,التغذوية , والاستقلابية</a></li>

                                                            <li><a href="#tab5" data-toggle="tab"><i class="fa fa-cube"></i> الاضطرابات العقلية والسلوكية</a></li>
                                                            <li><a href="#tab6" data-toggle="tab"><i class="fa fa-cogs"></i> أمراض الجهاز العصبي</a></li>
                                                            <li><a href="#tab7" data-toggle="tab"><i class="fa fa-tasks"></i> أمراض العين وملحقاتها</a></li>

                                                            <li><a href="#tab8" data-toggle="tab"><i class="fa fa-cube"></i> أمراض الأذن والناتئ الخشائي</a></li>
                                                            <li><a href="#tab9" data-toggle="tab"><i class="fa fa-cogs"></i> أمراض الجهاز الدوراني</a></li>
                                                            <li><a href="#tab10" data-toggle="tab"><i class="fa fa-tasks"></i> أمراض الجهاز التنفسي</a></li>

                                                            <li><a href="#tab11" data-toggle="tab"><i class="fa fa-cube"></i> أمراض الجهاز الهضمي</a></li>
                                                            <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cogs"></i> أمراض الجلد والنسيج تحت الجلد</a></li>
                                                            <li><a href="#tab13" data-toggle="tab"><i class="fa fa-tasks"></i> أمراض الجهاز العضلي الهيكلي والنسيج الضام</a></li>

                                                            <li><a href="#tab14" data-toggle="tab"><i class="fa fa-cube"></i> أمراض الجهاز البولي التناسلي</a></li>
                                                            <li><a href="#tab15" data-toggle="tab"><i class="fa fa-cogs"></i> الحمل,الولادة والنفاس</a></li>
                                                            <li><a href="#tab16" data-toggle="tab"><i class="fa fa-tasks"></i> حالات نوعية تحصل في الفترة حول الولادة</a></li>

                                                            <li><a href="#tab17" data-toggle="tab"><i class="fa fa-cube"></i> تشوهات خلقية, أسواء تشكل وشذوذات صبغية</a></li>
                                                            <li><a href="#tab18" data-toggle="tab"><i class="fa fa-cogs"></i> أعراض ,علامات وموجودات سريرية ومخبرية غير طبيعية ,غير مصنفة في مكان آخر</a></li>
                                                            <li><a href="#tab19" data-toggle="tab"><i class="fa fa-tasks"></i> أذية,تسمم وعقابيل أخرى محددة من أسباب خارجية</a></li>

                                                            <li><a href="#tab20" data-toggle="tab"><i class="fa fa-cube"></i> رموز لأغراض خاصة</a></li>
                                                            <li><a href="#tab21" data-toggle="tab"><i class="fa fa-cogs"></i> أسباب خارجية للمراضة والوفاة</a></li>
                                                            <li><a href="#tab22" data-toggle="tab"><i class="fa fa-tasks"></i> عوامل مؤثرة في الوضع الصحي والاتصال بالخدمات الصحية</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tabs-style-4 ">
                                            <div class="panel-body tabs-menu-body" style="height: 264px;width: 444px;">
                                                <div class="tab-content" id="chooseSelect">
                                                    <div class="tab-pane active" id="tab1">
                                                        <select id="" name="dia10[]" multiple class="form-control select2">
                                                            @foreach ($icd10_1 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab2">
                                                        <select id="" name="dia10[]" multiple class="form-control select2" style="width: 402px">
                                                            @foreach ($icd10_2 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab3">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_3 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab4">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_4 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="tab-pane" id="tab5">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_5 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab6">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_6 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab7">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_7 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab8">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_8 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="tab-pane" id="tab9">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_9 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab10">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_10 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab11">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_11 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab12">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_12 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="tab-pane" id="tab13">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_13 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab14">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_14 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab15">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_15 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab16">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_16 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="tab-pane" id="tab17">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_17 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab18">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_18 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab19">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_19 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab20">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_20 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="tab-pane" id="tab21">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_21 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="tab22">
                                                        <select id="" name="dia10[]" multiple class="form-control select2"  style="width: 402px">
                                                            @foreach ($icd10_22 as $key => $value)
                                                                @if (in_array($value->id,$arr))
                                                                    <option value="{{ $value->id }}" selected/>{{ $value->name_ar }} - </option>
                                                                @else
                                                                    <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>

                <div class="mg-t-30">
                    <button id="comSubmit" class="btn btn-main-primary pd-x-20" type="submit">اضافة</button>
                </div>
            </form>
        </div>
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

    $("#minusCom").on('click','i',function(e){
        e.preventDefault();
        $(this).closest("div").remove();
    });
</script>
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>

@endsection

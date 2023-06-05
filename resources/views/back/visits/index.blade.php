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
                        <li class="breadcrumb-item active">زيارات المريض</li>
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
    @if (session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-2">
                        <a class="btn btn-primary btn-sm" data-effect="effect-scale"
                           data-user_id="{{$patient}}"
                           data-toggle="modal" href="#modaldemo9" title="اضافة"><i
                                class="las la-pen-fancy"></i> اضافة زيارة </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="example1" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">عيادة</th>
                                <th class="wd-15p border-bottom-0">حالتها</th>
                                <th class="wd-20p border-bottom-0">بداية الزيارة</th>
                                <th class="wd-15p border-bottom-0">ملاحظة</th>
                                <th class="wd-15p border-bottom-0">التكلفة</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="">
                            @foreach ($visits as $key => $pat)
                                <tr>
                                    <td>{{ $pat->gnr_m_clinics->name_ar }}</td>
                                    <td>{{ $pat->getsType() }}</td>
                                    <td>{{ $pat->d_start() }}</td>
                                    <td>{{ $pat->note }}</td>
                                    <td><span>{{ $pat->price }}</span></td>
                                    <td>
                                        @if($pat->cln_m_services->isNotEmpty())
                                            <a href="{{ route('services.show', $pat->id) }}"
                                               class="btn btn-sm btn-success"
                                               title="استعراض الملف الطبي للزيارة"><i class="las la-eye"></i></a>
                                        @else
                                            <a href="{{ route('MedicalFile.create', ['visit' => $pat->id,'clinic' =>$pat->gnr_m_clinics->id,'patient'=>$pat->patient]) }}" class="btn btn-sm btn-primary-gradient"
                                               title="اضافة ملف طبي للزيارة"><i class="las la-pen"></i></a>
                                        @endif
                                        <a href="{{ route('visits.edit', $pat->id) }}" class="btn btn-sm btn-info"
                                           title="تعديل"><i class="las la-edit"></i></a>

                                            <form action="{{ route('visits.destroy','test') }}"
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
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
        <div class="modal" id="modaldemo9">
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
                            <input type="hidden" name="user_id" id="user_id" value="{{$patient}}">

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

    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->


    <script>

    </script>
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

        $("#priceID").click(function(e){
            //e.preventDefault();
            console.log("sadad");
            // $( this ).replaceWith('<x-forms.input id="" hidden="" name="visit" :value="'+$(this).text()+'" />');
        });
        $('#modaldemo8').on('show.bs.modal', function (event) {
            console.log("sadad");
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
        })
        $('#modaldemo9').on('show.bs.modal', function (event) {
            console.log("sadad");
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
        })
    </script>


@endsection

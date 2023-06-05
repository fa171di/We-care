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
                <h4 class="content-title mb-0 my-auto">الزيارات</h4><a href="#" id="priceID" class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    زيارات المريض</a>
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
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">عرض الزيارات وارباحها حسب :</h4>
                    </div>
                    <form action="{{ URL::current() }}" method="get" class="">
                        <div class="row row-sm">
                            <div class="col-xl-6 " id="history">
                                <div class="panel panel-primary tabs-style-3" style="width: 515px;">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu ">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                            class="fa fa-laptop"></i> اما ادخل شهر معين </a></li>
                                                <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i> او
                                                        ادخل يوم معين </a></li>
                                                <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> او
                                                        ادخل بين تاريخين</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab11">
                                                <p><input class="form-control fc-datepicker" name="mounth" value=""
                                                          placeholder="ادخل الشهر" type="month"/></p>
                                            </div>
                                            <div class="tab-pane" id="tab12">
                                                <p><input class="form-control fc-datepicker" name="day" value=""
                                                          placeholder="ادخل اليوم"
                                                          type="date"/></p>
                                            </div>
                                            <div class="tab-pane" id="tab13">
                                                <p><input class="form-control fc-datepicker" name="between1" value=""
                                                          placeholder="من الوقت"
                                                          type="date"/></p>
                                                <p class="mb-0"><input class="form-control fc-datepicker"
                                                                       name="between2" value="" placeholder="الي الوقت"
                                                                       type="date"/></p>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-dark mx-2">Filter</button>
                                </div>

                            </div>
                            <div class="col-xl-5">
                                <div class="card card-body tx-white-8 bg-success bd-0">
                                    <h5 class="mb-2 tx-16">ارباح الزيارات المعروضة : </h5>
                                    <span class="fs-14 ">{{$price}}</span>
                                </div>
                            </div>
                        </div>



                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap">

                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <div class="card">
                <div class="card-header pb-0">
                </div>
                <div class="card-body">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="example1" data-page-length='50'
                               style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-20p border-bottom-0">المريض</th>
                                <th class="wd-20p border-bottom-0">تاريخ الزيارة</th>
                                <th class="wd-15p border-bottom-0">ملاحظة</th>
                                <th class="wd-15p border-bottom-0">التكلفة</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody id="">
                            @foreach ($visits as $key => $pat)
                                <tr>
                                    <td>{{$pat->f_name}}</td>
                                    <td>{{ $pat->date }}</td>
                                    <td>{{ $pat->note }}</td>
                                    <td><span>{{ $pat->price }}</span></td>
                                    <td>
                                            <a href="{{ route('services.show', $pat->id) }}"
                                               class="btn btn-sm btn-success"
                                               title="استعراض الملف الطبي للزيارة"><i class="las la-eye"></i></a>
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
                        <div style="margin-top: 30px;">
                            {{$visits->withQueryString()->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
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
    </script>


@endsection

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
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                مستخدم</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <div style="font-size: large;
    padding-bottom: 10px;" class="content-title mb-0 my-auto">الخدمات المقدمة</div>
                </div>
            </div><br>

            <form id="servicesForm" action="" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <x-forms.input id="ServiceVisit" hidden="" name="visit" :value="$visit" />
                <x-forms.input id="ServiceClinic" hidden="" name="clinic" :value="$clinic" />
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><span class="">الخدمات</span></x-forms.label>
                        <select id="services" name="services[]" multiple class="form-control select2">
                            @foreach ($services as $key => $value)
                                <option value="{{ $value->id }}"/>{{ $value->name_ar }} - </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <div class="table-responsive hoverable-table">
                            <table class="table table-hover" id="" data-page-length='50'>
                                <tbody>
                                <tr>
                                    <th>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border-radius: 17px;font-size: 11px;margin-left: 22px;
    width: 32px;" class="btn btn-danger btn-sm">x</button>
                                        </form><b>wfrwfre</b>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mg-t-30">
                    <button id="ServiceSubmit" class="btn btn-main-primary pd-x-20" type="submit">اضافة</button>
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
                //contentType: "application/json",
                //dataType: "json",
                success: function(data) {
                    alert(data.result);
                    //location.reload();
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
       /* $(document).ready(function() {

            $("#ServiceSubmit").click(function() {

                var services = $("#services").val();
                var clinic = $("#ServiceClinic").val();
                var visit = $("#ServiceVisit").val();

                if(services=='') {
                    alert("Please chose service.");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "services.store",
                    contentType: "application/json; charset=utf-8",
                    data: {
                        'services': services,
                        'clinic': clinic,
                        'visit': visit,
                    },
                    cache: false,
                    success: function(data) {
                        alert("storing success");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });

            });

        });*/
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
@endsection


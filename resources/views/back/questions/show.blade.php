@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/css.css') }}" rel="stylesheet" />
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
                        <li class="breadcrumb-item active">جميع الأسئلة</li>
                    </ol></nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span></button>
            <strong>Well done!</strong> {{ session('success') }}.
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mg-b-0" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span></button>
            <strong>Oh snap!</strong> {{ session('error') }}.
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@if($questions->isNotEmpty()){{$questions[0]->gnr_m_clinics->name_ar}}@endif جميع الاسئلة الخاصة بقسم.</h6>
                        <p class="text-muted card-sub-title"></p>
                    </div>
                    <div aria-multiselectable="true" class="accordion accordion-blue" id="accordion2" role="tablist">
                        @if($questions->isNotEmpty())
                            @foreach($questions as $key => $q)
                                <div class="card mb-0">
                                    <a href="{{ route('questions.edit', $q->id) }}" style="    position: absolute;
    width: 43px;
    left: 18px;
    z-index: 2;
    top: 12px;
    background-color: #0162e8;"
                                       class="btn btn-sm btn-primary"><i class="las la-pen mg-l-5 mg-r-5"></i></a>
                                    <div class="card-header" id="heading{{$key}}2" role="tab">
                                        <a aria-controls="collapse{{$key}}2" aria-expanded="true"
                                           class="collapsed" data-toggle="collapse" href="#collapse{{$key}}2">
                                            {{$q->Question}}
                                        </a>
                                    </div>
                                    <div aria-labelledby="heading{{$key}}2" class="collapse" data-parent="#accordion2"
                                         id="collapse{{$key}}2" role="tabpanel">
                                        <div class="card-body">
                                            @if($q->answer !== null)
                                                {{$q->answer}}
                                            @else
                                                لم يتم الاجابة عن السؤال بعد
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted card-sub-title">لا يوجد اسئلة في هذا القسم</p>
                        @endif

                    </div><!-- accordion -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script>
        $('#deleteAds').on('submit','form',function(e) {
            e.preventDefault();
            $(this).closest(".closeAd").remove();
            $.ajax({
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('ads.destroy','test')}}",
                data: $(this).serialize()
                ,
                success: function(data) {
                    alert(data.result);
                },
                error: function(xhr, status, error) {
                    console.error(xhr);}});
        });
    </script>
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--- Internal Accordion Js -->
    <script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/accordion.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection

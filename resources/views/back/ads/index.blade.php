@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
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
            <li class="breadcrumb-item active">جميع الاعلانات</li>
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
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">


            </div>
            <div class="card-body row row-sm" style="">
                <div class="row" id="deleteAds">
                    @foreach ($ads as $value)
                        <div class="col-lg-4 col-md-12 col-12 col-sm-12 closeAd">
                            @if($value->statue == 0)
                                <div class="card" style="border-top: 7px solid #ee335e">
                            @else
                                <div class="card" style="border-top: 7px solid #22e840">
                            @endif
                                    @if($value->img != null)
                                        <img class="card-img-top" src="{{URL::asset('img/'.$value->img)}}"
                                             alt="Card image cap">
                                    @endif
                                    <div class="card-body">
                                        <p class="card-text">{{$value->text}}.</p>
                                    </div>
                                    <div class="card-footer bd-t text-xl-right">
                                        {{$value->time()}}
                                        <a href="{{ route('ads.edit', $value->id) }}" title="تعديل"><i style="    font-size: 21px;
    color: blue;" class="las la-pen-fancy mg-l-5 mg-r-5"></i></a>
                                        <form action=""
                                              style="display:inline" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="input" id="id" value="{{ $value->id }}">
                                            <input type="hidden" name="img" id="id" value="{{ $value->img }}">
                                            <button type="submit" style="    background-color: #fff;
    outline: 1px auto #fff;"><i style="font-size: 21px;
    color: red;" class="las la-trash mg-l-5 mg-r-5"></i></button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
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
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection

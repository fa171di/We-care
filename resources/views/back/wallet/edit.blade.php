@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">



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
                        <li class="breadcrumb-item active">حساب محفظتي</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
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
            <strong>{{ session('error') }}</strong> {{ session('msg') }}.
        </div>
    @endif
    <br>

    <div class="card">
        <div class="card-body">


            <form id="" action={{route('wallet.update', $patient[0]->id)}}"" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{$patient[0]->id}}">
                <input type="hidden" name="digital_wallet" value="{{$patient[0]->digital_wallet}}">
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-12" id="fnWrapper">
                         <div style="background-color: #062c5c;
    width: 200px;
    padding-right: 18px;
    padding-top: 9px;
    /* padding-bottom: 0px; */
    border-radius: 33px;
    margin-bottom: 16px;">
                            <input type="radio" required value="0" style="margin-left: 5px;width: 20px;height: 20px;" name="wallet">
                            <label for="outline" style="margin-left: 11px;color: #08ff08;font-size: 22px;">اضافة</label>
                            <input type="radio" required value="1" style="margin-left: 5px;width: 20px;height: 20px;" name="wallet">
                            <label for="outline" style="margin-left: 20px;color: #ff4747;font-size: 22px;">سحب</label>
                         </div>
                    </div>
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <x-forms.label id=""><strong class="">ادخل القيمة :</strong></x-forms.label>
                        <x-forms.input required oninvalid="this.setCustomValidity('يجب ان تدخل رقم')" onchange="this.setCustomValidity('')" inputmode="numeric" pattern="[0-9]*"  class="" name="accountValue"  />
                    </div>
                </div>

                <div class="mg-t-30">
                    <button id="ServiceSubmit" class="btn btn-success pd-x-20" type="submit">اضافة</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card card-body tx-white-8 bg-success bd-0">
                        <div class="">قيمة الحساب الحالي : <span class="tx-20 font-weight-bold mr-2">{{$patient[0]->digital_wallet}}</span></div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Shopping Cart-->
                    <div class="column text-lg"><span class="tx-20 font-weight-normal mr-2">العمليات التي تمت على الحساب</span></div>
                    <br>
                    <div class="product-details table-responsive text-nowrap">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>العملية</th>
                                <th>القيمة المضافة اوالمسحوبة</th>
                                <th>قيمة الحسساب السابق التي تمت العملية عليه</th>
                            </tr>
                            </thead>
                            <tbody id="">
                            @foreach ($patient[0]->wallet as $pat)
                                <tr>
                                    <td class="text-center text-lg text-medium">{{ $pat->created_at }}</td>
                                    @if($pat->statue == 0)
                                        <td class="text-center text-lg text-medium" style="color: limegreen">{{ $pat->Statue() }}</td>
                                    @else
                                        <td class="text-center text-lg text-medium" style="color: red">{{ $pat->Statue() }}</td>
                                    @endif

                                    <td class="text-center text-lg text-medium">{{ $pat->value_changing }}</td>
                                    <td class="text-center text-lg text-medium">{{ $pat->prev_value }}</td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->

    </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

@endsection

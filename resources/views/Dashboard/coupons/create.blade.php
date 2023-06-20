@extends('layouts.master')
@section('css')

@section('title')
    اضافة كوبون خصم
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> اضافة كوبون خصم</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">اضافة كوبون خصم</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">الكود</label>
                        <input type="text" name='code' value="{{ old('name') }}" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">نوع الخصم</label>
                        <select name="type" id="typeID" class="custom-select my-1 mr-sm-2">
                            <option selected disabled>حدد نوع الخصم</option>
                            <option value="fixed">قيمة</option>
                            <option value="precent">نسبة</option>
                        </select>
                    </div>
                    <div class="form-group" id="valueID" style="display: none;">
                        <label for="exampleInputEmail1">القيمة</label>
                        <input type="text" id='valID' name='value' value="{{ old('value') }}"
                            class="form-control" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group" id="precentID" style="display: none;">
                        <label for="exampleInputEmail1">نسبة الخصم</label>
                        <input type="text" id='preoffID' name='precent_off' value="{{ old('precent_off') }}"
                            class="form-control" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">نوع الاستخدام</label>
                        <select name="type_of_use" id="typeUseID" class="custom-select my-1 mr-sm-2">
                            <option selected disabled>اختر نوع الاستخدام</option>
                            <option value="0">مرة واحدة</option>
                            <option value="1">متعدد</option>
                        </select>
                    </div><br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">عدد مرات الاستخدام المتاح</label>
                        <input type="text" name='max_uses' value="{{ old('max_uses') }}" class="form-control"
                            id="maxID" aria-describedby="emailHelp">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">حد أقصى للخصم</label>
                        <input type="text" name='max_discount' value="{{ old('max_discount') }}" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">حد أدني لسعر العربة</label>
                        <input type="text" name='minimum_of_total' value="{{ old('minimum_of_total') }}"
                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label>تاريخ البداية</label>
                        <input class="form-control fc-datepicker" name="start_date" placeholder="YYYY-MM-DD"
                            type="text" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>تاريخ الانتهاء</label>
                        <input class="form-control" type="text" id="datepicker-action" name="expiry_date"
                            placeholder="YYYY-MM-DD" data-date-format="yyyy-mm-dd">
                    </div>
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<Script>
    //JQ

    // show and hide input [value&precent] [first way]
    $('#typeID').change(function() {
        if ($(this).val() === 'fixed') {
            $('#valueID').show();
            $('#precentID').hide();
            $('#preoffID').val('0');
        } else {
            // $('#precentID').Val('');
            $('#precentID').show();
            $('#valueID').hide();
            $('#valID').val('0');

        }
    });

    //select [type_of_use]
    $('#typeUseID').change(function() {
        if ($(this).val() === '0') {
            $('#maxID').val('1');

            $('#maxID').prop('readonly', true);
        }
        else {
            $('#maxID').prop('readonly', false);
        }
    });

    // show and hide input [value&precent] [second way]

    //input [value]
    // $('#valueID').change(function() {
    //     if ($(this).val()) {
    //         // $('#precentID').hide();
    //         $('#precentID').prop('disabled', true).attr('placeholder', 'تم تحديد القيمة لا يمكن اضافة النسبة');
    //     } else {
    //         // $('#precentID').show();
    //         $('#precentID').prop('disabled', false).attr('placeholder', '');
    //     }
    // });

    //input [precent_off]
    // $('#precentID').change(function() {
    //     if ($(this).val()) {
    //         $('#valueID').prop('disabled', true).attr('placeholder', 'تم تحديد النسبة لا يمكن اضافة القيمة');
    //     } else {
    //         $('#valueID').prop('disabled', false).attr('placeholder', '');
    //     }
    // });
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //JS

    // const inputValue = document.getElementById('valueID');
    // const inputPrecent = document.getElementById('precentID');

    // inputValue.addEventListener('change', function() {
    //     if (inputValue.value) {
    //         inputPrecent.disabled = true;
    //     } else {
    //         inputPrecent.disabled = false;
    //     }
    // });
    // inputPrecent.addEventListener('change', function() {
    //     if (inputPrecent.value) {
    //         inputValue.disabled = true;
    //     } else {
    //         inputValue.disabled = false;
    //     }
    // });

    // const select1 = document.getElementById('typeID');
    // const input1 = document.getElementById('maxID');

    // select1.addEventListener('change', function() {
    //     if (select1.value === '0') {
    //         input1.disabled = true;
    //     } else {
    //         input1.disabled = false;
    //     }
    // });
</Script>
@endsection

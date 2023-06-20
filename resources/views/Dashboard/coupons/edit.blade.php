@extends('layouts.master')
@section('css')

@section('title')
    تعديل كوبون|{{ $coupon->code }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">تعديل كوبون| {{ $coupon->code }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">{{ $coupon->code }}</li>
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
                <div class="card-body">
                    <form action="{{ route('coupon.update', ['id' => $coupon->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">الكود</label>
                            <input type="text" name='code' value="{{ $coupon->code }}" class="form-control"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">نوع الخصم</label>
                            <select name="type" id="typeID" class="custom-select my-1 mr-sm-2">
                                <option selected disabled>حدد نوع الخصم</option>
                                <option value="fixed"{{ $coupon->type == 'fixed' ? 'selected' : '' }}>قيمة</option>
                                <option value="precent"{{ $coupon->type == 'precent' ? 'selected' : '' }}>نسبة</option>
                            </select>
                        </div>
                        <div class="form-group" id="valueID" style="display: none;">
                            <label for="exampleInputEmail1">القيمة</label>
                            <input type="text" id='valID' name='value' value="{{ $coupon->value }}"
                                class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group" id="precentID" style="display: none;">
                            <label for="exampleInputEmail1">نسبة الخصم</label>
                            <input type="text" id='preoffID' name='precent_off' value="{{ $coupon->precent_off }}"
                                class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">نوع الاستخدام</label>
                            <select name="type_of_use" id="typeUseID" class="custom-select my-1 mr-sm-2">
                                <option selected disabled>اختر نوع الاستخدام</option>
                                <option value="0"{{ $coupon->type_of_use == 0 ? 'selected' : '' }}>مرة واحدة
                                </option>
                                <option value="1"{{ $coupon->type_of_use == 1 ? 'selected' : '' }}>متعدد</option>
                            </select>
                        </div><br>
                        <div class="form-group" id="maxID">
                            <label for="exampleInputEmail1">عدد مرات الاستخدام المتاح</label>
                            <input type="text" id='timesID' name='max_uses' value="{{ $coupon->max_uses }}"
                                class="form-control" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">حد أقصى للخصم</label>
                            <input type="text" name='max_discount' value="{{ $coupon->max_discount }}"
                                class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">حد أدني لسعر العربة</label>
                            <input type="text" name='minimum_of_total' value="{{ $coupon->minimum_of_total }}"
                                class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>تاريخ البداية</label>
                            <input class="form-control fc-datepicker" name="start_date" placeholder="YYYY-MM-DD"
                                type="text" value="{{ $coupon->start_date }}" required>
                        </div>
                        <div class="form-group">
                            <label>تاريخ الانتهاء</label>
                            <input class="form-control" type="text" id="datepicker-action" name="expiry_date"
                                value="{{ $coupon->expiry_date }}" placeholder="YYYY-MM-DD"
                                data-date-format="yyyy-mm-dd">
                        </div>
                        <button type="submit" class="btn btn-primary">تأكيد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        var typeID = $('#typeID');

        if (typeID.val() === 'fixed') {
            $('#valueID').show();
        }
        if (typeID.val() === 'precent') {
            $('#precentID').show();
        }
        typeID.on('change', function() {
            if ($(this).val() === 'fixed') {
                $('#valueID').show();
                $('#precentID').hide();
                $('#preoffID').val('');
            } else {
                $('#precentID').show();
                $('#valueID').hide();
                $('#valID').val('');
            }
        });

        var typeUseID = $('#typeUseID');
        if (typeUseID.val() === '0') {
            $('#maxID').hide();
            $('#timesID').val('1');
        }
        typeUseID.on('change', function() {
            if ($(this).val() === '1') {
                $('#maxID').show();

            } else {
                $('#maxID').hide();
                $('#timesID').val('1');
            }
        });
    });
</script>
@endsection

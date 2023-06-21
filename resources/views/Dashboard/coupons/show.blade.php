@extends('layouts.master')
@section('css')

@section('title')
    كوبون | {{ $coupon->code }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> كوبون | {{ $coupon->code }}</h4>
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
                <div class="tab nav-border">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                role="tab" aria-controls="home-02" aria-selected="true"> تفاصيل كوبون
                                | {{ $coupon->code }} </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02" role="tab"
                                aria-controls="profile-02" aria-selected="false">المستخدمين</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                            aria-labelledby="home-02-tab">
                            <table class="table table-striped table-hover" style="text-align:center">
                                <tbody>
                                    <tr>
                                        <th scope="row">الكود</th>
                                        <td>{{ $coupon->code }}</td>
                                        <th scope="row">نوع الخصم</th>
                                        <td>{{ $coupon->type }}</td>
                                        <th scope="row">نوع الاستخدام</th>
                                        <td>
                                            @if ($coupon->type_of_use === 1)
                                                متعدد
                                            @else
                                                مره واحدة
                                            @endif
                                        </td>
                                        <th scope="row">عدد مرات الاستخدام المتاح</th>
                                        <td>{{ $coupon->max_uses }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">قيمة الخصم</th>
                                        <td>{{ $coupon->value ? $coupon->value : '-' }}</td>
                                        <th scope="row">نسبه الخصم</th>
                                        <td>%{{ $coupon->precent_off ? $coupon->precent_off : '-' }}</td>
                                        <th scope="row">الحد الاقصى للخصم</th>
                                        <td>{{ $coupon->max_discount ? $coupon->max_discount : '-' }}L.E</td>
                                        <th scope="row">الحد الادني لسعر العربه</th>
                                        <td>{{ $coupon->minimum_of_total ? $coupon->minimum_of_total : '-' }}L.E</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">عدد مرات الاستخدام</th>
                                        <td>{{ $coupon->current_uses }}</td>
                                        <th scope="row">تاريخ البدأ</th>
                                        <td>{{ $coupon->start_date }}</td>
                                        <th scope="row">تاريخ الانتهاء</th>
                                        <td>{{ $coupon->expiry_date }}</td>
                                        <th scope="row"></th>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile-02" role="tabpanel" aria-labelledby="profile-02-tab">
                            <div class="card card-statistics">

                                <table
                                    class="table center-aligned-table mb-0 table table-hover"style="text-align:center">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col">#</th>
                                            <th scope="col">اسم العميل</th>
                                            <th scope="col">الكوبون</th>
                                            <th scope="col">الادوردر</th>
                                            <th scope="col">التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupon->users as $co)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $co->name }}</td>
                                                <td>{{ $coupon->code }}</td>
                                                @foreach ($co->userCart as $order)
                                                    <td>{{ $order->order_number }}</td>
                                                @endforeach
                                                <td>{{ $coupon->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection

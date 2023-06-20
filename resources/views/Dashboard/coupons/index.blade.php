@extends('layouts.master')
@section('css')

@section('title')
    كوبونات الخصم
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">كوبونات الخصم</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">كوبونات الخصم</li>
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
                <a href="{{ route('coupon.create') }}" class="btn btn-primary " role="button" aria-pressed="true">كوبون
                    جديد</a><br><br>
                <table id="datatable" class="table  table-dark table-sm table-bordered p-0" data-page-length="50"
                    style="text-align: center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الكود</th>
                            <th scope="col">نوع الخصم</th>
                            <th scope="col">الحالة</th>
                            <th scope="col">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>
                                    @if ($coupon->type == 'fixed')
                                        قيمة
                                    @else
                                        نسبة
                                    @endif
                                </td>
                                <td>
                                    @if ($coupon->current_uses >= $coupon->max_uses)
                                        <label class="badge badge-danger">غير متاح</label>
                                    @else
                                        <label class="badge badge-success">متاح</label>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-warning btn-sm edit"
                                        href="{{ route('coupon.show', ['coupon' => $coupon->id]) }}" title="Show"><i
                                            class="fa fa-eye "></i>
                                    </a>
                                    {{-- @can('product-edit') --}}
                                    <a class="btn btn-info btn-sm edit"
                                        href="{{ route('coupon.edit', ['id' => $coupon->id]) }}" title="تعديل"><i
                                            class="fa fa-edit"></i>
                                    </a>
                                    {{-- @endcan --}}
                                    {{-- @can('product-delete') --}}
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#coupon{{ $coupon->id }}" title="حذف">
                                        <i style="color: White" class="fa fa-trash"></i>
                                    </button>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                            <div class="modal fade" id="coupon{{ $coupon->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('coupon.delete', ['id' => $coupon->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">انت تقوم بعملية حذف الان</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary"data-dismiss="modal">رجوع</button>
                                                    <button type="submit" class="btn btn-danger">تأكيد</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection

@extends('layouts.master')
@section('css')

@section('title')
    تعديل مقاس وسعر المنتج
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">تعديل مقاس وسعر المنتج </h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">تعديل مقاس وسعر المنتج </li>
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <br>
                    <label for="exampleFormControlTextarea1">معلومات الجحم والسعر </label>
                    <div class="card-body">
                        <form action="{{ route('product.size.update', ['id' => $productSize->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="repeater"> --}}
                                {{-- <div data-repeater-list="data_list"> --}}
                                    {{-- <div data-repeater-item> --}}
                                        <div class="row">
                                            <div class="col">
                                                <label for="exampleInputEmail1" class="mr-sm-2">المقاس:</label>
                                                <div class="box">
                                                   <input type="text" value="{{$productSize->size->name}}" disabled readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="exampleInputEmail1">السعر</label>
                                                <input type="number" name='price' value="{{ $productSize->price }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    {{-- </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button" data-repeater-create type="button" value="صف جديد" />
                                    </div>
                                </div> --}}
                            {{-- </div> --}}
                        <button type="submit" class="btn btn-primary">تأكيد</button>

                        </form>
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

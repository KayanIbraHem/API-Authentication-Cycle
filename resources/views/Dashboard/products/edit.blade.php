@extends('layouts.master')
@section('css')

@section('title')
    تعديل المنتج
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">تعديل المنتج</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">تعديل المنتج </li>
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
                    <form action="{{ route('product.update', ['id' => $product->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم المنتج</label>
                            <input type="text" name='name' value="{{ $product->name }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الرئيسي</label>
                            <select name="maincat_id" id="exampleFormControlSelect1" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $product->maincat_id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الرئيسي الفرعي</label>
                            <select name="subcat_id" id="exampleFormControlSelect1" class="form-control">
                                @foreach ($categories as $mainCat)
                                    @foreach ($mainCat->subcategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" {{$subCategory->id==$product->subcat_id?"selected":''}}>{{ $subCategory->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الفرعي</label>
                            <select name="subsub_cat" id="exampleFormControlSelect1" class="form-control">
                                @foreach ($categories as $mainCategory)
                                    @foreach ($mainCategory->subcategories as $subCategory)
                                        @foreach ($subCategory->subSubCategories as $subSubCategory)
                                            <option value="{{ $subSubCategory->id }}"{{$subSubCategory->id==$product->subsub_cat?"selected":''}}>{{ $subSubCategory->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">الحجم</label>
                            <select name="size_id" id="exampleFormControlSelect1" class="form-control">
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}"{{$size->id==$product->size_id?"selected":""}}>{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">وصف المنتج</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" cols="12" name="description">{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">الصورة</label>
                            <input type="file" name="image" data-default-file="{{ asset($product->image) }}"
                                class="form-control dropify">

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

@endsection

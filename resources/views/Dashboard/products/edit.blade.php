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
                    <br>
                    <label for="exampleFormControlTextarea1">معلومات الجحم والسعر </label>
                    <br>

                    <table id="datatable" class="table  table-dark table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الحجم</th>
                                <th scope="col">السعر</th>
                                <th scope="col">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($product->size_names as $data)
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->price }}</td>
                                    <td>
                                        @can('product-edit')
                                            <a class="btn btn-info btn-sm edit"
                                                href="{{ route('product.size.edit', ['id' => $data->id]) }}"
                                                title="تعديل"><i class="fa fa-edit"></i></a>
                                        @endcan
                                        @can('product-delete')
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#size{{ $data->id }}" title="حذف">
                                                <i style="color: White" class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                            </tr>
                            <div class="modal fade" id="size{{ $data->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('product.size.delete', ['productSize' => $data->id]) }}"
                                        method="post">
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
                    <br>
                    <form action="{{ route('product.update', ['id' => $product->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم المنتج</label>
                            <input type="text" name='name' value="{{ $product->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الرئيسي</label>
                            <select name="maincat_id" id="exampleFormControlSelect1" class="custom-select my-1 mr-sm-2">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $product->maincat_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الرئيسي الفرعي</label>
                            <select name="subcat_id" id="exampleFormControlSelect1" class="custom-select my-1 mr-sm-2">
                                @foreach ($categories as $mainCat)
                                    @foreach ($mainCat->subcategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            {{ $subCategory->id == $product->subcat_id ? 'selected' : '' }}>
                                            {{ $subCategory->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الفرعي</label>
                            <select name="subsub_cat" id="exampleFormControlSelect1" class="custom-select my-1 mr-sm-2">
                                @foreach ($categories as $mainCategory)
                                    @foreach ($mainCategory->subcategories as $subCategory)
                                        @foreach ($subCategory->subSubCategories as $subSubCategory)
                                            <option
                                                value="{{ $subSubCategory->id }}"{{ $subSubCategory->id == $product->subsub_cat ? 'selected' : '' }}>
                                                {{ $subSubCategory->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <br>
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="data_list">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col">
                                                <label for="exampleInputEmail1" class="mr-sm-2">المقاس:</label>
                                                <div class="box">
                                                    <select class="custom-select my-1 mr-sm-2" name="size_id">
                                                        <option selected disabled> Select...</option>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->id }}">{{ $size->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="exampleInputEmail1">السعر</label>
                                                <input type="number" name='price' value="{{ old('price') }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button" data-repeater-create type="button" value="صف جديد" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">وصف المنتج</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" cols="12" name="description">{{ $product->description }}</textarea>
                        </div>
                        <br>
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

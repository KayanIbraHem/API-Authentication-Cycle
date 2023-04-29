@extends('layouts.master')
@section('css')

@section('title')
    تعديل القسم الفرعي
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">تعديل القسم الفرعي</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">تعديل القسم الفرعي</li>
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
                <form action="{{ route('category.subsub.update',['id'=>$subSubCat->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputEmail1">الاسم</label>
                        <input type="text" name='name' value="{{$subSubCat->name  }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="mb-1">حدد القسم الفرعي</label>
                        <select name="parent_id" id="exampleFormControlSelect1" class="form-control">
                            @foreach ($categories as $category)
                                @foreach ($category->subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{$subcategory->id==$subSubCat->parent_id?"selected":''}}>{{ $subcategory->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">الصورة</label>
                        <input type="file" name="image" data-default-file="{{asset($subSubCat->image)}}" class="form-control dropify">
                    </div>
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </form>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')

@endsection

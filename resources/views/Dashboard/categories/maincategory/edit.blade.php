@extends('layouts.master')
@section('css')

@section('title')
    تعديل القسم
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">تعديل القسم</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">تعديل القسم</li>
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
                <form action="{{ route('category.update', ['id' => $category->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputEmail1">الاسم</label>
                        <input type="text" name='name' value="{{ $category->name }}" class="form-control">
                    </div>
                    {{-- @if ($category->subcategories_count < 1)
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="mb-1">القسم الرئيسي</label>
                            <select name="parent_id" id="exampleFormControlSelect1" class="form-control">
                                <option value="0" {{ $category->parent_id == 0 ? 'selected' : '' }}>قسم رئيسي</option>
                                @foreach ($mainCategories as $cat)
                                    @if ($cat->id != $category->id)
                                        <option value="{{ $cat->id }}"
                                            {{ $cat->id == $category->parent_id ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endif --}}
                    <div class="form-group">
                        <label for="exampleInputEmail1">الصورة</label>
                        <input type="file" name="image" data-default-file="{{ asset($category->image) }}"
                            class="form-control dropify" required>
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

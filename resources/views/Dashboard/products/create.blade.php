@extends('layouts.master')
@section('css')

@section('title')
    اضافة منتج
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">اضافة منتج</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">اضافة منتج</li>
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
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المنتج</label>
                        <input type="text" name='name' value="{{ old('name') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="mb-1">القسم الرئيسي</label>
                        <select name="maincat_id" id="exampleFormControlSelect1" class="custom-select my-1 mr-sm-2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="mb-1">القسم الفرعي</label>
                        <select name="subcat_id" id="exampleFormControlSelect1" class="custom-select my-1 mr-sm-2">

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="mb-1">القسم الفرعي للفرعي</label>
                        <select name="subsub_cat" id="exampleFormControlSelect1" class="custom-select my-1 mr-sm-2">

                        </select>
                    </div>
                    {{-- <div class="card-body">
                        <div class="col">

                            <label for="sizes">Sizes:</label>
                            @foreach ($sizes as $size)
                                <input type="checkbox" name="sizes[]" value="{{ $size->id }}">
                                {{ $size->name }}<br>
                            @endforeach
                        </div>

                        <div class="col">

                            <label for="prices">Prices:</label>
                            @foreach ($sizes as $size)
                                <input type="number" name="prices[]" value="0" step="0.01"><br>
                            @endforeach
                        </div>
                    </div> --}}

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
                                    <div class="col">
                                        <input class="btn btn-danger " data-repeater-delete type="button"
                                            value="حذف الصف" />
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
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" cols="12" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">الصورة</label>
                        <input type="file" name="image" class="form-control dropify">
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
<script>
    $('select[name="maincat_id"]').on('change', function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: '{{ route('get-subcategories', '') }}/' + categoryId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="subcat_id"]').empty();
                    $('select[name="subsub_cat"]').empty();
                    $('select[name="subcat_id"]').append(
                        '<option selected disabled>  Select...</option>');
                    $.each(data, function(key, value) {
                        $('select[name="subcat_id"]').append('<option value="' + value.id +
                            '">' +
                            value.name + '</option>');
                    });
                }
            });
        } else {
            console.log('AJAX load did not work');
        }
    });

    $('select[name="subcat_id"]').on('change', function() {
        var subCatID = $(this).val();
        if (subCatID) {
            $.ajax({
                url: '{{ route('get-subsubcategories', '') }}/' + subCatID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="subsub_cat"]').empty();
                    $('select[name="subsub_cat"]').append(
                        '<option selected disabled>  Select...</option>');
                    $.each(data, function(key, value) {
                        $('select[name="subsub_cat"]').append('<option value="' + value.id +
                            '">' +
                            value.name + '</option>');
                    });
                }
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
</script>
@endsection

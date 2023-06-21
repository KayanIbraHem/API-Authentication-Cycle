@extends('layouts.master')
@section('css')

@section('title')
    قائمة الاقسام الفرعيه للقسم الفرعي
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">قائمة الاقسام الفرعيه للقسم الفرعي</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">قائمة الاقسام الفرعيه للقسم الفرعي</li>
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
                <table id="datatable" class="table  table-dark table-sm table-bordered p-0" data-page-length="50"
                    style="text-align: center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الاسم</th>
                            <th scope="col">الصورة</th>
                            <th scope="col">القسم الرئيسي</th>
                            <th scope="col">عدد المنتجات</th>
                            <th scope="col">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subsubcategories as $subcategories)
                            @foreach ($subcategories->subcategories as $subcategory)
                                @foreach ($subcategory->subSubCategories as $sub)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sub->name }}</td>
                                        <td><img src=" {{ asset($sub->image) }}" width="100px" height="100px">
                                        </td>
                                        <td>{{ $subcategory->name}}</td>
                                        <td>{{ $subcategories->products_count}}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm edit"
                                                href="{{ route('category.subsub.edit', ['id' => $sub->id]) }}" title="تعديل"><i
                                                    class="fa fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#subcategory{{ $sub->id }}" title="حذف">
                                                <i style="color: White" class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="subcategory{{ $sub->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('category.subsub.delete', ['id' => $sub->id]) }}" method="post">
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
                            @endforeach
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

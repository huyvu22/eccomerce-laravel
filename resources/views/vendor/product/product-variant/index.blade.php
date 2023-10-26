@extends('vendor.layouts.master')
@section('title')
    Shop Now
@endsection
@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            {{--Sidebar start--}}
            @include('vendor.layouts.sidebar')
            {{--Sidebar end --}}

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="mb-3">
                        <button class="btn btn-success" onclick="history.back()" style="font-size: 14px"><i class="fas fa-arrow-left"></i> Quay lại</button>
                    </div>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h4>Thuộc tính sản phẩm</h4>
                        <h6>Tên sản phẩm: {{$product->name}}</h6>
                        <div class="mb-3 mt-2">
                            <a href="{{route('vendor.products-variant.create',['product'=>$product->id])}}" class="btn btn-primary" style="font-size: 14px"><i
                                    class="fas fa-plus"></i> Tạo thuộc tính mới</a>
                        </div>
                    </div>
                    <div class="wsus__dashboard_profile">
                        <div class="wsus__dash_pro_area" style="font-size: 14px">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush




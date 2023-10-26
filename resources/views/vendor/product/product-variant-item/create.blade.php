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
                    <h4 class="mb-3">Tạo các thuộc tính của sản phẩm</h4>
                    <div class="mb-2">
                        <button class="btn btn-success" onclick="history.back()" style="font-size: 14px"><i class="fas fa-arrow-left"></i> Quay lại</button>
                    </div>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{route('vendor.products-variant-item.store')}}" method="post">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="">Tên thuộc tính (Màu sắc, Size, Dung lượng...)</label>
                                        <input type="text" name="variant_name" class="form-control" value="{{$variant->name}}" readonly style="font-size: 14px">
                                        @if($errors->has('variant_name'))
                                            <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <input type="hidden" name="variant_id" class="form-control" value="{{$variant->id}}">
                                        <input type="hidden" name="product_id" class="form-control" value="{{$product->id}}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Chi tiết thuộc tính con (xanh, size, M....)</label>
                                        <input type="text" name="item_name" class="form-control" value="{{old('item_name')}}" style="font-size: 14px">
                                        @if($errors->has('item_name'))
                                            <span class="text-danger">{{ $errors->first('item_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Đây là thuộc tính mặc định ( +0đ )</label>
                                        <select class="form-control" name="is_default" style="font-size: 14px">
                                            <option value="1">Mặc định (0đ)</option>
                                            <option value="0">Cộng thêm tiền</option>
                                        </select>
                                        @if($errors->has('is_default'))
                                            <span class="text-danger">{{ $errors->first('is_default') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Giá (Bỏ qua nếu là thuộc tính mặc định)</label>
                                        <input type="text" name="price" class="form-control" value="{{old('price')}}" style="font-size: 14px">
                                        @if($errors->has('price'))
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Trạng thái</label>
                                        <select class="form-control" name="status" style="font-size: 14px">
                                            <option value="1">Kích hoạt</option>
                                            <option value="0">Không kích hoạt</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>
@endsection





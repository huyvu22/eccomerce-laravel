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
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="mb-3">
                            <a class="btn btn-success" onclick="history.back()" href="#" style="font-size: 14px"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                        <h4 class="mb-3">Sửa các thuộc tính của sản phẩm</h4>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.products-variant-item.update',$variantItem)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-group mb-3">
                                        <label for="">Tên thuộc tính (Màu sắc, Size, Dung lương...)</label>
                                        <input type="text" name="variant_name" class="form-control" value="{{$variantItem->variant->name}}" readonly style="font-size: 14px">
                                        @if($errors->has('variant_name'))
                                            <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Chi tiết thuộc tính con (xanh, size M....)</label>
                                        <input type="text" name="item_name" class="form-control" value="{{$variantItem->name}}" style="font-size: 14px">
                                        @if($errors->has('item_name'))
                                            <span class="text-danger">{{ $errors->first('item_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Đây là thuộc tính mặc định ( +0đ )</label>
                                        <select class="form-control" name="is_default" style="font-size: 14px">
                                            <option value="1" {{$variantItem->is_default == 1 ? 'selected' : ''}}>Mặc định (0đ)</option>
                                            <option value="0" {{$variantItem->is_default == 0 ?  'selected': ''}}>Cộng thêm tiền</option>
                                        </select>
                                        @if($errors->has('is_default'))
                                            <span class="text-danger">{{ $errors->first('is_default') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Giá (Bỏ qua nếu là thuộc tính mặc định)</label>
                                        <input type="text" name="price" class="form-control" value="{{$variantItem->price}}" style="font-size: 14px">
                                        @if($errors->has('price'))
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Trạng thái</label>
                                        <select class="form-control" name="status">
                                            <option value="1" {{$variantItem->status == 1 ? 'selected' : ''}} >Kích hoạt</option>
                                            <option value="0" {{$variantItem->status == 0 ? 'selected' : ''}} >Không kích hoạt</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="font-size: 14px">Cập nhật</button>
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






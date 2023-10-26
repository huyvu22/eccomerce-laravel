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
                        <h4 class="mb-2"> Sửa thông tin sản phẩm </h4>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.products.update',$product)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')

                                    <div class="form-group mb-3">
                                        <label for="">Ảnh hiện tại</label>
                                        <br>
                                        <img src="{{asset($product->thumb_image)}}" width="100" alt="img">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Ảnh</label>
                                        <input type="file" name="image" class="form-control" value="{{$product->thumb_image}}" style="font-size: 14px">
                                        @if($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Tên</label>
                                        <input type="text" name="name" class="form-control" value="{{$product->name}}" style="font-size: 14px">
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="">Hạng mục cha</label>
                                                <select class="form-control category" name="category" style="font-size: 14px">
                                                    <option value="0">Select</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{$category->id}}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category'))
                                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="">Hạng mục con</label>
                                                <select class="form-control sub_category" name="sub_category" style="font-size: 14px">
                                                    <option value="0">Select</option>
                                                    @foreach($subCategories as $subCategory)
                                                        <option
                                                            value="{{$subCategory->id}}" {{$subCategory->id == $product->subCategory->id ? 'selected':''}}>{{$subCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('sub_category'))
                                                    <span class="text-danger">{{ $errors->first('sub_category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="">Hạng mục nhỏ hơn</label>
                                                <select class="form-control child_category" name="child_category" style="font-size: 14px">
                                                    <option value="0">Select</option>
                                                    @foreach($childCategories as $childCategory)
                                                        <option
                                                            value="{{$childCategory->id}}" {{$childCategory->id == $product->child_category_id ? 'selected' : ''}} >{{$childCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('child_category'))
                                                    <span class="text-danger">{{ $errors->first('child_category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Thương hiệu</label>
                                        <select class="form-control" name="brand" style="font-size: 14px">
                                            <option value="">Select</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}" {{ $product->brand_id == $brand->id ? 'selected' : '' }} >{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('brand'))
                                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">SKU</label>
                                        <input type="text" name="sku" class="form-control" value="{{$product->sku}}" style="font-size: 14px">
                                        @if($errors->has('sku'))
                                            <span class="text-danger">{{ $errors->first('sku') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Giá mặc định</label>
                                        <input type="text" name="price" class="form-control" value="{{$product->price}}" style="font-size: 14px">
                                        @if($errors->has('price'))
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Giá đề nghị</label>
                                        <input type="text" name="offer_price" class="form-control" value="{{$product->offer_price}}" style="font-size: 14px">
                                        @if($errors->has('offer_price'))
                                            <span class="text-danger">{{ $errors->first('offer_price') }}</span>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="">Ngày bắt đầu khuyến mại</label>
                                                <input type="text" name="offer_start_date" class="form-control datepicker" value="{{$product->offer_start_date}}"
                                                       style="font-size: 14px">
                                                @if($errors->has('offer_start_date'))
                                                    <span class="text-danger">{{ $errors->first('offer_start_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="">Ngày kết thúc khuyến mại</label>
                                                <input type="text" name="offer_end_date" class="form-control datepicker" value="{{$product->offer_end_date}}"
                                                       style="font-size: 14px">
                                                @if($errors->has('offer_end_date'))
                                                    <span class="text-danger">{{ $errors->first('offer_end_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Số lượng trong kho</label>
                                        <input type="number" name="stock_quantity" min="0" class="form-control" value="{{$product->quantity}}" style="font-size: 14px">
                                        @if($errors->has('stock_quantity'))
                                            <span class="text-danger">{{ $errors->first('stock_quantity') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Video Link</label>
                                        <input type="text" name="video_link" class="form-control" value="{{$product->video_link}}" style="font-size: 14px">
                                        @if($errors->has('video_link'))
                                            <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Mô tả ngắn</label>
                                        <textarea name="short_description" id="" class="form-control" style="font-size: 14px">{!! $product->short_description !!} </textarea>
                                        @if($errors->has('short_description'))
                                            <span class="text-danger">{{ $errors->first('short_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Mô tả chi tiết</label>
                                        <textarea name="full_description" id="" class="form-control summernote"
                                                  style="font-size: 14px">{!! $product->full_description !!} </textarea>
                                        @if($errors->has('full_description'))
                                            <span class="text-danger">{{ $errors -> first('full_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Loại sản phẩm</label>
                                        <select class="form-control" name="product_type" style="font-size: 14px">
                                            <option value="">Select</option>
                                            <option value="new_arrival" {{ $product->product_type == 'new_arrival' ? 'selected' : '' }}>New Arrival</option>
                                            <option value="featured" {{ $product->product_type == 'featured' ? 'selected' : '' }}>Featured</option>
                                            <option value="top_product" {{ $product->product_type == 'top_product' ? 'selected' : '' }}>Top Product</option>
                                            <option value="best_product" {{ $product->product_type == 'best_product' ? 'selected' : '' }}>Best Product</option>
                                        </select>
                                        @if($errors->has('is_top'))
                                            <span class="text-danger">{{ $errors->first('is_top') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="">Seo Title</label>
                                        <input type="text" name="seo_title" class="form-control" value="{{$product->seo_title}}" style="font-size: 14px">
                                        @if($errors->has('seo_title'))
                                            <span class="text-danger">{{ $errors->first('seo_title') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Seo Description</label>
                                        <textarea name="seo_description" id="" class="form-control summernote" style="font-size: 14px">{{ $product->seo_description }}</textarea>
                                        @if($errors->has('seo_description'))
                                            <span class="text-danger">{{ $errors->first('seo_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Trạng thái</label>
                                        <select class="form-control" name="status" style="font-size: 14px">
                                            <option value="">Select</option>
                                            <option value="1" {{$product->status == 1 ? 'selected' : ''}}>Kích hoạt</option>
                                            <option value="0" {{$product->status === 0 ? 'selected' : ''}}>Không kích hoạt</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



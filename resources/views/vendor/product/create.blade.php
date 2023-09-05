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
                        <h4 class="mb-2">Create Product</h4>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.products.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="">Image</label>
                                        <input type="file" name="image" class="form-control" value="{{ old('image') }}" style="font-size: 14px">
                                        @if($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}" style="font-size: 14px">
                                    @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="">Category</label>
                                                <select class="form-control category" name="category" style="font-size: 14px">
                                                    <option value="" >Select</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category'))
                                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="">Sub Category</label>
                                                <select class="form-control sub_category" name="sub_category" style="font-size: 14px">
                                                    <option value="" >Select</option>
                                                </select>
                                                @if($errors->has('sub_category'))
                                                    <span class="text-danger">{{ $errors->first('sub_category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="">Child Category</label>
                                                <select class="form-control child_category" name="child_category" style="font-size: 14px">
                                                    <option value="">Select</option>
                                                </select>
                                                @if($errors->has('child_category'))
                                                    <span class="text-danger">{{ $errors->first('child_category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Brand</label>
                                        <select class="form-control" name="brand" style="font-size: 14px">
                                            <option value="" >Select</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}" {{ old('brand') == $brand->id ? 'selected' : '' }} >{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('brand'))
                                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">SKU</label>
                                        <input type="text" name="sku" class="form-control" value="{{old('sku')}}" style="font-size: 14px">
                                        @if($errors->has('sku'))
                                            <span class="text-danger">{{ $errors->first('sku') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control" value="{{old('price')}}" style="font-size: 14px">
                                        @if($errors->has('price'))
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Offer Price</label>
                                        <input type="text" name="offer_price" class="form-control" value="{{old('offer_price')}}" style="font-size: 14px">
                                        @if($errors->has('offer_price'))
                                            <span class="text-danger">{{ $errors->first('offer_price') }}</span>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="">Offer Start Date </label>
                                                <input type="text" name="offer_start_date" class="form-control datepicker" value="{{old('offer_start_date')}}" style="font-size: 14px">
                                                @if($errors->has('offer_start_date'))
                                                    <span class="text-danger">{{ $errors->first('offer_start_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="">Offer End Date</label>
                                                <input type="text" name="offer_end_date" class="form-control datepicker" value="{{old('offer_end_date')}}" style="font-size: 14px">
                                                @if($errors->has('offer_end_date'))
                                                    <span class="text-danger">{{ $errors->first('offer_end_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Stock Quantity</label>
                                        <input type="number" name="stock_quantity" min="0" class="form-control" value="{{old('stock_quantity')}}" style="font-size: 14px">
                                        @if($errors->has('stock_quantity'))
                                            <span class="text-danger">{{ $errors->first('stock_quantity') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Video Link</label>
                                        <input type="text" name="video_link" class="form-control" value="{{old('video_link')}}" style="font-size: 14px">
                                        @if($errors->has('video_link'))
                                            <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Short Description</label>
                                        <textarea name="short_description" id="" class="form-control"  style="font-size: 14px">{{ old('short_description') }}</textarea>
                                        @if($errors->has('short_description'))
                                            <span class="text-danger">{{ $errors->first('short_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Full Description</label>
                                        <textarea name="full_description" id="" class="form-control summernote" style="font-size: 14px">{{ old('full_description') }}</textarea>
                                        @if($errors->has('full_description'))
                                            <span class="text-danger">{{ $errors -> first('full_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Product Type</label>
                                        <select class="form-control" name="product_type" style="font-size: 14px">
                                            <option value="">Select</option>
                                            <option value="new_arrival" {{ old('product_type') == 'new_arrival' ? 'selected' : '' }}>New Arrival</option>
                                            <option value="featured" {{ old('product_type') == 'featured' ? 'selected' : '' }}>Featured</option>
                                            <option value="top_product" {{ old('product_type') == 'top_product' ? 'selected' : '' }}>Top Product</option>
                                            <option value="best_product" {{ old('product_type') == 'best_product' ? 'selected' : '' }}>Best Product</option>
                                        </select>
                                        @if($errors->has('is_top'))
                                            <span class="text-danger">{{ $errors->first('is_top') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="">Seo Title</label>
                                        <input type="text" name="seo_title" class="form-control" value="{{old('seo_title')}}" style="font-size: 14px">
                                        @if($errors->has('seo_title'))
                                            <span class="text-danger">{{ $errors->first('seo_title') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Seo Description</label>
                                        <textarea name="seo_description" id="" class="form-control summernote"  style="font-size: 14px">{{ old('seo_description') }}</textarea>
                                        @if($errors->has('seo_description'))
                                            <span class="text-danger">{{ $errors->first('seo_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Status</label>
                                        <select class="form-control" name="status" style="font-size: 14px">
                                            <option value="" {{old('status') == '' ? 'selected' : ''}}>Select</option>
                                            <option value="1" {{old('status') == 1 ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{old('status') === 0 ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




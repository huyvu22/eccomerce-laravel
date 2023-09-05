@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.products.update',$product)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                    <label for="">Preview</label>
                                    <img src="{{asset($product->thumb_image)}}" width="100" alt="img">
                                </div>
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control" value="{{$product->thumb_image}}">
                                    @if($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$product->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Category</label>
                                            <select class="form-control category" name="category">
                                                <option value="" >Select</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('category'))
                                                <span class="text-danger">{{ $errors->first('category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Sub Category</label>
                                            <select class="form-control sub_category" name="sub_category">
                                                <option value="" >Select</option>
                                                @foreach($subCategories as $subCategory)
                                                    <option value="{{$subCategory->id}}" {{$subCategory->id == $product->subCategory->id ? 'selected':''}}>{{$subCategory->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('sub_category'))
                                                <span class="text-danger">{{ $errors->first('sub_category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Child Category</label>
                                            <select class="form-control child_category" name="child_category">
                                                <option value="">Select</option>
                                                @foreach($childCategories as $childCategory)
                                                <option value="{{$childCategory->id}}" {{$childCategory->id == $product->child_category_id ? 'selected' : ''}} >{{$childCategory->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('child_category'))
                                                <span class="text-danger">{{ $errors->first('child_category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Brand</label>
                                    <select class="form-control" name="brand">
                                        <option value="" >Select</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" {{ $product->brand_id == $brand->id ? 'selected' : '' }} >{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('brand'))
                                        <span class="text-danger">{{ $errors->first('brand') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">SKU</label>
                                    <input type="text" name="sku" class="form-control" value="{{$product->sku}}">
                                    @if($errors->has('sku'))
                                        <span class="text-danger">{{ $errors->first('sku') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" class="form-control" value="{{$product->price}}">
                                    @if($errors->has('price'))
                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Offer Price</label>
                                    <input type="text" name="offer_price" class="form-control" value="{{$product->offer_price}}">
                                    @if($errors->has('offer_price'))
                                        <span class="text-danger">{{ $errors->first('offer_price') }}</span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Offer Start Date </label>
                                            <input type="text" name="offer_start_date" class="form-control datepicker" value="{{$product->offer_start_date}}">
                                            @if($errors->has('offer_start_date'))
                                                <span class="text-danger">{{ $errors->first('offer_start_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Offer End Date</label>
                                            <input type="text" name="offer_end_date" class="form-control datepicker" value="{{$product->offer_end_date}}">
                                            @if($errors->has('offer_end_date'))
                                                <span class="text-danger">{{ $errors->first('offer_end_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" min="0" class="form-control" value="{{$product->quantity}}">
                                    @if($errors->has('stock_quantity'))
                                        <span class="text-danger">{{ $errors->first('stock_quantity') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Video Link</label>
                                    <input type="text" name="video_link" class="form-control" value="{{$product->video_link}}">
                                    @if($errors->has('video_link'))
                                        <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Short Description</label>
                                    <textarea name="short_description" id="" class="form-control" >{!! $product->short_description !!} </textarea>
                                    @if($errors->has('short_description'))
                                        <span class="text-danger">{{ $errors->first('short_description') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Full Description</label>
                                    <textarea name="full_description" id="" class="form-control summernote">{!! $product->full_description !!} </textarea>
                                    @if($errors->has('full_description'))
                                        <span class="text-danger">{{ $errors -> first('full_description') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Product Type</label>
                                    <select class="form-control" name="product_type">
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


                                <div class="form-group">
                                    <label for="">Seo Title</label>
                                    <input type="text" name="seo_title" class="form-control" value="{{$product->seo_title}}">
                                    @if($errors->has('seo_title'))
                                        <span class="text-danger">{{ $errors->first('seo_title') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Seo Description</label>
                                    <textarea name="seo_description" id="" class="form-control summernote">{{ $product->seo_description }}</textarea>
                                    @if($errors->has('seo_description'))
                                        <span class="text-danger">{{ $errors->first('seo_description') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="" >Select</option>
                                        <option value="1" {{$product->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$product->status === 0 ? 'selected' : ''}}>Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


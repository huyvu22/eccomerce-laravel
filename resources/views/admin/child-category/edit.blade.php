@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Child Category</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Child Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.child-category.update',$childCategory)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="">Category</label>

                                    <select class="form-control category" name="category">
                                        <option value="">Select</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$category->id == $childCategory->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>

                                @if($errors->has('category'))
                                        <span class="text-danger">{{$errors->first('category')}}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Sub Category</label>
                                    <select class="form-control sub_category" name="sub_category">
                                        <option value="0">Select</option>
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{$subCategory->id}}" {{$childCategory->sub_category_id == $subCategory->id ? 'selected' : ''}}>{{$subCategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('sub_category'))
                                        <span class="text-danger">{{$errors->first('sub_category')}}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$childCategory->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$childCategory->status==1? 'selected':''}}>Active</option>
                                        <option value="0" {{$childCategory->status==0? 'selected':''}}>Inactive</option>
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



@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Blogs</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Blog</h4>
                        </div>
                        <label for="">Preview Image</label>
                        <div>
                            <img src="{{asset($blog->image)}}" width="150" alt="img">
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.blog.update',$blog)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control" value="{{ $blog->image }}">
                                    @if($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$blog->title}}">
                                    @if($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select class="form-control category" name="category">
                                        <option value="" >Select</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ $blog->category->id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('category'))
                                        <span class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="">Content</label>
                                    <textarea name="content" id="" class="form-control summernote">{!! $blog->content !!}</textarea>
                                    @if($errors->has('content'))
                                        <span class="text-danger">{{ $errors -> first('content') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select</option>
                                        <option value="1" {{$blog->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$blog->status === 0 ? 'selected' : ''}}>Inactive</option>
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



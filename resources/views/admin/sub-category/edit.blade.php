@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Sub Category</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.sub-category.update',$subCategory)}}" method="post" >
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select class="form-control" name="category">
                                        <option value="" >Select</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$category->id == $subCategory->category_id ? 'selected':''}} >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('category'))
                                        <span class="text-danger">{{$errors->first('category')}}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control"  value="{{$subCategory->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$subCategory['status']==1? 'selected':''}}>Active</option>
                                        <option value="0" {{$subCategory['status']==0? 'selected':''}}>Inactive</option>
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



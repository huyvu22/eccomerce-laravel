@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Slider</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.slider.update',$slider)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Preview</label>
                                    <br>
                                <img width="200" src="{{asset($slider->banner)}}" alt="">

                                </div>
                                <div class="form-group">
                                    <label for="">Banner</label>
                                    <input type="file" name="banner" class="form-control" >
                                    @if($errors->has('banner'))
                                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Type</label>
                                    <input type="text" name="type" class="form-control" value="{{$slider->type}}">
                                    @if($errors->has('type'))
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$slider->title}}">
                                    @if($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Starting Price</label>
                                    <input type="text" name="starting_price" class="form-control" value="{{$slider->starting_price}}">
                                    @if($errors->has('starting_price'))
                                        <span class="text-danger">{{ $errors->first('starting_price') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Button Url</label>
                                    <input type="text" name="btn_url" class="form-control" value="{{$slider->btn_url}}">
                                    @if($errors->has('btn_url'))
                                        <span class="text-danger">{{ $errors->first('btn_url') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Serial</label>
                                    <input type="text" name="serial" class="form-control" value="{{$slider->serial}}">
                                    @if($errors->has('serial'))
                                        <span class="text-danger">{{ $errors->first('serial') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$slider->status==1? 'selected':''}}>Active</option>
                                        <option value="0" {{$slider->status==0? 'selected':''}}>Inactive</option>
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



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
                            <h4>Create Slider</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.slider.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
{{--                                <img src="{{asset('u')}}" alt="">--}}
                                <div class="form-group">
                                    <label for="">Banner</label>
                                    <input type="file" name="banner" class="form-control" >
                                    @if($errors->has('banner'))
                                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Type</label>
                                    <input type="text" name="type" class="form-control" value="{{old('type')}}">
                                    @if($errors->has('type'))
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{old('title')}}">
                                    @if($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Starting Price</label>
                                    <input type="text" name="starting_price" class="form-control" value="{{old('starting_price')}}">
                                    @if($errors->has('starting_price'))
                                        <span class="text-danger">{{ $errors->first('starting_price') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Button Url</label>
                                    <input type="text" name="btn_url" class="form-control" value="{{old('btn_url')}}">
                                    @if($errors->has('btn_url'))
                                        <span class="text-danger">{{ $errors->first('btn_url') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Serial</label>
                                    <input type="text" name="serial" class="form-control" value="{{old('serial')}}">
                                    @if($errors->has('serial'))
                                        <span class="text-danger">{{ $errors->first('serial') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                 <select class="form-control" name="status">
                                     <option value="1" {{old('status')==1?? 'selected'}}>Active</option>
                                     <option value="0" {{old('status')==0?? 'selected'}}>Inactive</option>
                                 </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


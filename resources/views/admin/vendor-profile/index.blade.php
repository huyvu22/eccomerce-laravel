@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Vendor Profile</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Vendor Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.vendor-profile.store')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="">Preview</label>
                                    <br>
                                    <img width="200" src="{{asset($profile->banner)}}" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="">Banner</label>
                                    <input type="file" name="banner" class="form-control" >
                                    @if($errors->has('banner'))
                                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Shop name</label>
                                    <input type="text" name="shop_name" class="form-control" value="{{$profile->shop_name}}">
                                    @if($errors->has('shop_name'))
                                        <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{$profile->phone}}">
                                    @if($errors->has('type'))
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{$profile->email}}">
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{$profile->address}}">
                                    @if($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" class="summernote">{{$profile->description}}</textarea>
                                    @if($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Facebook</label>
                                    <input type="text" name="fb_link" class="form-control" value="{{$profile->fb_link}}">
                                    @if($errors->has('fb_link'))
                                        <span class="text-danger">{{ $errors->first('fb_link') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Twitter</label>
                                    <input type="text" name="tw_link" class="form-control" value="{{$profile->tw_link}}">
                                    @if($errors->has('tw_link'))
                                        <span class="text-danger">{{ $errors->first('tw_link') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Instagram</label>
                                    <input type="text" name="insta_link" class="form-control" value="{{$profile->insta_link}}">
                                    @if($errors->has('insta_link'))
                                        <span class="text-danger">{{ $errors->first('insta_link') }}</span>
                                    @endif
                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


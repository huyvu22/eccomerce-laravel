@extends('frontend.dashboard.layouts.master')
@section('title')
    Shop Now
@endsection
@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            {{--Sidebar start--}}
            @include('frontend.dashboard.layouts.sidebar')
            {{--Sidebar end --}}
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content">
                        <h3><i class="fal fa-gift-card"></i> Become a Vendor</h3>
                        <div class="wsus__dashboard_add mb-4">
							{!! $condition->content !!}
                        </div>
                        <div class="wsus__dashboard_add ">
                            <form action="{{route('user.become-vendor.create')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if($errors->has('shop_banner'))
                                    <span class="text-danger">{{ $errors->first('shop_banner') }}</span>
                                @endif
                                <div class="col-xl-6 col-md-6">
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-image" aria-hidden="true"></i>
                                        <input type="file" name="shop_banner" value="{{old('shop_name')}}" placeholder="Shop Banner" >
                                    </div>
                                </div>

                                @if($errors->has('shop_name'))
                                    <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                @endif
                                <div class="wsus__dash_pro_single">
                                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                                    <input type="text" name="shop_name" value="{{old('shop_name')}}" placeholder="Shop Name">
                                </div>


                                <div class="row">
                                    @if($errors->has('shop_mail'))
                                        <span class="text-danger">{{ $errors->first('shop_mail') }}</span>
                                    @endif
                                   <div class="col-xl-6 col-md-6">
                                       <div class="wsus__dash_pro_single">
                                           <i class="fal fa-envelope-open" aria-hidden="true"></i>
                                           <input type="text" name="shop_mail" value="{{old('shop_mail')}}" placeholder="Shop Mail">
                                       </div>
                                   </div>

                                    @if($errors->has('shop_phone'))
                                        <span class="text-danger">{{ $errors->first('shop_phone') }}</span>
                                    @endif
                                   <div class="col-xl-6 col-md-6">
                                       <div class="wsus__dash_pro_single">
                                           <i class="fas fa-phone" aria-hidden="true"></i>
                                           <input type="text" name="shop_phone" value="{{old('shop_phone')}}" placeholder="Shop phone">
                                       </div>
                                   </div>
                                </div>

                                @if($errors->has('shop_address'))
                                    <span class="text-danger">{{ $errors->first('shop_address') }}</span>
                                @endif
                                <div class="wsus__dash_pro_single">
                                    <i class="fal fa-map-marker-alt" aria-hidden="true"></i>
                                    <input type="text" name="shop_address" value="{{old('shop_address')}}" placeholder="Shop Address">
                                </div>

                                @if($errors->has('shop_about'))
                                    <span class="text-danger">{{ $errors->first('shop_about') }}</span>
                                @endif
                                <div class="wsus__dash_pro_single">
                                    <textarea id="" name="shop_about" placeholder="About Your Shop">{{old('shop_about')}}</textarea>
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection



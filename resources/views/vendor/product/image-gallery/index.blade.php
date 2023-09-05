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
                    <div class="mb-3">
                        <button class="btn btn-success" onclick="history.back()" style="font-size: 14px"><i class="fas fa-arrow-left"></i> Back</button>
                    </div>
                    <h4>Product Image Gallery</h4>
                    <h6 class="mb-3">Product name: {{$product->name}}</h6>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.products-image-gallery.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="" class="mb-2">Upload Multiple Images</label>
                                        <input type="file" name="image[]" class="form-control" multiple style="font-size: 14px">
                                        <input type="hidden" name="product" value="{{$product->id}}">
                                        @if($errors->any())
                                            @foreach($errors->all() as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button class="btn btn-primary mt-3" style="font-size: 14px">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <h6 class="mt-3 mb-2">All Images</h6>
                    <div class="dashboard_content mt-md-0">
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush



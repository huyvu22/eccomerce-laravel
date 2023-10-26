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
                        <div class="mb-3">
                            <a class="btn btn-success" onclick="history.back()" href="#" style="font-size: 14px"><i class="fas fa-arrow-left"></i> Quay lại</a>
                        </div>
                        <h4 class="mb-3">Tạo thuộc tính</h4>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.products-variant.store')}}" method="post">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="">Tên</label>
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}" style="font-size: 14px">
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="product" class="form-control" value="{{request()->product}}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="">Trạng thái</label>
                                        <select class="form-control" name="status" style="font-size: 14px">
                                            <option value="1">Kích hoạt</option>
                                            <option value="0">Không kích hoạt</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="font-size: 14px">Tạo</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection





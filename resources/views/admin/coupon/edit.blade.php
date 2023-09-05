@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Coupon</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.coupon.update',$coupon)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$coupon->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Code</label>
                                    <input type="text" name="code" class="form-control" value="{{$coupon->code}}">
                                    @if($errors->has('code'))
                                        <span class="text-danger">{{ $errors->first('code') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="text" name="quantity" class="form-control" value="{{$coupon->quantity}}">
                                    @if($errors->has('quantity'))
                                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Max Use Per Person</label>
                                    <input type="text" name="max_use" class="form-control" value="{{$coupon->max_use}}">
                                    @if($errors->has('max_use'))
                                        <span class="text-danger">{{ $errors->first('max_use') }}</span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input type="text" name="start_date" class="form-control datepicker" value="{{$coupon->start_date}}">
                                            @if($errors->has('start_date'))
                                                <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">End Date</label>
                                            <input type="text" name="end_date" class="form-control datepicker" value="{{$coupon->end_date}}">
                                            @if($errors->has('end_date'))
                                                <span class="text-end_date">{{ $errors->first('end_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Discount Type</label>
                                            <select class="form-control" name="discount_type">
                                                <option value="percent" {{$coupon->discount_type == 'percent' ? 'selected' :''}} >Percentage (%)</option>
                                                <option value="amount" {{$coupon->discount_type == 'amount' ? 'selected' :''}} >Amount (₫)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Discount Value</label>
                                            <input type="text" name="discount_value" class="form-control" value="{{$coupon->discount_value}}">
                                            @if($errors->has('discount_value'))
                                                <span class="text-danger">{{ $errors->first('discount_value') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$coupon->status == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$coupon->status == 0 ? 'selected' : ''}}>Inactive</option>
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




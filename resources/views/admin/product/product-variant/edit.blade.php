@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product Variant</h1>
        </div>

        <div class="mb-3" >
            <button onclick="history.back()" class="btn btn-info" style="font-size: 14px">Back</button>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product Variant</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.products-variant.update',$products_variant)}}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$products_variant->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
{{--                                <input type="hidden" name="product" value="$products_variant">--}}

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$products_variant->status==1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$products_variant->status==0 ? 'selected' : ''}}>Inactive</option>
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





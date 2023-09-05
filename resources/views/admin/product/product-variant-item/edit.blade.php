@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product Variant Items</h1>
        </div>

        <div class="mb-3" >
            <button onclick="history.back()" class="btn btn-info">Back</button>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product Variant Items</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.products-variant-item.update',$variantItem)}}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Variant Name</label>
                                    <input type="text" name="variant_name" class="form-control" value="{{$variantItem->variant->name}}" readonly>
                                    @if($errors->has('variant_name'))
                                        <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Item Name</label>
                                    <input type="text" name="item_name" class="form-control" value="{{$variantItem->name}}">
                                    @if($errors->has('item_name'))
                                        <span class="text-danger">{{ $errors->first('item_name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" class="form-control" value="{{$variantItem->price}}">
                                    @if($errors->has('price'))
                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Is Default</label>
                                    <select class="form-control" name="is_default">
                                        <option value="" >Select</option>
                                        <option value="1" {{$variantItem->is_default == 1 ? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{$variantItem->is_default == 0 ?  'selected': ''}}>No</option>
                                    </select>
                                    @if($errors->has('is_default'))
                                        <span class="text-danger">{{ $errors->first('is_default') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$variantItem->status == 1 ? 'selected' : ''}} >Active</option>
                                        <option value="0" {{$variantItem->status == 0 ? 'selected' : ''}} >Inactive</option>
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






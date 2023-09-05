@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Flash Sale</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Flash Sale Date</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.flash-sale.update')}}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <input type="text" name="end_date" class="form-control datepicker" value="{{@$flashSaleDate->end_date}}">
                                    @if($errors->has('end_date'))
                                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                    @endif
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Flash Sale Products</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.flash-sale.add-product')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="" >Add Product</label>
                                    <select name="product" class="form-control select2">
                                        <option value="">Select</option>
                                        @if($products->count()>0)
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('product'))
                                        <span class="text-danger">{{ $errors->first('product') }}</span>
                                    @endif
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="">Show product at homepage</label>
                                        <select name="show_at_home" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @if($errors->has('show_at_home'))
                                            <span class="text-danger">{{ $errors->first('show_at_home') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @if($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Flash Sale Products</h4>
                        </div>
                        <div class="card-body data-table">
                            {{ $dataTable->table() }}
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



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
                        <div class="m-3">
                            <h6>Product: <b>{{$product->name}}</b></h6>
                            <h6>Variant: <b>{{$variant->name}}</b></h6>
                        </div>
                        <div class="card-header">
                            <div class="carr-header-action">
                                <a href="{{ route('admin.products-variant-item.create',['productId'=>$product->id,'variantId'=>$variant->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Variant Item
                                </a>
                            </div>

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


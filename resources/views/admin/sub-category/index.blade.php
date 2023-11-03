@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Withdraw Method</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Withdraw Method</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="carr-header-action">
                                <a href="{{route('admin.sub-category.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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


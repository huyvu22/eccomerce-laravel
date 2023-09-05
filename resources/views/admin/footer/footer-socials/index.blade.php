@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                        	<h4>Footer Socials</h4>
                        </div>
                        <div class="carr-header-action ml-4" >
                            <a href="{{route('admin.footer-socials.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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

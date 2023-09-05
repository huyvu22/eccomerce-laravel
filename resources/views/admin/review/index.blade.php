@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product Reviews</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">All Review</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Reviews</h4>
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

    <script>
        window.addEventListener('DOMContentLoaded',(e)=>{
            document.querySelector('.data-table').addEventListener('change', async (e) => {
                if (e.target.classList.contains('is_approved_review')) {
                    e.preventDefault();
                    const productId = e.target.dataset.productId;
                    const selectedValue = e.target.value;
                    const endpoint = `./review/update-approved/${productId}/${selectedValue}`;
                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if(data.status==200){
                        // toastr.success(data.message);
                        window.location.reload();
                    }
                }
            });
        })
    </script>
@endpush

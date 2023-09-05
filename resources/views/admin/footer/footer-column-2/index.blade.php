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
                            <h4>Footer Column 2 Title</h4>
                        </div>
                        <div class="m-4">
                            <div class="col-md-4">
                                <form action="{{route('admin.footer-column-2.change-title')}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group d-flex">
                                        <input type="text" name="title" class="form-control" value="{{$footerTitle->footer_column_2_title}}">

                                        <button class="btn btn-primary ml-3" type="submit">Save</button>
                                    </div>
                                    @if($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="card-header d-flex">
                            <h4>Footer Column 2</h4>
                        </div>
                        <div class="card-header-action ml-4" >
                            <a href="{{route('admin.footer-column-2.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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


@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Setting</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active" id="banner-1-list" data-toggle="list" href="#banner-1" role="tab">Homepage banner
                                            section 1</a>
                                        <a class="list-group-item list-group-item-action" id="banner-2-list" data-toggle="list" href="#banner-2" role="tab">Homepage banner
                                            section 2</a>
                                        <a class="list-group-item list-group-item-action" id="banner-3-list" data-toggle="list" href="#banner-3" role="tab">Homepage
                                            banner section 3</a>
                                        <a class="list-group-item list-group-item-action" id="banner-4-list" data-toggle="list" href="#banner-4" role="tab">Homepage
                                            banner section 4</a>
                                        <a class="list-group-item list-group-item-action" id="banner-5-list" data-toggle="list" href="#banner-5" role="tab">Products Page Banner</a>
                                        <a class="list-group-item list-group-item-action" id="banner-6-list" data-toggle="list" href="#banner-6" role="tab">Cart Page Banner</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">

                                        @include('admin.advertisement.homepage-banner-1')

                                        @include('admin.advertisement.homepage-banner-2')

                                        @include('admin.advertisement.homepage-banner-3')

                                        @include('admin.advertisement.homepage-banner-4')

                                        @include('admin.advertisement.product-page-banner')

                                        @include('admin.advertisement.cart-page-banner')

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

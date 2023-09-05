
@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Show Pending Request</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Show pending requests</div>
            </div>
        </div>

        <div class="section-body">
            <label for="">Preview Banner</label>
            <div class="form-group">
                <img src="{{asset($vendor->banner)}}" width="200" alt="img">
            </div>

            <table class="table table-striped table-hover table-md">
                <tr>
                    <td>User Name: </td>
                    <td>{{$vendor->user->name}}</td>
                </tr>
                <tr>
                    <td>User Email: </td>
                    <td>{{$vendor->user->email}}</td>
                </tr>
                <tr>
                    <td>Shop Name: </td>
                    <td>{{$vendor->shop_name}}</td>
                </tr>
                <tr>
                    <td>Shop Email: </td>
                    <td>{{$vendor->email}}</td>
                </tr>
                <tr>
                    <td>Shop Phone: </td>
                    <td>{{$vendor->phone}}</td>
                </tr>
                <tr>
                    <td> Shop Address: </td>
                    <td>{{$vendor->address}}</td>
                </tr>
                <tr>
                    <td> Description: </td>
                    <td>{{$vendor->description}}</td>
                </tr>

            </table>

            <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Action</label>
                        <select name="payment_status" data-id="{{$vendor->id}}" class="form-control pending_status">
                            <option {{$vendor->status == '0' ? 'selected' : ''}}  value="0">Pending</option>
                            <option {{$vendor->status == '1' ? 'selected' : ''}} value="1">Approve</option>
                        </select>
                    </div>

            </div>


        </div>
    </section>
@endsection
@push('scripts')
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            document.querySelector('.pending_status').addEventListener('change', async (e) => {
                let status = e.target.value;
                let id = e.target.dataset.id;
                const res = await fetch(`../change-status/${id}/${status}`);
                const data = await res.json();
                if(data['status']){
                    toastr.success(data.message);
                }
            })

        });
    </script>
@endpush




@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Withdraw Detail</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Withdraw Detail</div>
            </div>
        </div>

        <div class="section-body">
            <table class="table table-striped table-hover table-md">
                <tr>
                    <td>Method:</td>
                    <td>{{$withdrawRequest->method}}</td>
                </tr>

                <tr>
                    <td><b>Withdraw charge</b></td>
                    <td>{{($withdrawRequest->withdraw_charge) / ($withdrawRequest->total_amount) *100 }}%</td>
                </tr>
                <tr>
                    <td><b>Total Amount </b></td>
                    <td>{{format($withdrawRequest->total_amount)}}</td>
                </tr>
                <tr>
                    <td><b>Withdraw charge amount</b></td>
                    <td>{{format($withdrawRequest->withdraw_charge)}}</td>
                </tr>
                <tr>
                    <td><b>Withdraw Amount</b></td>
                    <td>{{format($withdrawRequest->withdraw_amount)}}</td>
                </tr>
                <tr>
                    <td><b>Account Info</b></td>
                    <td>{!! nl2br(str_replace('-', '<br>', e($withdrawRequest->account_info))) !!}</td>

                </tr>
            </table>

            <div class="col-md-3">
                <div class="form-group">
                    <form action="" method="post">
                        <label for="">Update Status</label>
                        <select name="status" data-id="{{$withdrawRequest->id}}" class="form-control withdraw_status">
                            <option @selected($withdrawRequest->status == 'pending') value="pending">Pending</option>
                            <option @selected($withdrawRequest->status == 'paid')  value="paid">Paid</option>
                            <option @selected($withdrawRequest->status == 'declined')  value="decline">Declined</option>
                        </select>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            document.querySelector('.withdraw_status').addEventListener('change', async (e) => {
                let status = e.target.value;
                let id = e.target.dataset.id;
                const res = await fetch(`../withdraw-list/${id}/${status}`);
                const data = await res.json();
                if (res.ok) {
                    toastr.success(data.message);
                }
            })

        });
    </script>
@endpush





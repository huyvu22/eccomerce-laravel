@extends('vendor.layouts.master')
@section('title')
    Shop Now - Withdraw
@endsection
@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            {{--Sidebar start--}}
            @include('vendor.layouts.sidebar')
            {{--Sidebar end --}}

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h4 class="mb-2">Tạo yêu cầu rút tiền</h4>

                        <div class="wsus__dashboard_profile">
                            <div class="row">
                                <div class="wsus__dash_pro_area col-md-7">
                                    <div class="form-group mb-3">
                                        <h5>Số dư hiện tại: {{format($totalBalance)}}</h5>
                                    </div>
                                    <form action="{{route('vendor.withdraw.store')}}" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <select name="method" class="form-control" id="method" style="font-size: 14px">
                                                <option value="">Chọn</option>
                                                @foreach($methods as $method)
                                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('method'))
                                                <span class="text-danger">{{ $errors->first('method') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Số tiền rút</label>
                                            <input type="text" name="withdraw_amount" class="form-control" value="{{old('withdraw_amount')}}" style="font-size: 14px">
                                            @if($errors->has('withdraw_amount'))
                                                <span class="text-danger">{{ $errors->first('withdraw_amount') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Thông tin chuyển khoản</label>
                                            <textarea type="text" name="account_info" class="form-control" value="{{old('account_info')}}" style="font-size: 14px"></textarea>
                                            @if($errors->has('account_info'))
                                                <span class="text-danger">{{ $errors->first('account_info') }}</span>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi</button>
                                    </form>
                                </div>

                                <div class="wsus__dash_pro_area col-md-5 method_info">

                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.method_info').hide();
            const formatPrice = (price) => {
                return parseInt(price).toLocaleString('en').replace(/,/g, '.') + '₫';
            }
            $('#method').on('change', function (e) {
                let id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{route('vendor.withdraw.show', ':id')}}".replace(':id', id),
                    success: function (response) {
                        if (response.id) {
                            $('.method_info').html(
                                `
                            <h4>Tiền rút tối đa trong khoảng: ${formatPrice(response.minimum_amount)} - ${formatPrice(response.maximum_amount)}</h4>
                            <h4>Phí: ${response.withdraw_charge}%</h4>
                            <p>${response.description}</p>
                        `
                            ).show();
                        } else {
                            $('.method_info').hide(); // Hide the element
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            });
        });


    </script>
@endpush




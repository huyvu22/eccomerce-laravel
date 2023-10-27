<div class="tab-pane fade" id="list-vnpay" role="tabpanel" aria-labelledby="list-vnpay-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.vnpay-setting.update',1)}}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="">VnPay Status</label>
                    <select name="status" id="" class="form-control">
                        <option value="1" {{@$vnPaySetting->status == 1 ? 'selected' : ''}}>Enable</option>
                        <option value="0" {{@$vnPaySetting->status == 0 ? 'selected' : ''}}>Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Account Mode</label>
                    <select name="mode" id="" class="form-control">
                        <option value="0" {{@$vnPaySetting->mode == 0 ? 'selected' : ''}}>Sandbox</option>
                        <option value="1" {{@$vnPaySetting->mode == 1 ? 'selected' : ''}}>Live</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Country</label>
                    <select name="country" id="" class="form-control">
                        <option value="vietnam">Viet Nam</option>
                        <option value="usa">USA</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency Name</label>
                    <select name="currency_name" id="" class="form-control">
                        <option value="vnd">Viet Nam Dong</option>
                        <option value="USD">USD</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency rate (VND)</label>
                    <input type="text" name="currency_rate" class="form-control" value="{{@$usdExchangeRates['VND']}}">
                    @if($errors->has('currency_rate'))
                        <span class="text-danger">{{ $errors->first('currency_rate') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Vnpay Client Id</label>
                    <input type="text" name="client_id" class="form-control" value="{{@$vnPaySetting->client_id}}">
                    @if($errors->has('client_id'))
                        <span class="text-danger">{{ $errors->first('client_id') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Vnpay Secret Key</label>
                    <input type="text" name="secret_key" class="form-control" value="{{@$vnPaySetting->secret_key}}">
                    @if($errors->has('secret_key'))
                        <span class="text-danger">{{ $errors->first('secret_key') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.paypal-setting.update',1)}}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="">Paypal Status</label>
                    <select name="status" id="" class="form-control">
                        <option value="1" {{$paypalSetting->status == 1 ? 'selected' : ''}}>Enable</option>
                        <option value="0" {{$paypalSetting->status == 0 ? 'selected' : ''}}>Disable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Account Mode</label>
                    <select name="mode" id="" class="form-control">
                        <option value="0" {{$paypalSetting->mode == 0 ? 'selected' : ''}}>Sandbox</option>
                        <option value="1" {{$paypalSetting->mode == 1 ? 'selected' : ''}}>Live</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Country</label>
                    <select name="country" id="" class="form-control">
                        <option value="vietnam">Viet Nam</option>
                        <option value="thailand">Thai Lan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency Name</label>
                    <select name="currency_name" id="" class="form-control">
                        <option value="vnd">Viet Nam Dong</option>
                        <option value="THB">Thai baht</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Currency rate (USD)</label>
                    <input type="text" name="currency_rate" class="form-control" value="{{$paypalSetting->currency_rate}}">
                    @if($errors->has('currency_rate'))
                        <span class="text-danger">{{ $errors->first('currency_rate') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Paypal Client Id</label>
                    <input type="text" name="client_id" class="form-control" value="{{$paypalSetting->client_id}}">
                    @if($errors->has('client_id'))
                        <span class="text-danger">{{ $errors->first('client_id') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Paypal Secret Key</label>
                    <input type="text" name="secret_key" class="form-control" value="{{$paypalSetting->client_id}}">
                    @if($errors->has('secret_key'))
                        <span class="text-danger">{{ $errors->first('secret_key') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

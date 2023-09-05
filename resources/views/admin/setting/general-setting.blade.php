<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="">
                <div class="form-group">
                    <label for="">Site Name</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
{{--                <div class="form-group">--}}
{{--                    <label for="">Layout</label>--}}
{{--                    <select name="layout" id="" class="form-control">--}}
{{--                        <option value="LTR">LTR</option>--}}
{{--                        <option value="RTL">RTL</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
                <div class="form-group">
                    <label for="">Contact Email</label>
                    <input type="text" name="contact_email" class="form-control" value="{{old('contact_email')}}">
                    @if($errors->has('contact_email'))
                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Contact Phone</label>
                    <input type="text" name="contact_email" class="form-control" value="{{old('contact_email')}}">
                    @if($errors->has('contact_phone'))
                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Contact Address</label>
                    <input type="text" name="contact_email" class="form-control" value="{{old('contact_email')}}">
                    @if($errors->has('contact_address'))
                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Map</label>
                    <input type="text" name="map" class="form-control" value="{{old('map')}}">
                    @if($errors->has('map'))
                        <span class="text-danger">{{ $errors->first('map') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Default Currency Name</label>
                    <select name="currency_name" id="" class="form-control">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Currency Icon</label>
                    <input type="text" name="currency_icon" class="form-control" value="{{old('contact_email')}}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

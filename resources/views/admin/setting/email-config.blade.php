<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.email-setting-update')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" value="{{$emailSettings->email}}">
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Mail Host </label>
                    <input type="text" class="form-control" name="host" value="{{$emailSettings->host}}">
                    @if($errors->has('host'))
                        <span class="text-danger">{{ $errors->first('host') }}</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Smtp username</label>
                            <input type="text" class="form-control" name="username" value="{{$emailSettings->username}}">
                            @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Smtp password</label>
                            <input type="text" class="form-control" name="password" value="{{$emailSettings->password}}">
                            @if($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail port</label>
                            <input type="text" class="form-control" name="port" value="{{$emailSettings->host}}">
                            @if($errors->has('port'))
                                <span class="text-danger">{{ $errors->first('port') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" >Mail Encryption</label>
                            <select name="encryption" id="" class="form-control">
                                <option value="tls" {{$emailSettings->encryption == 'tls' ? 'selected' : ''}}>TLS</option>
                                <option value="ssl" {{$emailSettings->encryption == 'ssl' ? 'selected' : ''}}>SSL</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

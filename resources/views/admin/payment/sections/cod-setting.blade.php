<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.cod-settings.update',1)}}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="">COD Status</label>
                    <select name="status" id="" class="form-control">
                        <option value="1" {{@$codSetting->status == 1 ? 'selected' : ''}}>Enable</option>
                        <option value="0" {{@$codSetting->status == 0 ? 'selected' : ''}}>Disable</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

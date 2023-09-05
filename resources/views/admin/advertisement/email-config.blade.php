<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.email-setting-update')}}" method="post">
                @csrf



                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

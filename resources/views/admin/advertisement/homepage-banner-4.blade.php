@php
    $homepageBannerSection4 = json_decode($homepageBannerSection4?->value)->banner_1;
@endphp
<div class="tab-pane fade " id="banner-4" role="tabpanel" aria-labelledby="banner-4-list">
    <div class="card border">
        <div class="card-body">
            <div class="form-group">
                <label for="">Preview</label>
                <br>
                <img src="{{asset(@$homepageBannerSection4->banner_image)}}" width="250px" alt="banner 1">
            </div>
            <form action="{{route('admin.homepage-banner-section-4')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Status</label>
                    <br>
                    <label class="custom-switch switch-status mt-2" style="cursor: pointer">
                        <input type="checkbox" name="status" class="form-control custom-switch-input" {{@$homepageBannerSection4->status == 1 ? 'checked' : ''}}>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_image" class="form-control" value="{{old('banner_image')}}">
                    @if($errors->has('banner_image'))
                        <span class="text-danger">{{ $errors->first('banner_image') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Banner Url</label>
                    <input type="text" name="banner_url" class="form-control" value="{{@$homepageBannerSection4->banner_url}}">
                    @if($errors->has('banner_url'))
                        <span class="text-danger">{{ $errors->first('banner_url') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

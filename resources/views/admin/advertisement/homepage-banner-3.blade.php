@php
    $homepageBannerSection3 = json_decode($homepageBannerSection3?->value)
@endphp
<div class="tab-pane fade" id="banner-3" role="tabpanel" aria-labelledby="banner-3-list">
    <div class="card border">

        <div class="card-body">
            <form action="{{route('admin.homepage-banner-section-3')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="">
                    <h4>Banner 1</h4>
                    <div class="form-group">
                        <label for="">Preview</label>
                        <br>
                        <img src="{{asset(@$homepageBannerSection3->banner_1->banner_image)}}" width="250px" alt="banner 1">
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <br>
                        <label class="custom-switch switch-status mt-2" style="cursor: pointer">
                            <input type="checkbox" name="banner_1_status" class="custom-switch-input" {{@$homepageBannerSection3->banner_1->banner_status == 1 ? 'checked' : ''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="">Banner Image</label>
                        <input type="file" name="banner_1_image" class="form-control" value="{{old('banner_1_image')}}">
                        @if($errors->has('banner_1_image'))
                            <span class="text-danger">{{ $errors->first('banner_1_image') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Banner Url</label>
                        <input type="text" name="banner_1_url" class="form-control" value="{{@$homepageBannerSection3->banner_1->banner_url}}" >
                        @if($errors->has('banner_1_url'))
                            <span class="text-danger">{{ $errors->first('banner_1_url') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Banner 2</h4>
                        <div class="form-group">
                            <label for="">Preview</label>
                            <br>
                            <img src="{{asset(@$homepageBannerSection3->banner_2->banner_image)}}" width="250px" alt="banner 1">
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <br>
                            <label class="custom-switch switch-status mt-2" style="cursor: pointer">
                                <input  type="checkbox" name="banner_2_status" class="custom-switch-input form-control" {{@$homepageBannerSection3->banner_2->banner_status == 1 ? 'checked' : ''}}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">Banner Image</label>
                            <input type="file" name="banner_2_image" class="form-control" value="{{old('banner_2_image')}}">
                            @if($errors->has('banner_2_image'))
                                <span class="text-danger">{{ $errors->first('banner_2_image') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Banner Url</label>
                            <input type="text" name="banner_2_url" class="form-control" value="{{@$homepageBannerSection3->banner_2->banner_url}}" >
                            @if($errors->has('banner_2_url'))
                                <span class="text-danger">{{ $errors->first('banner_2_url') }}</span>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h4>Banner 3</h4>
                        <div class="form-group">
                            <label for="">Preview</label>
                            <br>
                            <img src="{{asset(@$homepageBannerSection3->banner_3->banner_image)}}" width="250px" alt="banner 1">
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <br>
                            <label class="custom-switch switch-status mt-2" style="cursor: pointer">
                                <input type="checkbox" name="banner_3_status" class="custom-switch-input" {{@$homepageBannerSection3->banner_3->banner_status == 1 ? 'checked' : ''}}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">Banner Image</label>
                            <input type="file" name="banner_3_image" class="form-control" value="{{old('banner_3_image')}}">
                            @if($errors->has('banner_3_image'))
                                <span class="text-danger">{{ $errors->first('banner_2_image') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Banner Url</label>
                            <input type="text" name="banner_3_url" class="form-control" value="{{@$homepageBannerSection3->banner_3->banner_url}}" >
                            @if($errors->has('banner_3_url'))
                                <span class="text-danger">{{ $errors->first('banner_3_url') }}</span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">Update</button>

                </div>
            </form>

        </div>
    </div>
</div>

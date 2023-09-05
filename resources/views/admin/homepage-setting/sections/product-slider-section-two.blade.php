@php
    use App\Models\ChildCategory;use App\Models\SubCategory;
    $productSliderSectionTwo = json_decode($productSliderSectionTwo->value,true);
    $subCategorySection = SubCategory::where('category_id',$productSliderSectionTwo['category'])->get();
    $childCategorySection = ChildCategory::where('sub_category_id',$productSliderSectionTwo['sub_category'])->get();

@endphp
<div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.product-sliders-section-two')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category" id="" class="form-control category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $productSliderSectionTwo['category'] ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Sub Category</label>
                            <select name="sub_category" id="" class="form-control sub_category">
                                <option value="">Select</option>
                                @foreach($subCategorySection as $subCategory)
                                    <option
                                        value="{{$subCategory->id}}" {{$subCategory->id == $productSliderSectionTwo['sub_category'] ? 'selected' : ''}}>{{$subCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Child Category</label>
                            <select name="child_category" id="" class="form-control child_category">
                                <option value="">Select</option>
                                @foreach($childCategorySection as $childCategory)
                                    <option
                                        value="{{$childCategory->id}}" {{$childCategory->id == $productSliderSectionTwo['child_category'] ? 'selected' : ''}}>{{$childCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>






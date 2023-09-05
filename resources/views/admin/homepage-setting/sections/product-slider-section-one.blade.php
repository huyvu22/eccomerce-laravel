@php
    use App\Models\ChildCategory;use App\Models\SubCategory;
    $productSliderSectionOne = json_decode($productSliderSectionOne->value,true);
    $subCategorySection = SubCategory::where('category_id',$productSliderSectionOne['category'])->get();
    $childCategorySection = ChildCategory::where('sub_category_id',$productSliderSectionOne['sub_category'])->get();

@endphp
<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.product-sliders-section-one')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category" id="" class="form-control category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $productSliderSectionOne['category'] ? 'selected' : ''}}>{{$category->name}}</option>

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
                                        value="{{$subCategory->id}}" {{$subCategory->id == $productSliderSectionOne['sub_category'] ? 'selected' : ''}}>{{$subCategory->name}}</option>
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
                                        value="{{$childCategory->id}}" {{$childCategory->id == $productSliderSectionOne['child_category'] ? 'selected' : ''}}>{{$childCategory->name}}</option>
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

@push('scripts')
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            const categorySelects = document.querySelectorAll('.category');
            const subCategorySelects = document.querySelectorAll('.sub_category');

            if (categorySelects.length) {
                categorySelects.forEach(categorySelect => {
                    categorySelect.addEventListener('change', async (e) => {
                        const categoryId = e.target.value;
                        const subCategorySelect = e.target.parentNode.parentNode.nextElementSibling.querySelector('.sub_category');
                        const childCategorySelect = subCategorySelect.parentNode.parentNode.nextElementSibling.querySelector('.child_category');

                        if (categoryId > 0) {
                            const endpoint = `./homepage-settings/get-sub-category/${categoryId}`;
                            const res = await fetch(endpoint);
                            const data = await res.json();
                            if (data.status === 'success') {
                                let option = '<option value="0">Select</option>\n';
                                let {subCategories} = data;
                                if (subCategories.length) {
                                    subCategories.forEach(({id, name}) => {
                                        option += `<option value="${id}">${name}</option>\n`;
                                    });
                                }
                                subCategorySelect.innerHTML = option;
                            }
                            childCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                        } else {
                            subCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                            childCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                        }
                    })
                })

            }

            if (subCategorySelects.length) {
                subCategorySelects.forEach(subCategorySelect => {
                    subCategorySelect.addEventListener('change', async (e) => {
                        const subCategoryId = e.target.value;
                        const childCategorySelect = e.target.parentNode.parentNode.nextElementSibling.querySelector('.child_category');

                        if (subCategoryId > 0) {
                            const endpoint = `./homepage-settings/get-child-category/${subCategoryId}`;
                            const res = await fetch(endpoint);
                            const data = await res.json();
                            if (data.status === 'success') {
                                let option = '<option value="0">Select</option>\n';
                                let {childCategories} = data;
                                if (childCategories.length) {
                                    childCategories.forEach(({id, name}) => {
                                        option += `<option value="${id}">${name}</option>\n`;
                                    });
                                }
                                childCategorySelect.innerHTML = option;
                            }
                        }
                    })
                })

            }
        });
    </script>
@endpush

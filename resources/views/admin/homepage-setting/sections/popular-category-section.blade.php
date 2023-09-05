@php
    use App\Models\ChildCategory;use App\Models\SubCategory;
    $popularCategorySection = json_decode($popularCategorySection->value,true);
    $subCategorySection1 = SubCategory::where('category_id',$popularCategorySection[0]['category'])->get();
    $childCategorySection1 = ChildCategory::where('sub_category_id',$popularCategorySection[0]['sub_category'])->get();

    $subCategorySection2 = SubCategory::where('category_id',$popularCategorySection[1]['category'])->get();
    $childCategorySection2 = ChildCategory::where('sub_category_id',$popularCategorySection[1]['sub_category'])->get();

    $subCategorySection3 = SubCategory::where('category_id',$popularCategorySection[2]['category'])->get();
    $childCategorySection3 = ChildCategory::where('sub_category_id',$popularCategorySection[2]['sub_category'])->get();

    $subCategorySection4 = SubCategory::where('category_id',$popularCategorySection[3]['category'])->get();
    $childCategorySection4 = ChildCategory::where('sub_category_id',$popularCategorySection[3]['sub_category'])->get();

@endphp
<div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.popular-category-section')}}" method="post">
                @csrf
                <h6>Category 1</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_1" id="" class="form-control category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $popularCategorySection[0]['category'] ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Sub Category</label>
                            <select name="sub_category_1" id="" class="form-control sub_category">
                                <option value="">Select</option>
                                @foreach($subCategorySection1 as $subCategory)
                                    <option
                                        value="{{$subCategory->id}}" {{$subCategory->id == $popularCategorySection[0]['sub_category'] ? 'selected' : ''}}>{{$subCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Child Category</label>
                            <select name="child_category_1" id="" class="form-control child_category">
                                <option value="">Select</option>
                                @foreach($childCategorySection1 as $childCategory)
                                    <option
                                        value="{{$childCategory->id}}" {{$childCategory->id == $popularCategorySection[0]['child_category'] ? 'selected' : ''}}>{{$childCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h6>Category 2</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_2" id="" class="form-control category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $popularCategorySection[1]['category'] ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Sub Category</label>
                            <select name="sub_category_2" id="" class="form-control sub_category">
                                <option value="">Select</option>
                                @foreach($subCategorySection2 as $subCategory)
                                    <option
                                        value="{{$subCategory->id}}" {{$subCategory->id == $popularCategorySection[1]['sub_category'] ? 'selected' : ''}}>{{$subCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Child Category</label>
                            <select name="child_category_2" id="" class="form-control child_category">
                                <option value="">Select</option>
                                @foreach($childCategorySection2 as $childCategory)
                                    <option
                                        value="{{$childCategory->id}}" {{$childCategory->id == $popularCategorySection[1]['child_category'] ? 'selected' : ''}}>{{$childCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h6>Category 3</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_3" id="" class="form-control category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $popularCategorySection[2]['category'] ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Sub Category</label>
                            <select name="sub_category_3" id="" class="form-control sub_category">
                                <option value="">Select</option>
                                @foreach($subCategorySection3 as $subCategory)
                                    <option
                                        value="{{$subCategory->id}}" {{$subCategory->id == $popularCategorySection[2]['sub_category'] ? 'selected' : ''}}>{{$subCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Child Category</label>
                            <select name="child_category_3" id="" class="form-control child_category">
                                <option value="">Select</option>
                                @foreach($childCategorySection3 as $childCategory)
                                    <option
                                        value="{{$childCategory->id}}" {{$childCategory->id == $popularCategorySection[2]['child_category'] ? 'selected' : ''}}>{{$childCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h6>Category 4</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_4" id="" class="form-control category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$category->id == $popularCategorySection[3]['category'] ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Sub Category</label>
                            <select name="sub_category_4" id="" class="form-control sub_category">
                                <option value="">Select</option>
                                @foreach($subCategorySection4 as $subCategory)
                                    <option
                                        value="{{$subCategory->id}}" {{$subCategory->id == $popularCategorySection[3]['sub_category'] ? 'selected' : ''}}>{{$subCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Child Category</label>
                            <select name="child_category_4" id="" class="form-control child_category">
                                <option value="">Select</option>
                                @foreach($childCategorySection4 as $childCategory)
                                    <option
                                        value="{{$childCategory->id}}" {{$childCategory->id == $popularCategorySection[3]['child_category'] ? 'selected' : ''}}>{{$childCategory->name}}</option>
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

@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Permission</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Permission</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.permission.store')}}" method="post">
                                @csrf
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Name</label>--}}
{{--                                    <input type="text" name="name" class="form-control" value="{{old('name')}}">--}}
{{--                                    @if($errors->has('name'))--}}
{{--                                        <span class="text-danger">{{ $errors->first('name') }}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="">Group Name</label>--}}
{{--                                    <select class="form-control sub_category " name="group_name">--}}
{{--                                        <option value="" >Select</option>--}}
{{--                                        <option value="blog" >Blog</option>--}}
{{--                                        <option value="brand" >Brand</option>--}}
{{--                                        <option value="category" >Category</option>--}}
{{--                                        <option value="category" >Slider</option>--}}
{{--                                        <option value="category" >Vendor</option>--}}
{{--                                    </select>--}}
{{--                                    @if($errors->has('group_name'))--}}
{{--                                        <span class="text-danger">{{ $errors->first('group_name') }}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Module</th>
                                        <th class="text-center">Permission</th>
                                        <th class="text-center">Select All
                                            <input type="checkbox" name="" id="" class="check-all">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if ($modules->count() > 0)
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td class="text-center">{{ $module->title }}
                                                    <input type="checkbox" class="module-checked" name="" id="">
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        @if (!empty($roleListArr))
                                                            @foreach ($roleListArr as $key => $role)
                                                                <div class="col-2">
                                                                    <label
                                                                        for="role_{{ $module->name }}_{{ $key }}">{{ $role }}</label>
                                                                    <input type="checkbox" name="role[{{ $module->name }}][]"
                                                                           id="role_{{ $module->name }}_{{ $key }}"
                                                                           value="{{ $module->name.'.'.$key }}"
                                                                           class="item-checked"
                                                                           @if (isset($permissions[$module->name]) && in_array($module->name.'.'.$key, json_decode($permissions[$module->name]))) checked @endif
                                                                    >
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        @if ($module->name == 'groups')
                                                            <div class="col-3">
                                                                <input type="checkbox" name="role[{{ $module->name }}][]"
                                                                       id="role_{{ $module->name }}_permission" value="groups.permission"
                                                                       class="item-checked"
                                                                       @if (isset($permissions[$module->name]) && in_array('groups.permission', json_decode($permissions[$module->name]))) checked @endif
                                                                >
                                                                <label for="role_{{ $module->name }}_permission">authorization</label>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.module-checked').forEach(moduleCheckbox => {
                const itemCheckboxes = moduleCheckbox.closest('tr').querySelectorAll('.item-checked');

                // Check the "module checked" checkbox if at least one "item checked" checkbox is checked
                let isModuleChecked = true;
                itemCheckboxes.forEach(itemCheckbox => {
                    if (!itemCheckbox.checked) {
                        isModuleChecked = false;
                    }
                });

                moduleCheckbox.checked = isModuleChecked;

            });
        });

        document.querySelector(('.check-all')).addEventListener('change', (e)=>{
            if(e.target.checked === true){
                document.querySelectorAll(('.module-checked')).forEach(moduleItem =>{
                    moduleItem.checked = true;
                })
                document.querySelectorAll(('.item-checked')).forEach(item =>{
                    item.checked = true;
                })
            }else {
                document.querySelectorAll(('.module-checked')).forEach(moduleItem =>{
                    moduleItem.checked = false;
                })
                document.querySelectorAll(('.item-checked')).forEach(item =>{
                    item.checked = false;
                })
            }
        })

        document.querySelectorAll(('.module-checked')).forEach(moduleItem =>{
            moduleItem.addEventListener('change', (e)=>{
                let moduleChecked = e.target.checked;
                if(moduleChecked){
                    moduleItem.parentNode.nextElementSibling.querySelectorAll('.item-checked').forEach(item=>{
                        item.checked = true
                    })
                }else{
                    moduleItem.parentNode.nextElementSibling.querySelectorAll('.item-checked').forEach(item=>{
                        item.checked = false
                    })
                }
            });
        })

        document.querySelectorAll('.item-checked').forEach(item=>{
            item.addEventListener('change', (e)=>{
                let itemRow = e.target.parentNode.parentNode.parentNode;
                let countItems = itemRow.querySelectorAll('.item-checked').length;
                let moduleRow = itemRow.previousElementSibling;
                let count = 0;
                itemRow.querySelectorAll('.item-checked').forEach(element => {
                    if (element.checked) {
                        count++;
                    }else {
                        count--;
                    }
                });

                moduleRow.querySelector('.module-checked').checked = count === countItems;
            })
        })

    </script>

@endpush




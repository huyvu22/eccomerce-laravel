@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Authorization</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Authorization : {{$role->name}}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.update-role-permission',$role)}}" method="post">
                                @csrf

                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center" width="30%">Module</th>
                                        <th class="text-center">Permission</th>
                                        <th class="text-center" width="15%">Select All
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
                                                <td class="text-center">
                                                    <div class="row">
                                                        @if (!empty($roleLists))
                                                            @foreach($roleLists as $key=>$roleArr)
                                                                @if($module->name == $key)
                                                                    @foreach ($roleArr as $role)
{{--                                                                        @dd($permissionList)--}}
                                                                        <div class="col-2">
                                                                            <input type="checkbox" name="role[{{ $module->name }}][]"
                                                                                   id="role_{{ $module->name }}_{{ $role }}"
                                                                                   value="{{ $module->name.'.'.$role }}"
                                                                                   class="item-checked"
                                                                                @if (isset($permissionList[$module->name]) && in_array($module->name.'.'.$role, ($permissionList[$module->name]))) checked @endif
                                                                            >
                                                                            <label for="role_{{ $module->name }}_{{ $role }}">{{ $role }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif

                                                            @endforeach

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





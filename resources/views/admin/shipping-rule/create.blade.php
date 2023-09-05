@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Shipping Rule</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Shipping Rule</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.shipping-rule.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Type</label>
                                    <select class="form-control shipping-type" name="type">
                                        <option value="flat_cost">Flat Cost</option>
                                        <option value="min_order_amount">Minimum Order Amount</option>
                                    </select>
                                </div>

                                <div class="form-group min_amount d-none">
                                    <label for="">Minimum Amount</label>
                                    <input type="text" name="min_cost" class="form-control" value="{{old('min_cost')}}">
                                    @if($errors->has('min_cost'))
                                        <span class="text-danger">{{ $errors->first('min_cost') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Cost</label>
                                    <input type="text" name="cost" class="form-control" value="{{old('cost')}}">
                                    @if($errors->has('cost'))
                                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        document.querySelector('.shipping-type').addEventListener('change', (e)=>{
          if(e.target.value === "flat_cost"){
            document.querySelector('.min_amount').classList.add('d-none');
          }else{
              document.querySelector('.min_amount').classList.remove('d-none');
          }
        })
    });

</script>




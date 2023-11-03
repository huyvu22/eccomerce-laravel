@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Withdraw Method</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Withdraw Method</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.withdraw-method.update', $withdrawMethod)}}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$withdrawMethod->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Minimum Amount</label>
                                    <input type="text" name="minimum_amount" class="form-control" value="{{$withdrawMethod->minimum_amount}}">
                                    @if($errors->has('minimum_amount'))
                                        <span class="text-danger">{{ $errors->first('minimum_amount') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Maximum Amount</label>
                                    <input type="text" name="maximum_amount" class="form-control" value="{{$withdrawMethod->maximum_amount}}">
                                    @if($errors->has('maximum_amount'))
                                        <span class="text-danger">{{ $errors->first('maximum_amount') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Withdraw Charge (%)</label>
                                    <input type="text" name="withdraw_charge" class="form-control" value="{{$withdrawMethod->withdraw_charge}}">
                                    @if($errors->has('withdraw_charge'))
                                        <span class="text-danger">{{ $errors->first('withdraw_charge') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea type="text" name="description" class="summernote"> {!! $withdrawMethod->description !!}</textarea>
                                    @if($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



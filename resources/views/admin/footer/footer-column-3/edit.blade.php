@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Footer Column 2</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.footer-column-3.update', $footerColumn3)}}" method="post">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$footerColumn3->name}}">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Url</label>
                                    <input type="text" name="url" class="form-control" value="{{$footerColumn3->url}}">
                                    @if($errors->has('url'))
                                        <span class="text-danger">{{ $errors->first('url') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{$footerColumn3->status ==1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$footerColumn3->status ==0 ? 'selected' : ''}}>Inactive</option>
                                    </select>
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






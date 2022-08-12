@extends('admin.en.layout')
@section('title', 'Create Product')
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Create Product</h3>
      </div>
      <div class="form-group text-center mr-auto col-12 mt-3">
        @if (Session()->has('Success'))
            <div class="alert alert-success text-center">{{Session()->get('Success')}}</div>
            @php
              Session()->forget('Success')
            @endphp
        @endif
        @if (Session()->has('Error'))
            <div class="alert alert-danger text-center">{{Session()->get('Error')}}</div>
            @php
              Session()->forget('Error')
            @endphp
        @endif

      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="POST" action="{{asset('admin/products/store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="{{old('name')}}">
          </div>
            @error('name')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-group">
            <label for="exampleInputPassword1">Price</label>
            <input type="number" name="price" class="form-control" id="exampleInputPassword1" value="{{old('price')}}" >
          </div>
            @error('price')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">stock</label>
            <input type="number" name="stock" class="form-control" id="exampleInputEmail1" value="{{old('stock')}}">
          </div>
            @error('stock')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">code</label>
            <input type="text" name="code" class="form-control" id="exampleInputEmail1" value="{{old('code')}}">
          </div>
            @error('code')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">details</label>
            <textarea name="details" id="" cols="30" rows="10" class="form-control">{{old('details')}}</textarea>
          </div>
            @error('details')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">Sub Category</label>
            <select name="sub_cat_id" id="" class="form-control">
                @foreach ($subs as $key=>$value)
                  <option {{$value->id == old('sub_cat_id') ? 'selected' : ''}} value="{{$value->id}} ">{{$value->name}}</option>
                @endforeach
            </select>
          </div>
            @error('sub_cat_id')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          <div class="form-group">
            <label for="exampleInputFile">Image</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
            </div>
          </div>
            @error('image')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.card -->


@endsection

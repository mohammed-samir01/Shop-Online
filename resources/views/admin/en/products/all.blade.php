@extends('admin.en.layout')
@section('title', 'all products')
@section('links')
      <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
   
@endsection
@section('content')
<div class="col-12 text-left">
    <a href="{{asset('admin/products/create')}}" class="btn btn-success text-left">Add Product</a>
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

<table id="datatable" class="table table-bordered table-striped">
    <thead>
    <tr>
      <th>id</th>
      <th>name</th>
      <th>price</th>
      <th>code</th>
      <th>stock</th>
      <th>Action</th>


    </tr>
    </thead>
    <tbody>
    @foreach ($products as $key=>$value)
      <tr>
        <td>{{$value->id}}</td>
        <td>{{$value->name}}</td>
        <td>{{$value->price}}</td>
        <td>{{$value->code}}</td>
        <td>{{$value->stock}}</td>
        <td>
            <a href="{{asset('admin/products/edit/'.$value->id)}}" class="btn btn-warning">Edit</a>
            {{-- <a href="" class="btn btn-danger">Delete</a> --}}
            <form method="POST" action="{{asset('admin/products/destroy/'.$value->id)}}">
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
                @csrf
            </form>
        </td>
      </tr>
    @endforeach  

    </tbody>
  </table>
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
   
    $('#datatable').DataTable({
      "paging": true,
      "lengthChange":false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

    });
  });
</script>
  
@endsection
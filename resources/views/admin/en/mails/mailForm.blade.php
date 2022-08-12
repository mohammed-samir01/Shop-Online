@extends('admin.en.layout')
@section('title','mails')
@section('content')

    <div class="container">
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
          
        <div class="col-12">
            <form method="POST" action={{route('send-mail')}}>
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                    <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger text-light form-control">Send Mail</button>
                </div>
            </form>
        </div>
    </div>
@endsection
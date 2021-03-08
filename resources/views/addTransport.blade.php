@extends('layouts.app')
@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="list-style-type: none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
   <form action="/transport/add" method="post">
      @csrf
      <div class="form-row">
         <div class="form-group col-md-6">
            <label for="inputEmail4">Transport name</label>
            <input name="name" type="text" class="form-control" id="inputEmail4" placeholder="Transport name">
         </div>
         <div class="form-group col-md-6">
            <label for="inputPassword4">License No</label>
            <input name="lno" type="text" class="form-control" id="inputPassword4" placeholder="License no">
         </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit for review</button>
   </form>
</div>
@endsection
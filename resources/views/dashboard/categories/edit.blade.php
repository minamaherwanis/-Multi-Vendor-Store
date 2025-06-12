@extends('layouts.dashboard')
{{-- @extends('layouts.partials.nav') --}}

@section('title')
    <h1>Edite Category</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edite Category</li>
@endsection

@section('content')
   <form action="{{ route('categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
  
    @include('dashboard.categories._form',[
        'button_label'=>'Update'
    ])
</form>

    @endsection

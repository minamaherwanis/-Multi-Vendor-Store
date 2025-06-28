@extends('layouts.dashboard')
{{-- @extends('layouts.partials.nav') --}}

@section('title')
    <h1>Edite Product</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Edite Product</li>
@endsection

@section('content')
   <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
  
    @include('dashboard.products._form',[
        'button_label'=>'Update'
    ])
</form>

    @endsection

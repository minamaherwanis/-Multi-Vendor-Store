@extends('layouts.dashboard')
{{-- @extends('layouts.partials.nav') --}}

@section('title')
    <h1>Categories</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
   <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('dashboard.categories._form',[
        'button_label'=>'Save'
    ])
</form>

    @endsection

 @extends('layouts.dashboard')
 {{-- @extends('layouts.partials.nav') --}}

 @section('title')
 @endsection
 @section('breadcrumb')
 @parent
     <li class="breadcrumb-item active">Starter Page</li>
 @endsection

 @section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container mt-4">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-body text-center">
                <h2 class="mb-3">Welcome, {{ $user->name }} 👋</h2>
                <p class="lead text-muted">
                    Glad to see you back at <strong>{{ $title }}</strong>
                </p>
                <a href="{{ route('categories.index') }}" class="btn btn-success mt-3">
                    Go to categories
                </a>
            </div>
        </div>
    </div>


 
 @endsection

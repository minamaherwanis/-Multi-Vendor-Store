@foreach (['success', 'info', 'warning', 'danger', 'error'] as $type)
    @if (session()->has($type))
        <div 
            class="front-alert alert alert-{{ $type }} text-center"
            role="alert"
        >
            {{ session($type) }}
        </div>
    @endif
@endforeach

<style>
    .front-alert {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        min-width: 300px;
        max-width: 600px;
        padding: 15px 20px;
        font-size: 1.1rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(243, 240, 240, 0.2);
        z-index: 9999;
        animation: fadeInOut 2.5s forwards;
    }

    /* ألوان متناسقة مع الـ front */
    .alert-success { background-color: #4c77af; color: #fff; }
    .alert-info    { background-color: #2196F3; color: #fff; }
    .alert-warning { background-color: #ff9800; color: #fff; }
    .alert-danger,
    .alert-error   { background-color: #f44336; color: #fff; }

    /* Animation */
    @keyframes fadeInOut {
        0%   { opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
{{-- resources/views/super-admin/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }

        .page-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
        }

        .user-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
            cursor: pointer;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-top-bar { height: 6px; background: linear-gradient(90deg, #4f46e5, #7c3aed); }

        .avatar-circle {
            width: 65px; height: 65px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700; color: white; flex-shrink: 0;
        }

        .badge-admin {
            background-color: #ede9fe; color: #5b21b6;
            font-size: 11px; padding: 4px 10px;
            border-radius: 20px; font-weight: 600;
        }

        .badge-store-assigned {
            background-color: #dcfce7; color: #166534;
            font-size: 11px; padding: 4px 10px;
            border-radius: 20px; font-weight: 600;
        }

        .badge-store-none {
            background-color: #fee2e2; color: #991b1b;
            font-size: 11px; padding: 4px 10px;
            border-radius: 20px; font-weight: 600;
        }

        .info-row {
            display: flex; align-items: center; gap: 8px;
            font-size: 14px; color: #555;
            padding: 6px 0; border-bottom: 1px dashed #eee;
        }

        .info-row:last-child { border-bottom: none; }
        .info-row i { color: #4f46e5; width: 18px; text-align: center; }

        .assign-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none; color: white;
            border-radius: 10px; padding: 8px 18px;
            font-size: 13px; font-weight: 600;
            transition: opacity 0.2s;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }

        .assign-btn:hover { opacity: 0.85; color: white; }

        .search-wrapper {
            position: relative;
            margin-bottom: 28px;
        }

        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 13px 16px 13px 46px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            font-size: 15px;
            background: white;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .search-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79,70,229,0.1);
        }

        .search-input::placeholder { color: #9ca3af; }

        .search-count {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .no-results {
            display: none;
            text-align: center;
            padding: 50px 20px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-shield-lock-fill fs-2"></i>
                <div>
                    <h3 class="mb-0 fw-bold">Super Admin Panel</h3>
                    <small class="opacity-75">Manage admin users & assign stores</small>
                </div>
                <span class="badge bg-light text-dark ms-auto fs-6 px-3 py-2">
                    {{ $admins->count() }} Admins
                </span>
                <form method="POST" action="{{ route('admin.logout') }}" class="ms-2 mb-0">
                    @csrf
                    <button type="submit" style="
                        background: rgba(255,255,255,0.1);
                        border: 1px solid rgba(255,255,255,0.2);
                        color: white;
                        border-radius: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        font-weight: 600;
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        gap: 6px;
                        transition: background 0.2s;
                    " onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container pb-5">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($admins->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people-fill fs-1 d-block mb-3 text-secondary"></i>
                <h5>No admin users found.</h5>
            </div>
        @else

            {{-- Search Bar --}}
            <div class="search-wrapper">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="adminSearch"
                    class="search-input"
                    placeholder="Search by name or email..."
                    autocomplete="off"
                >
                <span class="search-count" id="searchCount">{{ $admins->count() }} admins</span>
            </div>

            <div class="row g-4" id="adminsGrid">
                @foreach($admins as $admin)
                    <div class="col-12 col-sm-6 col-lg-4 admin-card-col"
                         data-name="{{ strtolower($admin->name) }}"
                         data-email="{{ strtolower($admin->email) }}">
                        <div class="card user-card h-100">
                            <div class="card-top-bar"></div>
                            <div class="card-body p-4">

                                {{-- Avatar + Name --}}
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">{{ $admin->name }}</h6>
                                        <span class="badge-admin">
                                            <i class="bi bi-shield-check me-1"></i>Admin
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-3">

                                {{-- Info --}}
                                <div class="mb-3">
                                    <div class="info-row">
                                        <i class="bi bi-hash"></i>
                                        <span class="text-muted">ID:</span>
                                        <span class="fw-semibold">{{ $admin->id }}</span>
                                    </div>
                                    <div class="info-row">
                                        <i class="bi bi-envelope-fill"></i>
                                        <span class="text-muted">Email:</span>
                                        <span class="fw-semibold text-truncate">{{ $admin->email }}</span>
                                    </div>
                                    <div class="info-row">
                                        <i class="bi bi-shop"></i>
                                        <span class="text-muted">Store:</span>
                                        @if($admin->store_id)
                                            <span class="badge-store-assigned">
                                                <i class="bi bi-check-lg me-1"></i>Assigned
                                            </span>
                                        @else
                                            <span class="badge-store-none">
                                                <i class="bi bi-x-lg me-1"></i>Not Assigned
                                            </span>
                                        @endif
                                    </div>
                                    <div class="info-row">
                                        <i class="bi bi-calendar3"></i>
                                        <span class="text-muted">Joined:</span>
                                        <span class="fw-semibold">{{ $admin->created_at->format('Y-m-d') }}</span>
                                    </div>
                                </div>

                                {{-- Assign Button --}}
                                <a href="{{ route('adminstore.create', $admin->id) }}" class="assign-btn w-100 justify-content-center">
                                    <i class="bi bi-shop-window"></i>
                                    {{ $admin->store_id ? 'Change Store' : 'Assign Store' }}
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- No Results --}}
            <div class="no-results" id="noResults">
                <i class="bi bi-search fs-1 d-block mb-3"></i>
                <h5>No admins match your search</h5>
                <p class="mb-0">Try a different name or email.</p>
            </div>

        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput  = document.getElementById('adminSearch');
        const searchCount  = document.getElementById('searchCount');
        const noResults    = document.getElementById('noResults');
        const cards        = document.querySelectorAll('.admin-card-col');
        const total        = cards.length;

        searchInput?.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let visible = 0;

            cards.forEach(col => {
                const name  = col.dataset.name  || '';
                const email = col.dataset.email || '';
                const match = name.includes(q) || email.includes(q);
                col.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            searchCount.textContent = q
                ? visible + ' of ' + total
                : total + ' admins';

            noResults.style.display = visible === 0 && q ? 'block' : 'none';
        });
    </script>
</body>
</html>
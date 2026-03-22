{{-- resources/views/super-admin/create.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Store - {{ $admin->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }

        .page-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white; padding: 30px 0; margin-bottom: 40px;
        }

        .admin-info-card {
            border: none; border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden; margin-bottom: 24px;
        }

        .card-top-bar { height: 6px; background: linear-gradient(90deg, #4f46e5, #7c3aed); }

        .avatar-circle {
            width: 55px; height: 55px; border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 700; color: white; flex-shrink: 0;
        }

        /* Tabs */
        .custom-tabs { display: flex; gap: 8px; margin-bottom: 20px; }

        .custom-tab {
            flex: 1; padding: 12px 16px; border-radius: 12px;
            border: 2px solid #e5e7eb; background: white;
            font-weight: 600; font-size: 14px; color: #6b7280;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .custom-tab:hover { border-color: #4f46e5; color: #4f46e5; }

        .custom-tab.active {
            border-color: #4f46e5;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
        }

        .tab-pane-custom { display: none; }
        .tab-pane-custom.active { display: block; }

        /* Table Card */
        .stores-table-card {
            border: none; border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;
        }

        .stores-table-card .card-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white; padding: 16px 24px; border: none;
        }

        /* Store Search */
        .store-search-wrapper {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            background: #fafafa;
            position: relative;
        }

        .store-search-wrapper i.search-icon {
            position: absolute;
            left: 28px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 15px;
            pointer-events: none;
        }

        .store-search-input {
            width: 100%;
            padding: 9px 90px 9px 40px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            background: white;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .store-search-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .store-search-input::placeholder { color: #9ca3af; }

        .store-search-count {
            position: absolute;
            right: 28px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 20px;
            pointer-events: none;
        }

        .store-no-results {
            display: none;
            text-align: center;
            padding: 30px 20px;
            color: #9ca3af;
            font-size: 14px;
        }

        .store-row { cursor: pointer; transition: background-color 0.15s ease; }
        .store-row:hover { background-color: #f3f0ff !important; }
        .store-row.selected { background-color: #ede9fe !important; }
        .store-row td { vertical-align: middle; padding: 14px 16px; }

        .store-logo {
            width: 42px; height: 42px; border-radius: 10px;
            object-fit: cover; border: 1px solid #e5e7eb;
        }

        .store-logo-placeholder {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #e0e7ff, #ede9fe);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #4f46e5;
        }

        .status-badge-active {
            background-color: #dcfce7; color: #166634;
            font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;
        }

        .status-badge-inactive {
            background-color: #fee2e2; color: #991b1b;
            font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;
        }

        .store-radio { width: 18px; height: 18px; accent-color: #4f46e5; cursor: pointer; }

        /* New Store Form Card */
        .new-store-card {
            border: none; border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;
        }

        .new-store-card .card-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white; padding: 16px 24px; border: none;
        }

        .form-label { font-weight: 600; font-size: 14px; color: #374151; }

        .form-control, .form-select {
            border-radius: 10px; border: 2px solid #e5e7eb;
            padding: 10px 14px; font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        /* Remove Card */
        .remove-card {
            border: 2px dashed #fca5a5; border-radius: 16px;
            background: #fff7f7; padding: 28px; text-align: center;
        }

        /* Buttons */
        .submit-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none; color: white; border-radius: 12px;
            padding: 12px 32px; font-size: 15px; font-weight: 600;
            transition: opacity 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .submit-btn:hover { opacity: 0.85; color: white; }

        .remove-btn {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: none; color: white; border-radius: 12px;
            padding: 12px 32px; font-size: 15px; font-weight: 600;
            transition: opacity 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .remove-btn:hover { opacity: 0.85; color: white; }

        .back-btn {
            border: 2px solid #4f46e5; color: #4f46e5;
            border-radius: 12px; padding: 11px 24px;
            font-size: 15px; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .back-btn:hover { background: #4f46e5; color: white; }

        .currently-assigned {
            background-color: #fefce8; border: 1px solid #fde047;
            border-radius: 10px; padding: 10px 16px;
            font-size: 13px; color: #713f12; margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        #slug-hint { font-size: 12px; color: #6b7280; margin-top: 4px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-shop-window fs-2"></i>
                <div>
                    <h3 class="mb-0 fw-bold">Assign Store</h3>
                    <small class="opacity-75">Manage store assignment for this admin</small>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5" style="max-width: 900px;">

        {{-- Admin Info Card --}}
        <div class="admin-info-card">
            <div class="card-top-bar"></div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-circle">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">{{ $admin->name }}</h5>
                        <div class="text-muted" style="font-size: 14px;">
                            <i class="bi bi-envelope me-1"></i>{{ $admin->email }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-hash me-1"></i>ID: {{ $admin->id }}
                            @if($admin->store_id)
                                <span class="mx-2">•</span>
                                <i class="bi bi-shop me-1 text-success"></i>
                                <span class="text-success fw-semibold">Store Assigned</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Currently Assigned Warning --}}
        @if($admin->store_id)
            <div class="currently-assigned">
                <i class="bi bi-exclamation-triangle-fill"></i>
                This admin is currently assigned to <strong>Store #{{ $admin->store_id }}</strong>. Choosing a new store will replace it.
            </div>
        @endif

        {{-- Tabs --}}
        <div class="custom-tabs">
            <button class="custom-tab active" onclick="switchTab('existing', this)">
                <i class="bi bi-shop"></i> Assign Existing Store
            </button>
            <button class="custom-tab" onclick="switchTab('create', this)">
                <i class="bi bi-plus-circle"></i> Create New Store
            </button>
            @if($admin->store_id)
            <button class="custom-tab" onclick="switchTab('remove', this)" style="flex: 0.6; border-color: #fca5a5; color: #dc2626;">
                <i class="bi bi-x-circle"></i> Remove
            </button>
            @endif
        </div>

        {{-- ===================== TAB: Existing Store ===================== --}}
        <div id="tab-existing" class="tab-pane-custom active">
            <form action="{{ route('adminstore.store', $admin->id) }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="assign">

                <div class="stores-table-card">

                    {{-- Card Header --}}
                    <div class="card-header d-flex align-items-center gap-2">
                        <i class="bi bi-shop fs-5"></i>
                        <span class="fw-semibold">Available Stores</span>
                        <span class="badge bg-light text-dark ms-auto" id="storeCount">{{ $stores->count() }} stores</span>
                    </div>

                    @if($stores->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-shop fs-1 d-block mb-2"></i>
                            <p>No stores available. Create one in the next tab.</p>
                        </div>
                    @else

                        {{-- Search inside table --}}
                        <div class="store-search-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input
                                type="text"
                                id="storeSearch"
                                class="store-search-input"
                                placeholder="Search store by name or slug..."
                                autocomplete="off"
                            >
                            <span class="store-search-count" id="storeSearchCount">{{ $stores->count() }} stores</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:50px;"></th>
                                        <th style="width:60px;">Logo</th>
                                        <th>Store Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody id="storeTableBody">
                                    @foreach($stores as $store)
                                        <tr class="store-row {{ $admin->store_id == $store->id ? 'selected' : '' }}"
                                            onclick="selectStore({{ $store->id }}, this)"
                                            data-name="{{ strtolower($store->name) }}"
                                            data-slug="{{ strtolower($store->slug) }}">
                                            <td>
                                                <input class="store-radio" type="radio" name="store_id"
                                                    id="store_{{ $store->id }}" value="{{ $store->id }}"
                                                    {{ $admin->store_id == $store->id ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                @if($store->logo_image)
                                                    <img src="{{ asset($store->logo_image) }}" class="store-logo" alt="{{ $store->name }}">
                                                @else
                                                    <div class="store-logo-placeholder">
                                                        <i class="bi bi-shop"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $store->name }}</span>
                                                @if($store->description)
                                                    <div class="text-muted" style="font-size:12px;">{{ Str::limit($store->description, 50) }}</div>
                                                @endif
                                            </td>
                                            <td><code style="font-size:12px;color:#4f46e5;">{{ $store->slug }}</code></td>
                                            <td>
                                                @if($store->status === 'active')
                                                    <span class="status-badge-active"><i class="bi bi-circle-fill me-1" style="font-size:8px;"></i>Active</span>
                                                @else
                                                    <span class="status-badge-inactive"><i class="bi bi-circle-fill me-1" style="font-size:8px;"></i>Inactive</span>
                                                @endif
                                            </td>
                                            <td style="font-size:13px;color:#666;">{{ $store->created_at->format('Y-m-d') }}</td>
                                       <td>
    {{ $store->created_at->format('Y-m-d') }}
    <a href="{{ route('adminstore.store.edit', $store->id) }}"
       class="btn btn-sm btn-outline-primary ms-2">
        <i class="bi bi-pencil"></i>
    </a>
</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- No results row --}}
                        <div class="store-no-results" id="storeNoResults">
                            <i class="bi bi-search d-block mb-2" style="font-size:28px;"></i>
                            No stores match your search.
                        </div>

                    @endif
                </div>

                @error('store_id')
                    <div class="alert alert-danger mt-3 py-2">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('adminstore.index') }}" class="back-btn">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="submit-btn">
                        <i class="bi bi-check-lg"></i> Assign Store
                    </button>
                </div>
            </form>
        </div>

        {{-- ===================== TAB: Create New Store ===================== --}}
        <div id="tab-create" class="tab-pane-custom">
            <form action="{{ route('adminstore.store', $admin->id) }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="create">

                <div class="new-store-card">
                    <div class="card-header d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle fs-5"></i>
                        <span class="fw-semibold">Create New Store</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Store Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="store-name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="e.g. My Awesome Store">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="store-slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug') }}" placeholder="e.g. my-awesome-store">
                                <div id="slug-hint">Auto-generated from name. You can edit it.</div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Brief description of the store...">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status') !== 'inactive' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('adminstore.index') }}" class="back-btn">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="submit-btn">
                        <i class="bi bi-plus-lg"></i> Create & Assign
                    </button>
                </div>
            </form>
        </div>

        {{-- ===================== TAB: Remove Assignment ===================== --}}
        @if($admin->store_id)
        <div id="tab-remove" class="tab-pane-custom">
            <div class="remove-card">
                <i class="bi bi-shop-window text-danger" style="font-size: 48px;"></i>
                <h5 class="fw-bold mt-3 text-danger">Remove Store Assignment</h5>
                <p class="text-muted mb-4">
                    This will unlink <strong>{{ $admin->name }}</strong> from their currently assigned store
                    <strong>(Store #{{ $admin->store_id }})</strong>.<br>
                    The store itself will <strong>not</strong> be deleted.
                </p>
                <form action="{{ route('adminstore.store', $admin->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to remove the store assignment?')">
                    @csrf
                    <input type="hidden" name="action" value="remove">
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('adminstore.index') }}" class="back-btn">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="remove-btn">
                            <i class="bi bi-x-lg"></i> Yes, Remove Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tab switching
        function switchTab(name, btn) {
            document.querySelectorAll('.tab-pane-custom').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.custom-tab').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            btn.classList.add('active');
        }

        // Select store row
        function selectStore(id, row) {
            document.querySelectorAll('.store-row').forEach(r => r.classList.remove('selected'));
            row.classList.add('selected');
            document.getElementById('store_' + id).checked = true;
        }

        // Store search
        const storeSearch     = document.getElementById('storeSearch');
        const storeRows       = document.querySelectorAll('#storeTableBody .store-row');
        const storeNoResults  = document.getElementById('storeNoResults');
        const storeSearchCount = document.getElementById('storeSearchCount');
        const totalStores     = storeRows.length;

        storeSearch?.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let visible = 0;

            storeRows.forEach(row => {
                const name = row.dataset.name || '';
                const slug = row.dataset.slug || '';
                const match = name.includes(q) || slug.includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            storeSearchCount.textContent = q
                ? visible + ' of ' + totalStores
                : totalStores + ' stores';

            storeNoResults.style.display = visible === 0 && q ? 'block' : 'none';
        });

        // Auto-generate slug from name
        document.getElementById('store-name')?.addEventListener('input', function () {
            const slug = this.value
                .toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('store-slug').value = slug;
        });

        // Open correct tab if validation errors
        @if($errors->has('name') || $errors->has('slug') || $errors->has('status'))
            switchTab('create', document.querySelectorAll('.custom-tab')[1]);
        @endif
    </script>
</body>
</html>
{{-- resources/views/super-admin/edit-store.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Store - {{ $store->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }

        .page-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white; padding: 30px 0; margin-bottom: 40px;
        }

        .edit-card {
            border: none; border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;
        }

        .card-top-bar { height: 6px; background: linear-gradient(90deg, #4f46e5, #7c3aed); }

        .edit-card .card-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white; padding: 18px 24px; border: none;
        }

        .store-icon-circle {
            width: 52px; height: 52px; border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: white; flex-shrink: 0;
        }

        .form-label { font-weight: 600; font-size: 14px; color: #374151; }

        .form-control, .form-select {
            border-radius: 10px; border: 2px solid #e5e7eb;
            padding: 11px 14px; font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .field-hint { font-size: 12px; color: #9ca3af; margin-top: 5px; }

        .status-toggle {
            display: flex; gap: 10px;
        }

        .status-option {
            flex: 1; padding: 12px;
            border: 2px solid #e5e7eb; border-radius: 10px;
            cursor: pointer; text-align: center;
            transition: all 0.2s; background: white;
        }

        .status-option:has(input:checked).active-opt {
            border-color: #16a34a;
            background: #f0fdf4;
        }

        .status-option:has(input:checked).inactive-opt {
            border-color: #dc2626;
            background: #fff7f7;
        }

        .status-option input { display: none; }

        .status-option .opt-icon { font-size: 20px; margin-bottom: 4px; display: block; }
        .status-option .opt-label { font-size: 13px; font-weight: 600; color: #374151; }

        .divider-label {
            font-size: 11px; font-weight: 700; letter-spacing: .08em;
            color: #9ca3af; text-transform: uppercase;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 8px; margin-bottom: 20px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none; color: white; border-radius: 12px;
            padding: 12px 36px; font-size: 15px; font-weight: 600;
            transition: opacity 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .submit-btn:hover { opacity: 0.85; color: white; }

        .back-btn {
            border: 2px solid #4f46e5; color: #4f46e5;
            border-radius: 12px; padding: 11px 24px;
            font-size: 15px; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .back-btn:hover { background: #4f46e5; color: white; }

        .meta-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; padding: 4px 10px; border-radius: 20px;
            font-weight: 600;
        }

        .meta-badge.active  { background: #dcfce7; color: #166534; }
        .meta-badge.inactive { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-pencil-square fs-2"></i>
                <div>
                    <h3 class="mb-0 fw-bold">Edit Store</h3>
                    <small class="opacity-75">Update store details</small>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5" style="max-width: 720px;">

        {{-- Store Info Header --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="store-icon-circle">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <h5 class="mb-1 fw-bold text-dark">{{ $store->name }}</h5>
                <div class="d-flex align-items-center gap-2">
                    <code style="font-size:12px; color:#4f46e5;">{{ $store->slug }}</code>
                    <span class="meta-badge {{ $store->status }}">
                        <i class="bi bi-circle-fill" style="font-size:7px;"></i>
                        {{ ucfirst($store->status) }}
                    </span>
                    <span style="font-size:12px; color:#9ca3af;">
                        ID #{{ $store->id }} · Created {{ $store->created_at->format('Y-m-d') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Edit Form Card --}}
        <div class="edit-card">
            <div class="card-top-bar"></div>
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil fs-5"></i>
                <span class="fw-semibold">Store Details</span>
            </div>
            <div class="card-body p-4">

                <form action="{{ route('adminstore.store.update', $store->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Basic Info --}}
                    <p class="divider-label">Basic Info</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit-name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $store->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="edit-slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $store->slug) }}">
                            <p class="field-hint">Auto-updates with name. You can override it.</p>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Brief description of the store...">{{ old('description', $store->description) }}</textarea>
                        </div>
                    </div>

                    {{-- Status --}}
                    <p class="divider-label">Status</p>

                    <div class="status-toggle mb-4">
                        <label class="status-option active-opt">
                            <input type="radio" name="status" value="active"
                                {{ old('status', $store->status) === 'active' ? 'checked' : '' }}
                                onchange="highlightStatus()">
                            <span class="opt-icon">✅</span>
                            <span class="opt-label">Active</span>
                        </label>
                        <label class="status-option inactive-opt">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status', $store->status) === 'inactive' ? 'checked' : '' }}
                                onchange="highlightStatus()">
                            <span class="opt-icon">🔴</span>
                            <span class="opt-label">Inactive</span>
                        </label>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-3 pt-2">
                        <a href="{{ route('adminstore.index') }}" class="back-btn">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="submit-btn">
                            <i class="bi bi-check-lg"></i> Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-update slug from name (only if user hasn't manually changed slug)
        let slugManuallyEdited = false;

        document.getElementById('edit-slug')?.addEventListener('input', () => {
            slugManuallyEdited = true;
        });

        document.getElementById('edit-name')?.addEventListener('input', function () {
            if (slugManuallyEdited) return;
            const slug = this.value
                .toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('edit-slug').value = slug;
        });

        // Highlight selected status option
        function highlightStatus() {
            document.querySelectorAll('.status-option').forEach(opt => {
                const radio = opt.querySelector('input[type=radio]');
                opt.style.borderColor = radio.checked
                    ? (radio.value === 'active' ? '#16a34a' : '#dc2626')
                    : '#e5e7eb';
                opt.style.background = radio.checked
                    ? (radio.value === 'active' ? '#f0fdf4' : '#fff7f7')
                    : 'white';
            });
        }

        highlightStatus(); // run on load
    </script>
</body>
</html>
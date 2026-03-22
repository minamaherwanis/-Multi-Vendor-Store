{{-- resources/views/super-admin/login.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin — Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0a0a0f;
            --surface:   #111118;
            --border:    #1e1e2e;
            --accent:    #4f46e5;
            --accent2:   #7c3aed;
            --text:      #e8e8f0;
            --muted:     #6b6b80;
            --danger:    #ef4444;
        }

        body {
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Mono', monospace;
            color: var(--text);
            overflow: hidden;
            position: relative;
        }

        /* Animated grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(79,70,229,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79,70,229,0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
        }

        @keyframes gridMove {
            0%   { transform: translateY(0); }
            100% { transform: translateY(48px); }
        }

        /* Glowing orb */
        body::after {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79,70,229,0.12) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; transform: translate(-50%, -50%) scale(1); }
            50%       { opacity: 1;   transform: translate(-50%, -50%) scale(1.1); }
        }

        /* Card */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 48px 40px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 4px;
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Top accent line */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            border-radius: 4px 4px 0 0;
        }

        /* Header */
        .login-header {
            margin-bottom: 36px;
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--accent);
            border: 1px solid rgba(79,70,229,0.3);
            padding: 4px 10px;
            border-radius: 2px;
            margin-bottom: 16px;
            font-family: 'DM Mono', monospace;
        }

        .login-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
            animation: blink 1.5s step-end infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }

        .login-title {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        .login-title span {
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 8px;
            letter-spacing: 0.02em;
        }

        /* Error */
        .alert-danger {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 4px;
            padding: 12px 14px;
            font-size: 12px;
            color: #fca5a5;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-danger::before {
            content: '!';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px; height: 16px;
            border-radius: 50%;
            background: rgba(239,68,68,0.2);
            color: var(--danger);
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Form fields */
        .field {
            margin-bottom: 16px;
        }

        .field-label {
            display: block;
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .field-input-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field input {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 13px 14px 13px 42px;
            font-size: 13px;
            font-family: 'DM Mono', monospace;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            letter-spacing: 0.02em;
        }

        .field input::placeholder { color: var(--muted); }

        .field input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }

        .field input:focus + .field-icon,
        .field-input-wrap:focus-within .field-icon {
            color: var(--accent);
        }

        /* Password toggle */
        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 14px;
            padding: 0;
            transition: color 0.2s;
        }

        .toggle-pass:hover { color: var(--text); }

        /* Submit */
        .submit-btn {
            width: 100%;
            margin-top: 24px;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            border-radius: 4px;
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: white;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: opacity 0.2s, transform 0.15s;
        }

        .submit-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.08));
            pointer-events: none;
        }

        .submit-btn:hover   { opacity: 0.9; }
        .submit-btn:active  { transform: scale(0.99); }

        /* Footer */
        .login-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-footer span {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.08em;
        }

        .back-link {
            font-size: 11px;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .back-link:hover { color: var(--accent); }
    </style>
</head>
<body>

    <div class="login-card">

        {{-- Header --}}
        <div class="login-header">
            <div class="login-badge">Super Admin</div>
            <h1 class="login-title">Access <span>Control</span></h1>
            <p class="login-sub">Restricted area — authorized personnel only</p>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="field">
                <label class="field-label" for="email">Email Address</label>
                <div class="field-input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        autocomplete="email"
                        required
                    >
                    <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </div>
            </div>

            <div class="field">
                <label class="field-label" for="password">Password</label>
                <div class="field-input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••••••"
                        autocomplete="current-password"
                        required
                    >
                    <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <button type="button" class="toggle-pass" onclick="togglePassword()" id="toggleBtn">
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="eye-closed" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                AUTHENTICATE →
            </button>
        </form>

        {{-- Footer --}}
        <div class="login-footer">
            <span>SYS:SECURE v2.0</span>
            <a href="{{ url('/') }}" class="back-link">
                ← Back to site
            </a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input     = document.getElementById('password');
            const eyeOpen   = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            const isHidden  = input.type === 'password';

            input.type      = isHidden ? 'text' : 'password';
            eyeOpen.style.display   = isHidden ? 'none'  : '';
            eyeClosed.style.display = isHidden ? ''      : 'none';
        }
    </script>

</body>
</html>
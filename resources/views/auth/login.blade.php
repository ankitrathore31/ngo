<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NGO Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --purple: #6a0dad;
            --purple-light: #9d50bb;
            --gold: #c9a84c;
            --gold-light: #f0d080;
            --dark: #1a1a2e;
            --card-bg: #ffffff;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            overflow: hidden;
            background: var(--dark);
        }

        .split {
            height: 100vh;
            display: flex;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            flex: 1;
            position: relative;
            background: linear-gradient(135deg, #1a0533 0%, #6a0dad 50%, #9d50bb 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201, 168, 76, .25) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            animation: pulse-orb 6s ease-in-out infinite;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201, 168, 76, .15) 0%, transparent 70%);
            bottom: -80px;
            right: -80px;
            animation: pulse-orb 8s ease-in-out infinite reverse;
        }

        .brand-icon-wrap {
            position: relative;
            width: 100px;
            height: 100px;
            margin-bottom: 28px;
        }

        .brand-icon-wrap .ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(201, 168, 76, .4);
            animation: spin-ring 10s linear infinite;
        }

        .brand-icon-wrap .ring2 {
            position: absolute;
            inset: 10px;
            border-radius: 50%;
            border: 1px dashed rgba(255, 255, 255, .25);
            animation: spin-ring 15s linear infinite reverse;
        }

        .brand-icon-center {
            position: absolute;
            inset: 18px;
            background: rgba(255, 255, 255, .1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .icon-rotator {
            font-size: 2rem;
            transition: opacity .4s ease, transform .4s ease;
        }

        .icon-rotator.fading {
            opacity: 0;
            transform: scale(.7) rotate(-15deg);
        }

        .left-panel h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 8px;
            animation: fadeUp .8s ease forwards;
        }

        .left-panel p {
            font-size: .95rem;
            opacity: .75;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 300;
            animation: fadeUp 1s ease .15s both;
        }

        .gold-line {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 18px auto;
            animation: fadeUp 1s ease .1s both;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            background: #f7f5fc;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 38px 36px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(106, 13, 173, .12), 0 4px 16px rgba(0, 0, 0, .06);
            animation: fadeUp .7s ease forwards;
        }

        .login-card h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--dark);
            text-align: center;
            margin-bottom: 6px;
        }

        .login-card .subtitle {
            text-align: center;
            font-size: .82rem;
            color: #888;
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .form-group label {
            font-size: .8rem;
            font-weight: 500;
            color: #555;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e2e2;
            padding: 10px 14px;
            font-size: .92rem;
            transition: border-color .3s, box-shadow .3s;
        }

        .form-control:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(106, 13, 173, .1);
            outline: none;
        }

        /* ── ROLE SELECTOR ── */
        .role-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .role-label-row label {
            font-size: .8rem;
            font-weight: 500;
            color: #555;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin: 0;
        }

        .selected-badge {
            font-size: .72rem;
            padding: 3px 10px;
            border-radius: 20px;
            background: #f0e8ff;
            color: var(--purple);
            font-weight: 500;
            opacity: 0;
            transform: translateY(-4px);
            transition: all .3s ease;
        }

        .selected-badge.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .role-grid {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .role-chip {
            flex: 1 1 calc(20% - 8px);
            min-width: 64px;
            max-width: 80px;
            padding: 10px 6px 8px;
            border-radius: 12px;
            text-align: center;
            border: 1.5px solid #e8e8e8;
            cursor: pointer;
            background: #fafafa;
            transition: all .25s cubic-bezier(.34, 1.56, .64, 1);
            position: relative;
            overflow: hidden;
            user-select: none;
        }

        .role-chip::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--purple), var(--purple-light));
            opacity: 0;
            transition: opacity .25s ease;
            border-radius: 10px;
        }

        .role-chip:hover {
            transform: translateY(-3px) scale(1.04);
            border-color: #c8b8e8;
            box-shadow: 0 6px 18px rgba(106, 13, 173, .12);
        }

        .role-chip.active {
            border-color: var(--purple);
            transform: translateY(-4px) scale(1.06);
            box-shadow: 0 8px 24px rgba(106, 13, 173, .22);
        }

        .role-chip.active::before {
            opacity: 1;
        }

        .chip-emoji {
            font-size: 1.4rem;
            display: block;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        .role-chip.active .chip-emoji {
            transform: scale(1.2);
            animation: pop .3s ease forwards;
        }

        .chip-label {
            font-size: .68rem;
            font-weight: 500;
            letter-spacing: .3px;
            position: relative;
            z-index: 1;
            color: #666;
            transition: color .25s ease;
        }

        .role-chip.active .chip-label {
            color: white;
        }

        /* Selected preview strip */
        .role-preview {
            margin-top: 10px;
            height: 38px;
            border-radius: 10px;
            background: #f4eeff;
            border: 1px dashed #c8b0e8;
            display: flex;
            align-items: center;
            padding: 0 14px;
            gap: 10px;
            overflow: hidden;
        }

        .preview-inner {
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transform: translateX(-12px);
            transition: all .4s cubic-bezier(.34, 1.2, .64, 1);
        }

        .preview-inner.show {
            opacity: 1;
            transform: translateX(0);
        }

        .preview-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--purple);
            flex-shrink: 0;
            animation: pulse-dot 1.5s ease infinite;
        }

        .preview-text {
            font-size: .8rem;
            color: var(--purple);
            font-weight: 500;
        }

        .preview-hint {
            font-size: .78rem;
            color: #bbb;
            font-style: italic;
            margin-left: auto;
        }

        /* ── SUBMIT BTN ── */
        .btn-login {
            width: 100%;
            border-radius: 10px;
            padding: 11px;
            font-family: 'DM Sans', sans-serif;
            font-size: .92rem;
            font-weight: 500;
            letter-spacing: .5px;
            background: linear-gradient(135deg, var(--purple), var(--purple-light));
            border: none;
            color: white;
            cursor: pointer;
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, .2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width .5s ease, height .5s ease, opacity .5s ease;
            opacity: 0;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(106, 13, 173, .3);
        }

        .btn-login:active::after {
            width: 300px;
            height: 300px;
            opacity: 0;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e5e5, transparent);
            margin: 20px 0;
        }

        .form-check-label {
            font-size: .85rem;
            color: #666;
        }

        .forgot-link {
            text-align: center;
            margin-top: 14px;
        }

        .forgot-link a {
            font-size: .82rem;
            color: var(--purple);
            text-decoration: none;
            opacity: .75;
            transition: opacity .2s;
        }

        .forgot-link a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        /* ── KEYFRAMES ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin-ring {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse-orb {

            0%,
            100% {
                transform: scale(1) translate(0, 0);
            }

            50% {
                transform: scale(1.08) translate(10px, 10px);
            }
        }

        @keyframes pop {
            0% {
                transform: scale(.8);
            }

            60% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1.2);
            }
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(.7);
            }
        }

        .alert {
            border-radius: 10px;
            font-size: .88rem;
        }
    </style>
</head>

<body>
    <div class="split">

        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="brand-icon-wrap">
                <div class="ring"></div>
                <div class="ring2"></div>
                <div class="brand-icon-center">
                    <span id="icon-rotator" class="icon-rotator">🏛️</span>
                </div>
            </div>

            <h1>Gyan Bharti<br>Sanstha</h1>
            <div class="gold-line"></div>
            <p>Sanstha Management Portal</p>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="login-card mt-4 m-2">
                <h4>Welcome Back</h4>
                <p class="subtitle">Sign in to continue</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Role Selector -->
                    <div class="form-group mb-2">
                        <div class="role-label-row">
                            <label>User Type</label>
                            <span class="selected-badge" id="selectedBadge">—</span>
                        </div>

                        <div class="role-grid" id="roleGrid">
                            <div class="role-chip" data-role="Admin" data-label="Admin" data-emoji="👑">
                                {{-- <span class="chip-emoji">👑</span> --}}
                                <span class="chip-label">Admin</span>
                            </div>
                            <div class="role-chip" data-role="ngo" data-label="NGO" data-emoji="🤝">
                                {{-- <span class="chip-emoji">🤝</span> --}}
                                <span class="chip-label">NGO</span>
                            </div>
                            <div class="role-chip" data-role="staff" data-label="Staff" data-emoji="💼">
                                {{-- <span class="chip-emoji">💼</span> --}}
                                <span class="chip-label">Staff</span>
                            </div>
                            <div class="role-chip" data-role="member" data-label="Member" data-emoji="👤">
                                {{-- <span class="chip-emoji">👤</span> --}}
                                <span class="chip-label">Member</span>
                            </div>
                            <div class="role-chip" data-role="union" data-label="Union" data-emoji="🏛️">
                                {{-- <span class="chip-emoji">🏛️</span> --}}
                                <span class="chip-label">Union</span>
                            </div>
                        </div>

                        <!-- Live Preview Strip -->
                        {{-- <div class="role-preview">
                        <div class="preview-inner" id="previewInner">
                            <div class="preview-dot"></div>
                            <span class="preview-text" id="previewText">Logging in as …</span>
                        </div>
                        <span class="preview-hint" id="previewHint">← select a role</span>
                    </div> --}}

                        <input type="hidden" name="user_type" id="user_type" required>
                    </div>


                    <div class="divider"></div>
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control" name="email"
                            value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                    </div>



                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control" required
                                placeholder="••••••••">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary"
                                    style="border-radius:0 10px 10px 0; font-size:.82rem;" onclick="togglePwd()">
                                    <span id="pwdToggleLabel">Show</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Remember -->
                    <div class="form-group form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Keep me signed in</label>
                    </div>

                    <button type="submit" class="btn-login">Sign In</button>

                    @if (Route::has('password.request'))
                        <div class="forgot-link">
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        /* ── Icon rotator ── */
        const icons = ['🏛️', '🤝', '💼', '👨‍👨‍👧', '👤'];
        let idx = 0;
        const rotEl = document.getElementById('icon-rotator');

        setInterval(() => {
            rotEl.classList.add('fading');
            setTimeout(() => {
                idx = (idx + 1) % icons.length;
                rotEl.textContent = icons[idx];
                rotEl.classList.remove('fading');
            }, 400);
        }, 3000);

        /* ── Role selector ── */
        const chips = document.querySelectorAll('.role-chip');
        const badge = document.getElementById('selectedBadge');
        const previewInner = document.getElementById('previewInner');
        const previewText = document.getElementById('previewText');
        const previewHint = document.getElementById('previewHint');
        const hiddenInput = document.getElementById('user_type');

        chips.forEach(chip => {
            chip.addEventListener('click', function() {
                // Remove active from all
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const role = this.dataset.role;
                const label = this.dataset.label;
                const emoji = this.dataset.emoji;

                hiddenInput.value = role;

                // Badge
                badge.textContent = label;
                badge.classList.add('visible');

                // Preview strip
                previewText.textContent = `Logging in as ${emoji} ${label}`;
                previewHint.style.display = 'none';
                previewInner.classList.remove('show');
                void previewInner.offsetWidth; // reflow for re-trigger
                previewInner.classList.add('show');
            });
        });

        /* ── Password toggle ── */
        function togglePwd() {
            const p = document.getElementById('password');
            const lbl = document.getElementById('pwdToggleLabel');
            if (p.type === 'password') {
                p.type = 'text';
                lbl.textContent = 'Hide';
            } else {
                p.type = 'password';
                lbl.textContent = 'Show';
            }
        }
    </script>
</body>

</html>

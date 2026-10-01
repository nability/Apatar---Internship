<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Role - Apatar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #087F5B;
            --primary-dark: #056B4D;
            --primary-light: #E7F5EF;
            --background: #F7F8F7;
            --surface: #FFFFFF;
            --text-primary: #1F2933;
            --text-secondary: #7A858F;
            --border: #E7EBE9;
            --radius-md: 10px;
            --radius-xl: 16px;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--background);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .role-selector-container {
            max-width: 500px;
            width: 100%;
        }

        .role-selector-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .role-selector-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .role-selector-header p {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .role-selector-header .user-info {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--primary-light);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .role-selector-header .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
        }

        .role-selector-header .user-details p {
            margin: 0;
            font-size: 0.85rem;
        }

        .role-selector-header .user-details .name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .role-selector-header .user-details .email {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .role-cards {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .role-card {
            background: var(--surface);
            border: 2px solid var(--border);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .role-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .role-card.selected {
            background: var(--primary-light);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .role-card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            background: var(--primary-light);
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .role-card.selected .role-card-icon {
            background: var(--primary);
            color: #fff;
        }

        .role-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .role-card-key {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .role-card-check {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            float: right;
            margin-top: -2.5rem;
            background: var(--surface);
        }

        .role-card.selected .role-card-check {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .role-selector-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-select {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-select-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-select-primary:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-select-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .btn-logout:hover {
            border-color: var(--text-secondary);
            color: var(--text-primary);
            transform: translateY(-1px);
        }

        @media (max-width: 576px) {
            .role-selector-header h1 {
                font-size: 1.5rem;
            }

            .role-selector-header .user-info {
                flex-direction: column;
                text-align: center;
            }

            .role-cards {
                gap: 0.75rem;
            }

            .role-card {
                padding: 1.25rem;
            }

            .role-selector-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="role-selector-container">
        <div class="role-selector-header">
            <h1><i class="fa-solid fa-shield-halved me-2" style="color: var(--primary);"></i>Pilih Role</h1>
            <p>Silakan pilih role yang ingin Anda gunakan</p>

            <div class="user-info">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-details" style="flex: 1;">
                    <p class="name">{{ auth()->user()->name }}</p>
                    <p class="email">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('role.select.confirm') }}" id="roleForm">
            @csrf
            <div class="role-cards">
                @foreach ($roles as $role)
                    <label class="role-card" onclick="selectRole({{ $role->id }})">
                        <input type="radio" name="role_id" value="{{ $role->id }}" style="display: none;">
                        <div class="role-card-check">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="role-card-icon">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div class="role-card-key">{{ $role->name }}</div>
                        <div class="role-card-title">{{ $role->label }}</div>
                    </label>
                @endforeach
            </div>

            <div class="role-selector-actions">
                <button type="submit" class="btn btn-select btn-select-primary" id="selectBtn" disabled>
                    <i class="fa-solid fa-arrow-right me-1"></i>Lanjutkan
                </button>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-select btn-logout w-100">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>Keluar
                    </button>
                </form>
            </div>
        </form>
    </div>

    <script>
        const roleCards = document.querySelectorAll('.role-card');
        const roleRadios = document.querySelectorAll('input[name="role_id"]');
        const selectBtn = document.getElementById('selectBtn');

        function selectRole(roleId) {
            document.querySelector(`input[value="${roleId}"]`).checked = true;
            updateUI();
        }

        function updateUI() {
            roleCards.forEach(card => card.classList.remove('selected'));
            roleRadios.forEach(radio => {
                if (radio.checked) {
                    radio.closest('.role-card').classList.add('selected');
                    selectBtn.disabled = false;
                }
            });
        }

        roleCards.forEach(card => {
            card.addEventListener('click', updateUI);
        });
    </script>
</body>
</html>

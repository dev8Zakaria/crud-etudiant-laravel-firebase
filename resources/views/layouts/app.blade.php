<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion Étudiants')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #a855f7;
            --accent: #f43f5e;
            --background: #f8fafc;
            --sidebar: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --glass: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--background);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.1) 0px, transparent 50%);
            min-height: 100vh;
            color: var(--text-main);
            display: flex;
            flex-direction: column;
        }

        @auth
        body {
            flex-direction: row;
        }
        @endauth

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background: var(--sidebar);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            margin-bottom: 3rem;
        }

        .sidebar-brand i { width: 28px; height: 28px; }

        .nav-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            text-decoration: none;
            color: var(--text-muted);
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link i { width: 20px; height: 20px; }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.05);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem 3rem;
            min-height: 100vh;
            transition: all 0.3s ease;
            width: 100%;
        }

        @auth
        .main-content {
            margin-left: 280px;
        }
        @endauth

        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 3rem;
            gap: 1.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .btn-logout {
            background: transparent;
            border: none;
            color: var(--accent);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-family: inherit;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: rgba(244, 63, 94, 0.05);
        }

        /* Reusable Components */
        .card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.02);
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .alert-success { background: #ecfdf5; color: #059669; border: 1px solid #10b98133; }
        .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #ef444433; }

        @media (max-width: 1024px) {
            .sidebar { width: 80px; padding: 2rem 0.75rem; }
            .sidebar-brand span, .nav-link span { display: none; }
            .main-content { margin-left: 80px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    @auth
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i data-lucide="graduation-cap"></i>
            <span>EduManager</span>
        </a>

        <div class="nav-group">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i>
                <span>Tableau de bord</span>
            </a>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('etudiants.index') }}" class="nav-link {{ Request::routeIs('etudiants.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i>
                    <span>Étudiants</span>
                </a>
            @else
                <a href="{{ route('profil') }}" class="nav-link {{ Request::routeIs('profil') ? 'active' : '' }}">
                    <i data-lucide="user"></i>
                    <span>Mon Profil</span>
                </a>
            @endif
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i data-lucide="log-out"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <main class="main-content">
        @auth
        <div class="top-bar">
            <div class="user-profile">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: 700; font-size: 0.875rem;">{{ auth()->user()->name }}</span>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">{{ auth()->user()->role == 'admin' ? 'Administrateur' : 'Étudiant' }}</span>
                </div>
            </div>
        </div>
        @endauth

        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i data-lucide="alert-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP2CARS — @yield('title', 'Panel de Vehículos')</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --rojo:    #C0001A;
            --negro:   #0A0A0A;
            --gris:    #1C1C1E;
            --gris-md: #2C2C2E;
            --gris-lt: #3A3A3C;
            --plata:   #AEAEB2;
            --blanco:  #F5F5F7;
            --acento:  #FF2D44;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--negro);
            color: var(--blanco);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── NAV ── */
        .navbar-vip {
            background: var(--gris);
            border-bottom: 2px solid var(--rojo);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-brand-vip {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.9rem;
            color: var(--blanco) !important;
            letter-spacing: 3px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .brand-dot { color: var(--rojo); }
        .nav-links { display: flex; gap: 1rem; align-items: center; }
        .nav-links a {
            color: var(--plata);
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            padding: .4rem .9rem;
            border-radius: 6px;
            transition: all .2s;
        }
        .nav-links a:hover, .nav-links a.active {
            background: var(--rojo);
            color: #fff;
        }

        /* ── MAIN ── */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gris-lt);
        }
        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.8rem;
            letter-spacing: 2px;
            line-height: 1;
        }
        .page-title span { color: var(--rojo); }
        .page-subtitle { color: var(--plata); font-size: .9rem; margin-top: .3rem; }

        /* ── BOTONES ── */
        .btn-vip {
            background: var(--rojo);
            color: #fff;
            border: none;
            padding: .55rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: .88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: all .2s;
            cursor: pointer;
        }
        .btn-vip:hover { background: #a30016; color: #fff; transform: translateY(-1px); }
        .btn-outline-vip {
            background: transparent;
            border: 1.5px solid var(--gris-lt);
            color: var(--plata);
            padding: .5rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: .88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: all .2s;
            cursor: pointer;
        }
        .btn-outline-vip:hover { border-color: var(--plata); color: var(--blanco); }
        .btn-danger-vip {
            background: transparent;
            border: 1.5px solid #7f1d1d;
            color: #f87171;
            padding: .45rem 1rem;
            border-radius: 8px;
            font-size: .83rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            transition: all .2s;
            cursor: pointer;
        }
        .btn-danger-vip:hover { background: #7f1d1d; color: #fff; }

        /* ── CARD ── */
        .card-vip {
            background: var(--gris);
            border: 1px solid var(--gris-lt);
            border-radius: 14px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        /* ── TABLA ── */
        .table-vip { width: 100%; border-collapse: separate; border-spacing: 0; }
        .table-vip thead th {
            background: var(--gris-md);
            color: var(--plata);
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: .9rem 1.2rem;
            border-bottom: 1px solid var(--gris-lt);
        }
        .table-vip thead th:first-child { border-radius: 10px 0 0 0; }
        .table-vip thead th:last-child  { border-radius: 0 10px 0 0; }
        .table-vip tbody tr {
            border-bottom: 1px solid var(--gris-lt);
            transition: background .15s;
        }
        .table-vip tbody tr:hover { background: var(--gris-md); }
        .table-vip tbody td {
            padding: 1rem 1.2rem;
            font-size: .88rem;
            vertical-align: middle;
            color: var(--blanco);
        }
        .table-vip tbody tr:last-child td { border-bottom: none; }

        /* ── BADGE PLACA ── */
        .badge-placa {
            background: var(--rojo);
            color: #fff;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1rem;
            letter-spacing: 2px;
            padding: .25rem .75rem;
            border-radius: 6px;
        }

        /* ── SEARCH BAR ── */
        .search-wrap {
            position: relative;
            max-width: 360px;
        }
        .search-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--plata);
            font-size: 1rem;
        }
        .input-vip {
            background: var(--gris-md);
            border: 1.5px solid var(--gris-lt);
            color: var(--blanco);
            border-radius: 10px;
            padding: .6rem 1rem .6rem 2.8rem;
            font-size: .9rem;
            width: 100%;
            transition: border-color .2s;
        }
        .input-vip:focus {
            outline: none;
            border-color: var(--rojo);
            background: var(--gris-md);
            color: var(--blanco);
            box-shadow: 0 0 0 3px rgba(192,0,26,.15);
        }
        .input-vip::placeholder { color: var(--plata); }

        /* ── FORM ── */
        .form-label-vip {
            display: block;
            color: var(--plata);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-bottom: .4rem;
        }
        .form-input-vip {
            width: 100%;
            background: var(--gris-md);
            border: 1.5px solid var(--gris-lt);
            color: var(--blanco);
            border-radius: 10px;
            padding: .7rem 1rem;
            font-size: .9rem;
            transition: border-color .2s;
            font-family: 'DM Sans', sans-serif;
        }
        .form-input-vip:focus {
            outline: none;
            border-color: var(--rojo);
            box-shadow: 0 0 0 3px rgba(192,0,26,.15);
        }
        .form-input-vip.is-invalid { border-color: var(--acento); }
        .invalid-feedback-vip { color: #f87171; font-size: .78rem; margin-top: .3rem; }

        .section-label {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 2px;
            color: var(--rojo);
            margin-bottom: 1rem;
            padding-bottom: .5rem;
            border-bottom: 1px solid var(--gris-lt);
        }

        /* ── ALERTS ── */
        .alert-vip-success {
            background: rgba(34,197,94,.1);
            border: 1px solid rgba(34,197,94,.3);
            color: #86efac;
            border-radius: 10px;
            padding: .9rem 1.2rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .9rem;
        }
        .alert-vip-error {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5;
            border-radius: 10px;
            padding: .9rem 1.2rem;
            margin-bottom: 1.5rem;
            font-size: .9rem;
        }

        /* ── PAGINACIÓN ── */
        .pagination-vip { display: flex; gap: .4rem; align-items: center; margin-top: 1.5rem; justify-content: center; }
        .pagination-vip a, .pagination-vip span {
            padding: .45rem .85rem;
            border-radius: 7px;
            font-size: .85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }
        .pagination-vip a { background: var(--gris-md); color: var(--plata); border: 1px solid var(--gris-lt); }
        .pagination-vip a:hover { background: var(--rojo); color: #fff; border-color: var(--rojo); }
        .pagination-vip span.active { background: var(--rojo); color: #fff; border: 1px solid var(--rojo); }
        .pagination-vip span.disabled { background: var(--gris); color: var(--gris-lt); border: 1px solid var(--gris-lt); cursor: not-allowed; }

        /* ── DETAIL CARD ── */
        .detail-group { margin-bottom: 1.2rem; }
        .detail-label { color: var(--plata); font-size: .75rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
        .detail-value { color: var(--blanco); font-size: 1rem; margin-top: .2rem; }

        /* ── EMPTY STATE ── */
        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--plata); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: .4; }
        .empty-state p { font-size: .95rem; }

        /* ── MODAL ── */
        .modal-vip .modal-content {
            background: var(--gris);
            border: 1px solid var(--gris-lt);
            color: var(--blanco);
            border-radius: 14px;
        }
        .modal-vip .modal-header { border-bottom: 1px solid var(--gris-lt); }
        .modal-vip .modal-footer { border-top: 1px solid var(--gris-lt); }
        .modal-vip .btn-close { filter: invert(1); }

        .text-plata { color: var(--plata); }
        .text-rojo  { color: var(--rojo); }

        @media (max-width: 768px) {
            .page-header { flex-direction: column; gap: 1rem; align-items: flex-start; }
            .page-title { font-size: 2rem; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="navbar-vip">
    <a href="{{ route('vehiculos.index') }}" class="navbar-brand-vip">
        <i class="bi bi-car-front-fill text-danger"></i>
        VIP2<span class="brand-dot">CARS</span>
    </a>
    <div class="nav-links">
        <a href="{{ route('vehiculos.index') }}" class="{{ request()->routeIs('vehiculos.index') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Vehículos
        </a>
        <a href="{{ route('vehiculos.create') }}" class="{{ request()->routeIs('vehiculos.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Registrar
        </a>
        @auth
        <span style="color:var(--plata);font-size:.85rem;padding:.4rem .6rem;">
            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-outline-vip" style="font-size:.83rem;padding:.4rem .9rem;">
                <i class="bi bi-box-arrow-right"></i> Salir
            </button>
        </form>
        @endauth
    </div>
</nav>

<!-- CONTENT -->
<main class="main-content">
    @if(session('success'))
        <div class="alert-vip-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-vip-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
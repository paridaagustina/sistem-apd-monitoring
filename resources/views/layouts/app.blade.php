
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'APDMONITOR'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #f3f6fb;
            color: #263449;
            margin: 0;
        }

        .wadah {
            width: min(1400px, 94%);
            margin: 0 auto;
            padding: 30px 0;
        }

        .kartu {
            background: white;
            padding: 22px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,.04);
        }

        .statistik {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .angka {
            font-size: 30px;
            font-weight: 800;
            margin: 10px 0;
        }

        .teks-redup {
            color: #718096;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .hijau {
            background: #dcfce7;
            color: #166534;
        }

        .merah {
            background: #fee2e2;
            color: #991b1b;
        }

        .tombol {
            display: inline-block;
            padding: 10px 16px;
            background: #2457d6;
            color: white;
            text-decoration: none;
            border-radius: 9px;
            font-weight: 600;
        }

        .pembungkus-tabel {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #e5eaf1;
        }

        th {
            color: #64748b;
            font-size: 12px;
        }

        @media(max-width: 600px) {
            .wadah {
                width: 92%;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('layouts.navigation')

    <main class="wadah">
        @yield('content')
    </main>
@stack('scripts')
</body>
</html>

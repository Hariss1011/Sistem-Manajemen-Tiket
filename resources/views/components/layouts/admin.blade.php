<!DOCTYPE html>
<html lang="id">

<html lang="id" data-theme="bengtix">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($title ?? 'Panel admin') . ' · BengTix' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="drawer lg:drawer-open w-full min-h-screen bg-base-200">
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <!-- Navbar -->
            <nav class="navbar w-full bg-base-300">
                <label for="my-drawer-4" aria-label="open sidebar" class="btn btn-square btn-ghost lg:hidden">
                    <!-- Sidebar toggle icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round"
                        stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                        class="my-1.5 inline-block size-4">
                        <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                        </path>
                        <path d="M9 4v16"></path>
                        <path d="M14 10l2 2l-2 2"></path>
                    </svg>
                </label>
            </nav>
            <!-- Page content -->
            {{ $slot }}
        </div>

        @include('components.admin.sidebar')
    </div>

    @stack('scripts')
</body>

</html>

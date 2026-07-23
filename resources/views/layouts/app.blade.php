<!DOCTYPE html>
<html lang="ru" data-bs-theme="{{ auth()->user()->theme_color ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskFlow - ToDo')</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/css?family=Inter:wght@400;500;600;700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-body-secondary">

    <div class="d-flex flex-column flex-lg-row min-vh-100">
        
        <header class="d-flex justify-content-between align-items-center p-3 bg-body shadow-sm d-lg-none position-sticky top-0 z-3">
            <div class="d-flex align-items-center gap-2 fw-bold fs-5">
                <i class="bi bi-check2-square text-primary fs-3"></i> TaskFlow
            </div>
            
            <button class="btn btn-light border-0 px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="bi bi-list fs-1 text-body"></i>
            </button>
        </header>

        @include('partials.sidebar')

        <main class="flex-grow-1 p-3 p-lg-4 bg-body rounded-lg-4 shadow-sm my-lg-3 me-lg-3 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</body>
</html>
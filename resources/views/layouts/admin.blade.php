<!DOCTYPE html>
<html lang="en" class="scroll-smooth md:scroll-auto" data-theme="winter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="https://wbs.sukoharjokab.go.id/images/wb.png">
    <title>@yield('title') | WBS Kabupaten Sukoharjo</title>


    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>


</head>

<body class="antialiased md:subpixel-antialiased">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 h-screen bg-white shadow-lg p-6">
            @include('admin.partials.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Header -->
            @include('admin.partials.header', ['title' => $title ?? 'Dashboard'])

            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>

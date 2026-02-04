<!DOCTYPE html>
<html lang="en" class="scroll-smooth md:scroll-auto" data-theme="winter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="https://wbs.sukoharjokab.go.id/images/wbs.png">
    <title>@yield('title') | WBS Kabupaten Sukoharjo</title>


    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>


</head>

<body class="antialiased md:subpixel-antialiased bg-gray-50">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="lg:w-64 lg:h-screen lg:bg-white lg:shadow-lg lg:p-6 bg-gray-50">
            @include('admin.partials.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 w-full lg:w-auto">
            <!-- Header -->
            @include('admin.partials.header', ['title' => $title ?? 'Dashboard'])

            <!-- Page Content -->
            <div class="p-4 sm:p-6 lg:p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>

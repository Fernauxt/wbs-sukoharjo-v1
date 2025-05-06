@extends('layouts.endpage')

@section('title', 'Login Admin')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <!-- Left: Image -->
        <div class="h-screen lg:w-1/2 hidden lg:block relative">
            <img src="https://img.freepik.com/free-vector/flat-customer-service-week-illustration_23-2149644201.jpg?t=st=1746502649~exp=1746506249~hmac=1ced3c2d0b1dec13415be52d46db54069bd243ff06fb84a471e87ae35c58e143&w=740"
                alt="Placeholder Image" class="object-cover w-full h-full">
        </div>

        <!-- Right: Login Form -->
        <div class="lg:p-36 md:p-52 sm:p-20 p-8 w-full lg:w-1/2">
            <h1 class="text-2xl font-semibold mb-4">Login Admin</h1>

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <!-- Username Input -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-600">Username</label>
                    <input type="text" id="username" name="username"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off" required>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-800">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off" required>
                </div>

                <!-- Remember Me -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="text-blue-500">
                    <label for="remember" class="text-gray-700 ml-2">Remember Me</label>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="btn bg-red-500 hover:bg-red-800 text-white font-semibold rounded-md py-2 px-4 w-full">
                    Login
                </button>
            </form>

            <!-- Info bawah -->
            <div class="mt-6 text-center text-gray-600">
                Login hanya untuk petugas. Hubungi pengelola jika butuh akses.
            </div>
        </div>
    </div>
@endsection

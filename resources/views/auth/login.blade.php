<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md border border-gray-300">
        <h2 class="text-2xl font-bold mb-6 text-center">Login to Your Account</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded border border-gray-400 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full rounded border border-gray-400 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Login
            </button>
            {{-- <div class="flex justify-center">
                {!! NoCaptcha::display(['data-theme' => 'light']) !!}
            </div> --}}
        </form>
    </div>

    {{-- {!! NoCaptcha::renderJs() !!} --}}

</body>
</html>

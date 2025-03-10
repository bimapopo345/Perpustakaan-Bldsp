<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-background {
            background: linear-gradient(120deg, #4F46E5, #7C3AED, #F472B6);
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="min-h-screen gradient-background flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Register Member
                </h1>
                <p class="text-gray-500 mt-2">Bergabung dengan Perpustakaan Digital</p>
            </div>

            <form method="POST" action="{{ url('/register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           required autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           required>
                </div>

                <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:opacity-90 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>

                <p class="text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Login disini
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Decorative blob -->
    <div class="fixed top-0 right-0 -z-10 opacity-10">
        <svg class="w-96 h-96 text-indigo-600" fill="currentColor" viewBox="0 0 200 200">
            <path d="M45,-77.2C58.3,-70.3,69,-58.2,77.2,-44.2C85.4,-30.2,91.1,-15.1,89.8,-0.7C88.6,13.6,80.4,27.3,71.5,40.1C62.6,53,53,65.1,40.3,73.3C27.6,81.5,13.8,85.8,0.4,85.2C-13,84.5,-26,78.9,-39.1,71.5C-52.2,64.1,-65.4,55,-73.7,42.1C-82,29.2,-85.4,14.6,-84.6,0.4C-83.8,-13.7,-78.9,-27.4,-70.6,-39.2C-62.2,-50.9,-50.5,-60.7,-37.6,-67.5C-24.7,-74.3,-12.4,-78.2,1.7,-81C15.8,-83.9,31.7,-84.1,45,-77.2Z" transform="translate(100 100)" />
        </svg>
    </div>
</body>
</html>

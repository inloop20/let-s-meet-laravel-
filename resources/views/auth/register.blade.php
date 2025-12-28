<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Let's Meet | Sign In </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes scroll-up {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-50%);
            }
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 10px 2px rgba(14, 165, 233, 0.2);
            }

            25% {
                box-shadow: 5px 0 20px 2px rgba(14, 165, 233, 0.4);
            }

            50% {
                box-shadow: 0 0 10px 2px rgba(114, 165, 233, 0.2);
            }

            75% {
                box-shadow: -5px 0 20px 2px rgba(167, 139, 250, 0.3);
            }

            100% {
                box-shadow: 0 0 10px 2px rgba(167, 139, 250, 0.2);
            }
        }

        .animate-glow {
            animation: glow 3s ease-in-out infinite;
        }

        .animate-scroll-up {
            animation: scroll-up 12s linear infinite;
        }
    </style>
</head>

<body class="bg-slate-950 min-h-screen flex items-center justify-center text-gray-200 antialiased p-4 gap-10">
    @php
        $mode = request()->query('mode', 'login');
    @endphp

    <div
        class="relative w-full max-w-md bg-slate-950 rounded-3xl overflow-hidden border border-[#334155] p-10 animate-glow transition-transform duration-500">

        <div
            class="flex w-fit mx-auto items-center justify-center p-1.5 gap-2 bg-[#0f172a] rounded-full mb-10 border border-[#334155] shadow-inner">
            <button 
            onclick="window.location.href='?mode=login'"
                class="px-8 py-2 text-sm cursor-pointer rounded-full {{ $mode !== 'register' ? 'bg-sky-600 text-white' : 'text-gray-400' }} font-bold transition-all">
                Sign In </button>
            <button 
            onclick="window.location.href='?mode=register'"
                class="px-8 py-2 text-sm cursor-pointer rounded-full {{ $mode === 'register' ? 'bg-sky-600 text-white' : 'text-gray-400' }} transition-all">
                Sign Up
            </button>
        </div>

        <form method="POST" action="{{ $mode === 'register' ? route('auth.register') : route('auth.login') }}"
            class="space-y-6">
            @csrf
            @if ($mode == 'register')
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Username</label>
                    <input name="username" type="text"
                        class="w-full px-4 py-3 bg-slate-950 border border-[#334155] rounded-2xl outline-none focus:ring-2 focus:ring-sky-700 focus:border-transparent transition-all placeholder:text-gray-600"
                        placeholder="Abu bakar">
                </div>
            @endif
            <div class="space-y-1">
                <label for="email" class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Email Address
                </label>
                <input name="email" type="email"
                    class="w-full px-4 py-3 bg-slate-950 border border-[#334155] rounded-2xl outline-none focus:ring-2 focus:ring-sky-700 focus:border-transparent transition-all placeholder:text-gray-600"
                    placeholder="Abubakar@gmail.com">
            </div>
            <div class="relative space-y-1">
                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Password</label> <input
                    id='password' name="password" type="password"
                    class="w-full px-4 py-3 pr-12 bg-slate-950 border border-[#334155] rounded-2xl outline-none focus:ring-2 focus:ring-sky-700 focus:border-transparent transition-all placeholder:text-gray-600"
                    placeholder="••••••••">
                <div 
                onclick="togglePassword()"
                    class="absolute inset-y-0 right-3 top-7 flex items-center cursor-pointer"> 
                    <svg id="eyeIcon"
                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 hover:text-gray-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <div>
             @if ($errors->any())
    <div class="flex items-center gap-2 bg-[#1e293b] border border-[#334155] text-red-400 px-4 py-2 rounded-2xl mb-4 text-sm shadow-inner">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
        </svg>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

            </div>
            <button class="w-full py-2 bg-sky-700 hover:bg-sky-800 transition-all rounded-xl font-semibold text-white">
                {{ $mode === 'register' ? 'Sign up' : 'Sign in' }} </button>
        </form>
    </div>
    <div
        class="hidden md:flex flex-col justify-center w-full max-w-md p-12 bg-slate-900/30 rounded-3xl relative border border-white/5 overflow-hidden">
        <div class="z-20 mb-10">
            <h1 class="text-5xl font-black mb-2 text-white tracking-tight">Let’s <span class="text-sky-500">Meet.</span>
            </h1>
            <div class="h-1 w-12 bg-sky-500 rounded-full mb-4"></div>
            <p class="text-slate-400 text-lg leading-relaxed"> Experience the future of seamless event orchestration.
            </p>
        </div>
        <div
            class="relative h-48 z-10 overflow-hidden mask-[linear-gradient(to_bottom,transparent,black_20%,black_80%,transparent)]">
            <ul class="space-y-6 animate-scroll-up">
                <li class="flex items-center gap-4 text-slate-300 font-medium">Online Event Registration</li>
                <li class="flex items-center gap-4 text-slate-300 font-medium">Admin Dashboard & Analytics</li>
                <li class="flex items-center gap-4 text-slate-300 font-medium">Role-Based Access Control</li>
                <li class="flex items-center gap-4 text-slate-300 font-medium">Real-Time Management</li>
                <li class="flex items-center gap-4 text-slate-300 font-medium">Online Event Registration</li>
                <li class="flex items-center gap-4 text-slate-300 font-medium">Admin Dashboard & Analytics</li>
            </ul>
        </div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-sky-600/10 rounded-full blur-[100px]"></div>
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-indigo-600/10 rounded-full blur-[100px]"></div>
    </div>
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-indigo-600/10 rounded-full blur-[100px]"></div>
</body>


<script>
const passwordField = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');

function togglePassword() {
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3l18 18M9.88 9.88a3 3 0 014.24 4.24
        M12 5c4.478 0 8.268 2.943 9.542 7
        -.377 1.2-.996 2.32-1.816 3.24
        M2.458 12C3.732 16.057 7.523 19 12 19
        c1.327 0 2.613-.323 3.74-.894" />
    `;
  } else {
    passwordField.type = 'password';
    eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5
        c4.478 0 8.268 2.943 9.542 7
        -1.274 4.057-5.064 7-9.542 7
        -4.477 0-8.268-2.943-9.542-7z" />
    `;
  }
}
</script>


</html>
<nav class="bg-[#05080a]/80 backdrop-blur-xl border-b border-white/5 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-10">
            <div class="text-2xl font-black tracking-tighter">
                LET'S <span class="text-[#0070FF]">MEET</span>
            </div>
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ url('/') }}"
                   class="text-sm font-bold uppercase tracking-widest px-3 py-2 rounded-xl transition
                   {{ request()->is('/') ? '  text-[#0070FF] ' : 'text-slate-500 hover:text-white' }}">
                   Explore
                </a>
                <a href="{{ url('/events') }}"
                   class="text-sm font-bold uppercase tracking-widest px-3 py-2 rounded-xl transition
                   {{ request()->is('events') ? '  text-[#0070FF] ' : 'text-slate-500 hover:text-white' }}">
                   Browse Events
                </a>
                <a href="{{url('/my-events')}}"
                   class="text-sm font-bold uppercase tracking-widest px-3 py-2 rounded-xl transition
                   {{ request()->is('my-events') ? '  text-[#0070FF] ' : 'text-slate-500 hover:text-white' }}">
                   My Event
                </a>
                <a href="/events/create"
                   class="text-sm font-bold uppercase tracking-widest px-3 py-2 rounded-xl transition
                   {{ request()->is('events/create') ? ' text-[#0070FF] ' : 'text-slate-500 hover:text-white' }}">
                   Create Events
                </a>
                <a href="/dashboard"
                   class="text-sm font-bold uppercase tracking-widest px-3 py-2 rounded-xl transition
                   {{ request()->is('dashboard') ? ' text-[#0070FF] ' : 'text-slate-500 hover:text-white' }}">
                   Dashboard
                </a>
            </div>
        </div>

        @auth
        <details class="relative">
            <summary class="list-none flex items-center gap-3 px-3 py-2 rounded-xl 
                            cursor-pointer hover:bg-white/5 transition select-none">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#0070FF] to-[#1560BD]
                            flex items-center justify-center text-white font-bold uppercase">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="text-sm text-gray-200 font-medium hidden md:block">
                    {{ auth()->user()->name }}
                </span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          d="m6 9 6 6 6-6" />
                </svg>
            </summary>

            <div class="absolute right-0 mt-3 w-52 bg-[#0f1419]
                        border border-[#1560BD]/30 rounded-xl shadow-xl overflow-hidden z-50">
                <div class="px-4 py-3 border-b border-white/10">
                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-[#708090] truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="/profile" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:bg-white/5 transition">
                    Profile
                </a>
                <a href="/my-events" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:bg-white/5 transition">
                    My Events
                </a>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center gap-3 px-4 py-3
                               text-sm text-red-400 hover:bg-red-500/10 transition">
                        Logout
                    </button>
                </form>
            </div>
        </details>
        @else
        <div class="flex items-center gap-4">
            <a href="/login" class="text-[#708090] hover:text-white transition">Sign In</a>
            <a href="/login" class="px-6 py-2 bg-gradient-to-r from-[#0070FF] to-[#1560BD] rounded-xl text-white font-semibold">
                Get Started
            </a>
        </div>
        @endauth
    </div>
</nav>

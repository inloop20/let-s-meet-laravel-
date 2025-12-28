@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16 relative">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[#0070FF]/5 blur-[120px] rounded-full -z-10"></div>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class="text-6xl font-black text-white tracking-tighter uppercase leading-tight">
                ACCOUNT <span class="text-[#0070FF]">SETTINGS.</span>
            </h1>
            <p class="text-slate-500 font-medium mt-2">Personalize your identity across the platform.</p>
        </div>
        
        <div class="flex gap-3">
            <div class="glass-card px-6 py-3 rounded-2xl border-white/5">
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Member Since</p>
                <p class="text-white font-bold text-sm">{{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="glass-card rounded-[3rem] p-10 text-center border-[#0070FF]/20 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0070FF]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative inline-block mb-8">
                    <div class="w-32 h-32 rounded-[2.5rem] bg-gradient-to-br from-[#0070FF] to-cyan-400 p-[2px] rotate-3 group-hover:rotate-0 transition-transform duration-500">
                        <div class="w-full h-full rounded-[2.4rem] bg-[#0f1419] flex items-center justify-center text-4xl font-black text-white shadow-2xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="absolute bottom-1 right-2 w-6 h-6 bg-green-500 border-4 border-[#0f1419] rounded-full"></div>
                </div>

                <h3 class="text-2xl font-black text-white tracking-tight">{{ $user->name }}</h3>
                <p class="text-slate-500 text-sm font-medium mb-8">{{ $user->email }}</p>
                
                <div class="grid grid-cols-2 gap-4 pt-8 border-t border-white/5">
                    <div class="text-center p-4 rounded-2xl bg-white/5">
                        <p class="text-2xl font-black text-[#0070FF]">{{ $user->events()->count() }}</p>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-1">Hosted</p>
                    </div>
                    <div class="text-center p-4 rounded-2xl bg-white/5">
                        <p class="text-2xl font-black text-white">{{ $user->registrations()->count() }}</p>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-1">Attending</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-8">
            <div class="glass-card rounded-[3rem] p-8 md:p-12 border-white/5 shadow-2xl">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] ml-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#0070FF]"></span>
                                Full Name
                            </label>
                            <input value="{{ old('name', $user->name) }}" type="text" name="name" 
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-5 text-white font-bold outline-none focus:border-[#0070FF] focus:bg-white/[0.07] transition-all placeholder:text-slate-700"
                                placeholder="Your Name">
                            @error('name') <p class="text-red-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3 ml-2">
                            <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] ml-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#0070FF]"></span>
                                Email Address
                            </label>
                            <input value="{{ old('email', $user->email) }}" type="email" name="email" 
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-5 text-white font-bold outline-none focus:border-[#0070FF] focus:bg-white/[0.07] transition-all placeholder:text-slate-700"
                                placeholder="Email">
                            @error('email') <p class="text-red-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-3 mt-3">
                            <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] ml-1">
                                Password
                            </label>

                            <input type="password" name="password" 
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-5 text-white font-bold outline-none focus:border-[#0070FF] focus:bg-white/[0.07] transition-all placeholder:text-slate-700"
                                placeholder="*******">
                            @error('password') <p class="text-red-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-10 border-t border-white/5">
                        <p class="text-[10px] font-bold text-slate-600 max-w-[200px] leading-relaxed">
                            Ensure your information is accurate for event check-ins.
                        </p>
                        
                        <button type="submit" 
                            class="group relative flex items-center gap-3 px-12 py-5 bg-[#0070FF] text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-white hover:text-black transition-all shadow-xl shadow-[#0070FF]/20 overflow-hidden">
                            <span class="relative z-10">Save Changes</span>
                            <svg class="w-4 h-4 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
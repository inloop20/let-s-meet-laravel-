@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 relative">
    
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#0070FF]/10 blur-[150px] -z-10 rounded-full animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/5 blur-[120px] -z-10 rounded-full"></div>

  
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <span class="w-12 h-[2px] bg-[#0070FF]"></span>
                <span class="text-[10px] font-black text-[#0070FF] uppercase tracking-[0.4em]">Operational Dashboard</span>
            </div>
            <h1 class="text-7xl font-black text-white tracking-tighter uppercase leading-none">
                LIVE <span class="text-transparent bg-clip-text text=[400px] bg-gradient-to-r from-[#0070FF] to-cyan-400">OPS.</span>
            </h1>
        </div>
        <div class="glass-card px-6 py-4 rounded-2xl border-white/5 flex items-center gap-6">
            <div class="text-right">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">System Status</p>
                <p class="text-xs font-bold text-green-500 uppercase tracking-widest">All Systems Nominal</p>
            </div>
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse shadow-[0_0_10px_#22c55e]"></div>
        </div>
    </div>

  
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-20">
       
        <div class="glass-card p-8 rounded-[2.5rem] border-white/5 group hover:border-white/10 transition-all">
            <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Total Experiences</p>
            <div class="flex items-end justify-between">
                <h2 class="text-5xl font-black text-white italic tracking-tighter">{{ $totalEvents }}</h2>
                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2"/></svg>
                </div>
            </div>
        </div>

      
        <div class="glass-card p-8 rounded-[2.5rem] border-[#0070FF]/30 bg-[#0070FF]/5 relative group overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#0070FF]/10 blur-2xl rounded-full"></div>
            <p class="text-[9px] font-black text-[#0070FF] uppercase tracking-[0.2em] mb-4">Active Sessions</p>
            <div class="flex items-end justify-between">
                <h2 class="text-5xl font-black text-white italic tracking-tighter">{{ $liveEvents->count() }}</h2>
                <div class="flex h-3 w-3 mb-2">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </div>
            </div>
        </div>

        
        <div class="glass-card md:col-span-2 p-8 rounded-[2.5rem] border-white/5 flex items-center justify-between">
            <div>
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Total Attendee</p>
                <h2 class="text-5xl font-black text-white italic tracking-tighter">{{ number_format($totalAttendees) }}</h2>
            </div>
            <div class="flex -space-x-4">
                
               
            </div>
        </div>
    </div>

   
    <div class="space-y-12">
        <h3 class="text-xs font-black text-white uppercase tracking-[0.5em] flex items-center gap-4">
            Active Streams 
            <span class="h-px flex-1 bg-gradient-to-r from-white/10 to-transparent"></span>
        </h3>

        @forelse($liveEvents as $event)
            @php
                $checkedInCount = $event->registrations->whereNotNull('checked_in_at')->count();
                $totalCount = $event->registrations_count;
                $progress = ($totalCount > 0) ? ($checkedInCount / $totalCount) * 100 : 0;
            @endphp

            <div class="group relative">
               
                <div class="glass-card rounded-[3rem] border-white/10 overflow-hidden transition-all duration-500 hover:shadow-[0_0_50px_rgba(0,112,255,0.1)]">
                    
                   
                    <div class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-white/5">
                        
                        
                        <div class="lg:w-1/3 p-10 bg-white/[0.02]">
                            <div class="w-20 h-20 rounded-3xl overflow-hidden mb-8 shadow-2xl group-hover:scale-105 transition-transform">
                                <img src="{{ asset('storage/' . $event->event_poster) }}" class="w-full h-full object-cover">
                            </div>
                            <h4 class="text-3xl font-black text-white tracking-tighter uppercase mb-2">{{ $event->title }}</h4>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#0070FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                                {{ $event->address }}, {{$event->city}}
                            </p>
                            
                            <div class="mt-10 p-6 rounded-3xl bg-black/40 border border-white/5">
                                <div class="flex justify-between items-end mb-4">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Live Capacity</p>
                                    <p class="text-xl font-black text-white italic">{{ round($progress) }}%</p>
                                </div>
                                <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#0070FF] shadow-[0_0_15px_#0070FF]" style="width: {{ $progress }}%"></div>
                                </div>
                                <p class="mt-4 text-[10px] font-bold text-slate-600 uppercase tracking-tighter">
                                    {{ $checkedInCount }} Checked in out of {{ $totalCount }}
                                </p>
                            </div>
                        </div>

                       
                        <div class="lg:w-2/3 flex flex-col max-h-[500px]">
                            <div class="p-6 border-b border-white/5 bg-white/[0.01] flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Entry Registry</span>
                                <span class="px-3 py-1 bg-[#0070FF]/10 text-[#0070FF] text-[9px] font-black rounded-full uppercase">{{ $totalCount }} Registered</span>
                            </div>
                            
                            <div class="overflow-y-auto hide-scrollbar flex-1 bg-black/10">
                                <table class="w-full text-left">
                                    <tbody class="divide-y divide-white/5">
                                        @forelse($event->registrations as $reg)
                                            <tr class="hover:bg-white/[0.03] transition-colors group/row">
                                                <td class="px-8 py-4">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-[10px] font-black text-[#0070FF] border border-white/5">
                                                            {{ strtoupper(substr($reg->user->name ?? '?', 0, 2)) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-white group-hover/row:text-[#0070FF] transition-colors">{{ $reg->user->name }}</p>
                                                            <p class="text-[9px] text-slate-500 uppercase font-black tracking-widest">{{ $reg->user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-4 text-right">
                                                    @if($reg->checked_in_at)
                                                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/5 border border-green-500/20 rounded-xl">
                                                            <div class="w-1 h-1 rounded-full bg-green-500"></div>
                                                            <span class="text-[9px] font-black text-green-500 uppercase tracking-widest">Validated {{ $reg->checked_in_at }}</span>
                                                        </div>
                                                  
                                                       
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="px-8 py-20 text-center text-slate-600 font-black text-[10px] uppercase tracking-[0.3em]">No Manifest Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card rounded-[3rem] p-32 text-center border-dashed border-white/10">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-700">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2"/></svg>
                </div>
                <h4 class="text-white font-black uppercase tracking-[0.2em]">Operational Silence</h4>
                <p class="text-slate-500 text-sm mt-4 font-medium max-w-xs mx-auto">Launch an experience from your command center to begin real-time tracking.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(0, 112, 255, 0.1); border-radius: 10px; transition: all 0.3s; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(0, 112, 255, 0.3); }
</style>
@endsection
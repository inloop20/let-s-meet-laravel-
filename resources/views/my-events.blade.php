@extends('layouts.app')

@push('styles')
    <style>
        .glass-card {
            background: rgba(15, 20, 25, 0.75);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(21, 96, 189, 0.25);
        }


        .pagination-container nav div:first-child {
            display: none;
        }

        .pagination-container a,
        .pagination-container span {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 12px !important;
            margin: 0 4px !important;
            padding: 8px 16px !important;
        }

        .pagination-container .active span {
            background: #0070FF !important;
            border-color: #0070FF !important;
        }

        .modal-container {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-container:target {
            display: flex !important;
            opacity: 1;
        }

        body:has(.modal-container:target) {
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-10">
            <div>
                <h1 class="text-6xl font-black text-white tracking-tighter uppercase leading-tight">
                    MY <span class="text-[#0070FF]">DASHBOARD.</span>
                </h1>
                <p class="text-slate-500 font-medium mt-2">
                    {{ request('tab') === 'registered' ? 'Experiences you are attending.' : 'Experiences you have created.' }}
                </p>
            </div>

            <form action="{{ route('myEvents') }}" method="GET"
                class="glass-card flex items-center px-4 py-2 rounded-2xl w-full md:w-96 shadow-xl">
                <input type="hidden" name="tab" value="{{ request('tab', 'hosting') }}">
                <button type="submit" class="p-2 hover:text-[#0070FF] text-slate-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                </button>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..."
                    class="bg-transparent border-none outline-none text-white font-medium w-full placeholder:text-slate-600 py-3">
            </form>
        </div>

        <div class="flex gap-4 mb-12 border-b border-white/5 pb-6">
            <a href="{{ route('myEvents', ['tab' => 'hosting']) }}"
                class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('tab', 'hosting') === 'hosting' ? 'bg-[#0070FF] text-white shadow-lg shadow-[#0070FF]/20' : 'bg-white/5 text-slate-500 hover:bg-white/10' }}">
                Events I'm Hosting
            </a>
            <a href="{{ route('myEvents', ['tab' => 'registered']) }}"
                class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('tab') === 'registered' ? 'bg-[#0070FF] text-white shadow-lg shadow-[#0070FF]/20' : 'bg-white/5 text-slate-500 hover:bg-white/10' }}">
                Events I'm Attending
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($myEvents as $event)
                <div
                    class="glass-card rounded-[2.5rem] p-3 group transition-all duration-500 hover:-translate-y-2 border-transparent hover:border-[#0070FF]/50">
                    <div class="relative h-56 w-full overflow-hidden rounded-[2rem] mb-6">
                        <img src="{{ asset('storage/' . $event->event_poster) }}" alt="Poster"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-5 left-5">
                            <span
                                class="px-3 py-1 bg-white/10 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/10">
                                {{ $event->city }}
                            </span>
                        </div>
                    </div>

                    <div class="px-4 pb-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-[#0070FF]"></span>
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-4 truncate">{{ $event->title }}</h3>

                        <div class="flex items-center justify-between pt-6 border-t border-white/5">
                            <div class="flex flex-col">
                                <span
                                    class="text-[8px] font-black text-slate-600 uppercase tracking-[0.2em]">Capacity</span>
                                <span
                                    class="text-lg font-black text-white">{{ $event->registrations_count }}/{{ $event->ticket_capacity }}</span>
                            </div>

                            <div class="flex gap-2">
                                @if (request('tab', 'hosting') === 'hosting')
                                    <a href="{{ route('events.edit', $event->id) }}"
                                        class="px-6 py-3 bg-[#0070FF] text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white hover:text-black transition-all">
                                        Manage
                                    </a>
                                @else
                                    <a href="#ticket-{{ $event->id }}"
                                        class="px-6 py-3 bg-white/10 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0070FF] transition-all">
                                        View Ticket
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center glass-card rounded-[3rem]">
                    @if (request('tab') === 'registered')
                        <div
                            class="bg-amber-500/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-amber-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"
                                    stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Your calendar is empty</h3>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">You haven't registered for any events yet. Start
                            exploring the latest experiences!</p>
                        <a href="{{ route('allEvents') }}"
                            class="px-8 py-4 bg-[#0070FF] text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all">
                            Explore Events
                        </a>
                    @else
                        <div
                            class="bg-[#0070FF]/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-[#0070FF]">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No hosted events</h3>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">You haven't created any events yet. Why not host
                            your own experience today?</p>
                        <a href="{{ route('event.create') }}"
                            class="px-8 py-4 bg-white text-black text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#0070FF] hover:text-white transition-all">
                            + Host New Event
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <div class="pagination-container mt-16 flex justify-center">
            {{ $myEvents->appends(request()->query())->links() }}
        </div>
    </div>

    @foreach ($myEvents as $event)
        @if (request()->input('tab') === 'registered')
            <div id="ticket-{{ $event->id }}"
                class="modal-container fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm opacity-0 pointer-events-none target:opacity-100 target:pointer-events-auto transition-all duration-300">

                <a href="#" class="absolute inset-0 cursor-default"></a>

                <div
                    class="glass-card relative w-full max-w-sm overflow-hidden rounded-[3rem] border-[#0070FF]/30 shadow-2xl animate-float">

                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-[#0070FF] rounded-b-3xl z-10"></div>

                    <div class="p-6 pt-10">

                        <div class="flex justify-between items-start mb-6 gap-4">
                            <div class="min-w-0 flex-1">
                                <span class="text-[9px] font-black text-[#0070FF] uppercase tracking-[0.3em]">Official
                                    Entry</span>
                                <h2 class="text-2xl font-black text-white leading-tight mt-1 line-clamp-2"
                                    title="{{ $event->title }}">
                                    {{ $event->title }}
                                </h2>
                            </div>
                            <a href="#"
                                class="text-slate-500 hover:text-white text-3xl leading-none font-bold transition-colors">&times;</a>
                        </div>


                        <div class="space-y-5 mb-8">

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 flex-shrink-0 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 text-[#0070FF]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Date & Time
                                    </p>
                                    <p class="text-white text-xs font-bold leading-relaxed">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('D, M d, Y') }}<br>
                                        <span
                                            class="text-[#0070FF]">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 flex-shrink-0 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 text-[#0070FF]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                            stroke-width="2" stroke-linecap="round" />
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Location</p>
                                    <p class="text-white text-xs font-bold leading-snug line-clamp-2 mb-2">
                                        {{ $event->address }}, {{ $event->city }}
                                    </p>

                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->address . ' ' . $event->city) }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#0070FF]/10 border border-[#0070FF]/20 rounded-lg text-[9px] font-black text-[#0070FF] uppercase tracking-wider hover:bg-[#0070FF] hover:text-white transition-all">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        View Map
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="relative h-px w-full border-t border-dashed border-white/20 mb-8">
                            <div class="absolute -left-10 -top-3 w-6 h-6 bg-black rounded-full shadow-inner"></div>
                            <div class="absolute -right-10 -top-3 w-6 h-6 bg-black rounded-full shadow-inner"></div>
                        </div>

                        <div class="text-center">
                            <div
                                class="inline-block p-3 bg-white rounded-3xl mb-4 shadow-[0_0_30px_rgba(255,255,255,0.1)] transition-transform hover:scale-105">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://192.168.100.56:8000/check-in/{{ $event->id }}/{{ Auth::id() }}"
                                    alt="QR Code" class="w-28 h-28">
                            </div>

                        </div>
                    </div>


                    <div class="bg-[#0070FF] py-3 text-center">
                        <p class="text-[9px] font-black text-white uppercase tracking-[0.4em]">Non-Transferable Official
                            Pass</p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

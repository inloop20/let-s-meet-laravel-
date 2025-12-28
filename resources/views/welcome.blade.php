@extends('layouts.app')

@push('styles')
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .glass-card {
            background: rgba(15, 20, 25, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(21, 96, 189, 0.2);
        }

        .event-card:hover {
            transform: translateY(-8px);
            border-color: #0070FF;
            box-shadow: 0 20px 40px rgba(0, 112, 255, 0.15);
        }

        .modal-container {
            display: none;
        }

        .modal-container:target {
            display: flex !important;
        }

        body:has(.modal-container:target) {
            overflow: hidden;
        }
    </style>
@endpush

@section('title', "Let's Meet")

@section('content')

    @if (session('success'))
        <div
            class="fixed top-20 right-6 z-50 bg-green-500/10 border border-green-500/30 text-green-500 px-6 py-4 rounded-2xl font-bold shadow-lg text-sm max-w-xs flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()"
                class="ml-4 text-green-500 hover:text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div
            class="fixed top-20 right-6 z-50 bg-red-500/10 border border-red-500/30 text-red-500 px-6 py-4 rounded-2xl font-bold shadow-lg text-sm max-w-xs flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()"
                class="ml-4 text-red-500 hover:text-red-700 font-bold">&times;</button>
        </div>
    @endif


    <section class="relative pt-14 pb-16 px-6 overflow-hidden">
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#0070FF]/10 blur-[150px] rounded-full -z-10 animate-float">
        </div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/5 blur-[150px] rounded-full -z-10 animate-float"
            style="animation-delay: -2s"></div>

        <div class="max-w-4xl mx-auto text-center relative">
            <h1 class="text-6xl md:text-7xl font-black text-white mb-6 tracking-tighter leading-tight">
                CONNECT WITH <br /><span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-[#0070FF] to-cyan-400">YOUR PEOPLE.</span>
            </h1>
            <p class="text-lg text-slate-400 mb-12 max-w-2xl mx-auto font-medium">
                The all-in-one platform for creating, discovering, and managing world-class events.
            </p>

            
          <x-search-bar :categories="$categories" class="mb-12"/>

        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black tracking-tight text-white uppercase">Featured <span
                        class="text-[#0070FF]">Experience</span></h2>
                <p class="text-slate-500 font-medium">Curated events picking up steam this week.</p>
            </div>
            <a href="{{route('allEvents')}}"
                class="text-xs font-black tracking-[0.2em] text-[#0070FF] uppercase border-b-2 border-[#0070FF]/20 pb-1 hover:border-[#0070FF] transition-all">Browse
                all</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if ($events->isEmpty())
                <div class="col-span-full text-center py-20 bg-white/5 rounded-3xl">
                    <h3 class="text-xl font-black text-white mb-2">No Events Found</h3>
                    <p class="text-slate-400 font-medium">We couldn't find any events at the moment. Please check back later
                        or explore other categories.</p>
                </div>
            @endif
           <x-card :events="$events"/>
    </main>

    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-xs font-black tracking-[0.3em] text-slate-500 uppercase mb-8 text-center">Explore by Interest</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $topics = [
                    [
                        "id" => 1,
                        'name' => 'Technology',
                        'img' =>
                            'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80',
                    ],
                    [
                         "id" => 2,
                        'name' => 'Music',
                        'img' =>
                            'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80',
                    ],
                    [
                         "id" => 3,
                        'name' => 'Networking',
                        'img' =>
                            'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80',
                    ],
                    [
                         "id" => 4,
                        'name' => 'Design',
                        'img' =>
                            'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?auto=format&fit=crop&q=80',
                    ],
                ];
            @endphp
            @foreach ($topics as $topic)
                <a href="/events?search=&city=&category={{$topic['id']}}" class="group relative h-40 overflow-hidden rounded-3xl">
                    <img src="{{ $topic['img'] }}"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 grayscale group-hover:grayscale-0">
                    <div class="absolute inset-0 bg-black/60 group-hover:bg-black/20 transition-all"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        
                        <span class="text-white font-black uppercase tracking-widest text-sm">{{ $topic['name'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>


    <section class="max-w-5xl mx-auto px-6 py-24">
        <div class="glass-card rounded-[3rem] p-8 md:p-16 text-center relative overflow-hidden border-[#0070FF]/30">
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-[#0070FF]/20 blur-[80px] rounded-full"></div>

            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">BECOME THE <span
                    class="text-[#0070FF]">HOST.</span></h2>
            <p class="text-slate-400 mb-10 max-w-lg mx-auto font-medium">
                From local meetups to global conferences. We provide the tools to sell tickets, manage check-ins, and grow
                your community.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <button onclick="window.location.href='/create-event'"
                    class="w-full sm:w-auto px-10 py-5 bg-white text-black rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-[#0070FF] hover:text-white transition-all shadow-xl">
                    Create Event
                </button>
                <button
                    class="w-full sm:w-auto px-10 py-5 bg-white/5 text-white border border-white/10 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-white/10 transition-all">
                    Learn More
                </button>
            </div>
        </div>
    </section>



@endsection

@extends('layouts.app')

@section('title', "Discover Events | Let's Meet")

@push('styles')
<style>
  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
  }

  .hide-scrollbar::-webkit-scrollbar { display: none; }
  .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

  .animate-float { animation: float 6s ease-in-out infinite; }

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

  
  select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3 camp%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.25rem;
  }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#05080a] text-white">
    
    <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-[#0070FF]/5 blur-[150px] rounded-full -z-10 animate-float"></div>
    <div class="fixed bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/5 blur-[150px] rounded-full -z-10 animate-float" style="animation-delay: -2s"></div>

    <section class="relative pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-black text-white mb-4 tracking-tighter">
                DISCOVER <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0070FF] to-cyan-400">EXPERIENCES.</span>
            </h1>
            <p class="text-slate-400 mb-12 font-medium">Browse all upcoming events, workshops, and meetups.</p>
            <div class="max-w-4xl mx-auto">
                
                <x-search-bar :categories="$categories"/>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-10">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
       <x-card :events="$events"/>
          </div>
        <div class="mt-20">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </main>
</div>
@endsection
@extends('layouts.app')
@section('content')
    <div class="min-h-[80vh] flex items-center justify-center px-6">
        <div
            class="glass-card w-full max-w-sm rounded-[3rem] p-10 text-center border-2 
        @if ($status === 'success') border-green-500/50 @elseif($status === 'warning') border-amber-500/50 @else border-red-500/50 @endif">

            <div
                class="w-24 h-24 rounded-full mx-auto mb-8 flex items-center justify-center
            @if ($status === 'success') bg-green-500/20 text-green-500 @elseif($status === 'warning') bg-amber-500/20 text-amber-500 @else bg-red-500/20 text-red-500 @endif">
                @if ($status === 'success')
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                @elseif($status === 'warning')
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                            stroke-width="2" stroke-linecap="round" />
                    </svg>
                @else
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                @endif
            </div>

            <h1 class="text-3xl font-black text-white uppercase tracking-tighter mb-2">
                @if ($status === 'success')
                    Access Granted
                @elseif($status === 'warning')
                    Already Scanned
                @else
                    Access Denied
                @endif
            </h1>

            <p class="text-slate-400 font-medium mb-8">{{ $message }}</p>

            <div class="pt-8 border-t border-white/10">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Event</p>
                <p class="text-white font-bold">{{ $event->title }}</p>
            </div>

            <a href="{{ route('myEvents') }}"
                class="mt-10 inline-block text-[#0070FF] font-black text-xs uppercase tracking-widest border-b-2 border-[#0070FF]/20 pb-1">
                Back to Events
            </a>
        </div>
    </div>
@endsection

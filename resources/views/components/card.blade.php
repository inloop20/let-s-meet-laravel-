@props(['events'])
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@push('style')
    <style>
        .leaflet-tile {
            filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) opacity(0.7);
        }

        .leaflet-container {
            background: #0f1419;
        }
    </style>
@endpush

@foreach ($events as $event)
    <div class="event-card group flex flex-col glass-card rounded-[2.5rem] p-3 transition-all duration-500">
        <div class="relative h-64 w-full overflow-hidden rounded-[2rem] mb-6">
            <img src="{{ asset('storage/' . $event->event_poster) }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-[#05080a] via-transparent to-transparent opacity-60">
            </div>
            <div class="absolute top-5 left-5">
                <span
                    class="px-4 py-1.5 bg-[#0070FF] text-[10px] font-black uppercase tracking-widest rounded-full shadow-xl">Trending</span>
            </div>

        </div>
        <div class="px-4 pb-4">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $event->start_time }}
                    • </span>
                <div class="flex items-center gap-1 text-slate-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">{{ $event->city }}</span>
                </div>
            </div>

            <h3 class="text-xl font-bold text-white mb-3 leading-tight group-hover:text-[#0070FF] transition-colors">
                {{ $event->title }}</h3>
            <p class="text-sm text-slate-500 font-medium mb-6 line-clamp-2">{{ $event->description }}</p>
            <div class="flex items-center justify-between pt-6 border-t border-white/5">
                <div>
                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Attendees
                    </p>
                    <p class="text-lg font-black text-white">{{ $event->registrations_count }} /
                        {{ $event->ticket_capacity }}</p>
                </div>
                <a href="#event-details-{{ $event->id }}"
                    class="px-6 py-3 bg-white hover:bg-[#0070FF] hover:text-white text-black rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all">View
                    Details</a>
            </div>
        </div>
    </div>

    <div id="event-details-{{ $event->id }}"
        class="modal-container fixed inset-0 z-[100] items-center justify-center p-4 bg-black/80 backdrop-blur-sm transition-all">
        <a href="#!" class="absolute inset-0 cursor-default"></a>

        <div
            class="glass-card w-full max-w-2xl max-h-[90vh] rounded-[2.5rem] relative flex flex-col overflow-hidden shadow-2xl">

            <div class="h-48 md:h-64 w-full shrink-0 relative">
                <img src="{{ asset('storage/' . $event->event_poster) }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1419] to-transparent"></div>
                <a href="#!"
                    class="absolute top-6 right-6 w-10 h-10 bg-black/50 hover:bg-white hover:text-black rounded-full flex items-center justify-center text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                </a>
            </div>

            <div class="p-8 overflow-y-auto hide-scrollbar">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-md border 
         {{ $event->registrations_count < $event->ticket_capacity
             ? 'bg-green-500/10 text-green-500 border-green-500/20'
             : 'bg-red-500/10 text-red-500 border-red-500/20' }}">
                        {{ $event->registrations_count < $event->ticket_capacity ? 'Tickets Available' : 'Sold Out' }}
                    </span>

                    <span
                        class="px-3 py-1 bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-md border border-white/10">{{ $event->category->name }}</span>
                </div>

                <h2 class="text-4xl font-black text-white mb-8 leading-tight tracking-tighter">
                    {{ $event->title }}
                </h2>

                <div class="grid grid-cols-2 gap-4 mb-10">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] mb-1">Start
                            Date</p>
                        <p class="text-white font-bold text-sm">{{ $event->start_time }} </p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] mb-1">End
                            Date</p>
                        <p class="text-white font-bold text-sm"> {{ $event->end_time }}</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] mb-1">
                            Location</p>
                        <p class="text-white font-bold text-sm">{{ $event->city }}</p>
                        <p class="text-slate-400 text-xs">{{ $event->address }}</p>

                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] mb-1">
                            Attendees</p>
                        <p class="text-white font-bold text-sm">{{ $event->registrations_count }} Participants
                        </p>
                    </div>

                </div>

               
                <div class="col-span-2 mt-4">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] mb-2">Event Location Map
                    </p>
                    <div id="map-{{ $event->id }}" class="w-full h-48 rounded-2xl border border-white/10 z-0"></div>
                </div>

                <div class="space-y-6">
                    <h4
                        class="text-white font-black uppercase tracking-widest text-xs border-l-2 border-[#0070FF] pl-3">
                        About the Experience</h4>
                    <p class="text-slate-400 font-medium leading-relaxed">
                        {{ $event->description }}
                    </p>
                    @if ($event->important_note)
                        <div class="p-5 bg-amber-500/10 border border-amber-500/20 rounded-2xl">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                        stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <div>
                                    <p class="text-amber-500 text-xs font-black uppercase tracking-widest mb-1">
                                        Important Note</p>
                                    <p class="text-slate-300 text-sm">{{ $event->important_note }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-12 pt-8 border-t border-white/5 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-[#0070FF] to-cyan-500 flex items-center justify-center font-black text-white">
                        {{ substr($event->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Hosted by
                        </p>
                        <p class="text-white font-bold">{{ $event->user->name }}</p>
                    </div>
                </div>

            </div>

            <div class="p-6 border-t border-white/5 bg-black/20 flex items-center justify-between">
                <div>
                    <span class="block text-[10px] font-black text-slate-600 uppercase tracking-widest">Attendees</span>
                    <span class="text-2xl font-black text-white">{{ $event->registrations_count }}</span>
                </div>
                @php
                    $isRegistered = $event->registrations()->where('user_id', Auth::id())->exists();
                    $isSoldOut = $event->registrations()->count() >= $event->ticket_capacity;
                @endphp
                <form action="{{ route('event.register', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all
            {{ $isSoldOut || $isRegistered ? 'bg-gray-500 cursor-not-allowed' : 'bg-[#0070FF] hover:bg-white hover:text-black' }}"
                        {{ $isSoldOut || $isRegistered ? 'disabled' : '' }}>
                        @if ($isRegistered)
                            Already Subscribed
                        @elseif($isSoldOut)
                            Sold Out
                        @else
                            Secure Ticket
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($events as $event)
            (function() {

                const lat = {{ $event->latitude ?? 0 }};
                const lng = {{ $event->longitude ?? 0 }};

                if (lat !== 0 && lng !== 0) {
                    const mapId = 'map-{{ $event->id }}';
                    const map = L.map(mapId, {
                        zoomControl: false,

                    }).setView([lat, lng], 12);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);


                    const customIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:#0070FF; width:12px; height:12px; border-radius:50%; border:2px solid white; box-shadow: 0 0 10px #0070FF;'></div>",
                        iconSize: [12, 12],
                        iconAnchor: [6, 6]
                    });

                    L.marker([lat, lng], {
                        icon: customIcon
                    }).addTo(map);


                    window.addEventListener('hashchange', function() {
                        if (window.location.hash === '#event-details-{{ $event->id }}') {
                            setTimeout(() => {
                                map.invalidateSize();
                            }, 200);
                        }
                    });


                    if (window.location.hash === '#event-details-{{ $event->id }}') {
                        setTimeout(() => {
                            map.invalidateSize();
                        }, 200);
                    }
                }
            })();
        @endforeach
    });
</script>

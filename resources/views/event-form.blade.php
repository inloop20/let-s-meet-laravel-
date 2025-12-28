@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .leaflet-tile-container {
            filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
        }

        .leaflet-container {
            background: #05080a !important;
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .leaflet-control-attribution {
            display: none;
        }


        .form-input:focus {
            border-color: #0070FF;
            box-shadow: 0 0 20px rgba(0, 112, 255, 0.2);
            outline: none;
        }

        .glass-input {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .input-error {
            border-color: rgba(239, 68, 68, 0.5) !important;
        }


        .suggestions-wrapper {
            position: relative;
        }

        #suggestions-list {
            position: absolute;
            top: 110%;
            left: 0;
            right: 0;
            background: rgba(17, 24, 39, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            z-index: 1000;
            display: none;
            max-height: 250px;
            overflow-y: auto;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        }

        .suggestion-item {
            padding: 1.25rem;
            cursor: pointer;
            color: #cbd5e1;
            font-size: 0.75rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s;
        }

        .suggestion-item:hover {
            background: #0070FF;
            color: white;
        }

        .scrollbar-hide::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }
    </style>
@endpush

@section('content')
    @php $isEdit = request()->routeIs('events.edit'); @endphp

    <div class="max-w-6xl mx-auto px-6 py-16">
        <div class="mb-12">
            <span class="text-[#0070FF] font-black uppercase tracking-[0.3em] text-[10px]">Creator Studio</span>
            <h1 class="text-5xl font-black text-white leading-tight tracking-tighter mt-2">
                {{ $isEdit ? 'Modify' : 'Deploy' }} <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-[#0070FF] to-cyan-400">Experience</span>
            </h1>
        </div>

        <form action="{{ $isEdit ? route('events.update', $event->id) : route('events.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <div class="lg:col-span-7 space-y-8">
                    <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 space-y-6">
                        <h2
                            class="text-white font-black uppercase tracking-widest text-xs border-l-2 border-[#0070FF] pl-3">
                            General Information</h2>

                        <div>
                            <label
                                class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">Experience
                                Title</label>
                            <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}"
                                class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input @error('title') input-error @enderror"
                                placeholder="Give it a bold name...">
                            @error('title')
                                <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">Start
                                    Time</label>
                                <input type="datetime-local" name="start_time"
                                    value="{{ old('start_time', isset($event) ? date('Y-m-d\TH:i', strtotime($event->start_time)) : '') }}"
                                    class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input @error('start_time') input-error @enderror">
                                @error('start_time')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">End
                                    Time</label>
                                <input type="datetime-local" name="end_time"
                                    value="{{ old('end_time', isset($event) ? date('Y-m-d\TH:i', strtotime($event->end_time)) : '') }}"
                                    class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input @error('end_time') input-error @enderror">
                                @error('end_time')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">Ticket
                                    Capacity</label>
                                <input min="1" type="number" name="ticket_capacity"
                                    value="{{ old('ticket_capacity', $event->ticket_capacity ?? 1) }}"
                                    class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input @error('ticket_capacity') input-error @enderror">
                                @error('ticket_capacity')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">Category</label>
                                <select name="category_id"
                                    class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input appearance-none">
                                    <option value="">Select Category</option>
                                    @foreach ([1 => 'Technology', 2 => 'Music', 3 => 'Networking', 4 => 'Design'] as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('category_id', $event->category_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('capacity_id')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 space-y-6">
                        <h2
                            class="text-white font-black uppercase tracking-widest text-xs border-l-2 border-[#0070FF] pl-3">
                            Experience Content</h2>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">Detailed
                                Description</label>
                            <textarea name="description" rows="4"
                                class="w-full p-5 glass-input rounded-2xl text-white font-medium form-input @error('description') input-error @enderror"
                                placeholder="What happens in this experience?">{{ old('description', $event->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-widest">Important
                                Note (Optional)</label>
                            <textarea name="important_note" rows="2"
                                class="w-full p-5 glass-input rounded-2xl text-white font-medium form-input border-dashed @error('important_note') input-error @enderror"
                                placeholder="Entry requirements, dress code, etc...">{{ old('important_note', $event->important_note ?? '') }}</textarea>
                            @error('important_note')
                                <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="lg:col-span-5 space-y-8">
                    <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 space-y-6">
                        <h2
                            class="text-white font-black uppercase tracking-widest text-xs border-l-2 border-[#0070FF] pl-3">
                            Location Engine</h2>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-widest pl-1">Target
                                    City</label>
                                <input type="text" name="city" id="city-input"
                                    value="{{ old('city', $event->city ?? '') }}" placeholder="City name"
                                    class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input @error('city') input-error @enderror">
                                @error('city')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="suggestions-wrapper">
                                <label
                                    class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-widest pl-1">Street
                                    Address</label>
                                <input type="text" id="address-input" name="address"
                                    value="{{ old('address', $event->address ?? '') }}"
                                    placeholder="Search or type address..." autocomplete="off"
                                    class="w-full p-5 glass-input rounded-2xl text-white font-bold form-input @error('address') input-error @enderror">
                                @error('address')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                                <div id="suggestions-list" class="scrollbar-hide"></div>
                            </div>
                        </div>

                        <div id="map" class="h-[280px] w-full mt-4 ring-1 ring-white/10"></div>

                        <input type="hidden" name="latitude" id="lat-input"
                            value="{{ old('latitude', $event->latitude ?? '') }}">
                        <input type="hidden" name="longitude" id="lng-input"
                            value="{{ old('longitude', $event->longitude ?? '') }}">
                    </div>

                    <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 space-y-4">
                        <h2
                            class="text-white font-black uppercase tracking-widest text-xs border-l-2 border-[#0070FF] pl-3">
                            Visual Identity</h2>
                        <input type="file" name="event_poster" id="poster-upload" class="hidden">
                        <label for="poster-upload"
                            class="cursor-pointer block border-2 border-dashed border-white/10 rounded-[2rem] p-8 hover:bg-white/5 transition-all text-center">
                            <div id="poster-preview">
                                @if (isset($event) && $event->event_poster)
                                    <img src="{{ asset('storage/' . $event->event_poster) }}"
                                        class="mx-auto object-cover rounded-2xl shadow-2xl">
                                @else
                                    <div class="py-4">
                                        <div class="mb-2 text-[#0070FF]"><i class="fas fa-cloud-upload-alt text-2xl"></i>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Upload
                                            Poster</p>
                                    </div>
                                @endif
                                @error('event_poster')
                                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-6 bg-white hover:bg-[#0070FF] text-black hover:text-white rounded-[2rem] font-black uppercase tracking-[0.2em] transition-all transform hover:-translate-y-1 shadow-[0_20px_40px_rgba(0,0,0,0.3)]">
                        {{ $isEdit ? 'Update Event' : 'Create Event' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const initialLat = parseFloat("{{ old('latitude', $event->latitude ?? 24.8607) }}");
            const initialLng = parseFloat("{{ old('longitude', $event->longitude ?? 67.0011) }}");
            const latInput = document.getElementById('lat-input');
            const lngInput = document.getElementById('lng-input');
            const addressInput = document.getElementById('address-input');
            const suggestionsList = document.getElementById('suggestions-list');
            const cityInput = document.getElementById('city-input');

            const map = L.map('map', {
                zoomControl: false
            }).setView([initialLat, initialLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);



            let marker = L.circleMarker([initialLat, initialLng], {
                radius: 12,
                fillColor: "#0070FF",
                color: "#fff",
                weight: 3,
                fillOpacity: 1
            }).addTo(map);

            function updateMarker(lat, lng, fly = true) {
                marker.setLatLng([lat, lng]);
                latInput.value = lat;
                lngInput.value = lng;
                if (fly) map.flyTo([lat, lng], 16);

                fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.address) {
                            cityInput.value = data.address.city || data.address.town || data.address.village ||
                                '';
                            addressInput.value = data.display_name || '';
                            console.log(data.display_name);

                        }
                    });
            }

            map.on('click', e => updateMarker(e.latlng.lat, e.latlng.lng, false));

            let debounce;
            addressInput.addEventListener('input', function() {
                clearTimeout(debounce);
                const query = this.value;
                if (query.length < 3) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                debounce = setTimeout(async () => {
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5`
                        );
                    const data = await response.json();
                    if (data.length > 0) {
                        suggestionsList.innerHTML = data.map(item => `
                        <div class="suggestion-item" onclick="selectLocation('${item.lat}', '${item.lon}', '${item.display_name.replace(/'/g, "\\'")}')">
                            ${item.display_name}
                        </div>
                    `).join('');
                        suggestionsList.style.display = 'block';
                    }
                }, 400);
            });

            window.selectLocation = (lat, lon, name) => {
                addressInput.value = name;
                suggestionsList.style.display = 'none';
                updateMarker(parseFloat(lat), parseFloat(lon));
            };

            document.addEventListener('click', e => {
                if (e.target !== addressInput) suggestionsList.style.display = 'none';
            });

            document.getElementById('poster-upload').onchange = function() {
                const [file] = this.files;
                if (file) {
                    document.getElementById('poster-preview').innerHTML =
                        `<img src="${URL.createObjectURL(file)}" class="mx-auto h-32 w-32 object-cover rounded-2xl">`;
                }
            };
        });
    </script>
@endsection

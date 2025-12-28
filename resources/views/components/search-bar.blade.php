@props(['categories' => []])

<form action="{{ route('allEvents') }}" method="GET"  class ='glass-card p-2 rounded-3xl shadow-2xl'>
    <div class="flex flex-col md:flex-row items-center gap-2">
        <div class="flex-1 flex items-center px-4 gap-3 w-full">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..."
                class="bg-transparent w-full py-4 outline-none text-white font-medium placeholder:text-slate-600">
        </div>

        <div class="block w-px h-8 bg-white/10"></div>

        <div class="flex-1 flex items-center px-4 gap-3 w-full">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" />
                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" />
            </svg>
            <input type="text" name="city" value="{{ request('city') }}" placeholder="Location"
                class="bg-transparent w-full py-4 outline-none text-white font-medium placeholder:text-slate-600">
        </div>

        <div class="hidden md:block w-px h-8 bg-white/10"></div>

        <div class="flex-1 flex items-center px-4 gap-3 w-full relative">
            <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <select name="category" 
                class="bg-transparent w-full py-4 outline-none text-black font-medium appearance-none cursor-pointer">
                <option value="" class="bg-[#0f1419] text-slate-400">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" class="text-black" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <button type="submit"
            class="w-full md:w-auto px-10 py-4 bg-[#0070FF] hover:bg-white hover:text-black rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shrink-0">
            Find Event
        </button>
    </div>
</form>
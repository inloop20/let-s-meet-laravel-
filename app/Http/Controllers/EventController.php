<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EventController extends Controller{
   
    public function checkin(Event $event, User $user){
        try {
        if($event->user_id !== Auth::id()){
            return view("checkin",['status' => 'Unauthorized', 'message' => 'Only the host can scan tickets.', 'event' => $event]);
        }
        $registration = EventRegistration::where('user_id',$user->id)->where('event_id',$event->id)->first();
        
        if(!$registration){
            return view('checkin', ['status' => 'error', 'message' => 'Invalid Ticket!','event' => $event]);
        }
        if ($registration->checked_in_at) {
            return view('checkin', ['status' => 'warning', 'message' => 'Already Scanned at ' . $registration->checked_in_at,'event' => $event,]);
        }
        $registration->update(['checked_in_at' => now()]);
        return view('checkin', ['status' => 'success', 'message' => 'Access Granted for ' . $user->name,'event' => $event,]);
        } catch (\Throwable $th) {
           return view('checkin',['status'=> 'error', 'message' => 'Something went wrong', 'event' => $event]);
        }
    }

    public function allEvents(Request $request){
        $categories = Category::all();
        $query = Event::query()->withCount('registrations');
        
        if ($request->filled('search')) {
            $search = $request->search;
           
                $query->where('title', 'like', "%{$search}%");
            
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', "%{$request->city}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query->latest()->paginate(12);

        return view('events', compact('events', 'categories'));
    }

    public function create(){
        return view('event-form');
    }

    public function edit(Event $event){
        return view('event-form', compact('event'));
    }

    public function register(Event $event){
        try {
            $isRegistered = $event->registrations()->where('user_id', Auth::id())->exists();
            $isSoldOut = $event->registrations()->count() >= $event->ticket_capacity;
            if ($isRegistered) {
                return back()->with('error', 'Already subscribed');
            }
            if ($isSoldOut) {
                return back()->with('error', 'Tickets are sold out!');
            }

            EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
            ]);

            return redirect('/my-events?tab=registered')->back()->with('success', 'Successfully registered!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function getEvents(Event $event){
        $categories = Category::all();
        $events = Event::with(['user', 'category'])
            ->withCount('registrations')
            ->where('end_time',">=",now())
            ->orderBy('registrations_count', 'desc')
            ->orderBy('start_time', 'asc')
            ->limit(3)
            ->get();

        return view('welcome', compact('events', 'categories'));
    }

   public function update(Request $request, Event $event){
    if ($event->user_id !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255|min:3',
        'description' => 'required|string|min:3',
        'event_poster' => 'image|mimes:jpg,jpeg,png|max:2048',
        'city' => 'required|string|max:100',
        'address' => 'required|string|max:255',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'ticket_capacity' => 'required|integer|min:1|max:5000',
        'important_note' => 'nullable|string|max:255',
    ]);
    if ($request->hasFile('event_poster')) {
        $posterPath = $request->file('event_poster')->store('events', 'public');
        $validated['event_poster'] = $posterPath;
    } else {
      
        unset($validated['event_poster']);
    }

    $event->update($validated);

    return redirect()->route('myEvents')->with('success', 'Event updated successfully!');
}

   
    public function destroy(Event $event){
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->delete();
        return redirect()->route('myEvents')->with('success', 'Event deleted permanently.');
    }

    public function myEvents(Request $request, Event $event){
        $search = $request->input('search');
        $tab= $request->input('tab','hosting');

        if($tab==='registered'){
           $eventIds = EventRegistration::where('user_id', Auth::id())
            ->pluck('event_id');

        $myEvents = Event::whereIn('id', $eventIds)
            ->withCount('registrations')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('city', 'LIKE', "%{$search}%");
            })
            ->orderBy('start_time', 'desc')
            ->paginate(10)
            ->withQueryString();
           
        }else {
              $myEvents = Event::where('user_id', Auth::id())
            ->withCount('registrations')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('city', 'LIKE', "%{$search}%");
            })
            ->orderBy('start_time', 'desc')
            ->paginate(10)
            ->withQueryString();
        }
                      
        return view('my-events', compact('myEvents'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:3',
            'city' => 'required|string|max:100|min:3',
            'address' => 'required|string|max:255|min:3',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'event_poster' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:22000',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after_or_equal:start_time',
            'ticket_capacity' => 'required|integer|min:1|max:5000',
            'important_note' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $validated['user_id'] = Auth::id();

        $path = null;

        try {
            if ($request->hasFile('event_poster')) {
                $path = $request->file('event_poster')->store('events', 'public');
                $validated['event_poster'] = $path;
            }

            Event::create($validated);

            return redirect()->route('myEvents')->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
          dd($e);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create event. Please try again.']);
        }
    }
}

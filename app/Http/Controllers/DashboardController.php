<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Event $event)
    {
        $user = Auth::user();
        $totalEvents = Event::where('user_id', $user->id)->count();
        $liveEvents = Event::with('registrations.user')
                           ->withCount('registrations')
                           ->where('user_id', $user->id)
                           ->where('start_time', '>=', now())
                           ->get();
        
      $totalAttendees = Event::where('user_id', Auth::id())
    ->withCount('registrations')
    ->get()
    ->sum('registrations_count');

        return view('dashboard', compact('totalEvents', 'liveEvents', 'totalAttendees','event'));
    }
    public function checkinList(){

    }
}

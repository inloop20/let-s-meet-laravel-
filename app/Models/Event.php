<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
      protected $fillable = [
        'user_id', 'title', 'description', 'city', 'address','latitude','longitude', 
        'category_id', 'event_poster', 'start_time', 'end_time', 
        'ticket_capacity', 'important_note'
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
{
    return $this->hasMany(EventRegistration::class);
}


    
}

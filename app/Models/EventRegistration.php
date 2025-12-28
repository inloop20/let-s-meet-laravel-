<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $table = 'event_registrations'; 
    protected $fillable = ['event_id', 'user_id', 'checked_in_at'];

    public function user()
{
    return $this->belongsTo(User::class);
}

}

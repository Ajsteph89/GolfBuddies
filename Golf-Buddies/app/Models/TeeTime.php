<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TeeTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',
        'scheduled_at',
        'notes',
        'max_players',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}

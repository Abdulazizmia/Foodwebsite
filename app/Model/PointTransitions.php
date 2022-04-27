<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PointTransitions extends Model
{
    protected $casts = [
        'amount' => 'float',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    protected $table = "point_transitions";

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'user_id',
        'linenotifytoken_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function linenotifytoken()
    {
        return $this->belongsTo('App\Models\LineNotifyToken');
    }
}

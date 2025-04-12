<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'newsletter_id'
    ];

    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }
}

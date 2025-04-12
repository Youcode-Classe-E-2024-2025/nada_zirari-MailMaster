<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'subject',
        'content',
        'newletter_id'
    ];

    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['expired_count','sync_date'];

    public function scopeLastRecord($query)
    {
        return $query->orderBy('sync_date','desc');
    }

    public function app()
    {
        return $this->belongsTo();
    }
}

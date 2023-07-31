<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'platform_id'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function expiredSubscription()
    {
        return $this->hasMany(ExpiredSubscription::class);
    }
}

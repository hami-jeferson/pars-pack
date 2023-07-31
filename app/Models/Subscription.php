<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'app_id', 'previous_status'];

    public function app()
    {
        return $this->belongsTo(App::class);
    }
}

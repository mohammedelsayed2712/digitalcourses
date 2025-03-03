<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    protected $with = ['courses'];

    public function scopeSession()
    {
        return $this->where('session_id', session()->getId());
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}

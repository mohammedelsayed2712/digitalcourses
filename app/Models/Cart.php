<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guraded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}

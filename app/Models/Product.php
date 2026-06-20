<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Season;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'image_path', 'description'];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'category_id',
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

}

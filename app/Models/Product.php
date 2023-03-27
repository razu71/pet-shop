<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'category_uuid',
        'title',
        'price',
        'description',
        'metadata',
        'deleted_at',
    ];

    public function category() {
        return $this->belongsTo(Category::class,'category_uuid','uuid');
    }

    public function metadata(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, TRUE),
            set: fn ($value) => json_encode($value, TRUE),
        );
    }
}

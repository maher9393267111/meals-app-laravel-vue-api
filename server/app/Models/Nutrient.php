<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\UnitEnum;

class Nutrient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'carbs_in_hundred',
        'unit',
        'standard_amount',
        'favourite_order'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function meal()
    {
        return $this->belongsToMany(Meal::class)->withTimestamps();
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'unit' => UnitEnum::class,
    ];
}

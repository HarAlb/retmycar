<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
}

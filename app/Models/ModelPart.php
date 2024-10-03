<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPart extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [
        'id'
    ];
    public function parts()
    {
        return $this->hasMany(Part::class, 'model_part_id');
    }

    public function areaPart()
    {
        return $this->hasMany(AreaPart::class, 'model_part_id');
    }

}

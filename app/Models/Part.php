<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [
        'id'
    ];
    public function modelPart()
    {
        return $this->belongsTo(ModelPart::class, 'model_part_id');
    }

    public function areaPart()
    {
        return $this->hasMany(AreaPart::class, 'part_id');
    }

    public function partArea()
    {
        return $this->hasMany(PartArea::class, 'part_id');
    }
}

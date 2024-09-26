<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
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
}

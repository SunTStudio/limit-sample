<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaPart extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function modelPart()
    {
        return $this->belongsTo(ModelPart::class, 'model_part_id');
    }

    public function parts()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }
}

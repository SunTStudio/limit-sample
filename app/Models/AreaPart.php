<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaPart extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [
        'id'
    ];

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function modelPart()
    {
        return $this->belongsTo(ModelPart::class, 'model_part_id');
    }

    public function parts()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }

    public function partArea()
    {
        return $this->belongsTo(PartArea::class, 'part_area_id');
    }
}

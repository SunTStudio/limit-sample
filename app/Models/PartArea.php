<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartArea extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function parts()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }

    public function areaPart()
    {
        return $this->hasMany(AreaPart::class, 'part_area_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundraisingPhase extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable =[
        'fundraising_id',
        'name',
        'photo',
        'notes',
    ];

    public function fundraising():BelongsTo {
        return $this->belongsTo(Fundraising::class);
    }
}

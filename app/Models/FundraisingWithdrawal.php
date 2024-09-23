<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FundraisingWithdrawal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'fundraising_id',
        'fundraiser_id',
        'has_received',
        'has_sent',
        'amount_requested',
        'amount_received',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'proof',
    ];

    public function fundraising():BelongsTo {
        return $this->belongsTo(Fundraising::class);
    }

    public function fundraiser():BelongsTo {
        return $this->belongsTo(Fundraiser::class);
    }
}

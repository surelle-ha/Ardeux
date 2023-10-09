<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status',
        'tokenCount',
        'type',
        'transaction',
        'previousSupply',
        'newSupply',
        'error',
        'timestampRequested',
        'timestampCompleted',
    ];
}

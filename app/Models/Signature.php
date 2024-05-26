<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signature extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'signature';

    protected $fillable = [
        'user_id',
        'description',
        'due_date',
        'amount',
        'status_invoice',
    ];
}

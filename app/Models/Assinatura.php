<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assinatura extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'descricao',
        'vencimento',
        'valor',
        'status_fatura',
    ];
}

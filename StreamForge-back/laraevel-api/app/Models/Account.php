<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    protected $fillable = [
        'account_email',
        'account_password',
        'account_type'
    ];
    
}

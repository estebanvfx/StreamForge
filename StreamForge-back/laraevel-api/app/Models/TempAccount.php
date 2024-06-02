<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAccount extends Model
{
    use HasFactory;

    protected $table = 'temp_accounts';

    protected $fillable = [
        'account_email',
        'account_password',
        'account_type'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = ['type', 'name', 'phone', 'email', 'product', 'quantity', 'message', 'attachment', 'is_read'];
}

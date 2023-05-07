<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenPositions extends Model
{
    use HasFactory;
    protected $table = 'open_positions';
    protected $guarded = [];

}

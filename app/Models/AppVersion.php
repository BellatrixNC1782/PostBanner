<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    use HasFactory;
    
    protected $table = 'app_versions';
    protected $fillable = ['platform', 'min_version', 'max_version', 'force_update'];
}

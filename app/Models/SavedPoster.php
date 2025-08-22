<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Common;

class SavedPoster extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'saved_posters';
    
}

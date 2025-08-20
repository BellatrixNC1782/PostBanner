<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Common;

class BusinessProfile extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'business_details';
    
}

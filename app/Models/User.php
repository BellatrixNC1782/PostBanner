<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use DB;
use DateTime;

class User extends Authenticatable implements JWTSubject,Auditable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'email',
    ];

    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    } 
    
    public static function getUser($table_name, $datatable_fields, $conditions_array, $getfiled, $request, $join_str = array()) {
    DB::enableQueryLog();
    $output = array();
    $data = DB::table($table_name)
        ->select($getfiled);
    
    if (!empty($join_str)) {
        foreach ($join_str as $join) {
            if (!isset($join['join_type'])) {
                $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id']);
            } else {
                $data->leftJoin($join['table'], $join['join_table_id'], '=', $join['from_table_id']);
            }
        }
    }
    
    if (isset($request->start_date) && isset($request->end_date)) {
        if (!empty($request->start_date) && !empty($request->end_date)) {
                        
            $start_date = DateTime::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d');
            $end_date = DateTime::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d');
                        
            $data->whereDate('u.created_at', '>=', $start_date)->whereDate('u.created_at', '<=', $end_date);
        }
    }
        
    if(isset($request->country_id) && !empty($request->country_id)){
        $data->where('u.country_id',$request->country_id);
    }
    
    if ($request['search']['value'] != '') {
        $data->where(function($query) use ($request, $datatable_fields) {
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $query->orWhere($datatable_fields[$i], 'like', '%' . $request['search']['value'] . '%');
                }
            }
        });
    }
    
    $data->whereNull('u.deleted_at');
    $data->where('u.email_verify','Yes');
    
    if(isset($request->status) && !empty($request->status)){
        $data->where('u.status', $request->status);
    }
    
    if (isset($request['order']) && count($request['order'])) {
        for ($i = 0; $i < count($request['order']); $i++) {
            if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                $data->orderBy($datatable_fields[$request['order'][$i]['column']], $request['order'][$i]['dir']);
            }
        }
    }
    
    $count = $data->get()->count(); // Counting users
    $data->skip($request['start'])->take($request['length']);
    $output['recordsTotal'] = $count;
    $output['recordsFiltered'] = $count;
    $output['draw'] = $request['draw'];
    $data_d = $data->get(); // Grouping by user id
        
    if (!$data_d->isEmpty()) {
        foreach ($data_d as $key => $d) {
            $data_d[$key]->created_at = Common::adminconvertTimezone($d->created_at, 'm-d-Y h:i A');
            $data_d[$key]->user_name = (empty($d->user_name)) ? 'NA' : $d->user_name;
            $data_d[$key]->country = (empty($d->country)) ? 'NA' : $d->country;
            
        }
    }
    
    $output['data'] = $data_d;
    return json_encode($output);
}
    
}

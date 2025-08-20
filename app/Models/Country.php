<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class Country extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'country';
    
    public static function getCountry($table_name, $datatable_fields, $conditions_array, $getfiled, $request, $join_str = array()) {
        DB::enableQueryLog();
        $output = array();
        $data = DB::table($table_name)
            ->select($getfiled);
        
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $data->orderBy($datatable_fields[$request['order'][$i]['column']], $request['order'][$i]['dir']);
                }
            }
        }
        
        $data->whereNull('deleted_at');
        if ($request['search']['value'] != '') {
            $data->where(function($query) use ($request, $datatable_fields) {
                for ($i = 0; $i < count($datatable_fields); $i++) {
                    if (filter_var($request['columns'][$i]['searchable'], FILTER_VALIDATE_BOOLEAN) === true) {
                        $query->orWhere($datatable_fields[$i], 'like', '%' . $request['search']['value'] . '%');
                    }
                }
            });
        }
        $count = $data->count();
        
        $data->skip($request['start'])->take($request['length']);

        $data_d = $data->get();

        /*if (!$data_d->isEmpty()) {
            foreach ($data_d as $key => $d) {
            }
        }*/
        $output['recordsTotal'] = $count;
        $output['recordsFiltered'] = $count;
        $output['draw'] = $request['draw'];
        $output['data'] = $data_d;
        
        return json_encode($output);
    }
    
}

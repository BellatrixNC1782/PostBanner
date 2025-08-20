<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class Notifications extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'notifications';
    public static function getNotificationModel($table_name, $datatable_fields, $conditions_array, $getfiled, $request, $join_str = array()) {
        DB::enableQueryLog();
        $output = array();
        $data = DB::table($table_name)
            ->select($getfiled);
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id']);
                } else {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id'], $join['join_type']);
                }
            }
        }
       
        if ($request['search']['value'] != '') {
            $data->where(function($query) use ($request, $datatable_fields) {
                for ($i = 0; $i < count($datatable_fields); $i++) {
                    if ($request['columns'][$i]['searchable'] == 'true') {
                        $query->orWhere($datatable_fields[$i], 'like', '%' . $request['search']['value'] . '%');
                    }
                }
            });
        }
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $data->orderBy($datatable_fields[$request['order'][$i]['column']], $request['order'][$i]['dir']);
                }
            }
        }
        
        $count = $data->get()->count();
        $data->skip($request['start'])->take($request['length']);
        $output['recordsTotal'] = $count;
        $output['recordsFiltered'] = $count;
        $output['draw'] = $request['draw'];
        $data_d = $data->get();
        
        if (!$data_d->isEmpty()) {
            foreach ($data_d as $key => $d) {
                $data_d[$key]->created_at = Common::adminconvertTimezone($d->created_at, 'm-d-Y h:i A');
            }
        }
        
        $output['data'] = $data_d;
        return json_encode($output);
    }
}

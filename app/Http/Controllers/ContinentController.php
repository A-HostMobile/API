<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Helper\CustomHelper as Help;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $result = DB::select(DB::raw("SELECT  C.C_CONTINENT_NAME,Q1.QC_LOOKUP_VALUE2,Q1.QC_LOOKUP_CODE 
			                          FROM QUICK_CODES Q1 , CONTINENTS C
			                          WHERE  QC_LOOKUP_TYPE = 'LV_POD' AND Q1.QC_LOOKUP_VALUE1 = C.C_CONTINENT_ID 
			                          ORDER BY C.C_CONTINENT_NAME"));
            $data[] = array('continent' => '');
            $index = 0;
            $index_city =0;
            foreach ($result as $row) {
                if($data[$index]['continent'] != $row->c_continent_name&&!empty($data[$index]['continent'])){
                        $index++;
                        $index_city =0;
                    }
                    if(empty($data[$index]['continent'])){
                        $data[$index] = array('continent'=>$row->c_continent_name);
                        $data[$index]['city'][$index_city] = array('country_name'=>$row->qc_lookup_value2,'code' =>$row->qc_lookup_code);
                        $index_city++;
                    }
                    else{
                        $data[$index]['city'][$index_city] = array('country_name'=>$row->qc_lookup_value2,'code' => $row->qc_lookup_code);
                        $index_city++;
                    }
            }
            $resp = Help::createResp(0,"Query Success",$data);
            return response()->json($resp);

        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Helper\CustomHelper as Help;

class CommoditiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $result = DB::select(DB::raw("SELECT QC_LOOKUP_CODE,LOWER(QC_LOOKUP_VALUE1) AS QC_LOOKUP_VALUE1,TO_NUMBER(QC_LOOKUP_VALUE2) AS QC_LOOKUP_VALUE2 
                                          FROM QUICK_CODES 
                                          WHERE QC_LOOKUP_TYPE = 'LV_COMMODITY' 
                                          ORDER BY TO_NUMBER(QC_LOOKUP_BEGIN) ASC,TO_NUMBER(QC_LOOKUP_NO) ASC"));

            $resp = Help::createResp(0,"Query Success",$result);
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

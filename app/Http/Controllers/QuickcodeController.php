<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Helper\CustomHelper as Help;

class QuickcodeController extends Controller
{
    public function pod(){
        try{
            $result = DB::select(DB::raw("SELECT QC_DESCRIPTION,QC_LOOKUP_VALUE1,UPPER(QC_LOOKUP_VALUE2) AS QC_LOOKUP_VALUE2,QC_LOOKUP_TYPE,QC_LOOKUP_NO,QC_LOOKUP_CODE
			                              FROM QUICK_CODES 
                                          WHERE QC_LOOKUP_TYPE = 'LV_POD' 
                                          ORDER BY TO_NUMBER(QC_LOOKUP_CODE) ASC "));

            $resp = Help::createResp(0,"Query POD Success",$result);
            return response()->json($resp);

        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query POD Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }

    public function package(){
        try{
            $result = DB::select(DB::raw("SELECT LOWER(QC_LOOKUP_VALUE1) AS QC_LOOKUP_VALUE1,QC_LOOKUP_TYPE,QC_LOOKUP_NO,QC_LOOKUP_CODE
			                              FROM QUICK_CODES 
                                          WHERE QC_LOOKUP_TYPE = 'LV_PACKAGE' 
                                          ORDER BY TO_NUMBER(QC_LOOKUP_CODE) ASC "));

            $resp = Help::createResp(0,"Query Package Success",$result);
            return response()->json($resp);

        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query Package Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }

    public function gwunit(){
        try{
            $result = DB::select(DB::raw("SELECT LOWER(QC_LOOKUP_VALUE1) AS QC_LOOKUP_VALUE1,QC_LOOKUP_TYPE,QC_LOOKUP_NO,QC_LOOKUP_CODE
			                              FROM QUICK_CODES 
                                          WHERE QC_LOOKUP_TYPE = 'LV_GW_UNIT' 
                                          ORDER BY TO_NUMBER(QC_LOOKUP_CODE) DESC "));

            $resp = Help::createResp(0,"Query GWUnit Success",$result);
            return response()->json($resp);

        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query GWUnit Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }

    public function countrycode(){
        try{
            $result = DB::select(DB::raw("SELECT QC_LOOKUP_VALUE1,QC_LOOKUP_VALUE2,QC_LOOKUP_TYPE,QC_LOOKUP_NO,QC_LOOKUP_CODE
			  	                          FROM QUICK_CODES 
                                          WHERE QC_LOOKUP_TYPE ='LV_CG_COUNTRY_CODE' AND QC_LOOKUP_CODE='TH' "));

            $resp = Help::createResp(0,"Query CountryCode Success",$result);
            return response()->json($resp);

        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query CountryCode Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Agent as Agents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Helper\CustomHelper as Help;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try{
            $column = ['A_LABEL','A_LATTITUDE','A_LONGTITUDE'];
            $data = Agents::select($column)
                                ->whereNotNull('A_LABEL')
                                ->get();

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

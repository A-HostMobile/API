<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use PDO;
use DB;
use App\Schedules as Schedule;
use App\Helper\CustomHelper as Help;
use Str;

class ScheduleController extends Controller
{
    public function searchSchedule($dest){

    	try{
      		 
			 $today = date("d/m/Y",time());
			 $condition_date = " S_CLOSING_DATE >= TO_DATE('$today', 'DD/MM/YYYY')+ INTERVAL '2' DAY ORDER BY S_ETD ASC";

			 $result = DB::select(DB::raw("SELECT S_SCHEDULE_ID,S_TYPE,S_FROM,S_TO,S_CARRIER,S_FEEDER,S_FVOY,S_VESSEL,S_VOY,
			 							TO_CHAR(S_CLOSING_DATE,'DD-MON-YYYY') as S_CLOSING_DATE,
			 							TO_CHAR(S_ETD,'DD-MON-YYYY') as S_ETD,TO_CHAR(S_ETA,'DD-MON-YYYY') as S_ETA,
			 							S_FEEDER_FLAG,CREATION_DATE,CREATED_BY,
			 							TO_CHAR(LAST_UPDATE_DATE,'DD-MON-YYYY') as LAST_UPDATE_DATE,
			 							LAST_UPDATED_BY,(SELECT VALIDATE_CLOSING_DATE(S_CLOSING_DATE) FROM DUAL) AS TIME 
										FROM SCHEDULES
										WHERE S_TO= '$dest' 
										AND $condition_date"));

			 $data = array();
			 foreach ($result as $row ) 
				{
					if($row->time == 1){
						$row->time = "Monday-Friday before: 17.00 PM";
					}
					else if($row->time == 2){
						$row->time = "Saturday Closing Date  before : 12.00 AM";
					}

					$data[] = $row;
					
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

    public function otherSchedule($dest,$loading){

    	try{
      		 
			 $today = date("d/m/Y",time());
			 $loading = date("d-m-Y",$loading);
			 $condition_date = " S_CLOSING_DATE >= TO_DATE('$today', 'DD/MM/YYYY')+ INTERVAL '2' DAY ORDER BY S_ETD ASC";

			 $result = DB::select(DB::raw("SELECT S_SCHEDULE_ID,S_TYPE,S_FROM,S_TO,S_CARRIER,S_FEEDER,S_FVOY,S_VESSEL,S_VOY,
			 							S_CLOSING_DATE,S_ETD,S_ETA,S_FEEDER_FLAG,CREATION_DATE,CREATED_BY,LAST_UPDATE_DATE,
			 							LAST_UPDATED_BY,(SELECT VALIDATE_CLOSING_DATE(S_CLOSING_DATE) FROM DUAL) AS TIME 
			 							FROM SCHEDULES 
			 							WHERE S_TO = '$dest' 
			 							AND S_CLOSING_DATE >= TO_DATE('$today', 'DD/MM/YYYY')+ INTERVAL '2' DAY 
			 							AND TO_DATE('$loading', 'DD/MM/YYYY') <= S_CLOSING_DATE 
			 							ORDER BY S_CLOSING_DATE ASC FETCH FIRST 1 ROWS ONLY"));
			 $data = array();
			 foreach ($result as $row ) 
				{
					if($row->time == 1){
						$row->time = "Monday-Friday before: 17.00 PM";
					}
					else if($row->time == 2){
						$row->time = "Saturday Closing Date  before : 12.00 AM";
					}

					$data[] = $row;
					
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

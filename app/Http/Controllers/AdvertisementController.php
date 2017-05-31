<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Helper\CustomHelper as Help;

class AdvertisementController extends Controller
{
    public function home(){
        try{
            $result = DB::select(DB::raw("SELECT B_ACTIVE_FLAG,B_DISPLAY_SEQ,B_ITEM_ID,ba.BA_MIME_TYPE,ba.BA_IMAGE1 AS IMAGE,ba.BA_SEQ 
                                          FROM BLOGS b INNER JOIN BLOGS_ATTACHMENT ba ON b.B_ITEM_ID = ba.BA_ITEM_ID 
                                          WHERE B_ACTIVE_FLAG = 1 AND ba.BA_SEQ = 1 AND b.B_DISPLAY_TO > SYSDATE AND rownum <= 3 
                                          ORDER BY B_DISPLAY_SEQ DESC"));
            $index = 0;
            $data = array();
            $img_base64 = array();

            foreach ($result as $row) {
                $row->image = base64_encode($row->image);
                $data[] = $row;
            }
            $resp = Help::createResp(0,"Query Home Success",$data);
            return response()->json($resp);
        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query Home Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }

    public function news(){
        try{
            $result = DB::select(DB::raw("SELECT B_TOPIC,B_TYPE,B_ACTIVE_FLAG,B_SHORT_DESC,B_DISPLAY_SEQ,B_ITEM_ID,ba.BA_MIME_TYPE,ba.BA_IMAGE1
                                          AS IMAGE,ba.BA_SEQ 
                                          FROM BLOGS b INNER JOIN BLOGS_ATTACHMENT ba ON b.B_ITEM_ID = ba.BA_ITEM_ID 
                                          WHERE B_TYPE = 1 AND B_ACTIVE_FLAG = 1 AND ba.BA_SEQ = 1 AND b.B_DISPLAY_TO >= SYSDATE
                                          ORDER BY B_DISPLAY_SEQ DESC"));
            $index = 0;
            $data = array();
            $img_base64 = array();

            foreach ($result as $row) {
                $row->image = base64_encode($row->image);
                $data[] = $row;
            }
            $resp = Help::createResp(0,"Query News Success",$data);
            return response()->json($resp);
        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query News Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }

    public function promotions(){
        try{
            $result = DB::select(DB::raw("SELECT B_TOPIC,B_TYPE,B_ACTIVE_FLAG,B_SHORT_DESC,B_DISPLAY_SEQ,B_ITEM_ID,ba.BA_MIME_TYPE,ba.BA_IMAGE1
                                          AS IMAGE,ba.BA_SEQ 
                                          FROM BLOGS b INNER JOIN BLOGS_ATTACHMENT ba ON b.B_ITEM_ID = ba.BA_ITEM_ID
                                          WHERE B_TYPE = 2 AND B_ACTIVE_FLAG = 1 AND ba.BA_SEQ = 1 AND b.B_DISPLAY_TO >= SYSDATE
                                          ORDER BY B_DISPLAY_SEQ DESC"));
            $index = 0;
            $data = array();
            $img_base64 = array();

            foreach ($result as $row) {
                $row->image = base64_encode($row->image);
                $data[] = $row;
            }
            $resp = Help::createResp(0,"Query Promotions Success",$data);
            return response()->json($resp);
        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query Promotions Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);

        }
    }

    public function detail($id){
        try{
            $master = DB::table('BLOGS')
                                ->select()
                                ->where('B_ITEM_ID','=',$id)
                                ->get();
            $detail = DB::table('BLOGS_ATTACHMENT')
                                ->select()
                                ->where('BA_ITEM_ID','=',$id)
                                ->get();
            $index = 0;
            foreach($master as $row)
                {
                    $masterData = array("topic"=>$row->b_topic,
                                        "type"=>$row->b_type,
                                        "content"=>$row->b_content);
                } 
            foreach($detail as $row)
                {
                    $row->ba_image1 = base64_encode($row->ba_image1);
                    $img[$index] = array("img"=>$row->ba_image1,
                                         "type"=>$row->ba_mime_type);	
                    $index++;
                }
            $data = array("master"=>$masterData,
                          "detail"=>$img);

            $resp = Help::createResp(0,"Query Detail Success",$data);
            return response()->json($resp);
        }catch(\Illuminate\Database\QueryException $e){
            $resp = Help::createResp(2,"Query Detail Error",$e->getMessage());
            return response()->json($resp);

        }catch(\Exception $e){
            $resp = Help::createResp(1,"Connect DB Error",$e->getMessage());
            return response()->json($resp);
        }
    }
}

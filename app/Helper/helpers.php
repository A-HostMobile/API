<?php

namespace App\Helper;

class CustomHelper
{
    static function createResp($code,$mesg,$data)
    {
        return $response = array('responseCode'        	=> $code,
                                 'responseMessage'     	=> $mesg,
                                 'responseData'			=> $data);
    }
}
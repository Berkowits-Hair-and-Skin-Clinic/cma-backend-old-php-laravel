<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Session;
use validate;
use Sentinel;
//use DB;
use App\Models\BookAppointment;
use DateTime;
use App\Http\Middleware\SmsController;

class AiSimulator extends Controller{
    var $hairstyle_api_url="https://www.ailabapi.com/api/portrait/effects/hairstyle-editor-pro";
    var $ai_lab_api_key="DYO7an5hJm5yB4esq9gQocap1JkGhkbUWedcAEKr1oEfCdL3lOIsY6BMCzQrnI3V";
    
    public function applyHairstyle (Request $request){
        if(empty($request->get("hairStyle")) OR empty($request->get("imagePath"))){
            $response['success'] = "0";
            $response['msg'] = "Parameters Missing : hairStyle or imagePath";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $hairStyle = !empty($request->get("hairStyle")) ? $request->get("hairStyle") : 'SlickBack';
        $color = !empty($request->get("color")) ? $request->get("color") : 'black';
        // Start Applying Hair Style
        $imagePath=$request->get("imagePath");
        $curl = curl_init();

        $data = array(
            'task_type' => 'async',
            'auto' => 1,
            'image' => new CURLFILE($imagePath),
            'hair_style' => $hairStyle,
            'color' => $color
        );
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->hairstyle_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'ailabapi-api-key: ' . $this->ai_lab_api_key
            ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);
    
        return $response;
    }

}

?>
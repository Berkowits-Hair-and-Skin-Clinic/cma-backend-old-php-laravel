<?php 
namespace App\Http\Middleware;
use Closure;
use Sentinel;
use App\Posts;
use Illuminate\Support\Facades\Http;
require base_path('vendor').'/twilio/sdk/src/Twilio/autoload.php';
use Twilio\Rest\Client;
class SmsController{

    public static function SmsPhoneMsg91($param_array){
        //param_array should have sms_type , number , otp etc
        $auth_key = "114484AEIgCRIe676d06eaP1";
        $api_url="https://control.msg91.com/api/v5/flow";
        $phone="91".$param_array['number'];
        switch($param_array['sms_type']){
            case 'voucher':
                $template_id = "68023324d6fc056b86147662";
                $payload = [
                    "template_id" => $template_id,
                    "recipients" => [
                        [
                            "mobiles" => $phone,
                            "var1" => $param_array['otp']
                        ]
                    ]
                ];
            break;
            case 'otp':
                $template_id = "677fad3ed6fc0508bf167174";
                $payload = [
                    "template_id" => $template_id,
                    "recipients" => [
                        [
                            "mobiles" => $phone,
                            "var1" => $param_array['otp']
                        ]
                    ]
                ];
            break;
            case 'AppoinmentConfirmation_1':
                $template_id = "67836975d6fc052ac90b1ac2";
                $payload = [
                    "template_id" => $template_id,
                    "recipients" => [
                        [
                            "mobiles" => $phone,
                            "var1" => $param_array['customer_name'],
                            "va2r" => $param_array['service_name'],
                            "var3" => $param_array['city'],
                            "var4" => $param_array['center_name'],
                            "var5" => $param_array['center_phone']
                        ]
                    ]
                ];
            break;
            case 'order-confirmation':
            break;
        }
        // Initialize cURL
        $curl = curl_init();
        // Set cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload), // Encode the dynamic payload
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authkey: $auth_key",
                "content-type: application/json"
            ],
        ]);
        // Execute cURL request
        $response = curl_exec($curl);
        $err = curl_error($curl);
        // Close cURL
        curl_close($curl);
        $data = json_decode($response, true); 
        return $data ;
    }
    // This function will be used to send multi rtype format whatsapp msg
    public static function sendMultiFormatWhatsAppTelephant($telephant_template_id=NULL,$param=NULL){
        $phone = "+91".$param['phone'];
        switch($telephant_template_id){
            // telephant_template_id (Short Description): 
            case 'aih_result_download1':
                $components = [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $param['firstname']// Include the dynamic OTP
                            ],
                            [
                                "type" => "text",
                                "text" => $param['result_url']
                            ],
                            
                        ]
                    ]
                ];
            break;
            case 'promoters_otp':
                $components = [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $param['otp']
                            ]
                        ]
                    ]
                ];
            break;
            case 'vlc_ecom_order':
                $components = [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $param['client_name']
                            ],
                            [
                                "type" => "text",
                                "text" => $param['ecom_checkout_url']// Include the dynamic OTP
                            ]
                        ]
                    ]
                ];
            break;
            case 'vlc_order_report':
                $components = [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $param['client_name']
                            ],
                            [
                                "type" => "text",
                                "text" => $param['doctor_name']// Include the dynamic OTP
                            ],
                            [
                                "type" => "text",
                                "text" => $param['prescription_url']// Include the dynamic OTP
                            ]
                        ]
                    ]
                ];

            break;
            case 'vlc_share_prescription_1':
                $components = [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $param['client_name']
                            ],
                            [
                                "type" => "text",
                                "text" => $param['doctor_name']// Include the dynamic OTP
                            ],
                            [
                                "type" => "text",
                                "text" => $param['prescription_url']// Include the dynamic OTP
                            ]
                        ]
                    ]
                ];
            break;
            case 'cma_otp_4':
                $components = [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => "OTP"
                            ],
                            [
                                "type" => "text",
                                "text" => $param['otp'] // Include the dynamic OTP
                            ]
                        ]
                    ]
                ];
                break; 

        }
        // Construct the post parameter
        $postparam = json_encode([
            "apikey" => env('TELEPHANT_API_KEY'),
            "to" => $phone,
            "channels" => ["whatsapp"],
            "whatsapp" => [
                "contentType" => "template",
                "template" => [
                    "templateId" => $telephant_template_id,
                    "language" => "en",
                    "components" => $components // Using the dynamic variable
                ]
            ]
        ]);
         // send MSG
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('TELEPHANT_API_URL_SEND_MGS'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postparam,
            
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $data = json_decode($response, true); 
            return $data ;

    }
    public static function sendWhatsAppSMSTelephant($number,$otp){
    //$phone = 916200091023;
    $phone = "+91".$number;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => env('TELEPHANT_API_URL_SEND_MGS'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
            "apikey" => env('TELEPHANT_API_KEY'),
            "to" => $phone,
            "channels" => ["whatsapp"],
            "whatsapp" => [
                "contentType" => "template",
                "template" => [
                    "templateId" => "cma_otp_4",
                    "language" => "en",
                    "components" => [
                        [
                            "type" => "body",
                            "parameters" => [
                                [
                                    "type" => "text",
                                    "text" => "OTP"
                                ],
                                [
                                    "type" => "text",
                                    "text" => $otp // Include the dynamic OTP
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true); 
        return $data ;
        //var_dump($data);
    }
    //Twilio Phone SMS
    public static function sendTwilioPhoneSms($number, $otp){
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $otp =  $otp;
        $phone = "+91".$number;
        $twilioNumber = env('TWILIO_FROM');
        $twilio = new Client($sid, $token);
        $message = $twilio->messages->create(
            $phone,
            array(
              "from" => $twilioNumber,
              "body" => $otp." is the OTP to login to Berkowits Hair & Skin Clinic."
            )
          );
        return $message->sid;
        //print($message->sid);

    }
    // Not working
    public static function sendOtpSms($number, $otp){
        if(!empty($number))
        { 
            $msg  = urlencode($otp." Your OTP for Mobile confirmation to receive a call back from experts at Berkowits Hair and Skin Clinic.");
            //$msg  = urlencode($otp." Your OTP to login to CMA");
            $cURL = curl_init();  
            curl_setopt($cURL, CURLOPT_URL, 'https://api.flash49.com/fe/api/v1/send?username=berkowits.trans&password=Wj2pV&unicode=false&from=BRKWTS&to='.$number.'&text='.$msg.'&dltContentId=1307168231116619330'); 
            //https://api.flash49.com/fe/api/v1/send?username=berkowits.trans&password=Wj2pV&unicode=false&from=BRKWTS&to=9310976551&text=5465%20your%20OTP%20for%20Berkowits%20Hair%20and%20Skin%20Clinic.&dltContentId=1307168058865663055 
            curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET"); 
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);   
            $response = curl_exec($cURL);   
            // echo $response;
            curl_close($cURL);   
        }
    }
}
?>
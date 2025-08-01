<?php 
namespace App\Http\Middleware;
use Closure;
use Sentinel;
use App\Posts;
use Illuminate\Support\Facades\Http;
class Zenoti{
     static $api_base_url="https://api.zenoti.com/v1/";
     //static $zenoti_api_key=env('ZENOTI_API_KEY');
     public static function createZenotiService($dataArray){
        $curl = curl_init();
        if($dataArray['therapist_id']=="any"){
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.zenoti.com/v1/bookings?is_double_booking_enabled=true",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'is_only_catalog_employees' => true,
                    'center_id' => $dataArray['center_id'],
                    'date' => $dataArray['date'],
                    'guests' => [
                        [
                         'id' => $dataArray['guest_id'],
                         'items' => [
                        [
                        'item' => [
                        'id' => $dataArray['service_id']
                        ]
                    ]
                        ]
                    ]
                ]
                ]),
                CURLOPT_HTTPHEADER => [
                    "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
                    "accept: application/json",
                    "content-type: application/json"
                ],
                ]);
        }else{
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.zenoti.com/v1/bookings?is_double_booking_enabled=true",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'is_only_catalog_employees' => true,
                    'center_id' => $dataArray['center_id'],
                    'date' => $dataArray['date'],
                    'guests' => [
                        [
                         'id' => $dataArray['guest_id'],
                         'items' => [
                        [
                        'item' => [
                        'id' => $dataArray['service_id']
                        ],
                        'therapist' => [
                        'id' => $dataArray['therapist_id'],
                        'gender' => '0'
                        ]
                            ]
                        ]
                    ]
                ]
                ]),
                CURLOPT_HTTPHEADER => [
                    "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
                    "accept: application/json",
                    "content-type: application/json"
                ],
                ]);
        }
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo $response;
            $data = json_decode($response, true); 
            return $data ;
        }
    }
    public static function createZenotiGuest($dataArray){
        $namearray=explode(" ",$dataArray['name']);
        if(empty($namearray[1]) OR $namearray[1]==null){
            $namearray[1]="NA";
        }
        if(empty($dataArray['center_id']) OR $dataArray['center_id']==null){
            $dataArray['center_id']="47d45b25-1da4-4f6e-9340-8f6b87df0007";
        }
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.zenoti.com/v1/guests",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'center_id' => $dataArray['center_id'],
            'personal_info' => [
                'first_name' => $namearray[0],
                'last_name' =>  $namearray[1],
                'middle_name' => '',
                'email' => $dataArray['email'],
                'mobile_phone' => [
                        'country_code' => 95,
                        'phone_code' => 0,
                        'number' => $dataArray['phone'],
                ],
                'work_phone' => [
                        'country_code' => 95,
                        'phone_code' => 0,
                        'number' => $dataArray['phone'],
                ],
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo $response;
            $data = json_decode($response, true); 
            return $data ;
        }
    }
    public static function createGiftcardInvoice($dataArray){
        $response_array=array();
        $response_array['status']="success";
        $response_array['guest_name']=$dataArray['name'];
        $response_array['guest_phone']=$dataArray['phone'];
        $response_array['guest_email']=$dataArray['email'];
        // create Custom Gift Card Template
        if(empty($dataArray['center_id']) OR $dataArray['center_id']==null){
            $dataArray['center_id']="47d45b25-1da4-4f6e-9340-8f6b87df0007"; // head office
        }
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.zenoti.com/v1/giftcards/templates/custom",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'center_id' => $dataArray['center_id'],
            'custom_amount' => [
                'amount' => $dataArray['amount'],
                'validity' =>  365,
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);
        $response1 = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            //echo "cURL Error #:" . $err;
            $response_array['status']="fail";
            $response_array['errors_template']=$err;
        } else {
            //echo $response;
            $data1 = json_decode($response1, true); 
            $gift_card_template_id = $data1['id'];
            $response_array['gift_card_template_id']=$gift_card_template_id;
            //return $data ;
        }
        //return $response_array;
        // create INVOICE  for above Custom Gift Card Template
        $zenoti_guest_id="";
        $datazenoti=Zenoti::searchGuest($dataArray['phone']);
        $guests = $datazenoti['guests']; 
        foreach ($guests as $guest) {
            $zenoti_guest_id=htmlspecialchars($guest['id']);
            $center_id=htmlspecialchars($guest['center_id']);
        }
        if(!empty($zenoti_guest_id)){
            $guest_id=$zenoti_guest_id; 
            $center_id= $center_id; 
        }else{
            $guest_id="E1FA810A-7A89-41B1-BD7F-D0B019A050E8"; // to be searched by phone , hardcoed as shak for now
            $center_id="47d45b25-1da4-4f6e-9340-8f6b87df0007"; // head office

        }
        //$guest_id="E1FA810A-7A89-41B1-BD7F-D0B019A050E8"; // to be searched by phone , hardcoed as shak for now
        //$center_id="47d45b25-1da4-4f6e-9340-8f6b87df0007"; // head office
        $payload = json_encode([
            "center_id" => $center_id,
            "guest_id" => $guest_id,
            "sale_by" => "b8bdadfa-54af-4958-859e-233e4070b1c8",    
            "giftcards" => [
                [
                    "template_id" => $gift_card_template_id,
                    "schedule_time" => date("Y-m-d"),
                    "occassion" => [
                        "id" => "27fb7e73-e0d6-4b49-97a4-c03584e31700",
                        "image_id" => "",
                        "message" => "Online Paid for consultation"
                    ],
                    "recepient" => [
                        "name" => $dataArray['name'],
                        "email" => $dataArray['email']
                    ],
                    "notes" => $dataArray['policy']
                ]
            ]
        ]);
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.zenoti.com/v1/invoices/giftcards",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        /*CURLOPT_POSTFIELDS => json_encode([
            'center_id' => $dataArray['center_id'],
            'guest_id'=>$guest_id,
            "sale_by"=>"b8bdadfa-54af-4958-859e-233e4070b1c8", // ALTIUS EMP ZENOTI ID 
            'giftcards' => [
                'template_id' => $gift_card_template_id,
                'schedule_time' => "2025-03-22T09:00:00",
                'occassion' => [
                    'id' => "27fb7e73-e0d6-4b49-97a4-c03584e31700",
                    'image_id' => "",
                    'message' => "Online Paid for consultation",
                ],
                "recepient" => [
                    "name" => $dataArray['name'],
                    "email" =>$dataArray['email']
                ],
                "notes"=> $dataArray['policy']
            ]
        ]),*/
        CURLOPT_POSTFIELDS =>$payload,
        /*CURLOPT_POSTFIELDS =>'{
            "center_id": "47d45b25-1da4-4f6e-9340-8f6b87df0007",
            "guest_id": "E1FA810A-7A89-41B1-BD7F-D0B019A050E8",
            "sale_by": "b8bdadfa-54af-4958-859e-233e4070b1c8",
            "giftcards": [
                {
                    "template_id": "5bafd8f2-e7cb-4647-a9be-85d7091fb699",
                    "schedule_time": "2025-03-22T09:00:00",
                    "occassion": {
                        "id": "27fb7e73-e0d6-4b49-97a4-c03584e31700",
                        "image_id": "",
                        "message": "Online Paid for consultation"
                    },
                    "recepient": {
                        "name": "Shak Akhtar",
                        "email": "shak@berkowits.in"
                    },
                    "notes": "Fully refundable advanced fees for consultation"
                }
            ],
        }',*/
        CURLOPT_HTTPHEADER => [
            "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);
        $response2 = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            //echo "cURL Error #:" . $err;
            $response_array['status']="fail";
            $response_array['errors_invoice']=$err;
            return $response_array;
            
        } else {
            //echo $response;
            $data2 = json_decode($response2, true); 
            //return $data2 ;
            $invoice_id = $data2['invoice_id'];
            $response_array['invoice_id']=$invoice_id;
            //return $data ;
        }
        return $response_array;

    }
    public static function executePostCURL($apiurl){
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL =>$apiurl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => [
            "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true); 
            return $data ;
        }
    }
    public static function executeGetCURL($apiurl){
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL =>$apiurl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
            "accept: application/json"
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true); 
            return $data ;
        }
    }
    public static function guestDetailsByID($zenoti_id){
        $apiURL="https://api.zenoti.com/v1/guests/".$zenoti_id;
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public function sendSMSMsg91(){
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\n  
        \"template_id\": \"663e20c1d6fc0541c9006f32\",\n  
        \"short_url\": \"0\",\n  
        \"short_url_expiry\": \"600\",\n  
        \"realTimeResponse\": \"1\", \n  
        \"recipients\": [\n    
                        {\n      \"mobiles\": \"919XXXXXXXXX\",\n      
                        \"VAR1\": \"VALUE 1\",\n      
                        \"VAR2\": \"VALUE 2\"\n    
                        }\n  
                        ]\n
        }",
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authkey: Enter your MSG91 authkey",
            "content-type: application/json"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }
    public static function searchGuest($phone){
            $apiBaseurl="https://api.zenoti.com/v1/guests/search?";
            $apiURL=$apiBaseurl."phone=".$phone."&SearchAcrossCenter=True";
            //$apiURL="phone=9999208894&SearchAcrossCenter=True";
            $response=Zenoti::executeGetCURL($apiURL);
            //$response_json_decoded=json_decode($response_json);
            return $response;
    }
    public static function purchaseProducts($zenoti_guest_id){
        $guest_id=$zenoti_guest_id;
        $apiURL = "https://api.zenoti.com/v1/guests/{$guest_id}/products";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function listAllCenter(){
        $apiURL = "https://api.zenoti.com/v1/centers";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function listService($center_id){
        $apiURL = "https://api.zenoti.com/v1/Centers/{$center_id}/services";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function listEmployeeFromCenter($center_id){
        $apiURL = "https://api.zenoti.com/v1/centers/{$center_id}/employees";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function mapEmpServiceCenter($center_id,$service_id){
        //$apiURL = "https://api.zenoti.com/v1/centers/{$center_id}/employees";
        $apiURL="https://api.zenoti.com/v1/centers/{$center_id}/services/{$service_id}/therapists?";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function getServiceSlots($booking_id){
        $apiURL="https://api.zenoti.com/v1/bookings/{$booking_id}//slots?check_future_day_availability=true'";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function getZenotiGuestAppointment($guest_id,$start_date,$end_date){
        if($start_date==null && $end_date==null){
            $apiURL="https://api.zenoti.com/v1/guests/{$guest_id}/appointments?size=100";
        }else{
            $apiURL="https://api.zenoti.com/v1/guests/{$guest_id}/appointments?size=100&start_date={$start_date}&end_date={$end_date}";
        }
        //var_dump($apiURL);
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function getAppointmentDetail($id){
        //$id=appointment_id
        $appointment_id=$id;
        $apiURL="https://api.zenoti.com/v1/appointments/{$appointment_id}";
        $response=Zenoti::executeGetCURL($apiURL);
        return $response;
    }
    public static function reserverZenotiBooking($booking_id,$slottime){
        $apiURL="https://api.zenoti.com/v1/bookings/{$booking_id}/slots/reserve";
        //var_dump($apiURL);
        //$response=Zenoti::executePostCURL($apiURL);
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL =>$apiURL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'slot_time' => $slottime
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb",
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true); 
            //return $data ;
        }
        $response2=$data;
        return $response2;
    }
    public static function confirmZenotiBooking($booking_id){
        $map = []; // Add required payload fields here, if any.
        $jsonPayload = json_encode($map); // Encode the payload as JSON
        $apiURL="https://api.zenoti.com/v1/bookings/{$booking_id}/slots/confirm";
        //$apiUrl = "https://api.zenoti.com/v1/bookings/111cd5fb-ffc2-4d90-a7e3-7d8dbf0e5e0b/slots/confirm";
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: apikey 46289d793f3b4f2fb2ba0b42d8b85c6d2429be29b8764142bd6b60cc2eed3deb'  // Replace with your actual API key
        ];
        // Initialize cURL session
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $apiURL);         // Set the API URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  // Set the request headers
        curl_setopt($ch, CURLOPT_POST, true);           // Set the request method to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload); // Attach the JSON payload
        // Execute the request and get the response
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true); 
            //return $data ;
        }
        $response2=$data;
        return $response2;
    }
}
?>
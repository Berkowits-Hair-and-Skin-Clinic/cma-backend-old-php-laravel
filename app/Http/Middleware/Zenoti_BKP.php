<?php 
namespace App\Http\Middleware;
use Closure;
use Sentinel;
use App\Posts;
use Illuminate\Support\Facades\Http;
class Zenoti{
     static $api_base_url="https://api.zenoti.com/v1/";
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
                    "Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49",
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
                    "Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49",
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
            "Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49",
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
            "Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49",
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
            "Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49",
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
            "Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49",
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
            'Authorization: apikey 2b265e640325425daa98c9732d47cd0a4d1bdebe382942088b4ab2f74d94ee49'  // Replace with your actual API key
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
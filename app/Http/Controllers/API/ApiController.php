<?php
namespace App\Http\Controllers\API;
error_reporting(-1);
ini_set('display_errors', 'On');
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use PDO;
use Session;
use validate;
use Sentinel;
use Response;
use Validator;
//use DB;
use Illuminate\Support\Facades\DB;
use DataTables;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Otp;
use App\Models\UrlRedirect;
use App\Models\User;
use App\Models\Services;
use App\Models\ServicesEnabled;
use App\Models\ZenotiServiceBooking;
use App\Models\Review;
use App\Models\Doctors;
use App\Models\Patient;
use App\Models\TokenData;
use App\Models\Resetpassword;
use App\Models\BookAppointment;
use App\Models\SlotTiming;
use App\Models\Doctor_Hoilday;
use App\Models\Schedule;
use App\Models\Reportspam;
use App\Models\Settlement;
use App\Models\Subscription;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\Banner;
use App\Models\About;
use App\Models\Privecy;
use Hash;
use Mail;
use DateTime;
use DateInterval;
use App\Models\Medicines;
use App\Models\AppointmentMedicines;
use App\Models\ap_img_uplod;
use App\Models\PharmacyOrder;
use App\Models\PharmacyOrderData;
use App\Models\PharmacyProduct;
use Carbon\Carbon;
use Exception;
use Google_Client;
use Illuminate\Support\Facades\File;
use App\Http\Middleware\Zenoti;
use App\Http\Middleware\SmsController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Eshop;
use App\Models\VideoConsultation;
use App\Http\Controllers\DoctorController;
use App\Models\AiAnalysis;
use App\Models\PayByLink;
use App\Models\AiSimulator;
use App\Models\OpportunityMaster;

class ApiController extends Controller
{
    /** This API is used to save lead in altius and using leadID 
     * save record in CMA & also capture UTM data
     * */ 
    public function lead_pushtocma(Request $request){
        //SAVE LEAD TO CMA
        date_default_timezone_set('Asia/Kolkata');
        $postParameter2 = array( 
            'opportunity_lead_fullname' => $request->get("name"),
            'opportunity_lead_firstname' => $request->get("firstname"),
            'opportunity_lead_lastname' => $request->get("lastname"),
            'opportunity_lead_email' => $request->get("email"),
            'opportunity_lead_phone' => $request->get("phone"),
            'center_name' => $request->get("center"),
            'service_name' => $request->get("service_name"),
            'centerId' => "",
            'opportunity_lead_source' => $request->get("leadSource"),
            'zenotiReferralSource' => $request->get("leadSource"),
            'campaign_name'=>'',
            'adset_name'=>'',
            'ad_name'=>'',
            'Altius_response'=>"null",
            'Altius_leadId'=>"0000",
            'utm_source'=>$request->get("utm_source"),
            'utm_medium'=>$request->get("utm_medium"),
            'utm_campaign'=>$request->get("utm_campaign"),
        );
        $utm_array=array();
        if(!empty($request->get("utm_source"))){
            $utm_array['utm_source']=$request->get("utm_source");
            $utm_array['utm_medium']=$request->get("utm_medium");
            $utm_array['utm_campaign']=$request->get("utm_campaign");
            $utm_json = json_encode($utm_array);
        }else{
            $utm_array="";
            $utm_json="";
        }

        $opportunity_id_hash=time();
        DB::table('berko_opportunity_master')->insert([
            'opportunity_id_hash' =>md5($opportunity_id_hash),
            'opportunity_lead_firstname' => $postParameter2['opportunity_lead_firstname'],
            'opportunity_lead_lastname' => $postParameter2['opportunity_lead_lastname'],
            'opportunity_lead_email' => $postParameter2['opportunity_lead_email'],
            'opportunity_lead_phone' => $postParameter2['opportunity_lead_phone'],
            'center_name' => $postParameter2['center_name'],
            'service_name' => $postParameter2['service_name'],
            'opportunity_lead_source' => $postParameter2['opportunity_lead_source'],
            'Altius_response'=>$postParameter2['Altius_response'],
            'Altius_leadId'=>$postParameter2['Altius_leadId'],
            'opportunity_lead_utmparam'=>$utm_json,
            'creation_date'=>date("Y-m-d H:i:s")
        ]);
        $msg="Lead Added to CMA";
        $response['success'] = "1";
        $response['msg'] =$msg;
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function lead_pushaltius_savecma(Request $request){
        date_default_timezone_set('Asia/Kolkata');
        $msg="";
        switch($request->get("leadSource")){
            case 'Video_Consultation_Lead':
            //case 'AI_Hair_Genrator_Lead':
            case 'AI_Norwood_Scale_Lead':
                $altius_response="not sent";
                $Altius_leadId="0011";
                $msg.="Lead Skipped to Altius";
            break;
            default:
                $altiusParameter = array( 
                    'firstname' => $request->get("firstname"),
                    'lastname' => $request->get("lastname"),
                    'name' => $request->get("firstname")." ".$request->get("lastname"),
                    'email' => $request->get("email"),
                    'phone' => $request->get("phone"),
                    'centerName' => $request->get("center"),
                    'centerId' => "",
                    'leadSource' => $request->get("leadSource"),
                    'zenotiReferralSource' => $request->get("leadSource"),
                    'campaign_name'=>"",
                    'adset_name'=>'',
                    'ad_name'=>'',
                    'service_name'=> $request->get("service_name"),
                    'utm_source'=>$request->get("utm_source"),
                    'utm_medium'=>$request->get("utm_medium"),
                    'utm_campaign'=>$request->get("utm_campaign"),
            
                );
                $parambody = json_encode($altiusParameter);
                //Send Lead To Altius
                $request_headers = [
                    'webServiceName:getShopifyLeads',
                    'token:OVsQOLzdYtQtCGCu'
                ];
                $altius_apiurl = "https://berkowitslms.altius.cc/api/getLead";
            
                $curlHandle = curl_init($altius_apiurl);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parambody);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $request_headers);
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'webServiceName:getShopifyLeads', 'token:OVsQOLzdYtQtCGCu'));
                $curlResponse = curl_exec($curlHandle);
                $obj = json_decode($curlResponse);
                curl_close($curlHandle);
                if($obj->status=="Success"){
                    $msg.="Lead Sent to Altius";
                    $altius_response="Success";
                    $Altius_leadId=$obj->leadId;
                }else{
                    $msg.="ALTIUS RESPONSE: FAILED Lead Already Added";
                    $altius_response="Failed";
                    $Altius_leadId="0000";
                }
            break;

        }
        //SAVE LEAD TO CMA
        $postParameter2 = array( 
            'opportunity_lead_fullname' => $request->get("name"),
            'opportunity_lead_firstname' => $request->get("firstname"),
            'opportunity_lead_lastname' => $request->get("lastname"),
            'opportunity_lead_email' => $request->get("email"),
            'opportunity_lead_phone' => $request->get("phone"),
            'center_name' => $request->get("center"),
            'service_name' => $request->get("service_name"),
            'centerId' => "",
            'opportunity_lead_source' => $request->get("leadSource"),
            'zenotiReferralSource' => $request->get("leadSource"),
            'campaign_name'=>'',
            'adset_name'=>'',
            'ad_name'=>'',
            'Altius_response'=>$altius_response,
            'Altius_leadId'=>$Altius_leadId,
            'utm_source'=>$request->get("utm_source"),
            'utm_medium'=>$request->get("utm_medium"),
            'utm_campaign'=>$request->get("utm_campaign"),
        );
        $utm_array=array();
        if(!empty($request->get("utm_source"))){
            $utm_array['utm_source']=$request->get("utm_source");
            $utm_array['utm_medium']=$request->get("utm_medium");
            $utm_array['utm_campaign']=$request->get("utm_campaign");
            $utm_json = json_encode($utm_array);
        }else{
            $utm_array="";
            $utm_json="";
        }

        $opportunity_id_hash=time();
        DB::table('berko_opportunity_master')->insert([
            'opportunity_id_hash' =>md5($opportunity_id_hash),
            'opportunity_lead_firstname' => $postParameter2['opportunity_lead_firstname'],
            'opportunity_lead_lastname' => $postParameter2['opportunity_lead_lastname'],
            'opportunity_lead_email' => $postParameter2['opportunity_lead_email'],
            'opportunity_lead_phone' => $postParameter2['opportunity_lead_phone'],
            'center_name' => $postParameter2['center_name'],
            'service_name' => $postParameter2['service_name'],
            'opportunity_lead_source' => $postParameter2['opportunity_lead_source'],
            'Altius_response'=>$postParameter2['Altius_response'],
            'Altius_leadId'=>$postParameter2['Altius_leadId'],
            'opportunity_lead_utmparam'=>$utm_json,
            'creation_date'=>date("Y-m-d H:i:s")
        ]);
        $msg.=" | Lead Added to CMS";
        $response['success'] = "1";
        $response['msg'] =$msg;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function analytics_admin_check(Request $request){
        $phone=$request->get("phone");
        if(empty($phone)){
            $response['success'] = "0";
            $response['msg'] = __("Phone number missing");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        // Select User with conditions
        $users = DB::table('analytics_admin')
        ->where('phone', $phone)
        ->get();
        if(empty($users[0]->id)){
            $response['success'] = "0";
            $response['msg'] = __("User Does Not Exist");
            return json_encode($response, JSON_NUMERIC_CHECK);

        }
        $otp=rand(100000,999999);
        $otp_unique_id=md5($otp);
        $param_array=array(
            'sms_type'=>'otp',
            'number'=>$phone,
            'otp'=>$otp
        );
        $sendSMS=SmsController::SmsPhoneMsg91($param_array);
        $sendWhatsApp=SmsController::sendWhatsAppSMSTelephant($phone,$otp);
        //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
        if($sendSMS){
            if(!empty($request->get("request_from"))){
                $request_from=$request->get("request_from");
            }else{
                $request_from="analytics_admin";
            }
            DB::table('otp')->updateOrInsert(
                ['phone' => $phone],
                ['otp' => $otp,'request_from' => $request_from,'otp_unique_id' => $otp_unique_id,'is_active' => 1]
            );
            $response['success'] = "1";
            $response['msg'] = __("OTP SENT");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
            $response['success'] = "0";
            $response['msg'] = __("OTP NOT SENT");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }

    }
    public function create_vlc_products_checkout(Request $request){
        if(empty($request->get("vlc_id"))){
            $response['success'] = "0";
            $response['msg'] = "Parameters Missing : vlc_id";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $products = [
            ['id_product' => 24, 'id_product_attribute' => 0, 'quantity' => 1],
            ['id_product' => 21, 'id_product_attribute' => 0, 'quantity' => 1],
            ['id_product' => 22, 'id_product_attribute' => 0, 'quantity' => 1],
        ];
        $response=Eshop::create_vlc_products_checkout($products);
        return json_encode($response, JSON_NUMERIC_CHECK);

    }

    /** Creating master for visitor whenever we capture name, email and phone */
    public function create_master_account($dataArray){
        // create zenoti Account
        //$dataArray['firstname']=$request->get("firstname");
        //$dataArray['lastname']=$request->get("lastname");
        //$dataArray['name']=$dataArray['firstname']." ".$dataArray['lastname'];
        //$dataArray['email']=$request->get("email");
        //$dataArray['phone']=$request->get("phone");
        $data=Zenoti::createZenotiGuest($dataArray);
        if (array_key_exists("message",$data)){
            $zenoti_id="";
            $center_id="";
        }else{
            //var_dump($data);SUCCESS ADDED
            $zenoti_id=$data['id'];
            $center_id=$data['center_id'];
        }
        // create Ecommerce Account
                    //STEP 2 : Add record in Ecom
                    // Add or check user data in Ecommerce Store
                    $isCustomerExist=Eshop::getEcomCustomerID($dataArray['phone'],$dataArray['email']);
                    if(!$isCustomerExist){
                        // Add new customer
                        $nameArray=explode(" ",$dataArray['name']);
                        if(!empty($dataArray['password'])){
                            $password=$dataArray['password'];
                        }else{
                            $password="berko123456";
                        }
                            $param=array();
                            $param['firstname']=$nameArray[0];
                            if(empty($nameArray[1])) {
                                $lastname="NA";
                             }else{
                                $lastname=$nameArray[1];
                            }
                            $param['lastname']=$lastname;
                            $param['email']=$dataArray['email'];
                            $param['password']=$password;
                            
                            $dataCustomer=Eshop::addResource("customers","POST",$param);
                            //var_dump($dataCustomer);exit;
                            //echo "customerID=".$dataCustomer['customer']['id'];
                            $customerId = $dataCustomer['customer']['id'];
                            //return json_encode($dataCustomer, JSON_NUMERIC_CHECK);
                            }else{
                                $customerId =$isCustomerExist;
                                $param['password']="123456";
                    }
                    // create CMA Account
                    $inset = new Patient();
                    $inset->phone = $dataArray['phone'];;
                    $inset->name = $dataArray['name'];
                    $inset->password = $param['password'];
                    $inset->email =$dataArray['email'];;
                    $inset->zenoti_id=$zenoti_id;
                    $inset->center_id=$center_id;
                    $inset->id_customer_ecom=$customerId;
                    $inset->save();
                    $cma_id=$inset->id;
                    $response['success'] = "1";
                    $response['CMA_ID'] = $cma_id;
                    $response['id_customer'] = $customerId;
                    $response['zenoti_id'] = $zenoti_id;
                    return $response;
    }
    public function attach_cma_role_user(Request $request){
        if(empty($request->get("user_id")) OR empty($request->get("role_name"))){
            $response['success'] = "0";
            $response['msg'] = "Parameters Missing : user_id or role_name";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $user = Sentinel::findById($request->get("user_id")); // Find user by ID
        $role = Sentinel::findRoleBySlug($request->get("role_name")); // Find role by slug
        // Assign role to user
        $role->users()->attach($user);
        $response['success'] = "1";
        $response['msg'] = "Role assigned to user!";
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function create_cma_role(Request $request){
        // Define role data
        if(empty($request->get("slug")) OR empty($request->get("name"))){
            $response['success'] = "0";
            $response['msg'] = "Parameters Missing : slug or name";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        switch($request->get("slug")){
            case 'superadmin':
                $permission=[
                    'all.create' => true,
                    'all.update' => true,
                    'all.delete' => true,
                    'all.view' => true,
                ];
            break;
            case 'admin':
                $permission=[
                    'all.create' => true,
                    'all.update' => true,
                    'all.delete' => true,
                    'all.view' => true,
                ];
            break;
            case 'employee':
                $permission=[
                    'required.view' => true,
                ];
            break;

        }
        $roleData = [
            'slug' => $request->get("slug"),  // Unique role identifier
            'name' => $request->get("name"),
            'permissions' => $permission,
        ];
         // Create role
        $role = Sentinel::getRoleRepository()->createModel()->create($roleData);
        $response['success'] = "1";
        $response['msg'] = "Role Created : ".$role->name;
        return json_encode($response, JSON_NUMERIC_CHECK);
        //echo "Role created: " . $role->name;
    }
    public function create_cma_user(Request $request){
        if(empty($request->get("email")) OR empty($request->get("password"))){
            $response['success'] = "0";
            $response['msg'] = "Parameters Missing : email or password";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $credentials = [
            'email'    => $request->get("email"),
            'password' => $request->get("password"),
        ];
        $user = Sentinel::registerAndActivate($credentials);
        if ($user) {
            $response['success'] = "0";
            $response['msg'] = "User created";
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else {
            $response['success'] = "0";
            $response['msg'] = "User Not Created";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    public function set_session(Request $request){
        session_start();
        ob_start();
        if(!empty($request->latitude) AND !empty($request->longitude)){
            session(['lat' => $request->latitude]);
            session(['lng' => $request->longitude]);
        }else{
            $response['success'] = "0";
            $response['msg'] = "LAT LNG MISSING";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $rand=rand(100000,999999);
        DB::table('session_lat_lng')->insert([
            'session_id' => bcrypt($rand),
            'user_id' => 0,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
        ]);
        $response['msg'] = "Session Set";
        //var_dump($response);
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    /**  APIs for Admin Dashboard & Emails */
    public function ecom_abandoned_cart(Request $request){
        // Ecom Database config
        $host = '127.0.0.1';
        $dbname = 'i9995583_q9tk1';
        $user = 'ecomuser';
        $pass = 'Berkowits@2025@1';
        $charset = 'utf8mb4';

        // Set up DSN and PDO
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);

            $sql = "
                SELECT 
                    c.id_cart,
                    cu.firstname,
                    cu.lastname,
                    cu.email,
                    a.phone,
                    a.phone_mobile,
                    a.address1,
                    a.address2,
                    a.postcode,
                    a.city,
                    a.id_country,
                    c.date_add AS cart_created,
                    p.id_product,
                    pl.name AS product_name,
                    cp.quantity
                FROM kznj_cart c
                LEFT JOIN kznj_orders o ON (c.id_cart = o.id_cart)
                LEFT JOIN kznj_customer cu ON (c.id_customer = cu.id_customer)
                LEFT JOIN (
                    SELECT a1.*
                    FROM kznj_address a1
                    INNER JOIN (
                        SELECT id_customer, MAX(date_add) AS latest_address
                        FROM kznj_address
                        WHERE deleted = 0
                        GROUP BY id_customer
                    ) a2 ON a1.id_customer = a2.id_customer AND a1.date_add = a2.latest_address
                ) a ON (a.id_customer = cu.id_customer)
                LEFT JOIN kznj_cart_product cp ON (cp.id_cart = c.id_cart)
                LEFT JOIN kznj_product p ON (p.id_product = cp.id_product)
                LEFT JOIN kznj_product_lang pl ON (pl.id_product = p.id_product AND pl.id_lang = 1)
                WHERE o.id_order IS NULL
                AND c.id_customer > 0
                ORDER BY c.date_add DESC
            ";

            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();

            // Return JSON response
            header('Content-Type: application/json');
           $alldata=json_encode([
                'status' => 'success',
                'count' => count($results),
                'ecom_abandoned_cart_list' => $results
            ]);
            $response['status'] = "1";
            $response['success'] = "1";
            $response['count'] = count($results);
            $response['ecom_abandoned_cart_list'] = $results;
            return json_encode($response, JSON_NUMERIC_CHECK);

        } catch (PDOException $e) {
            // Error response
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

    }
    public function website_contact_form_data(Request $request){
        $slected_date="";
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            //$records = AiAnalysis::orderBy('id', 'desc')->get();
            $records = OpportunityMaster::whereBetween('creation_date', [$request->get("start_date"), $request->get("end_date")])
            ->where(function ($query) {
                $query->where('opportunity_lead_source', 'Web-contact-us-form')
                      ->orWhere('opportunity_lead_source', 'Website_Contact_Form');
            })
            ->orderBy('opportunity_id', 'desc')
            ->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = OpportunityMaster::whereDate('creation_date', $request->get("start_date"))->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            /*$records = OpportunityMaster::where(function ($query) {
                $query->where('opportunity_lead_source', 'Web-contact-us-form')
                      ->orWhere('opportunity_lead_source', 'Website_Contact_Form');
            })
            ->orderBy('opportunity_id', 'desc')
            ->get();*/
           // $slected_date=$request->get("start_date");
            //$slected_date=date('Y-m-d');
            $startDate = date('Y-m-d', strtotime('-6 days')); // 6 days ago
            $endDate = date('Y-m-d'); // today
            $slected_date= $startDate."-".$endDate;
            $records = OpportunityMaster::whereBetween('creation_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('opportunity_lead_source', 'Web-contact-us-form')
                    ->orWhere('opportunity_lead_source', 'Website_Contact_Form');
            })
            ->orderBy('opportunity_id', 'desc')
            ->get();

        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = OpportunityMaster::whereDate('creation_date', $yesterday)
            ->where(function ($query) {
                $query->where('opportunity_lead_source', 'Web-contact-us-form')
                      ->orWhere('opportunity_lead_source', 'Website_Contact_Form');
            })
            ->orderBy('opportunity_id', 'desc')
            ->get();
        }
        $list = [];

        foreach ($records as $record) {
            $list[] = [
                "id" => $record->opportunity_id,
                "opportunity_id" => $record->opportunity_id,
                "opportunity_id_hash" => $record->opportunity_id_hash,
                "opportunity_title" => $record->opportunity_title,
                "opportunity_lead_firstname" => $record->opportunity_lead_firstname,
                "opportunity_lead_lastname" => $record->opportunity_lead_lastname,
                "opportunity_lead_email" => $record->opportunity_lead_email,
                "opportunity_lead_phone" => $record->opportunity_lead_phone,
                "opportunity_lead_source" => $record->opportunity_lead_source,
                "opportunity_lead_utmparam" => $record->opportunity_lead_utmparam,
                "center_name" => $record->center_name,
                "service_name" => $record->service_name,
                "stage_name" => $record->stage_name,
                "call_status" => $record->call_status,
                "disposition" => $record->disposition,
                "price" => $record->price,
                "creation_date" => $record->creation_date,
                "is_enabled" => $record->is_enabled,
                "opportunity_lead_msg" => $record->opportunity_lead_msg,
                "opportunity_lead_appointment_date_time" => $record->opportunity_lead_appointment_date_time,
                "Altius_response" => $record->Altius_response,
                "Altius_leadId" => $record->Altius_leadId,
            ];
        }
        
        

        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['website_contact_form_data'] = $list;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function landing_page_form_data(Request $request){
        $slected_date="";
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            //$records = AiAnalysis::orderBy('id', 'desc')->get();
            $records = OpportunityMaster::whereBetween('creation_date', [$request->get("start_date"), $request->get("end_date")])
            ->where('opportunity_lead_source', "Landing_Page_Contact_Form")
            ->orderBy('opportunity_id', 'desc')
            ->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = OpportunityMaster::whereDate('creation_date', $request->get("start_date"))->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            $records = OpportunityMaster::where('opportunity_lead_source', "Landing_Page_Contact_Form")->orderBy('opportunity_id','desc')->get();
            $slected_date=$request->get("start_date");
        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = OpportunityMaster::whereDate('creation_date', $yesterday)
            ->where('opportunity_lead_source', "Landing_Page_Contact_Form")
            ->get();
        }
        $list = [];

        foreach ($records as $record) {
            $list[] = [
                "id" => $record->opportunity_id,
                "opportunity_id" => $record->opportunity_id,
                "opportunity_id_hash" => $record->opportunity_id_hash,
                "opportunity_title" => $record->opportunity_title,
                "opportunity_lead_firstname" => $record->opportunity_lead_firstname,
                "opportunity_lead_lastname" => $record->opportunity_lead_lastname,
                "opportunity_lead_email" => $record->opportunity_lead_email,
                "opportunity_lead_phone" => $record->opportunity_lead_phone,
                "opportunity_lead_source" => $record->opportunity_lead_source,
                "opportunity_lead_utmparam" => $record->opportunity_lead_utmparam,
                "center_name" => $record->center_name,
                "service_name" => $record->service_name,
                "stage_name" => $record->stage_name,
                "call_status" => $record->call_status,
                "disposition" => $record->disposition,
                "price" => $record->price,
                "creation_date" => $record->creation_date,
                "is_enabled" => $record->is_enabled,
                "opportunity_lead_msg" => $record->opportunity_lead_msg,
                "opportunity_lead_appointment_date_time" => $record->opportunity_lead_appointment_date_time,
                "Altius_response" => $record->Altius_response,
                "Altius_leadId" => $record->Altius_leadId,
            ];
        }
        
        

        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['landing_page_form_data'] = $list;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function ai_hair_generator(Request $request){
        $slected_date="";
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            //$records = AiAnalysis::orderBy('id', 'desc')->get();
            $records = AiSimulator::whereBetween('created_at', [$request->get("start_date"), $request->get("end_date")])->orderBy('id', 'desc')->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = AiSimulator::whereDate('created_at', $request->get("start_date"))->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            //$records = AiSimulator::orderBy('id','desc')->get();
            //$slected_date=$request->get("start_date");
            //records for last 7 days
            $startDate = date('Y-m-d', strtotime('-6 days')); // 6 days ago
            $endDate = date('Y-m-d'); // today
            $slected_date= $startDate."-".$endDate;
            $records = AiSimulator::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = AiSimulator::whereDate('created_at', $yesterday)->get();
        }
        $list = [];

        foreach ($records as $record) {
            $list[] = [
                "id" => $record->id,
                "id_enc" => $record->id_enc,
                "original_file_name" => $record->original_file_name,
                "edited_file_name" => $record->edited_file_name,
                "simulator_used" => $record->simulator_used,
                "simulator_used_type" => $record->simulator_used_type,
                "chosen_color" => $record->chosen_color,
                "guest_phone" => $record->guest_phone,
                "guest_firstname" => $record->guest_firstname,
                "guest_lastname" => $record->guest_lastname,
                "guest_email" => $record->guest_email,
                "created_at" => $record->created_at,
                "updated_at" => $record->updated_at,
                "additional_data" => $record->additional_data,
                "reponse_task_details" => $record->reponse_task_details,
                "task_id" => $record->task_id,
            ];
        }
        
        

        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['ai_hair_generator'] = $list;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function ai_analysis_list(Request $request){
        $slected_date="";
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            //$records = AiAnalysis::orderBy('id', 'desc')->get();
            $records = AiAnalysis::whereBetween('date_add', [$request->get("start_date"), $request->get("end_date")])->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = AiAnalysis::whereDate('date_add', $request->get("start_date"))->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            $records = AiAnalysis::orderBy('id','desc')->get();
            $slected_date=$request->get("start_date");
        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = AiAnalysis::whereDate('date_add', $yesterday)->get();
        }
        $list=array();
        foreach($records as $record){
            $arr=array(
                "id"=>$record['id'],
                "enc_id"=>$record['id_enc'],
                "client_first_name"=>$record['fullname'],
                "client_phone"=>$record['phone'],
                "client_email"=>$record['email'],
                "client_gender"=>$record['gender'],
                "primary_concern"=>$record['primary_concern'],
                "created_at"=>$record['date_add'],
            );
            $list[]=$arr;
        }

        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['ai_analysis_list'] = $list;
        return json_encode($response, JSON_NUMERIC_CHECK);



    }
    public function dashboard_counters(Request $request){
        $startOfMonth = Carbon::now()->startOfMonth();
        $today = Carbon::now();
        $startDateMonth=explode(" ",$startOfMonth);
        $TodayDateMonth=explode(" ",$today);
        $totaldoctor = Doctors::where('profile_type','1')->count();
        $totalvc = VideoConsultation::all()->count();
        $totalai_analysis = AiAnalysis::all()->count();
        $total_pay_by_link= PayByLink::all()->count();
        //$totalappointment = count(BookAppointment::all());
        $totalappointment = ZenotiServiceBooking::all()->count();
        $total_ai_hair= AiSimulator::all()->count();
        $totalLandingForm=OpportunityMaster::where('opportunity_lead_source', "Landing_Page_Contact_Form")->get()->count();
        // This Month
        $CurrentMonthLandingFormDataCount = OpportunityMaster::whereBetween('creation_date', [$startOfMonth, $today])
        ->where('opportunity_lead_source', "Landing_Page_Contact_Form")
        ->count();
        $CurrentMonthPayByLinkCount = PayByLink::whereBetween('created_at', [$startOfMonth, $today])
        ->count();
        $CurrentMonthVCCount = VideoConsultation::whereBetween('created_at', [$startOfMonth, $today])
        ->count();
        $CurrentMonthAppointmentCount = ZenotiServiceBooking::whereBetween('created_at', [$startOfMonth, $today])
        ->count();
        $CurrentMonthNorwoodCount = AiAnalysis::whereBetween('date_add', [$startOfMonth, $today])
        ->count();
        $CurrentMonthAiHairCount = AiSimulator::whereBetween('created_at', [$startOfMonth, $today])
        ->count();
        $dashboard_counters=array(
            "total_pay_by_link"=>$total_pay_by_link,
            "totalvc"=>$totalvc,
            "totalai_analysis"=>$totalai_analysis,
            "totaldoctor"=>$totaldoctor,
            "totalappointment"=>$totalappointment,
            "totalAiHair"=>$total_ai_hair,
            "totalLandingForm"=>$totalLandingForm,
            "currentmonth_vc"=>$CurrentMonthVCCount,
            "currentmonth_appointment"=>$CurrentMonthAppointmentCount,
            "currentmonth_norwood"=>$CurrentMonthNorwoodCount,
            "currentmonth_landing_form"=>$CurrentMonthLandingFormDataCount,
            "currentmonth_paybylink"=>$CurrentMonthPayByLinkCount,
            "currentmonth_aihair"=>$CurrentMonthAiHairCount,
            "startMonth"=>$startDateMonth[0],
            "Today"=>$TodayDateMonth[0]
        );
        $response['status'] = "Success";
        $response['counters'] = $dashboard_counters;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function pay_by_link(Request $request){
        $slected_date="";
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            //$records = AiAnalysis::orderBy('id', 'desc')->get();
            $records = PayByLink::whereBetween('created_at', [$request->get("start_date"), $request->get("end_date")])->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = PayByLink::whereDate('created_at', $request->get("start_date"))->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            $records = PayByLink::orderBy('id','desc')->get();
            $slected_date=$request->get("start_date");
        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = PayByLink::whereDate('created_at', $yesterday)->get();
        }
        $list = [];

        foreach ($records as $record) {
            $list[] = [
                "id" => $record->id, // encrypted id
                "leadID" => $record->leadID,
                "payment_link_id" => $record->payment_link_id,
                "payment_id" => $record->payment_id,
                "name" => $record->name,
                "email" => $record->email,
                "phone" => $record->phone,
                "amount" => $record->amount,
                "description" => $record->description,
                "policy_name" => $record->policy_name,
                "payment_link_url" => $record->payment_link_url,
                "more_deatils" => $record->more_deatils,
                "status" => $record->status,
                "altius_status" => $record->altius_status,
                "zenoti_giftcard_id" => $record->zenoti_giftcard_id,
                "zenoti_invoice_id" => $record->zenoti_invoice_id,
                "created_at" => $record->created_at,
                "updated_at" => $record->updated_at,
            ];
        }
        
        

        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['pay_bu_link_list'] = $list;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function video_consultation_booking_list(Request $request){
        $slected_date=""; $today_date=date('Y-m-d');
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            $records = VideoConsultation::whereBetween('created_at', [$request->get("start_date"), $request->get("end_date")])->get();
            $records_today = VideoConsultation::whereDate('preferred_date', $today_date)->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = VideoConsultation::whereDate('created_at', $request->get("start_date"))->get();
            $records_today = VideoConsultation::whereDate('preferred_date', $today_date)->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            $records = VideoConsultation::orderBy('id','desc')->get();
            $records_today = VideoConsultation::whereDate('preferred_date', $today_date)->get();
            $slected_date=$request->get("start_date");
        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = VideoConsultation::whereDate('created_at', $yesterday)->get();
            $records_today = VideoConsultation::whereDate('preferred_date', $today_date)->get();
        }

        //$records = VideoConsultation::whereDate('created_at', $yesterday)->get();
        $list=array();
        $tried=array();
        $todaylist=array();
        foreach($records_today as $record_today){
            $center=Doctors::where('center_id',$record_today['center_id'])->first();
            if(empty($center->name)){
                $center_name="NA";
            }else{
                $center_name=$center->name;
            }
            $arr_today=array(
                "ID"=>$record_today['id'],
                "VLC_ID"=>$record_today['encryption_id'],
                "center_name"=>$center_name,
                "client_first_name"=>$record_today['firstname'],
                "client_city"=>$record_today['city'],
                "language"=>$record_today['language'],
                "client_phone"=>$record_today['phone'],
                "doctor_details"=>$record_today['doctor_details'],
                "order_status"=>$record_today['order_status'],
                "VC_status"=>$record_today['status'],
                "payment_status"=>$record_today['payment_status'],
                "transaction_id"=>$record_today['transaction_id'],
                "preferred_date"=>$record_today['preferred_date'],
                "time_slot"=>$record_today['time_slot'],
                "created_at"=>$record_today['created_at'],
                "google_meet_link"=>$record_today['google_meet_link'],
            );
             $todaylist[]=$arr_today;

        }
        foreach($records as $record){
            $center=Doctors::where('center_id',$record['center_id'])->first();
            if(empty($center->name)){
                $center_name="NA";
            }else{
                $center_name=$center->name;
            }
            $arr=array(
                "ID"=>$record['id'],
                "VLC_ID"=>$record['encryption_id'],
                "center_name"=>$center_name,
                "client_first_name"=>$record['firstname'],
                "client_city"=>$record['city'],
                "language"=>$record['language'],
                "client_phone"=>$record['phone'],
                "doctor_details"=>$record['doctor_details'],
                "order_status"=>$record['order_status'],
                "VC_status"=>$record['status'],
                "payment_status"=>$record['payment_status'],
                "transaction_id"=>$record['transaction_id'],
                "preferred_date"=>$record['preferred_date'],
                "time_slot"=>$record['time_slot'],
                "created_at"=>$record['created_at'],
                "google_meet_link"=>$record['google_meet_link'],
            );
            if(empty($record['transaction_id']) OR $record['transaction_id']==NULL){
                $tried[]=$arr;
            }else{
                $list[]=$arr;
            }
        }
        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['TodayVideoConsultationScheduled'] = $todaylist;
        $response['PaidVideoConsultationBooking'] = $list;
        $response['UnpaidVideoConsultationBooking'] = $tried;
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function zenoti_service_booking_list(Request $request){
        $slected_date="";
        if(!empty($request->get("start_date")) && !empty($request->get("end_date"))){
            $records = ZenotiServiceBooking::whereBetween('created_at', [$request->get("start_date"), $request->get("end_date")])->get();
            //$records = ZenotiServiceBooking::whereBetween('created_at', [$request->get("start_date"), $request->get("end_date")])->get();
            $slected_date=$request->get("start_date")."-".$request->get("end_date");
        }elseif(!empty($request->get("start_date"))){
            $records = ZenotiServiceBooking::whereDate('created_at', $request->get("start_date"))->get();
            $slected_date=$request->get("start_date");
        }elseif(!empty($request->get("result")) && $request->get("result")=="all"){
            $records = ZenotiServiceBooking::orderBy('id','desc')->get();
            $slected_date="All Result";
        }else{
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $slected_date=$yesterday ;
            //$records=VideoConsultation::orderBy('id', 'desc')->get();
            $records = ZenotiServiceBooking::whereDate('created_at', $yesterday)->get();
        }
        //$yesterday = date('Y-m-d', strtotime('-1 day'));
        $list=array();
        $tried=array();
        //$records = ZenotiServiceBooking::whereDate('created_at', $yesterday)->get();
        foreach($records as $record){
            $guest=Patient::where('zenoti_id',$record['zenoti_guest_id'])->first();
            if(empty($guest->name)){
                $guest_name="NA";
            }else{
                $guest_name=$guest->name;
            }
            if(empty($guest->phone)){
                $phone="NA";
            }else{
                $phone=$guest->phone;
            }
            $center=Doctors::where('center_id',$record['zenoti_center_id'])->first();
            if(empty($center->name)){
                $center_name="NA";
            }else{
                $center_name=$center->name;
            }
            $arr=array(
                'id'=>$record['id'],
                'zenoti_guest_id'=>$record['zenoti_guest_id'],
                'zenoti_therapist_id'=>$record['zenoti_therapist_id'],
                'zenoti_service_id'=>$record['zenoti_service_id'],
                'zenoti_center_id'=>$record['zenoti_center_id'],
                'zenoti_booking_id'=>$record['zenoti_booking_id'],
                'appointment_id'=>$record['appointment_id'],
                'created_at'=>$record['created_at'],
                'booked_from'=>$record['booked_from'],
                'guest_name'=>$guest_name,
                'guest_phone'=>$phone,
                'service_name'=>"",
                'center_name'=>$center_name,
                'therapist_name'=>"",


            );
            if(empty($record['appointment_id']) OR $record['appointment_id']==NULL){
                $tried[]=$arr;
            }else{
                $list[]=$arr;
            }
            
        }
        //$getAppointment = ZenotiServiceBooking::all();
        $response['status'] = "1";
        $response['success'] = "1";
        $response['date'] = $slected_date;
        $response['ConfirmedAppointment'] = $list;
        $response['TriedAppointment'] = $tried;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function save_lead_send_to_altius(Request $request){
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required",
            "phone" => "required",
            "leadSource" =>"required",
        ];
        $messages = array(
            'firstname.required' => "firstname is required",
            'lastname.required' => "lastname is required",
            'email.required' => "email is required",
            'phone.required' => "phone is required",
            'leadSource.required' => "leadSource is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['status'] = "0";
            $response['success'] = "0";
            $response['msg'] = $message;
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $msg="";
        $postParameter = array( 
            'firstname' => $request->get("firstname"),
            'lastname' => $request->get("lastname"),
            'name' => $request->get("firstname")." ".$request->get("lastname"),
            'email' => $request->get("email"),
            'phone' => $request->get("phone"),
            'centerName' => $request->get("center"),
            'centerId' => "",
            'leadSource' => $request->get("leadSource"),
            'zenotiReferralSource' => "HO-Landing Page",
            'campaign_name'=>'',
            'adset_name'=>'',
            'ad_name'=>'',
            'service_name'=> $request->get("service_name"),
    
        );
        // create account in Zenoti,Ecom,CMA 
        $create_master_account_response=$this->create_master_account($postParameter);
        // create account in Zenoti,Ecom,CMA  END
        $parambody = json_encode($postParameter);
        //Send Lead To Altius
        $request_headers = [
            'webServiceName:getShopifyLeads',
            'token:OVsQOLzdYtQtCGCu'
        ];
        $altius_apiurl = "https://berkowitslms.altius.cc/api/getLead";
    
        $curlHandle = curl_init($altius_apiurl);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parambody);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'webServiceName:getShopifyLeads', 'token:OVsQOLzdYtQtCGCu'));
        $curlResponse = curl_exec($curlHandle);
        $obj = json_decode($curlResponse);
        //var_dump($curlResponse);
        //echo $obj->status;
        curl_close($curlHandle);
        if($obj->status=="Success"){
            $msg.="Lead Sent to Altius";
            $Altius_leadId=$obj->leadId;
        }else{
            $msg.="ALTIUS RESPONSE: FAILED Lead Already Added";
            $Altius_leadId="0000";
        }
        //return $obj->status;
        //SAVE LEAD TO CMA
        $postParameter2 = array( 
            'opportunity_lead_fullname' => $request->get("name"),
            'opportunity_lead_firstname' => $request->get("firstname"),
            'opportunity_lead_lastname' => $request->get("lastname"),
            'opportunity_lead_email' => $request->get("email"),
            'opportunity_lead_phone' => $request->get("phone"),
            'center_name' => $request->get("center"),
            'service_name' => $request->get("service_name"),
            'centerId' => "",
            'opportunity_lead_source' => $request->get("leadSource"),
            'zenotiReferralSource' => "HO-Landing Page",
            'campaign_name'=>'',
            'adset_name'=>'',
            'ad_name'=>'',
            'Altius_response'=>$obj->status,
            'Altius_leadId'=>$Altius_leadId
        );
        $opportunity_id_hash=time();
        DB::table('berko_opportunity_master')->insert([
            'opportunity_id_hash' =>md5($opportunity_id_hash),
            'opportunity_lead_firstname' => $postParameter2['opportunity_lead_firstname'],
            'opportunity_lead_lastname' => $postParameter2['opportunity_lead_lastname'],
            'opportunity_lead_email' => $postParameter2['opportunity_lead_email'],
            'opportunity_lead_phone' => $postParameter2['opportunity_lead_phone'],
            'center_name' => $postParameter2['center_name'],
            'service_name' => $postParameter2['service_name'],
            'opportunity_lead_source' => $postParameter2['opportunity_lead_source'],
            'Altius_response'=>$postParameter2['Altius_response'],
            'Altius_leadId'=>$postParameter2['Altius_leadId']
        ]);
        $msg.=" | Lead Added to CMS";
        $response['success'] = "1";
        $response['msg'] =$msg;
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function save_general_lead(Request $request){
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "opportunity_lead_firstname" => "required",
            "opportunity_lead_email" => "required",
            "opportunity_lead_phone" => "required",
            "center_name" => "required",
            "service_name" => "required"
        ];
        $messages = array(
            'opportunity_lead_firstname.required' => "Name is required",
            'opportunity_lead_email.required' => "Email is required",
            'opportunity_lead_phone.required' => "Phone is required",
            'center_name.required' => "center_name is required",
            'service_name.required' => "service_name is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['status'] = "0";
            $response['success'] = "0";
            $response['msg'] = $message;
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
            $postParameter = array( 
                'opportunity_lead_fullname' => $request->get("name"),
                'opportunity_lead_firstname' => $request->get("opportunity_lead_firstname"),
                'opportunity_lead_lastname' => $request->get("opportunity_lead_lastname"),
                'opportunity_lead_email' => $request->get("opportunity_lead_email"),
                'opportunity_lead_phone' => $request->get("opportunity_lead_phone"),
                'center_name' => $request->get("center_name"),
                'service_name' => $request->get("service_name"),
                'centerId' => "",
                'opportunity_lead_source' => $request->get("BerkoLeadSource"),
                'zenotiReferralSource' => "HO-Landing Page",
                'campaign_name'=>'',
                'adset_name'=>'',
                'ad_name'=>'',
                'Altius_response'=>$request->get("Altius_response")
            );
            $opportunity_id_hash=time();
            DB::table('berko_opportunity_master')->insert([
                'opportunity_id_hash' =>md5($opportunity_id_hash),
                'opportunity_lead_firstname' => $postParameter['opportunity_lead_firstname'],
                'opportunity_lead_lastname' => $postParameter['opportunity_lead_lastname'],
                'opportunity_lead_email' => $postParameter['opportunity_lead_email'],
                'opportunity_lead_phone' => $postParameter['opportunity_lead_phone'],
                'center_name' => $postParameter['center_name'],
                'service_name' => $postParameter['service_name'],
                'opportunity_lead_source' => $postParameter['opportunity_lead_source'],
                'Altius_response'=>$postParameter['Altius_response']
            ]);
            $response['success'] = "1";
            $response['msg'] = "Lead Added";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    public function delete_my_account(Request $request){
        $getuser = Patient::where("id", $request->get("user_id"))->first();
        if(!empty($request->get("user_id")) AND $getuser){
            $response['success'] = "1";
            $response['msg'] = "Account Deleted";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
            $response['success'] = "0";
            $response['msg'] = "Invalid Account id";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    public function createZenotiGiftCardInvoice(Request $request){
        if(empty($request->get("amount")) OR empty($request->get("policy")) OR empty($request->get("email")) OR empty($request->get("name")) OR empty($request->get("phone"))){
            $response['success'] = "0";
            $response['msg'] = "Parameters Missing : amount or policy or email or name or phone";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $param=array(
            'amount'=>$request->get("amount"),
            'policy'=>$request->get("policy"),
            'email'=>$request->get("email"),
            'name'=>$request->get("name"),
            'phone'=>$request->get("phone")

        );
        $return_array=Zenoti::createGiftcardInvoice($param);
        $response['data'] =$return_array;
        return json_encode($response, JSON_NUMERIC_CHECK);


    }
    public function old2newurl(Request $request){
        if(!empty($request->get("url"))){
            $data=UrlRedirect::where("old_url",$request->get("url"))->first();
            if($data){
                $response['success'] = "1";
                $response['msg'] = "Data Found";
                $response['data'] =$data;
                return json_encode($response, JSON_NUMERIC_CHECK);
            }else{
                $response['success'] = "0";
                $response['msg'] = "Old URL not found";
                return json_encode($response, JSON_NUMERIC_CHECK);
            }
        }else{
            $response['success'] = "0";
            $response['msg'] = "Url value missing!";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    // 
    public function sendWhatsAPPTelephant(Request $request){
        if(empty($request->get("phone")) OR empty($request->get("template_id"))){
            $response['success'] = "0";
            $response['msg'] = __("Phone or  template_id  missing");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $param=array();
        switch($request->get("template_id")){
            case 'aih_result_download1':
                $param=array(
                    'phone'=>$request->get("phone"),
                    'firstname'=>$request->get("firstname"),
                    'result_url'=>$request->get("result_url"),

                );
            break;
            case 'vlc_share_prescription_1':
                $param=array(
                    'phone'=>$request->get("phone"),
                    'client_name'=>$request->get("client_name"),
                    'doctor_name'=>$request->get("doctor_name"),
                    'prescription_url'=>$request->get("prescription_url"),

                );

            break;
            case 'order-status-update':
            break;
            case 'otp':
                $templateId="cma_otp_4";
                $otp="";
            break;
        }
            $result=SmsController::sendMultiFormatWhatsAppTelephant($request->get("template_id"),$param);
            $response['success'] = "1";
            $response['msg'] = $result;
            return json_encode($response, JSON_NUMERIC_CHECK);

    }
    // no use
    public function sendWhatsAppSMSTelephant($type,$number){
        switch($type){
            case 'order-confirmation':
                $templateId="";
            break;
            case 'order-status-update':
            break;
            case 'otp':
                $templateId="cma_otp_4";
                $otp="";
            break;
        }
    }
    public function send_voucher(Request $request){
        $phone=$request->get("phone");
        if(empty($phone)){
            $response['success'] = "0";
            $response['msg'] = __("Phone number missing");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $otp=rand(100000,999999);
        $otp_unique_id=md5($otp);
        $param_array=array(
            'sms_type'=>'voucher',
            'number'=>$phone,
            'otp'=>$otp,
            'phone'=>$phone
        );
        $sendSMS=SmsController::SmsPhoneMsg91($param_array);
        $sendWhatsApp=SmsController::sendMultiFormatWhatsAppTelephant("promoters_otp",$param_array);
        //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
        if($sendSMS){
            if(!empty($request->get("request_from"))){
                $request_from=$request->get("request_from");
            }else{
                $request_from=null;
            }
            DB::table('otp')->updateOrInsert(
                ['phone' => $phone],
                ['otp' => $otp,'request_from' => $request_from,'otp_unique_id' => $otp_unique_id,'is_active' => 1]
            );
            $response['success'] = "1";
            $response['msg'] = __("OTP SENT");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
            $response['success'] = "0";
            $response['msg'] = __("OTP NOT SENT");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    public function send_otp(Request $request){
        $phone=$request->get("phone");
        if(empty($phone)){
            $response['success'] = "0";
            $response['msg'] = __("Phone number missing");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $otp=rand(100000,999999);
        $otp_unique_id=md5($otp);
        $param_array=array(
            'sms_type'=>'otp',
            'number'=>$phone,
            'otp'=>$otp
        );
        $sendSMS=SmsController::SmsPhoneMsg91($param_array);
        $sendWhatsApp=SmsController::sendWhatsAppSMSTelephant($phone,$otp);
        //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
        if($sendSMS){
            if(!empty($request->get("request_from"))){
                $request_from=$request->get("request_from");
            }else{
                $request_from=null;
            }
            DB::table('otp')->updateOrInsert(
                ['phone' => $phone],
                ['otp' => $otp,'request_from' => $request_from,'otp_unique_id' => $otp_unique_id,'is_active' => 1]
            );
            $response['success'] = "1";
            $response['msg'] = __("OTP SENT");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
            $response['success'] = "0";
            $response['msg'] = __("OTP NOT SENT");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    /** API KEY AUTHENTICATION */
    public function logActivity($calledApi){
        $headerList=getallheaders();
        if (array_key_exists("user_id",$headerList)){
            if(empty($headerList['user_id'])){
                $user_id=0;
            }else{
                $user_id=$headerList['user_id'];
            }
        }else{
            $user_id=0;
        }
        if (array_key_exists("source",$headerList)){
            if(empty($headerList['source'])){
                $source="App";
            }else{
                $source=$headerList['source'];
            }
        }else{
            $source="App";
        }
        $logactivity=Authenticate::logActivity($calledApi,$user_id,$source);
        return;
    }
    /** API KEY AUTHENTICATION END */
    public function verify_otp(Request $request){
        $logActivity=$this->logActivity("verify_otp");
        /** API KEY AUTHENTICATION */
        /*$logActivity=$this->logActivity("verify_otp");
        if(!$apikeyStatus){
            $response['success'] = "0";
            $response['msg'] = __("check api_auth_key missing or invalid ");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }*/
        /** API KEY AUTHENTICATION END */
        $phone=$request->get("phone");
        $otp=$request->get("otp");
        if(empty($phone) OR empty($otp)){
            $response['success'] = "0";
            $response['msg'] = __("Phone or otp number missing");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $verifyOtp=Otp::where("phone",$phone)->where("otp",$otp)->where("is_active",1)->first();
        if($verifyOtp){
            // SET OTP =0 means used
            DB::table('otp')->updateOrInsert(
                ['phone' => $request->get("phone")],
                ['is_active' => 0]
            );
            $response['success'] = "1";
            $response['msg'] = __("OTP MATCHED And VERIFIED");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
            $response['success'] = "0";
            $response['msg'] = __("OTP NOT MATCHED");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    //Added By Shak
    public function create_service_cma(Request $request){
        if(!empty($request->get("booking_id"))){
            $booking_id=$request->get("booking_id");
            $store=new ZenotiServiceBooking();
            $store->zenoti_guest_id=$request->get("zenoti_guest_id");
            $store->zenoti_therapist_id=$request->get("zenoti_therapist_id");
            $store->zenoti_service_id=$request->get("zenoti_service_id");
            $store->zenoti_center_id=$request->get("zenoti_center_id");
            $store->zenoti_booking_id=$booking_id;
            $store->booked_from="App";
            $store->save();
            if($store){
                $response['success'] = "1";
                $response['msg'] = __("Service Saved to CMA");
                $response['data'] = $store;
                return json_encode($response, JSON_NUMERIC_CHECK);
            }
        }
        $response['success'] = "0";
        $response['msg'] = __("Fields Missing ! Required booking_id,zenoti_guest_id,zenoti_therapist_id,zenoti_service_id,zenoti_center_id");
        $response['method'] ="post(form-body data)";
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function update_service_cma(Request $request){
        if(!empty($request->get("reservation_id")) && !empty($request->get("booking_id"))){
            $reservationId=$request->get('reservation_id');
            $booking_id=$request->get('booking_id');
            // update is_reserved & reservation_id in CMA DB
            ZenotiServiceBooking::where('zenoti_booking_id', $booking_id)->update(['is_reserved' => 1, 'reservation_id' => $reservationId]);
            $response['success'] = "1";
            $response['msg'] = __("Reservation Id Up[dated to CMA");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        if(!empty($request->get("appointment_id")) && !empty($request->get("booking_id"))){
            $booking_id=$request->get('booking_id');
            $appointment_id=$request->get('appointment_id');
            ZenotiServiceBooking::where('zenoti_booking_id', $booking_id)->update(['is_confirmed' => 1, 'appointment_id' => $appointment_id]);
            // creating booking data in CMA
            $this->create_cma_booking($appointment_id);
            $response['success'] = "1";
            $response['msg'] = __("Appointment Id Up[dated to CMA");
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $response['success'] = "0";
        $response['msg'] = __("Field Missing");
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    //created by shak to create booking data in cma
    public function create_cma_booking($apoointment_id){
        // call to cma service booking DB
        $bookingData = ZenotiServiceBooking::where('appointment_id', $apoointment_id)->first();
        if($bookingData ){
            $client_zenoti_id=$bookingData['zenoti_guest_id']; //user_id
            $userDetails=Patient::where('zenoti_id', $client_zenoti_id)->first();
            $user_id=$userDetails['id']; //user_id
            ////////// Doctor / Center Details /////
            $berkowits_center_id=$bookingData['zenoti_center_id'];// doctoe_id
            $doctorDetails=Doctors::where('center_id', $berkowits_center_id)->first();
            $doctor_id=$doctorDetails['id'];//doctoe_id
            ///////////////////////////////
            $zenoti_booking_id=$bookingData['zenoti_booking_id'];// zenoti_booking_id
            $zenoti_appointment_id=$bookingData['appointment_id'];// zenoti_booking_id
        }else{
            // call to zenoti API
            $appointmentDetail=Zenoti::getAppointmentDetail($apoointment_id);
            $zenoti_appointment_id=$appointmentDetail[0]['appointment_id'];
            $client_zenoti_id=$appointmentDetail[0]['guest']['id'];
            $userDetails=Patient::where('zenoti_id', $client_zenoti_id)->first();
            $user_id=$userDetails['id']; //user_id
            ////////// Doctor / Center Details 
            ///// no centerid in appointment details API so retreiving it from guest details
            $guestDetails=Zenoti::guestDetailsByID($client_zenoti_id);
            $berkowits_center_id=$guestDetails['center_id'];// doctoe_id
            $doctorDetails=Doctors::where('center_id', $berkowits_center_id)->first();
            $doctor_id=$doctorDetails['id'];//doctoe_id
            $zenoti_booking_id=null;
        }
        // create CMA booking
        $data = new BookAppointment();
        $data->user_id = $user_id;
        $data->doctor_id = $doctor_id;
        $data->zenoti_booking_id = $zenoti_booking_id;
        $data->zenoti_appointment_id = $zenoti_appointment_id;
        $data->save();
        if($data){
            $response['success'] = "1";
            $response['msg'] = "Booking Created in CMA";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
    }
    public function connectycube_register(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "type" => "required",
        ];
        if ($request->type == 1) {
            $rules['patient_id'] = 'required';
        } else {
            $rules['doctor_id'] = 'required';
        }
        $messages = array(
            'type.required' => "type is required",
            'patient_id.required' => "patient_id is required",
            'doctor_id.required' => "doctor_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->type == 1) {
                $data = Patient::find($request->patient_id);
                if ($data) {
                    $login_field = "";
                    $user_id = "";
                    $connectycube_password = "";
                    if (env('ConnectyCube') == true) {
                        $login_field = $data->phone . rand() . "#1";
                        $user_id = $this->signupconnectycude($data->name, $data->password, $data->email, $data->phone, $login_field);
                        $connectycube_password = $data->password;
                    }
                    $data->connectycube_user_id = $user_id;
                    $data->login_id = $login_field;
                    $data->connectycube_password = $connectycube_password;
                    $connrctcube = ($data->connectycube_user_id);
                    if ($connrctcube == "0-email must be unique") {
                        $response['status'] = "0";
                        $response['msg'] = "Email Or Mobile Number Already Register in ConnectCube";
                    } else {
                        $data->save();
                        $response['status'] = "1";
                        $response['msg'] =  "ConnectCube Register Successfully";
                        $response['data'] = array("connectycube_user_id" => $data->connectycube_user_id, "login_id" => $login_field);
                    }
                } else {
                    $response = array("status" => 0, "msg" => "Patient id Not Found");
                }
            } else {
                $data = Doctors::find($request->doctor_id);
                if ($data) {
                    $login_field = "";
                    $user_id = "";
                    $connectycube_password = "";
                    if (env('ConnectyCube') == true) {
                        $login_field =$data->phoneno . rand() . "#2";
                        $user_id = $this->signupconnectycude($data->name, $data->password, $data->email, $data->phoneno, $login_field);
                        $connectycube_password = $data->password;
                    }
                    $data->connectycube_user_id = $user_id;
                    $data->login_id = $login_field;
                    $data->connectycube_password = $connectycube_password;
                    $connrctcube = ($data->connectycube_user_id);
                    if ($connrctcube == "0-email must be unique") {
                        $response['status'] = "0";
                        $response['msg'] = "Email Or Mobile Number Already Register in ConnectCube";
                    } else {
                        $data->save();
                        $response['status'] = "1";
                        $response['msg'] =  "ConnectCube Register Successfully";
                        $response['data'] = array("connectycube_user_id" => $data->connectycube_user_id, "login_id" => $login_field);
                    }
                } else {
                    $response = array("status" => 0, "msg" => "Doctors id Not Found");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    // ////// ///////  Ecommerce Berkowits Store API  //////// //////// ////// //
    public function reorder(Request $request){
        if(!empty($request->id_order)){
            $apiurl=env('BERKOWITS_PRODUCT_API_URL').'orders/'.$request->id_order;
            $data=Eshop::curlEshop($apiurl,"GET");
            $old_id_cart = $data['order']['id_cart'];
            //return json_encode($data, JSON_NUMERIC_CHECK);
            //exit;

            // latest new cart id 
            $LastcartIdData=Eshop::curlEshop(env('BERKOWITS_PRODUCT_API_URL').'carts?sort=[id_DESC]&limit=1',"GET");
            //return json_encode($LastcartIdData, JSON_NUMERIC_CHECK);
            //exit;
            $last_cart_id = $LastcartIdData['carts'][0]['id'];
            $new_id_cart=$last_cart_id+1;
            $apiurlold_cart=env('BERKOWITS_PRODUCT_API_URL').'carts/'.$old_id_cart."?output_format=XML";
            $old_cart_Details=Eshop::curlEshop($apiurlold_cart,"GET");
            $old_cart_Details['cart']['id'] = ''; // with new id
            
            //var_dump($id_cart);
            // converting json to xml
            $xml = new \SimpleXMLElement('<prestashop/>');
            Eshop::arrayToXml($old_cart_Details, $xml);
            $xmstr=$xml->asXML();
            $responseNewCart=Eshop::curlEshopPost("carts/".$new_id_cart,"POST",$xmstr);
            return json_encode($responseNewCart, JSON_NUMERIC_CHECK);
        } else{
            $response['success'] = 0;
            $response['msg'] = "ERROR: id_order missing";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }

    }
    public function order_payments(Request $request){
        if(empty($request->id_order) OR empty($request->id_txn)){
            $response['success'] = 0;
            $response['msg'] = "ERROR: id_order or  id_txn missing";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $apiorderDetails=env('BERKOWITS_PRODUCT_API_URL')."orders/".$request->id_order;
        $orderDetails=Eshop::curlEshop($apiorderDetails,"GET");
        $order_ref=$orderDetails['order']['reference'];

        $apiorderPaymentDetails=env('BERKOWITS_PRODUCT_API_URL')."order_payments/?display=full&filter[order_reference]=[".$order_ref."]";
        $orderPaymentDetails=Eshop::curlEshop($apiorderPaymentDetails,"GET");
        $id_order_payment=$orderPaymentDetails['order_payments'][0]['id'];
        
        $response['success'] = 1;
        $response['msg'] = "Success";
        $response['order_ref'] = $order_ref;
        $response['id_order_payment'] = $id_order_payment;

        // Patch in order_payment
        $param2 = array(
            'id'=>$id_order_payment,
            'transaction_id' => $request->id_txn,
            
        );
        $patchData=Eshop::addResource("order-payment-patch","PATCH",$param2);
        $response['orderPayemnt'] = $patchData;
        //$response['paymentDetails'] = $orderPaymentDetails;
        return json_encode($response, JSON_NUMERIC_CHECK); 

    }
    public function orders(Request $request){
        $method = strtolower($request->method());
        if($method=="get"){
            // order list by cutomer
            if(!empty($request->id_customer)){
                $apiurl=env('BERKOWITS_PRODUCT_API_URL').'orders?sort=[id_DESC]&display=full&filter[id_customer]=['.$request->id_customer.']';
                $data=Eshop::curlEshop($apiurl,"GET");
                return json_encode($data, JSON_NUMERIC_CHECK);
            } 
            if(!empty($request->id_order)){
                $apiurl=env('BERKOWITS_PRODUCT_API_URL').'orders/'.$request->id_order;
                $data=Eshop::curlEshop($apiurl,"GET");
                //var_dump($data['order']['id_address_delivery']);exit;
                if(empty($data['order']['id_address_delivery']) OR $data['order']['id_address_delivery']==0){
                    $id_address_delivery=0;
                }else{
                    $id_address_delivery=$data['order']['id_address_delivery'];
                }
                //$id_address_delivery=$data['order']['id_address_delivery'];
                //var_dump($data['order']['associations']['order_rows']);
                $img_array=[];
                foreach($data['order']['associations']['order_rows'] as $row){
                    $id_product=$row['product_id'];
                    $productbaseurl=env('BERKOWITS_PRODUCT_API_URL')."products";
                    $apiurlDetails=$productbaseurl."/".$id_product."?display=[id,name,id_category_default,id_default_image,link_rewrite]";
                    $dataProductDetails=Eshop::curlEshop($apiurlDetails,"GET");
                    //$idCategoryDefault = $dataProductDetails['products'][0]['id_category_default'];
                    $productImage = env('BERKOWITS_PRODUCT_URL') . $dataProductDetails['products'][0]['id_default_image'] . "-catalog_large/" . $dataProductDetails['products'][0]['link_rewrite'] . ".jpg"; 
                    //var_dump($id_product);
                    $ref_array=array(
                        'product_id'=>$id_product,
                        'image_url'=>$productImage
                    );
                    $img_array[]=$ref_array;
                }
                // Address Details
                if(empty($id_address_delivery) OR $id_address_delivery==0){
                    $data_address=0;
                }else{
                    $apiurladdress=env('BERKOWITS_PRODUCT_API_URL').'addresses/'.$id_address_delivery;
                    $data_address=Eshop::curlEshop($apiurladdress,"GET");
                }
                /////////
                $response['success'] = 1;
                $response['msg'] = "Order Details!";
                $response['orderDetails'] =$data;
                $response['imgList'] =$img_array;
                $response['AddressDelivery'] =$data_address;
                return json_encode($response, JSON_NUMERIC_CHECK);
                //return json_encode($data,$img_array, JSON_NUMERIC_CHECK);
            } 
            $response['success'] = 0;
            $response['msg'] = "ERROR: id_customer or id_order missing!Check";
            return json_encode($response, JSON_NUMERIC_CHECK);

        }
        // Method POST OR PUT : Create order
        if(empty($request->id_cart) OR empty($request->id_customer) OR empty($request->id_address) OR $request->id_address==0){
            $response['success'] = 0;
            $response['msg'] = "ERROR: id_cart or  id_customer, id_address missing or id_address value is 0!";
            return json_encode($response, JSON_NUMERIC_CHECK);
        } 
        if(empty($request->payment_type)){
            $payment="Cash on delivery (COD)";
            $payment_module="ps_cashondelivery";
            $order_status=13;
        }else{
            $payment=$request->payment_type;
            $payment_module=$request->payment_gateway_name;
            $order_status=2;
        }
        $param = array(
            'id_customer' => $request->id_customer,
            'id_cart' => $request->id_cart, // 109 for India in e-commerce
            'id_currency' => 2,
            'id_address_invoice' => $request->id_address,
            'id_address_delivery' => $request->id_address,
            'id_carrier' => 10,
            'current_state' => $order_status,
            'payment' => $payment,
            'module' => $payment_module,
            'id_lang' => 1,
            'total_paid' => $request->total_paid,
            'total_paid_real' => $request->total_paid_real,
            'total_products' => $request->total_products,
            'total_products_wt' => $request->total_products_wt,
            'conversion_rate' => '1.000000'
        );
        $data=Eshop::addResource("orders","POST",$param);
        $lastOrderID=Eshop::getLastOrderId($request->id_customer);
        if ($lastOrderID>0){
            $response['success'] = "1";
            $response['msg'] ="Order Placed Successfully";
            $response['lastOrderID'] =$lastOrderID;
            // Execute Patch
            $param2 = array(
                'id'=>$lastOrderID,
                'current_state' => $order_status,
                'id_address_invoice' => $request->id_address,
                'id_address_delivery' => $request->id_address,
                
            );
            $patchData=Eshop::addResource("order-patch","PATCH",$param2);
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        
    }
    public function show_cart(Request $request){
        if(empty($request->id_cart)){
            $response['success'] = 0;
            $response['msg'] = "id_cart missing(id_cart) ";
            return json_encode($response, JSON_NUMERIC_CHECK);

        }
        $productbaseurl=env('BERKOWITS_PRODUCT_API_URL')."carts";
        $apiurlDetails=$productbaseurl."/".$request->id_cart."";
        $cartDetails=Eshop::curlEshop($apiurlDetails,"GET");

        // Adding more fields in cart_rows
        $data =$cartDetails;
        // New fields to add in each cart row
        if(!empty($data)){
            foreach ($data['cart']['associations']['cart_rows'] as &$cartRow) {
                $product_id=$cartRow['id_product'] ;
                if($product_id>0){
                    $productbaseurl=env('BERKOWITS_PRODUCT_API_URL')."products";
                    $apiurlDetails=$productbaseurl."/".$product_id;
                    
                    $dataProductDetails=Eshop::curlEshop($apiurlDetails,"GET");
                    $price=$dataProductDetails['product']['price'];
                    $price_tax_incl=round($price+$price*9/100,2);
                    $productImage = env('BERKOWITS_PRODUCT_URL') . $dataProductDetails['product']['id_default_image'] . "-catalog_large/" . $dataProductDetails['product']['link_rewrite'] . ".jpg"; 
                    $cartRow['price_tax_excl'] = $price; // Adding price field
                    $cartRow['price_tax_incl'] = $price_tax_incl; // Adding price field
                    $cartRow['product_image'] = $productImage; // Adding discount field
                    $cartRow['name'] = $dataProductDetails['product']['name']; // Adding discount field
    
                }

                
            }
            return json_encode($data, JSON_NUMERIC_CHECK);
        }else{
            $data['msg']="No Products";
            return json_encode($data, JSON_NUMERIC_CHECK);

        }

        
        
    }
    public function add_to_cart(Request $request){
        if(empty($request->id_customer)){
            $response['success'] = 0;
            $response['msg'] = "id_customer missing(id_customer) ";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $customerId = $request->id_customer;
        // Step 1: Check if Customer has a Cart (or Create a New One)
        //$customerId = 1; // Replace with actual customer ID
        //$cartsXML = Eshop::makeRequest(env('BERKOWITS_PRODUCT_API_URL') . 'carts?display=[id]&filter[id_customer]=' . $customerId);
        $cartsXML = Eshop::makeRequest(env('BERKOWITS_PRODUCT_API_URL') . 'carts?sort=[id_DESC]&limit=1&display=[id]&filter[id_customer]=' . $customerId);
        $carts = new \SimpleXMLElement($cartsXML);
        $cartId = (count($carts->carts->cart) > 0) ? (int)$carts->carts->cart[0]->id : null;
        // check if order is placed with cartid or not
        $apiurlcheck=env('BERKOWITS_PRODUCT_API_URL').'orders?display=[id]&filter[id_cart]=['.$cartId.']';
        $cart_order_relation=Eshop::curlEshop($apiurlcheck,"GET");
        if(empty($cart_order_relation)){

        }else{
            // if order placed with that cart id .... create new cart 
            $cartId=null; 
            // update id_cart in patient master table
            DB::table('patient')->updateOrInsert(
                ['id_customer_ecom' => $customerId],
                ['id_cart' => 0]
            );
        }
        /*if(empty($request->id_cart)){
            $cartId=null;
        }else{
            $cartId=$request->id_cart;
        }*/
         // everytime new cart
        //var_dump($cartId);exit;//21
        // If no cart exists, create a new one
        //$cartId =536;
        if (!$cartId) {
            $cartSchemaXML = Eshop::makeRequest(env('BERKOWITS_PRODUCT_API_URL')  . 'carts?schema=blank');
            $cartXML = simplexml_load_string($cartSchemaXML);
            $cartXML->cart->id_customer = $customerId;
            $cartXML->cart->id_currency = 2; // Replace with your currency ID
            $cartXML->cart->id_lang = 1; // Language ID
            if(!empty($request->id_product)){
            }
            // Convert to XML string and create cart
            $cartResponse = Eshop::makeRequest(env('BERKOWITS_PRODUCT_API_URL')  . 'carts', 'POST', $cartXML->asXML());
            $cartResponseXML = new \SimpleXMLElement($cartResponse);
            //var_dump($cartResponseXML);exit;
            $cartId = (int)$cartResponseXML->cart->id;
        }
        ////////////// Worked till first cart createion with virtual product entry//////
        define('PS_SHOP_PATH', env('BERKOWITS_PRODUCT_API_URL')); // Change to your shop URL
        define('PS_WS_AUTH_KEY', env('BERKOWITS_PRODUCT_API_KEY')); // Replace with your API key
        // Cart ID to update
        $cart_id = $cartId ; // Replace with your actual cart ID
        // update id_cart in patient master table
        DB::table('patient')->updateOrInsert(
            ['id_customer_ecom' => $customerId],
            ['id_cart' => $cartId]
        );
        // Retrieve the existing cart data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, PS_SHOP_PATH . "carts/$cart_id?output=XML");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode(PS_WS_AUTH_KEY . ':')
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        // Check if the response is valid
        if (!$response) {
            die("Error retrieving cart.");
        }
        // Load XML and modify the cart
        $xml = new \SimpleXMLElement($response);
        // Delete Product From Cart ///
        if(!empty($request->action)){
            switch($request->action){
                case 'delete_product':
                    foreach ($xml->cart->associations->cart_rows->cart_row as $cartRow) {
                        if ((int)$cartRow->id_product == $request->id_product) {
                            $dom = dom_import_simplexml($cartRow);
                            $dom->parentNode->removeChild($dom);
                            $response2['msg'] = "Product deleted from cart successfully: ";
                            break;
                        }
                    }
                break;
            }
        }else{
        // Add product or update quantity
        $productExists = false;
        foreach ($xml->cart->associations->cart_rows->cart_row as $cartRow) {
            if ((int)$cartRow->id_product == $request->id_product) {
                $cartRow->quantity = (int)$cartRow->quantity + $request->quantity;
                $productExists = true;
                $response2['msg'] = "Product Quantity Updated successfully: ";
                //var_dump("product exist");
                break;
            }
        }
        if(!$productExists){
            // IF product not exist in cart Example: Add a new product to cart
            $new_product = $xml->cart->associations->cart_rows->addChild('cart_row');
            $new_product->addChild('id_product', $request->id_product); // New Product ID
            $new_product->addChild('quantity', $request->quantity); // Quantity
            $response2['msg'] = "Product added to cart successfully: ";
        }
        }
        // Convert XML back to string
        $updated_xml = $xml->asXML();
        // Send PUT request to update cart
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, PS_SHOP_PATH . "carts/$cart_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode(PS_WS_AUTH_KEY . ':'),
            'Content-Type: text/xml'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $updated_xml);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // Check response
        if ($httpCode == 200 || $httpCode == 201) {
            //echo "Cart updated successfully:\n$response";
            $response2['success'] = 1;
            $response2['id_product'] =$request->id_product ;
            $response2['id_cart'] =$cartId;
            //$response2['data'] =$response;
            return json_encode($response2, JSON_NUMERIC_CHECK);
        } else {
            $response2['success'] =0;
            $response2['msg'] ="Failed to update cart";
            $response2['data'] =$response;
            return json_encode($response2, JSON_NUMERIC_CHECK);
            //echo "Failed to update cart. Response:\n$response";
        }
    }
    public function addresses(Request $request){
        if(!empty($request->id_customer)){
            $id_customer=$request->id_customer;
        }else{
            if(empty($request->cmaphone) OR empty($request->cmaemail)){
                $response['success'] = 0;
                $response['msg'] = "USER CMA phone & Email Required (cmaphone,cmaemail) ";
                return json_encode($response, JSON_NUMERIC_CHECK);
            }
            $id_customer=Eshop::getEcomCustomerID($request->cmaphone,$request->cmaemail);

        }

        if($id_customer){
            $method = strtolower($request->method());
            switch($method ){
                case 'get':
                        $apiurl=env('BERKOWITS_PRODUCT_API_URL')."addresses?display=full&filter[id_customer]=[".$id_customer."]";
                        $addressList=Eshop::curlEshop($apiurl,"GET");
                        $response['success'] = 1;
                        if(empty($addressList)){
                            //echo "hi";
                            $addresses=array(
                                "addresses" =>[]
                            );
                            //$jsonenc=json_encode($addresses,JSON_NUMERIC_CHECK);
                            $response['addressList'] =$addresses;
                        }else{
                            $response['addressList'] = $addressList;
                        }
                        
                        
                        return json_encode($response, JSON_NUMERIC_CHECK);
                break;
                case 'post':
                case 'put':
                    $postfields=array(
                        'id_customer'=>$id_customer,
                        'alias'=>$request->address_type,
                        'lastname'=>$request->last_name,
                        'firstname'=>$request->first_name,
                        'address1'=>$request->address.",".$request->address2,
                        'address2'=>$request->landmark,
                        'postcode'=>$request->zip_code,
                        'city'=>$request->city,
                        'phone'=>$request->phone,
                        'phone_mobile'=>$request->phone,
                    );
                    $data=Eshop::addResource("addresses","POST",$postfields);
                    return json_encode($data, JSON_NUMERIC_CHECK);
                break;
                case 'patch':
                    if(empty($request->id_address)){
                        $response['success'] = 0;
                        $response['msg'] = "Address ID Missing, Patch not possible (id_address) ";
                        return json_encode($response, JSON_NUMERIC_CHECK);
                    }
                    // Get the XML Details of Address
                    $apiurl=env('BERKOWITS_PRODUCT_API_URL')."addresses/".$request->id_address;
                    $authorizationKey = base64_encode(env('BERKOWITS_PRODUCT_API_KEY') . ':');
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                    CURLOPT_URL =>$apiurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 100,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Basic $authorizationKey",
                        "accept: application/json",
                        "output_format: XML"
                    ],
                    ]);
                    $response = curl_exec($curl);
                    //var_dump($response);exit;
                    $err = curl_error($curl);
                    curl_close($curl);
                    $xml = simplexml_load_string($response);
                    //var_dump($xml);exit;
                    // find whicg field to be updated
                    if(!empty($request->address_type)){
                        $xml->address->alias = $request->address_type; 
                    }
                    if(!empty($request->last_name)){
                        $xml->address->lastname = $request->last_name; 
                    }
                    if(!empty($request->first_name)){
                        $xml->address->firstname = $request->first_name; 
                    }
                    if(!empty($request->landmark)){
                        $xml->address->alias = $request->landmark; 
                    }
                    if(!empty($request->address)){
                        $xml->address->address1 = $request->address; 
                    }
                    if(!empty($request->address2)){
                        $xml->address->address2 = $request->address2; 
                    }
                    if(!empty($request->phone)){
                        $xml->address->phone = $request->phone; 
                    }
                    if(!empty($request->zip_code)){
                        $xml->address->postcode = $request->zip_code; 
                    }
                    $updatedXml = $xml->asXML();
                    //$data=Eshop::addResource("addresses","POST",$updatedXml);
                    $data=Eshop::curlEshopPost("addresses","PATCH",$updatedXml);
                    return json_encode($data, JSON_NUMERIC_CHECK);
                break;
                case 'delete':
                    if(empty($request->id_address)){
                        $response['success'] = 0;
                        $response['msg'] = "Address ID Missing, Patch not possible (id_address) ";
                        return json_encode($response, JSON_NUMERIC_CHECK);
                    }
                    $apiurl=env('BERKOWITS_PRODUCT_API_URL')."addresses/".$request->id_address;
                    $data=Eshop::curlEshop($apiurl,strtoupper("delete"));
                    return json_encode($data, JSON_NUMERIC_CHECK);
                break;
            }
        }else{
            // No record found in Ecommerce
            $response['success'] = 0;
            $response['msg'] = "No Customer Record Found in Ecommerce , please add new customer first!";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        // Get id_customer from phone or by email.
        //$apiurl=env('BERKOWITS_PRODUCT_API_URL')."addresses/".$product_id."?display=[id,name,meta_description,price,link_rewrite,date_add,date_upd,id_default_image]";
        //$custData=Eshop::curlEshop("","");
    }
    public function add_customer_ecom(Request $request){
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required",
            "password" => "required"
        ];
        $messages = array(
            'firstname.required' => "firstname is required",
            'lastname.required' => "lastname is required",
            'email.required' => "email is required",
            'password.required' => "password is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else {
            $param=array();
            $param['firstname']=$request->firstname;
            $param['lastname']=$request->lastname;
            $param['email']=$request->email;
            $param['password']=$request->password;
            $data=Eshop::addResource("customers","POST",$param);
            return json_encode($data, JSON_NUMERIC_CHECK);
        }
    }
    public function product_search(Request $request){
        $productsearchurl=env('BERKOWITS_PRODUCT_API_URL')."search";
        $query=str_replace(" ","-",$request->keyword);
        $param="?query=$query&language=1";
        $apiurl=$productsearchurl.$param;
        $data=Eshop::curlEshop($apiurl,"GET");
        // Get Product Details
        foreach($data['products'] as $product){
            $product_id=$product['id'];
            $apiurlDetails=env('BERKOWITS_PRODUCT_API_URL')."products/".$product_id."?display=[id,name,meta_description,price,link_rewrite,date_add,date_upd,id_default_image]";
            $dataProductDetails=Eshop::curlEshop($apiurlDetails,"GET");
            $price=$dataProductDetails['products'][0]['price'];
            $price_tax_incl=round($price+$price*0.09);
            $productImage = env('BERKOWITS_PRODUCT_URL') . $dataProductDetails['products'][0]['id_default_image'] . "-catalog_large/" . $dataProductDetails['products'][0]['link_rewrite'] . ".jpg"; 
            $ref_array=array(
                'id'=>$dataProductDetails['products'][0]['id'],
                'pharmacy_id'=>156,
                'name'=>$dataProductDetails['products'][0]['name'],
                'description'=>$dataProductDetails['products'][0]['meta_description'],
                'price'=>$price_tax_incl,
                'price_tax_excl'=>$price,
                'price_tax_incl'=>$price_tax_incl,
                'image'=>$productImage,
                'link'=>$dataProductDetails['products'][0]['link_rewrite'],
                'created_at'=>$dataProductDetails['products'][0]['date_add'],
                'updated_at'=>$dataProductDetails['products'][0]['date_upd'],
            );
            $res[]=$ref_array;
        }
        $response['data']=$res;
        $response['pharmacy_tax']=0; 
        $response['pharmacy_delivery_charge']=0; 
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function product_details(Request $request){
        $productbaseurl=env('BERKOWITS_PRODUCT_API_URL')."products";
        $apiurlDetails=$productbaseurl."/".$request->product_id."";
        $dataProductDetails=Eshop::curlEshop($apiurlDetails,"GET");
        $price=$dataProductDetails['product']['price'];
        $price_tax_incl=round($price+$price*0.09);
        $productImage = env('BERKOWITS_PRODUCT_URL') . $dataProductDetails['product']['id_default_image'] . "-catalog_large/" . $dataProductDetails['product']['link_rewrite'] . ".jpg"; 
        $imageIds = $dataProductDetails['product']['associations']['images'];
        $catIds = $dataProductDetails['product']['associations']['categories'];
        $imageList=array();$catList=array();
        foreach ($imageIds as $image) {
            //echo "Image ID: " . $image['id'] . "<br>";
            $imageList[]=env('BERKOWITS_PRODUCT_URL') . $image['id'] . "-catalog_large/" . $dataProductDetails['product']['link_rewrite'] . ".jpg"; 
        }
        foreach ($catIds as $catId) {
            $catbaseurl=env('BERKOWITS_PRODUCT_API_URL')."categories/".$catId['id'];
            $catDetails=Eshop::curlEshop($catbaseurl,"GET");
            $catList[]=$catDetails;
        }
        $response['msg']="Product Details"; 
        $response['success']=1; 
        $response['productPrice']=$price_tax_incl; 
        $response['productPriceTaxExcl']=$price; 
        $response['productPriceTaxIncl']=$price_tax_incl; 
        $response['productImageUrl']=$productImage; 
        $response['data'] = $dataProductDetails['product'];
        $response['imageList'] =$imageList;
        $response['CategoryList'] =$catList;
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function product_list(Request $request){
        $apibaseurl=env('BERKOWITS_PRODUCT_API_URL')."products";
        if(empty($_REQUEST['limit'])){
            $limit="?limit=0,6";
            $apiurl=$apibaseurl.$limit;
            //$next_url=$apibaseurl."?limit=10,20";
            $next_url=env('APP_URL')."api/product_list?limit=6,12";
        }else{
            $l=explode(",",$_REQUEST['limit']);
            $endlimit=$l[1];
            $newlimit=$endlimit.",".$endlimit+6;
            $apiurl=$apibaseurl."?limit=".$newlimit;
            //$nexturllimit=($endlimit).','.$endlimit+6;
            //$next_url=$apibaseurl."?limit=".$nexturllimit;
            $next_url=env('APP_URL')."api/product_list?limit=".$newlimit;
        }
        $data=Eshop::curlEshop($apiurl,"GET");
        $response['data'] = $data;
        $res=[];
        foreach($data['products'] as $product){
            $product_id=$product['id'];
            $apiurlDetails=$apibaseurl."/".$product_id."?display=[id,name,meta_description,price,link_rewrite,date_add,date_upd,id_default_image]";
            $dataProductDetails=Eshop::curlEshop($apiurlDetails,"GET");
            $price=$dataProductDetails['products'][0]['price'];
            $price_tax_incl=round($price+$price*0.09);
            $productImage = env('BERKOWITS_PRODUCT_URL') . $dataProductDetails['products'][0]['id_default_image'] . "-catalog_large/" . $dataProductDetails['products'][0]['link_rewrite'] . ".jpg"; 
            $ref_array=array(
                'id'=>$dataProductDetails['products'][0]['id'],
                'pharmacy_id'=>156,
                'name'=>$dataProductDetails['products'][0]['name'],
                'description'=>$dataProductDetails['products'][0]['meta_description'],
                'price'=>$price_tax_incl,
                'price_tax_excl'=>$price,
                'price_tax_incl'=>$price_tax_incl,
                'image'=>$productImage,
                'link'=>$dataProductDetails['products'][0]['link_rewrite'],
                'created_at'=>$dataProductDetails['products'][0]['date_add'],
                'updated_at'=>$dataProductDetails['products'][0]['date_upd'],
            );
            $res[]=$ref_array;
        }
        $response['pharmacy_tax']=0; 
        $response['pharmacy_delivery_charge']=0; 
        $response['msg']="Berkowits Ecommerec Product List"; 
        $response['success']=1; 
        $response['next_url']=$next_url; 
        $response['data'] = $res;
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
     // ////// ///////  Ecommerce Berkowits Store API END  //////// //////// ////// //
    public function pharmacy_medicines(Request $request)
    {
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "pharmacy_id" => "required",
        ];
        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $setting = Setting::find(1);
            if ($request->keyword) {
                $data = PharmacyProduct::where('pharmacy_id', $request->pharmacy_id)->where('name', 'LIKE', '%' . $request->keyword . '%')->get();
                if (count($data) != 0) {
                    $response['success'] = "1";
                    $response['msg'] = __("message.Medicines_Get_Success");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                } else {
                    $response['success'] = "0";
                    $response['msg'] = __("message.Medicines_data_Not_Found");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                    // $response = array("status" => 0, "msg" => "Medicines data Not Found");
                }
            } else {
                $data = PharmacyProduct::where('pharmacy_id', $request->pharmacy_id)->get();
                if (count($data) != 0) {
                    $response['success'] = "1";
                    $response['msg'] = __("message.Medicines_Get_Success");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                } else {
                    $response['success'] = "0";
                    $response['msg'] = __("message.Medicines_data_Not_Found");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                    // $response = array("status" => 0, "msg" => "Medicines data Not Found");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function medicines_detail(Request $request)
    {
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "medicine_id" => "required",
        ];
        $messages = array(
            'medicine_id.required' => "medicine_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyProduct::find($request->medicine_id);
            if ($data) {
                $response['success'] = "1";
                $response['msg'] = __("message.Medicines_Get_Success");
                $response['data'] = $data;
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.Medicines_data_Not_Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function medicine_order(Request $request)
    {
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "user_id" => "required",
            "pharmacy_id" => "required",
            "phoneno" => "required",
            "total" => "required",
            "product_json" => "required",
            "payment_type" => "required",
            "address" => "required",
            "message" => "required",
            "tax" => "required",
            "delivery_charge" => "required",
            "tax_pr" => "required",
        ];
        if ($request->payment_type != 'COD') {
            $rules['transaction_id'] = 'required';
        }
        $messages = array(
            'user_id.required' => "user_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'phoneno.required' => "phoneno is required",
            'total.required' => "total is required",
            'product_json.required' => "product_json is required",
            'payment_type.required' => "payment_type is required",
            'address.required' => "address is required",
            'message.required' => "message is required",
            'tax.required' => "tax is required",
            'delivery_charge.required' => "delivery_charge is required",
            'tax_pr.required' => "tax_pr is required",
            'transaction_id.required' => "transaction_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->payment_type == 'COD') {
                $data = new PharmacyOrder();
                $data->Pharmacy_id = $request->pharmacy_id;
                $data->tax_pr = $request->tax_pr;
                $data->tax = $request->tax;
                $data->delivery_charge = $request->delivery_charge;
                $data->total = $request->total;
                $data->phone = $request->phoneno;
                $data->message = $request->message;
                $data->address = $request->address;
                $data->payment_type = $request->payment_type;
                $data->is_completed = '1';
                $data->order_type = 2;
                $data->status = 0;
                $data->user_id = $request->user_id;
                $data->save();
                if ($request->product_json) {
                    $products = json_decode($request->product_json, true);
                    // return $products;
                    foreach ($products as $id => $item) {
                        $add = new PharmacyOrderData();
                        $add->order_id = $data->id;
                        $add->service_id = $item['id'];
                        $add->qty = $item['quantity'];
                        $add->name = $item['title'];
                        $add->price = $item['price'];
                        $add->save();
                    }
                }
            } else {
                $data = new PharmacyOrder();
                $data->Pharmacy_id = $request->pharmacy_id;
                $data->tax_pr = $request->tax_pr;
                $data->tax = $request->tax;
                $data->delivery_charge = $request->delivery_charge;
                $data->total = $request->total;
                $data->phone = $request->phoneno;
                $data->message = $request->message;
                $data->address = $request->address;
                $data->payment_type = $request->payment_type;
                $data->is_completed = '1';
                $data->order_type = 2;
                $data->status = 0;
                $data->user_id = $request->user_id;
                $data->transaction_id = $request->transaction_id;
                $data->save();
                if ($request->product_json) {
                    $products = json_decode($request->product_json, true);
                    // return $products;
                    foreach ($products as $id => $item) {
                        $add = new PharmacyOrderData();
                        $add->order_id = $data->id;
                        $add->service_id = $item['id'];
                        $add->qty = $item['quantity'];
                        $add->name = $item['title'];
                        $add->price = $item['price'];
                        $add->save();
                    }
                }
            }
            $response['status'] = "1";
            $response['msg'] = __("message.Medicines_Order_Success");
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function prescription_order(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "user_id" => "required",
            "pharmacy_id" => "required",
            "prescription_file" => "required",
            "phoneno" => "required",
            "address" => "required",
            "message" => "required",
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'prescription_file.required' => "prescription_file is required",
            'phoneno.required' => "phoneno is required",
            'address.required' => "address is required",
            'message.required' => "message is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = new PharmacyOrder();
            if ($request->hasFile('prescription_file')) {
                $file = $request->file('prescription_file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/orderprescription/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('prescription_file')->move($destinationPath, $picture);
            }
            $data->prescription = $picture;
            $data->Pharmacy_id = $request->pharmacy_id;
            $data->phone = $request->phoneno;
            $data->message = $request->message;
            $data->address = $request->address;
            $data->is_completed = '1';
            $data->order_type = 1;
            $data->status = 0;
            $data->user_id = $request->user_id;
            $data->save();
            $response['status'] = "1";
            $response['msg'] = __("message.Prescription_Order_Success");
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function view_order(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "order_id" => "required",
        ];
        $messages = array(
            'order_id.required' => "order_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyOrder::find($request->order_id);
            if ($data) {
                $data1 = PharmacyOrderData::where('order_id', $data->id)->get();
                if (!$data1->isEmpty()) {
                    $sub = 0;
                    foreach ($data1 as $orderDetail) {
                        $medicine = PharmacyProduct::find($orderDetail->service_id);
                        if ($medicine && $medicine->image) {
                            $orderDetail->medicine_img = asset("public/upload/pharmacymedicine") . '/' . $medicine->image;
                        } else {
                            $orderDetail->medicine_img = "";
                        }
                        $sub += $orderDetail->price * $orderDetail->qty;
                    }
                    $data->subtotal = $sub;
                }
                $pharmacy = Doctors::find($data->Pharmacy_id);
                if ($pharmacy) { // Check if the pharmacy exists
                    $data->Pharmacy_name = $pharmacy->name;
                    $data->Pharmacy_address = $pharmacy->address;
                    $data->Pharmacy_email = $pharmacy->email;
                    $data->Pharmacy_phoneno = $pharmacy->phoneno;
                    $data->Pharmacy_image = $pharmacy->image
                        ? asset("public/upload/doctors") . '/' . $pharmacy->image
                        : "";
                } else {
                    // Handle case if pharmacy not found
                    $data->Pharmacy_name = "Pharmacy not found";
                    $data->Pharmacy_address = "";
                    $data->Pharmacy_email = "";
                    $data->Pharmacy_phoneno = "";
                    $data->Pharmacy_image = "";
                }
                $data->medicine = $data1;
                $user = Patient::find($data->user_id);
                if ($user) {
                    $data->user_image = $user->profile_pic ? asset("public/upload/profile/" . $user->profile_pic) : "";
                    $data->user_name = $user->name;
                    $data->user_email = $user->email;
                } else {
                    $data->user_image = "";
                    $data->user_name = "";
                    $data->user_email = "";
                }
                $setting = Setting::find(1);
                $data->admin_delivery_charge = $setting->pharmacy_delivery_charge;
                $data->admin_tax = $setting->pharmacy_tax;
                $response['status'] = "1";
                $response['msg'] = __("message.Order Details");
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
                // $response['data']=$data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function change_pharmacyorder_status(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "order_id" => "required",
            "status" => "required",
        ];
        $messages = array(
            'order_id.required' => "order_id is required",
            'status.required' => "status is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyOrder::find($request->order_id);
            if ($data) {
                $data->status = $request->status;
                $data->save();
                if ($request->get("status") == '1') { // accept
                    $msg = __("message.pharmacy_order_Accept_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '2') { //reject
                    $msg = __("message.pharmacy_order_reject_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '3') { //complete
                    $msg = __("message.pharmacy_order_complete_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '4') { //waiting
                    $msg = __("message.pharmacy_order_user_Accept_msg");
                    $android = $this->sendNotifications($msg, $data->Pharmacy_id, "doctor_id", $data->id);
                } else if ($request->get("status") == '6') { //cancel
                    $msg =  __("message.pharmacy_order_user_reject_msg");
                    $android = $this->sendNotifications($msg, $data->Pharmacy_id, "doctor_id", $data->id);
                } else if ($request->get("status") == '7') { //Prepared
                    $msg =  __("message.pharmacy_order_Prepared_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '8') { //Out_for_Delivery
                    $msg =  __("message.pharmacy_order_Out_for_Delivery_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                }
                $response['status'] = "1";
                $response['msg'] = __("message.Order_Status_Change_Success");
                // $response['data']=$data;
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function prescription_addprice(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "order_id" => "required",
            "price" => "required",
        ];
        $messages = array(
            'order_id.required' => "order_id is required",
            'price.required' => "price is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyOrder::where('id', $request->order_id)->where('order_type', '1')->first();
            if ($data) {
                $setting = Setting::find(1);
                $subtotal = $request->price + $setting->pharmacy_delivery_charge;
                $tax = $subtotal * $setting->pharmacy_tax /100;
                $data->tax_pr = $setting->pharmacy_tax;
                $data->tax = $tax;
                $data->delivery_charge = $setting->pharmacy_delivery_charge;
                $data->total = $subtotal + $tax;
                $data->prescription_price = $request->price;
                $data->status = 5;
                $data->save();
                $msg = __("message.pharmacy_send_price_order");
                // $android = $this->send_notification_android_user($msg, $data->user_id);
                $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                $response['status'] = "1";
                $response['msg'] = __("message.pharmacy_send_price_order");
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function send_notification_android_user($msg, $user_id)
    {
        $setting = $user = User::find(1);
        $key = $setting->android_key;
        $getuser = TokenData::where("type", 1)->where("user_id", $user_id)->get();
        //  echo "<pre>";print_r($getuser);exit;
        $i = 0;
        if (count($getuser) != 0) {
            $reg_id = array();
            foreach ($getuser as $gt) {
                $reg_id[] = $gt->token;
            }
            $regIdChunk = array_chunk($reg_id, 1000);
            foreach ($regIdChunk as $k) {
                $registrationIds =  $k;
                $message = array(
                    'message' => $msg,
                    'title' =>  'Notification',
                    'notificationType' => 4,
                    'body' => $msg,
                );
                $message1 = array(
                    'body' => $msg,
                    'title' =>  'Notification'
                );
                $fields = array(
                    'registration_ids'  => $registrationIds,
                    'data'              => $message
                );
                $url = 'https://fcm.googleapis.com/fcm/send';
                $headers = array(
                    'Authorization: key=' . $key, // . $api_key,
                    'Content-Type: application/json'
                );
                $json =  json_encode($fields);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);
                //   echo "<pre>";print_r($result);exit;
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
                $response[] = json_decode($result, true);
            }
            $succ = 0;
            foreach ($response as $k) {
                $succ = $succ + $k['success'];
            }
            if ($succ > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    public function get_user_order_list(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "user_id" => "required",
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyOrder::where('user_id', $request->user_id)
                ->orderBy('id', 'desc')
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $d) {
                    $d->prescription = asset("public/upload/orderprescription") . '/' . $d->prescription;
                    if ($d->order_type == 2) {
                        $orderDetails = PharmacyOrderData::where('order_id', $d->id)->get();
                        $sub = 0;
                        if (!$orderDetails->isEmpty()) {
                            foreach ($orderDetails as $orderDetail) {
                                $medicine = PharmacyProduct::find($orderDetail->service_id);
                                if ($medicine && $medicine->image) {
                                    $orderDetail->medicine_img = asset("public/upload/pharmacymedicine") . '/' . $medicine->image;
                                } else {
                                    $orderDetail->medicine_img = "";
                                }
                                $sub += $orderDetail->price * $orderDetail->qty;
                            }
                        }
                        $d->medicine = $orderDetails; // Assigning the medicines to the order
                        $d->subtotal = $sub;
                    }
                    $pharmacy = Doctors::find($d->Pharmacy_id);
                    if ($pharmacy) { // Check if the pharmacy exists
                        $d->Pharmacy_name = $pharmacy->name;
                        $d->Pharmacy_address = $pharmacy->address;
                        $d->Pharmacy_email = $pharmacy->email;
                        $d->Pharmacy_phoneno = $pharmacy->phoneno;
                        $d->Pharmacy_image = $pharmacy->image
                            ? asset("public/upload/doctors") . '/' . $pharmacy->image
                            : "";
                    } else {
                        // Handle case if pharmacy not found
                        $d->Pharmacy_name = "Pharmacy not found";
                        $d->Pharmacy_address = "";
                        $d->Pharmacy_email = "";
                        $d->Pharmacy_phoneno = "";
                        $d->Pharmacy_image = "";
                    }
                }
                $response['status'] = "1";
                $response['msg'] = __("message.Order_List_Get_Success");
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
            }
            $response['status'] = "1";
            $response['msg'] = __("message.Prescription_Order_Success");
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_pharmacy_order_list(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "pharmacy_id" => "required",
        ];
        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->type) {
                $data = PharmacyOrder::where('pharmacy_id', $request->pharmacy_id)->whereIn('status', ['0', '1', '4', '5',' 7',' 8'])->orderby('id', "DESC")->get();
                if (count($data) != 0) {
                    foreach ($data as $d) {
                        $data1 = PharmacyOrderData::where('order_id', $d->id)->get();
                        if (count($data1) != 0) {
                            $d->medicine = $data1;
                        }
                        $user = Patient::find($d->user_id);
                        if ($user) {
                            $d->user_image = $user->profile_pic ? asset("public/upload/profile/" . $user->profile_pic) : "";
                            $d->user_name = $user->name;
                            $d->user_email = $user->email;
                        } else {
                            $d->user_image = "";
                            $d->user_name = "";
                            $d->user_email = "";
                        }
                    }
                    $response['status'] = "1";
                    $response['msg'] =  __("message.Order_List_Get_Success");
                    $response['data'] = $data;
                } else {
                    $response['status'] = "0";
                    $response['msg'] = __("message.Order_not_found");
                    $response['data'] = $data;
                }
            } else {
                $data = PharmacyOrder::where('pharmacy_id', $request->pharmacy_id)->orderby('id', "DESC")->get();
                if (count($data) != 0) {
                    foreach ($data as $d) {
                        $data1 = PharmacyOrderData::where('order_id', $d->id)->get();
                        if (count($data1) != 0) {
                            $d->medicine = $data1;
                        }
                        $user = Patient::find($d->user_id);
                        if ($user) {
                            $d->user_image = $user->profile_pic ? asset("public/upload/profile/" . $user->profile_pic) : "";
                            $d->user_name = $user->name;
                            $d->user_email = $user->email;
                        } else {
                            $d->user_image = "";
                            $d->user_name = "";
                            $d->user_email = "";
                        }
                    }
                    $response['status'] = "1";
                    $response['msg'] =  __("message.Order_List_Get_Success");
                    $response['data'] = $data;
                } else {
                    $response['status'] = "0";
                    $response['msg'] = __("message.Order_not_found");
                    $response['data'] = $data;
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function add_pharmacy_medicine(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "medicine_id" => "required",
            "pharmacy_id" => "required",
            "name" => "required",
            "description" => "required",
            "price" => "required",
        ];
        $messages = array(
            'medicine_id.required' => "medicine_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'name.required' => "name is required",
            'description.required' => "description is required",
            'price.required' => "price is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->medicine_id == 0) {
                $data = new PharmacyProduct();
                $msg = __("message.Successfull Medicine Added");
                $img_url = "";
                $rel_url = "";
            } else {
                $data = PharmacyProduct::find($request->medicine_id);
                $msg = __("message.Successfull Medicine Update");
                $img_url = $data->image;
                $rel_url = $data->image;
            }
            if ($request->hasFile('upload_image')) {
                $file = $request->file('upload_image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/pharmacymedicine/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('upload_image')->move($destinationPath, $picture);
                $img_url = $picture;
                $image_path = public_path() . "/upload/pharmacymedicine/" . $rel_url;
                if (file_exists($image_path) && $rel_url != "") {
                    try {
                        unlink($image_path);
                    } catch (Exception $e) {
                    }
                }
            }
            $data->image = $img_url;
            $data->pharmacy_id = $request->pharmacy_id;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->save();
            $response['status'] = "1";
            $response['msg'] = $msg;
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function delete_pharmacy_medicine(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "medicine_id" => "required",
        ];
        $messages = array(
            'medicine_id.required' => "medicine_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyProduct::find($request->medicine_id);
            if ($data) {
                $data->delete();
                $response['status'] = "1";
                $response['msg'] = __("message.Successfull Medicine Delete");
            } else {
                $response['status'] = "1";
                $response['msg'] = __("message.Result Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_bankdetails(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "doctor_id" => "required",
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Doctors::select('bank_name', 'ifsc_code', 'account_no', 'account_holder_name')->find($request->doctor_id);
            if ($data) {
                $response['success'] = "1";
                $response['msg'] =  __("message.Doctors_Bank_Details");
                $response['data'] = $data;
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function add_bankdetails(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "doctor_id" => "required",
            "bank_name" => "required",
            "ifsc_code" => "required",
            "account_no" => "required",
            "account_holder_name" => "required",
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'bank_name.required' => "bank_name is required",
            'ifsc_code.required' => "ifsc_code is required",
            'account_no.required' => "account_no is required",
            'account_holder_name.required' => "account_holder_name is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Doctors::find($request->doctor_id);
            if ($data) {
                $data->bank_name = $request->get("bank_name");
                $data->ifsc_code = $request->get("ifsc_code");
                $data->account_no = $request->get("account_no");
                $data->account_holder_name = $request->get("account_holder_name");
                $data->save();
                $response['success'] = "1";
                $response['msg'] =  __("message.Doctors_Bank_Add_Success");
                // $response['data']=$data;
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function most_used_medicine(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [];
        $messages = array();
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Medicines::select("id", "name", "dosage", "medicine_type", "description")->limit(15)->get();
            if ($data) {
                // $response['success']="1";
                $response['msg'] = __("message.Medicines_data_Get_Success");
                $response['data'] = $data;
            } else {
                $response = array("status" => 0, "msg" => "Medicines id Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function upload_image(Request $request)
    {
        $response = array("status" => "0", "message" => "Validation error");
        $rules = [
            'appointment_id' => 'required',
            'image' => 'required',
            'name' => 'required'
        ];
        $messages = array(
            'appointment_id.required' => "appointment_id is required",
            'image.required' => "image is required",
            'name.required' => "name is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/ap_img_up/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('image')->move($destinationPath, $picture);
                $img_url = $picture;
            } else {
                $img_url = '';
            }
            $data = new ap_img_uplod();
            $data->name = $request->get("name");
            $data->appointment_id = $request->get("appointment_id");
            $data->image = $img_url;
            $data->save();
            $response = array("status" => 1, "message" => __("message.Upload Image"), "data" => $data);
            return Response::json($response);
            // $response['success']="1";
            // $response['message']="Update Successfully";
            //  $response['data']=$data;
            // return $request;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function delete_upload_image(Request $request)
    {
        $response = ['status' => '0', 'message' => 'Validation error'];
        $rules = [
            'image_id' => 'required',
        ];
        $messages = [
            'image_id.required' => 'image_id is required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ', ';
            }
            $response['msg'] = $message;
        } else {
            $data = ap_img_uplod::find($request->get('image_id'));
            if ($data) {
                $image_path = public_path('upload/ap_img_up') . '/' . $data->image;
                unlink($image_path);
                $data->delete();
                $response['status'] = '1';
                $response['message'] =  __("message.Image_Delete_Successfully");
            } else {
                $response['status'] = '0';
                $response['message'] = __("message.Image_allready_deleted");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function add_medicine_to_app(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'medicine_id' => 'required',
            'appointment_id' => 'required',
        ];
        $messages = array(
            'medicine_id.required' => 'The Medicine Id field is required.',
            'appointment_id.required' => 'The Appointment Id  field is required.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $BookAppointment = BookAppointment::where('id', $request->appointment_id)->first();
            if ($BookAppointment) {
                $app_medicine = new AppointmentMedicines;
                $app_medicine->appointment_id = $request->appointment_id;
                $app_medicine->medicines = $request->medicine_id;
                $app_medicine->save();
                // $user=BookAppointment::find($request->get("appointment_id"));
                // $set = Setting::find(1);
                // $msg = "Doctor have sent E-Prescription for you";
                // $android=$this->send_notification_android_user($set->android_key,$msg,$user->user_id);
                $response = array("status" => 1, "msg" =>  __("message.Successfull Medicine Added")); //"Medicine successfully added to E-prescription."
            } else {
                $response = array("status" => 0, "msg" => __("message.Appointment Not Found"));
            }
        }
        return Response::json($response);
    }
    public function search_medicine(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'name' => 'required'
        ];
        $messages = array(
            'name.required' => "name is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Medicines::Where('name', 'like', '%' . $request->get("name") . '%')->select("id", "name", "dosage", "medicine_type", "description")->get();
            if ($data) {
                // foreach($data as $data){
                //     $arrName[] = array(
                //     "id"=>$data->id,
                //     "name"=>$data->name,
                //     "dosage"=>$data->dosage,
                //     "medicine_type"=>$data->explode(',',$data->medicine_type)
                //     );
                // }
                // return $arrName;
                $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
            } else {
                $response = array("status" => 0, "msg" => __("message.Result Not Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function change_password_doctor(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
            'conf_password' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'old_password.required' => "old_password is required",
            'new_password.required' => "new_password is required",
            'conf_password.required' => "conf_password is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Doctors::where('id', $request->get("doctor_id"))->first();
            if ($data) {
                if ($data->password == $request->get("old_password")) {
                    if ($request->get("new_password") == $request->get("new_password")) {
                        $data->password = $request->get("new_password");
                        $data->save();
                        $response = array("status" => 1, "msg" => __("message.Password Change Successfully"));
                    } else {
                        $response = array("status" => 0, "msg" => __("message.Confirm_Password_not_match"));
                    }
                } else {
                    $response = array("status" => 0, "msg" => __("message.Current_Password_wrong"));
                }
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return Response::json($response);
    }
    public function doctor_subscription_list(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Doctors::where('id', $request->get("doctor_id"))->first();
            if ($data) {
                $Subscriber = Subscriber::where('doctor_id', $request->get("doctor_id"))->where('is_complet', "1")->where('status', "2")->join('doctors', 'doctors.id', '=', 'subscriber.doctor_id')->join('subscription', 'subscription.id', '=', 'subscriber.subscription_id')->get(['subscriber.status', 'subscription.month', 'subscription.price', 'subscriber.date']);
                if ($Subscriber) {
                    $ls['doctors_subscription'] = $Subscriber;
                    $response['success'] = "1";
                    $response['register'] = __("message.Subscription List");
                    $response['data'] = $ls;
                } else {
                    $response = array("status" => 0, "msg" => __("message.Subscription_Detail_Found"));
                }
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return Response::json($response);
    }
    public function get_subscription_list()
    {
        $data = Subscription::all();
        if ($data) {
            $setting = Setting::find(1);
            $currency = explode("-", trim($setting->currency));
            $array = array("data" => $data, "currency" => trim($currency[1]));
            $response = array("status" => 1, "msg" => __("message.Subscription List"), "data" => $array);
        } else {
            $response = array("status" => 0, "msg" => __("message.Result Not Found"));
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_all_enabled_service(Request $request)
    {
        if(empty($request->zenoti_center_id) OR empty($request->zenoti_service_category_id)){
            $response['success'] = "0";
            $response['msg'] = "zenoti_service_category_id or zenoti_center_id missing";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }else{
        }
        $data = DB::table('service_online_enabled')
                ->where('zenoti_center_id', $request->zenoti_center_id)
                ->where('zenoti_service_category_id', $request->zenoti_service_category_id)
                ->get();
        if($data){
            return json_encode(array("status"=>1,"EnabledServiceList" => $data));
        }else{
            return json_encode(array("status"=>2,"EnabledServiceList" => $data));
        }
    }
    public function get_all_category(Request $request)
    {
        $data = DB::table('zenoti_service_category')
            ->select('id', 'category_name')
            ->get();
        if($data){
            $center_id="b4a00fda-2e31-49cb-b57a-79e64dd57502";
            return json_encode(array("status"=>1,"CategoryList" => $data,"center_id"=>$center_id));
        }else{
            return json_encode(array("status"=>2,"CategoryList" => $data , "center_id"=>$center_id));
        }
    }
    public function get_all_cta(Request $request)
    {
        $data = DB::table('cta_app')
            ->select('app_title', 'app_short_desc', 'app_button_txt','app_button_type','camera_required','app_image_url','app_button_click_url')
            ->get();
        if($data){
            return json_encode(array("status"=>1,"CtaList" => $data));
        }else{
            return json_encode(array("status"=>2,"CtaList" => $data));
        }
    }
    public function get_all_city(Request $request)
    {
        $data = DB::table('all_center_city')
            ->select('city', 'state', 'country')
            ->get();
        if($data){
            return json_encode(array("status"=>1,"CityList" => $data));
        }else{
            return json_encode(array("status"=>2,"CityList" => $data));
        }
    }
    public function get_all_center(Request $request)
    {
        //$data = Doctors::all();
        $data = Doctors::where("record_type",'center')->get();
        $data2=array();
        if($data){
            return json_encode(array("status"=>1,"ListOfCMACenters" => $data));
        }else{
            return json_encode(array("status"=>2,"ListOfCMACenters" => $data));
        }
    }
    public function get_all_doctor(Request $request)
    {
        $data = Doctors::take(27)->get();
        $services = Services::all();
        foreach ($data as $d) {
            $d->timing = Schedule::select("start_time", "day_id", "end_time", "duration")->where("doctor_id", $d->id)->get();
        }
        return json_encode(array("services" => $services, "data" => $data));
    }
    public function showsearchdoctor(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'term' => 'required'
        ];
        $messages = array(
            'term.required' => "term is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Doctors::Where('name', 'like', '%' . $request->get("term") . '%')->select("id", "name", "address", "image", "department_id")->paginate(10);
            if ($data) {
                foreach ($data as $k) {
                    $dr = Services::find($k->department_id);
                    if ($dr) {
                        $k->department_name = $dr->name;
                    } else {
                        $k->department_name = "";
                    }
                    $k->image = asset('public/upload/doctors') . '/' . $k->image;
                    unset($data->department_id);
                }
                $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
            } else {
                $response = array("status" => 0, "msg" => __("message.Result Not Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function nearbydoctor(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            // 'lat' => 'required',
            // 'lon' => 'required',
            'type' => 'required',
        ];
        if ($request->type == 1) {
            $rules['lat'] = 'required';
            $rules['lon'] = 'required';
        }
        $messages = array(
            'lat.required' => "lat is required",
            'lon.required' => 'lon is requied',
            'type.required' => 'type is requied',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->type == 1) {
                $lat = $request->get("lat");
                $lon =  $request->get("lon");
                if(!empty($request->get("filterbycity"))){
                    $filterby=$request->get("filterbycity");
                    $data = DB::table("doctors")
                    ->select(
                        "doctors.id",
                        "doctors.name",
                        "doctors.address",
                        "doctors.department_id",
                        "doctors.image",
                        "doctors.zenoti_id",
                        "doctors.center_id",
                        "doctors.speciality",
                        "doctors.record_type",
                        DB::raw("6371 * acos(cos(radians(" . $lat . "))
                              * cos(radians(doctors.lat))
                              * cos(radians(doctors.lon) - radians(" . $lon . "))
                              + sin(radians(" . $lat . "))
                              * sin(radians(doctors.lat))) AS distance")
                    )->where('record_type', 'center')->where('address', 'like', '%' . $filterby . '%',)
                    ->orderby('distance')->WhereNotNull("doctors.lat")->where('profile_type', 1)->paginate(10);
                }else{
                    $data = DB::table("doctors")
                    ->select(
                        "doctors.id",
                        "doctors.name",
                        "doctors.address",
                        "doctors.department_id",
                        "doctors.image",
                        "doctors.zenoti_id",
                        "doctors.center_id",
                        "doctors.speciality",
                        "doctors.record_type",
                        DB::raw("6371 * acos(cos(radians(" . $lat . "))
                              * cos(radians(doctors.lat))
                              * cos(radians(doctors.lon) - radians(" . $lon . "))
                              + sin(radians(" . $lat . "))
                              * sin(radians(doctors.lat))) AS distance")
                    )->where('record_type', 'center')
                    ->orderby('distance')->WhereNotNull("doctors.lat")->where('profile_type', 1)->paginate(10);
                }
                if ($data) {
                    foreach ($data as $k) {
                        $department = Services::find($k->department_id);
                        $k->department_name = isset($department) ? $department->name : "";
                        $k->image = asset("public/upload/doctors") . '/' . $k->image;
                        unset($k->department_id);
                    }
                    $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
                } else {
                    $response = array("status" => 0, "msg" => __("message.Result Not Found"));
                }
            } else {
                $data = DB::table("doctors")->select(
                    "doctors.id",
                    "doctors.name",
                    "doctors.address",
                    "doctors.department_id",
                    "doctors.image",
                    "doctors.zenoti_id",
                    "doctors.center_id",
                    "doctors.speciality",
                    "doctors.record_type",
                )->where('profile_type', 2)->paginate(10);
                if ($data) {
                    foreach ($data as $k) {
                        $k->image = asset("public/upload/doctors") . '/' . $k->image;
                        unset($k->department_id);
                    }
                    $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
                } else {
                    $response = array("status" => 0, "msg" => __("message.Result Not Found"));
                }
            }
        }
        $response['distane_string']="km away";
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function postregisterpatient(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'phone' => 'required',
            'password' => 'required',
            // 'token' => 'required',
            'email' => 'required',
            'name' => 'required'
        ];
        $messages = array(
            'phone.required' => "Mobile No is required",
            'password.required' => "password is required",
            //   'token.required' => "token is required",
            'phone.unique' => "Mobile Number Already Register",
            'email.required' => 'Email is required',
            'name.required' => 'name is required'
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getuser = Patient::where("phone", $request->get("phone"))->first();
            if (empty($getuser)) { //update token
                $getemail = Patient::where("email", $request->get("email"))->first();
                if ($getemail) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Email Already Existe");
                    return json_encode($response, JSON_NUMERIC_CHECK);
                } else {
                    // STEP 1 : First Create Guest in ZENOTI
                    $dataArray=[];
                    $dataArray['name']=$request->get("name");
                    $dataArray['email']=$request->get("email");
                    $dataArray['phone']=$request->get("phone");
                    $data=Zenoti::createZenotiGuest($dataArray);
                    if (array_key_exists("message",$data)){
                        $response['success'] = "0";
                        $response['register'] =$data['message'];
                        return json_encode($response, JSON_NUMERIC_CHECK);
                    }else{
                                    //var_dump($data);SUCCESS ADDED
                                    $zenoti_id=$data['id'];
                                    $center_id=$data['center_id'];
                    }
                    // STEP 1 : END
                    //STEP 2 : Add record in Ecom
                    // Add or check user data in Ecommerce Store
                    $isCustomerExist=Eshop::getEcomCustomerID($dataArray['phone'],$dataArray['email']);
                    if(!$isCustomerExist){
                        // Add new customer
                        $nameArray=explode(" ",$dataArray['name']);
                        if(!empty($request->get("password"))){
                            $password=$request->get("password");
                        }else{
                            $password="berko123456";
                        }
                            $param=array();
                            $param['firstname']=$nameArray[0];
                            if(empty($nameArray[1])) {
                                $lastname="NA";
                             }else{
                                $lastname=$nameArray[1];
                            }
                            $param['lastname']=$lastname;
                            $param['email']=$dataArray['email'];
                            $param['password']=$password;
                            $dataCustomer=Eshop::addResource("customers","POST",$param);
                            //echo "customerID=".$dataCustomer['customer']['id'];
                            $customerId = $dataCustomer['customer']['id'];
                            //return json_encode($dataCustomer, JSON_NUMERIC_CHECK);
                            }else{
                                $customerId =$isCustomerExist;
                            }
                    $inset = new Patient();
                    $inset->phone = $request->get("phone");
                    $inset->name = $request->get("name");
                    $inset->password = $request->get("password");
                    $inset->email = $request->get("email");
                    $inset->zenoti_id=$zenoti_id;
                    $inset->center_id=$center_id;
                    $inset->id_customer_ecom=$customerId;
                    $inset->save();
                    $store = TokenData::where("token", $request->get("token"))->update(["user_id" => $inset->id]);
                    $response['success'] = "1";
                    $response['register'] = array("user_id" => $inset->id, "name" => $request->get("name"), "phone" => $inset->phone, "email" => $inset->email,"zenoti_id"=>$zenoti_id,"center_id"=>$center_id,"id_customer_ecom"=>$customerId,"id_cart"=>0);
                }
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Mobile_No_Already_Register");
                return json_encode($response, JSON_NUMERIC_CHECK);
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function storetoken(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'type' => 'required',
            'token' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['register'] =  __("message.enter_data_perfectly");
        } else {
            $store = new TokenData();
            $store->token = $request->get("token");
            $store->type = $request->get("type");
            $store->save();
            $response['success'] = "1";
            //   $response['headers']=array("Access-Control-Allow-Origin"=>"*","Access-Control-Allow-Credentials"=>true,"Access-Control-Allow-Headers"=>"Origin,Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token","Access-Control-Allow-Methods"=>"POST, OPTIONS,GET");
            $response['register'] = "Registered";
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getalldoctors()
    {
        $data = Doctors::take(26)->get();
        return Response::json($data);
    }
    public function showlogin(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        if(!empty($request->get("actionType") AND $request->get("actionType")!=null)){
            switch($request->get("actionType")){
                case 'sourceregister':
                    $phone=$request->get("phone");
                    // check record if exist in ZENOTI
                    $data=Zenoti::searchGuest($phone);
                    if ($data['page_Info']['total'] > 0) 
                    {
                        $response['success'] = "0";
                        $response['nextstep'] = "goback";
                        $response['register'] = __("Account already exist with this mobile number");
                        $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                        return json_encode($response, JSON_NUMERIC_CHECK);
                    }
                    //////////////
                    $otp=rand(100000,999999);
                    $request_from="App";
                    DB::table('otp')->updateOrInsert(
                        ['phone' => $phone],
                        ['otp' => $otp,'request_from' => $request_from]
                    );
                    $param_array=array(
                        'sms_type'=>'otp',
                        'number'=>$phone,
                        'otp'=>$otp
                    );
                    $sendSMS=SmsController::SmsPhoneMsg91($param_array);
                    //$sendSMS=Zenoti::sendOtpSms($phone,$otp);
                    //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
                    //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
                    $response['success'] = "1";
                    $response['nextstep'] = "verifyotp";
                    $response['register'] = "OTP SENT";
                    $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                    //$response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password,"zenoti_id"=>$zenoti_id,"center_id"=>$center_id);
                    return json_encode($response, JSON_NUMERIC_CHECK);
                break;
                case 'verifyotp':
                    $phone=$request->get("phone");
                    $otp=$request->get("otp");
                    $verifyOtp=Otp::where("phone",$request->get("phone"))->where("otp",$request->get("otp"))->where("is_active",1)->first();
                    if($verifyOtp){
                        // SET OTP =0 means used
                        DB::table('otp')->updateOrInsert(
                            ['phone' => $request->get("phone")],
                            ['is_active' => 0]
                        );
                        $getuser=Patient::where("phone",$request->get("phone"))->first();
                        if(empty($getuser->zenoti_id) OR $getuser->zenoti_id==null){
                            $datazenoti=Zenoti::searchGuest($phone);
                            $guests = $datazenoti['guests']; 
                            foreach ($guests as $guest) {
                                $zenoti_id=htmlspecialchars($guest['id']);
                                $center_id=htmlspecialchars($guest['center_id']);
                            }
                        }else{
                            $zenoti_id=$getuser->zenoti_id;
                            $center_id=$getuser->center_id;
                        }
                        //$getuser = Patient::where("email", $request->get("email"))->where("password", $request->get("password"))->first();
                        if ($getuser) { //update token
                            $store = TokenData::where("token", $request->get("token"))->first();
                            if ($store) {
                                $store->user_id = $getuser->id;
                                $store->save();
                            }
                            $getuser->login_type = $request->get("login_type");
                            $getuser->save();
                            if ($getuser->profile_pic != "") {
                                $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                            } else {
                                $image = asset("public/upload/profile/profile.png");
                            }
                            $response['success'] = "1";
                            $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                            $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password,"zenoti_id"=>$zenoti_id,"center_id"=>$center_id,"id_customer"=>$getuser->id_customer_ecom,"id_cart"=>$getuser->id_cart);
                            return json_encode($response, JSON_NUMERIC_CHECK);
                        } else { //in vaild user
                            $response['success'] = "0";
                            $response['register'] = __("USER NOT FOUND");
                            return json_encode($response, JSON_NUMERIC_CHECK);
                        }
                    }else{
                        $response['success'] = "0";
                        $response['register'] = __("OTP Not matched");
                        return json_encode($response, JSON_NUMERIC_CHECK);
                    }
                break;
                case 'loginbyotp':
                    $phone=$request->get("phone");
                    $data=Zenoti::searchGuest($phone);
                    if (!isset($data['page_Info']['total']) || $data['page_Info']['total'] <= 0) {
                        $response['success'] = "0";
                        $response['nextstep'] = "register";
                        $response['register'] = __("No User Found With This Phone Number! Create a new account");
                        $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                        return json_encode($response, JSON_NUMERIC_CHECK);
                    }else{
                        $guests = $data['guests'];
                        foreach ($guests as $guest) {
                            $zenoti_id=htmlspecialchars($guest['id']);
                            $center_id=htmlspecialchars($guest['center_id']);
                            $clientname = htmlspecialchars($guest['personal_info']['first_name'] . " " . $guest['personal_info']['last_name']);
                            $email = htmlspecialchars($guest['personal_info']['email']);
                            if(empty($email) OR $email=="null"){
                                $email=$request->get("phone")."@dummy.com";
                            }
                        }
                        $getuser = Patient::where("phone", $request->get("phone"))->first();
                        if($getuser){
                            // user data exist in CMA
                            // check user data in Ecommerce Store
                            if($getuser['id_customer_ecom']==0){
                                $isCustomerExist=Eshop::getEcomCustomerID($phone,$email);
                                if(!$isCustomerExist){
                                    // Add new customer
                                    $nameArray=explode(" ",$clientname);
                                    $password="berko123456";
                                    $param=array();
                                    $param['firstname']=$nameArray[0];
                                    $param['lastname']=$nameArray[1];
                                    $param['email']=$email;
                                    $param['password']=$password;
                                    $json=Eshop::addResource("customers","POST",$param);
                                    $data = json_decode($json, true);
                                     // Access the customer ID
                                    $customerId = $data['customer']['id'];
                                    //return json_encode($data, JSON_NUMERIC_CHECK);

                                }else{
                                    $customerId =$isCustomerExist;
                                }
                                DB::table('patient')->updateOrInsert(
                                    ['phone' => $phone],
                                    ['id_customer_ecom' => $customerId]
                                );

                            }else{
                                $customerId=$getuser['id_customer_ecom'];
                            }

                            

                            $otp=rand(100000,999999);
                            $otp_unique_id=md5($otp);
                            $request_from="App";
                            DB::table('otp')->updateOrInsert(
                                ['phone' => $phone],
                                ['otp' => $otp,'request_from' => $request_from,'otp_unique_id' => $otp_unique_id,'is_active' => 1]
                            );
                            $sendWhatsApp=SmsController::sendWhatsAppSMSTelephant($phone,$otp);
                            $param_array=array(
                                'sms_type'=>'otp',
                                'number'=>$phone,
                                'otp'=>$otp
                            );
                            $sendPhoneSMS=SmsController::SmsPhoneMsg91($param_array);
                            $getuser['id_customer']=$customerId;
                            $getuser['zenoti_id']=$zenoti_id;
                            $getuser['center_id']=$center_id;
                            $response['success'] = "1";
                            $response['nextstep'] = "verifyotp";
                            $response['register'] = $getuser;
                            $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                            return json_encode($response, JSON_NUMERIC_CHECK);
                        }else{
                        
                                // Add or check user data in Ecommerce Store
                                $isCustomerExist=Eshop::getEcomCustomerID($phone,$email);
                                if(!$isCustomerExist){
                                    // Add new customer
                                    $nameArray=explode(" ",$clientname);
                                    $password="berko123456";
                                    $param=array();
                                    
                                    $param['firstname']=$nameArray[0];
                                    if(empty($nameArray[1])){
                                        $lastname="NA";
                                    }else{
                                        $lastname=$nameArray[1];
                                    }
                                    $param['lastname']=$lastname;
                                    $param['email']=$email;
                                    $param['password']=$password;
                                    $dataCustomer=Eshop::addResource("customers","POST",$param);
                                    //$data = json_decode($data, true);
                                     // Access the customer ID
                                    $customerId = $dataCustomer['customer']['id'];
                                    //return json_encode($data, JSON_NUMERIC_CHECK);

                                }else{
                                    $customerId =$isCustomerExist;
                                }
                            //Add new record in CMA DB
                            $login_field = "";
                            $user_id = "";
                            $connectycube_password = "";
                            $getuser = new Patient();
                            $phone = $request->get("phone");
                            //$getuser->login_type = $request->get("login_type");
                            $getuser->login_type=1;
                            $png_url = "";
                            if ($request->get("image") != "") {
                                $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                                $path = public_path() . '/upload/profile/' . $png_url;
                                $content = $this->file_get_contents_curl($request->get("image"));
                                $savefile = fopen($path, 'w');
                                fwrite($savefile, $content);
                                fclose($savefile);
                                $img = public_path() . '/upload/profile/' . $png_url;
                                $getuser->profile_pic = $png_url;
                            }
                            $number = rand();
                            $fix = "123";
                            $length = 8;
                            $password = substr(str_repeat(0, $length) . $number . $fix, -$length);
                            $password=rand(1000000,999999);
                            $getuser->phone = $phone;
                            $getuser->name = $clientname;
                            $getuser->password = $password;
                            $getuser->email = $email;
                            $getuser->zenoti_id=$zenoti_id;
                            $getuser->center_id=$center_id;
                            $getuser->id_customer_ecom=$customerId;
                            if (env('ConnectyCube') == true) {
                                $login_field = $request->get("phone") . rand() . "#1";
                                $user_id = $this->signupconnectycude($request->get("name"), $password, $request->get("email"), $phone, $login_field);
                                $connectycube_password = $password;
                            }
                            $getuser->connectycube_user_id = $user_id;
                            $getuser->login_id = $login_field;
                            $getuser->connectycube_password = $connectycube_password;
                            if ($user_id == "0-email must be unique") {
                                $response['success'] = "0";
                                $response['register'] = __("message.ConnectCube_error_msg");
                            } else {
                                $getuser->save();
                                $otp=rand(100000,999999);
                                $otp_unique_id=md5($otp);
                                $request_from="App";
                                DB::table('otp')->updateOrInsert(
                                    ['phone' => $phone],
                                    ['otp' => $otp,'request_from' => $request_from,'otp_unique_id' => $otp_unique_id,'is_active' => 1]
                                );
                                $param_array=array(
                                    'sms_type'=>'otp',
                                    'number'=>$phone,
                                    'otp'=>$otp
                                );
                                $sendPhoneSMS=SmsController::SmsPhoneMsg91($param_array);
                                $sendWhatsApp=SmsController::sendWhatsAppSMSTelephant($phone,$otp);
                                //$sendSMS=Zenoti::sendOtpSms($phone,$otp);
                                //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
                                $store = TokenData::where("token", $request->get("token"))->first();
                                if ($store) {
                                    $store->user_id = $getuser->id;
                                    $store->save();
                                }
                                if ($getuser->profile_pic != "") {
                                    $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                                } else {
                                    $image = asset("public/upload/profile/profile.png");
                                }
                                $response['success'] = "1";
                                $response['nextstep'] = "verifyotp";
                                $response['register'] = $getuser;
                                $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                                //$response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password,"zenoti_id"=>$zenoti_id,"center_id"=>$center_id);
                                return json_encode($response, JSON_NUMERIC_CHECK);
                            }
                        }
                    }
                break;
            }
        }
        $rules = [
            'email' => 'required',
            // 'token' => 'required',
            "login_type" => 'required'
        ];
        if ($request->input('login_type') == '1') {
            $rules['password'] = 'required';
        }
        if ($request->input('login_type') == '2' || $request->input('login_type') == '3' || $request->input('login_type') == '4') {
            $rules['name'] = 'required';
            //   $rules['phone']='required';
        }
        $messages = array(
            'email.required' => "Email is required",
            'password.required' => "password is required",
            //   'token.required' => "token is required",
            'login_type.required' => "login type is required",
            'name.required' => "name is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->input('login_type') == '1') {
                $getuser = Patient::where("email", $request->get("email"))->where("password", $request->get("password"))->first();
                if ($getuser) { //update token
                    $store = TokenData::where("token", $request->get("token"))->first();
                    if ($store) {
                        $store->user_id = $getuser->id;
                        $store->save();
                    }
                    $getuser->login_type = $request->get("login_type");
                    $getuser->save();
                    if ($getuser->profile_pic != "") {
                        $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $response['success'] = "1";
                    $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                    $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password,"zenoti_id"=>$getuser->zenoti_id,"center_id"=>$getuser->center_id,"id_customer"=>$getuser->id_customer_ecom,"id_cart"=>$getuser->id_cart);
                } else { //in vaild user
                    $data = Patient::where("phone", $request->get("phone"))->first();
                    if ($data) {
                        $response['success'] = "0";
                        $response['register'] = __("message.Current Password is Wrong");
                    } else {
                        $response['success'] = "0";
                        $response['register'] = __("message.You have entered an invalid email address");
                    }
                }
            } else if ($request->input('login_type') == '2' || $request->input('login_type') == '3' || $request->input('login_type') == '4') {
                $getuser = Patient::where("email", $request->get("email"))->first();
                if ($getuser) { //update patient
                    $imgdata = $getuser->profile_pic;
                    $png_url = "";
                    if ($request->get("image") != "") {
                        $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                        $path = public_path() . '/upload/profile/' . $png_url;
                        $content = $this->file_get_contents_curl($request->get("image"));
                        $savefile = fopen($path, 'w');
                        fwrite($savefile, $content);
                        fclose($savefile);
                        $img = public_path() . '/upload/profile/' . $png_url;
                        $getuser->login_type = $request->get("login_type");
                        $getuser->profile_pic = $png_url;
                        $getuser->save();
                    }
                    if ($imgdata != $png_url && $imgdata != "") {
                        $image_path = public_path() . "/upload/profile/" . $imgdata;
                        if (file_exists($image_path) && $imgdata != "") {
                            try {
                                unlink($image_path);
                            } catch (Exception $e) {
                            }
                        }
                    }
                    $store = TokenData::where("token", $request->get("token"))->first();
                    if ($store) {
                        $store->user_id = $getuser->id;
                        $store->save();
                    }
                    if ($getuser->profile_pic != "") {
                        $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $response['success'] = "1";
                    $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                    $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password,"zenoti_id"=>$getuser->zenoti_id,"center_id"=>$getuser->center_id);
                } else { //register patient
                    $login_field = "";
                    $user_id = "";
                    $connectycube_password = "";
                    $getuser = new Patient();
                    $phone = rand(100000000, 9999999999);
                    $getuser->login_type = $request->get("login_type");
                    $png_url = "";
                    if ($request->get("image") != "") {
                        $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                        $path = public_path() . '/upload/profile/' . $png_url;
                        $content = $this->file_get_contents_curl($request->get("image"));
                        $savefile = fopen($path, 'w');
                        fwrite($savefile, $content);
                        fclose($savefile);
                        $img = public_path() . '/upload/profile/' . $png_url;
                        $getuser->profile_pic = $png_url;
                    }
                    $number = rand(1000000,999999);
                    $fix = "@123";
                    $length = 8;
                    $password = substr(str_repeat(0, $length) . $number . $fix, -$length);
                    $getuser->phone = $phone;
                    $getuser->name = $request->get("name");
                    $getuser->password = $password;
                    $getuser->email = $request->get("email");
                    if (env('ConnectyCube') == true) {
                        $login_field = $request->get("phone") . rand() . "#1";
                        $user_id = $this->signupconnectycude($request->get("name"), $password, $request->get("email"), $phone, $login_field);
                        $connectycube_password = $password;
                    }
                    $getuser->connectycube_user_id = $user_id;
                    $getuser->login_id = $login_field;
                    $getuser->connectycube_password = $connectycube_password;
                    if ($user_id == "0-email must be unique") {
                        $response['success'] = "0";
                        $response['register'] = __("message.ConnectCube_error_msg");
                    } else {
                        $getuser->save();
                        $store = TokenData::where("token", $request->get("token"))->first();
                        if ($store) {
                            $store->user_id = $getuser->id;
                            $store->save();
                        }
                        if ($getuser->profile_pic != "") {
                            $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                        } else {
                            $image = asset("public/upload/profile/profile.png");
                        }
                        $response['success'] = "1";
                        $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                        //$response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password);
                        $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password,"zenoti_id"=>$getuser->zenoti_id,"center_id"=>$getuser->center_id);
                    }
                }
            } else {
                $data = Patient::where("phone", $request->get("phone"))->first();
                if ($data) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Invaild Phone Number");
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.Invaild Login Type");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public function doctorregister(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'phone' => 'required',
            'password' => 'required',
            'email' => 'required',
            'name' => 'required',
            // 'type' => 'required',
            // 'token' =>'required'
        ];
        $messages = array(
            'phone.required' => "Mobile No is required",
            'password.required' => "password is required",
            //   'token.required' => "token is required",
            'email.required' => 'Email is required',
            'name.required' => 'name is required',
            // 'type.required' => "type is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getuser = Doctors::where("email", $request->get("email"))->first();
            if (empty($getuser)) { //update token
                $inset = new Doctors();
                $inset->phoneno = $request->get("phone");
                $inset->name = $request->get("name");
                $inset->password = $request->get("password");
                $inset->email = $request->get("email");
                if ($request->get("type")) {
                    if ($request->get("type") == 2) {
                        $inset->profile_type = $request->get("type");
                    }
                } else {
                    $inset->profile_type = 1;
                }
                $inset->save();
                $store = TokenData::where("token", $request->get("token"))->update(["user_id" => $inset->id]);
                $response['success'] = "1";
                $response['register'] = array("user_id" => $inset->id, "name" => $inset->name, "phone" => $inset->phoneno, "email" => $inset->email,);
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Email Already Existe");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function doctorlogin(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
            // 'token' => 'required'
        ];
        $messages = array(
            'email.required' => "Email is required",
            'password.required' => "password is required",
            'type.required' => "type is required",
            //   'token.required' => "token is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getuser = Doctors::where("email", $request->get("email"))->where("password", $request->get("password"))->where("profile_type",  $request->get("type"))->first();
            if ($getuser) { //update token
                $store = TokenData::where("token", $request->get("token"))->first();
                if ($store) {
                    $store->doctor_id = $getuser->id;
                    $store->save();
                }
                if ($getuser->image != "") {
                    $image = asset("public/upload/doctors") . '/' . $getuser->image;
                } else {
                    $image = asset("public/upload/profile/profile.png");
                }
                $response['success'] = "1";
                $response['register'] = array("doctor_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phoneno, "email" => $getuser->email, "login_id" => $getuser->login_id, "connectycube_user_id" => $getuser->connectycube_user_id, "profile_pic" => $image, "connectycube_password" => $getuser->connectycube_password);
            } else { //in vaild user
                $data = Doctors::where("email", $request->get("email"))->first();
                if ($data) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Current Password is Wrong");
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.You have entered an invalid email address");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getspeciality(Request $request)
    {
        //$data=Services::select('id','name','icon')->paginate(10);
        if(!empty($request->get("concern_type"))) {
            $data = Services::where('concern_category',$request->get("concern_type"))->get();
        }else{
            $data = Services::select('id', 'name', 'icon')->get();
        }
        if (count($data) > 0) {
            foreach ($data as $d) {
                $d->total_doctors = count(Doctors::where("department_id", $d->id)->get());
                $d->icon = asset("public/upload/services") . '/' . $d->icon;
            }
            $response['success'] = "1";
            $response['register'] = __("message.Speciality_list");
            $response['data'] = $data;
        } else {
            $response['success'] = "0";
            $response['register'] = __("message.Speciality_Not_Found");
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function bookappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required',
            'slot_id' => 'required',
            'slot_name' => 'required',
            'phone' => 'required',
            'user_description' => 'required',
            'payment_type' => 'required',
            'consultation_fees' => 'required'
        ];
        if ($request->get("payment_type") == "stripe") {
            $rules['stripe_payment_id'] = 'required';
        }
        $messages = array(
            'stripe_payment_id.required' => "stripe_payment_id is required",
            'user_id.required' => "user_id is required",
            'doctor_id.required' => "doctor_id is required",
            'date.required' => "date is required",
            'slot_id.required' => "slot_id is required",
            'slot_name.required' => "slot_name is required",
            'phone.required' => "phone is required",
            'user_description.required' => "user_description is required",
            //   'payment_method_nonce.required'=>"payment_method_nonce is required",
            'consultation_fees.requierd' => "consultation_fees is required",
            "payment_type.required" => "Payment Type is Required",
            //   "stripeToken.required"=>"stripeToken is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if (Patient::find($request->get("user_id"))) {
                $getappointment = BookAppointment::where("date", $request->get("date"))->where('is_completed', '1')->where("slot_id", $request->get("slot_id"))->first();
                if ($getappointment) {
                    $response['success'] = "0";
                    $response['register'] = "Slot Already Booked";
                } else {
                    DB::beginTransaction();
                    try {
                        $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
                        $data = new BookAppointment();
                        $data->user_id = $request->get("user_id");
                        $data->doctor_id = $request->get("doctor_id");
                        $data->slot_id = $request->get("slot_id");
                        $data->slot_name = $request->get("slot_name");
                        $data->date = $request->get("date");
                        $data->phone = $request->get("phone");
                        $data->user_description = $request->get("user_description");
                        $service_therapist_detail=$request->get("service").",".$request->get("therapist");
                        $data->service_therapist_detail=$service_therapist_detail;
                        if ($request->get("payment_type") == "COD") {
                            $data->payment_mode = "COD";
                            $data->is_completed = "1";
                        } else if ($request->get("payment_type") == "stripe") {
                            $data->payment_mode = "";
                            $data->is_completed = "1";
                            $data->transaction_id = $request->get("stripe_payment_id");
                        } else {
                            $data->payment_mode = "";
                            $data->is_completed = "0";
                        }
                        $data->consultation_fees = $request->get("consultation_fees");
                        $data->save();
                        if ($request->get("payment_type") == "COD") {
                            $url = "";
                        } else {
                            $url = route('make-payment', ['id' => $data->id, "type" => '1']);
                        }
                        if ($data->payment_mode == "COD") {
                            $store = new Settlement();
                            $store->book_id = $data->id;
                            $store->status = '0';
                            $store->payment_date = $date->format('Y-m-d');
                            $store->doctor_id = $data->doctor_id;
                            $store->amount = $request->get("consultation_fees");
                            $store->save();
                            $msg = __("message.You have a new upcoming appointment");
                            $user = User::find(1);
                            // $android = $this->send_notification_android($user->android_key, $msg, $request->get("doctor_id"), "doctor_id", $data->id);
                            // $ios = $this->send_notification_IOS($user->ios_key, $msg, $request->get("doctor_id"), "doctor_id", $data->id);
                            $android = $this->sendNotifications($msg, $request->get("doctor_id"), "doctor_id", $data->id);
                            try {
                                $user = Doctors::find($request->get("doctor_id"));
                                $user->msg = $msg;
                                $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                                    $message->to($user->email, $user->name)->subject(__('message.System Name'));
                                });
                            } catch (\Exception $e) {
                            }
                        }
                        $response['success'] = "1";
                        $response['register'] = __("message.Appointment Book Successfully");
                        $response['data'] = $data->id;
                        $response['url'] = $url;
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                        $response['success'] = "0";
                        $response['register'] = $e;
                    }
                }
            } else {
                $response['success'] = "3";
                $response['register'] = __("message.User not found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function viewdoctor(Request $request)
    {
        /** Log Acrtivity */
        $apiName="viewdoctor/".$request->get("doctor_id");
        $logActivity=$this->logActivity($apiName);
        /** Log Acrtivity */
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'type' => 'required',
        ];
        if ($request->type == 1) {
            //$rules['doctor_id'] = 'required';
        } else {
            $rules['pharmacy_id'] = 'required';
        }
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'type.required' => "type is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->type == 1) {
                if(!empty($request->get("doctor_id"))){
                    $getdetail = Doctors::find($request->get("doctor_id"));
                }
                if(!empty($request->get("center_id"))){
                    $getdetail = Doctors::where("center_id",$request->get("center_id"))->first();
                }
                
                //->where('record_type', 'center')->
                //$getdetail = Doctors::where('id',$request->get("doctor_id"))->where('record_type', 'center')->first();
                if(empty($request->id_category)){
                    $services=ServicesEnabled::where("zenoti_center_id",$getdetail->center_id)->get();
                }else{
                    $services=ServicesEnabled::where("zenoti_center_id",$getdetail->center_id)->where("zenoti_service_category_id",$request->id_category)->get();
                }
                
                
                unset($getdetail->state);
                unset($getdetail->city);
                if (empty($getdetail)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                } else {
                    $getdepartment = Services::find($getdetail->department_id);
                    if ($getdepartment) {
                        $getdetail->department_name = $getdepartment->name;
                    } else {
                        $getdetail->department_name = "";
                    }
                    $getdetail->avgratting = Review::where('doc_id', $request->get("doctor_id"))->avg('rating');
                    $getdetail->total_review = count(Review::where('doc_id', $request->get("doctor_id"))->get());
                    $getdetail->image = asset('public/upload/doctors') . '/' . $getdetail->image;
                    $response['success'] = "1";
                    $response['register'] = __("message.Doctor_Get_Success");
                    $response['data'] = $getdetail;
                    $response['enabledService']=$services;
                }
            } else {
                $getdetail = Doctors::where('id', $request->get("pharmacy_id"))->where('profile_type', 2)->first();
                unset($getdetail->state);
                unset($getdetail->city);
                if (empty($getdetail)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Pharmacy_Not_Found");
                } else {
                    $getdepartment = Services::find($getdetail->department_id);
                    if ($getdepartment) {
                        $getdetail->department_name = $getdepartment->name;
                    } else {
                        $getdetail->department_name = "";
                    }
                    $getdetail->avgratting = Review::where('doc_id', $request->get("pharmacy_id"))->avg('rating');
                    $getdetail->total_review = count(Review::where('doc_id', $request->get("pharmacy_id"))->get());
                    $getdetail->image = asset('public/upload/doctors') . '/' . $getdetail->image;
                    $response['success'] = "1";
                    $response['register'] = __("message.Pharmacy_Get_Success");
                    $response['data'] = $getdetail;
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function addreview(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'rating' => 'required',
            'doc_id' => 'required',
            'description' => 'required'
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'rating.required' => "rating is required",
            'doc_id.required' => "doc_id is required",
            'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $store = new Review();
            $store->user_id = $request->get("user_id");
            $store->doc_id = $request->get("doc_id");
            $store->rating = $request->get("rating");
            $store->description = $request->get("description");
            $store->save();
            $response['success'] = "1";
            $response['register'] = __("message.Review_Add_Success");
            $response['data'] = $store;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getslotdata(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'date' => 'required',
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'date.required' => "date is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $day = date('N', strtotime($request->get("date"))) - 1;
            $data = Schedule::with('getslotls')->where("doctor_id", $request->get("doctor_id"))->where("day_id", $day)->get();
            $main = array();
            if (count($data) > 0) {
                foreach ($data as $k) {
                    $slotlist = array();
                    $slotlist['title'] = $k->start_time . " - " . $k->end_time;
                    if (count($k->getslotls) > 0) {
                        foreach ($k->getslotls as $b) {
                            $ka = array();
                            $getappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->whereNotNull('transaction_id')->where('is_completed', '1')->where('status', "!=", 6)->first();
                            $getcodappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('payment_mode', "COD")->where('is_completed', '1')->where('status', "!=", 6)->first();
                            $cancel_appointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('status', 6)->where('is_completed', '1')->first();
                            $ka['id'] = $b->id;
                            $ka['name'] = $b->slot;
                            if ($getappointment || $getcodappointment) {
                                $ka['is_book'] = '1';
                            } elseif ($cancel_appointment) {
                                $ka['is_book'] = '0';
                            } else {
                                $ka['is_book'] = '0';
                            }
                            $slotlist['slottime'][] = $ka;
                        }
                    }
                    $main[] = $slotlist;
                }
            }
            if (empty($slotlist)) {
                $response['success'] = "0";
                $response['register'] = __("message.Slot_Not_Found");
            } else {
                $response['success'] = "1";
                $response['register'] = __("message.Get_Slot_Success");
                $response['data'] = $main;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getlistofdoctorbyspecialty(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'department_id' => 'required',
            'lat' => 'required',
            'lon' => 'required'
        ];
        $messages = array(
            'department_id.required' => "department_id is required",
            'lat.required' => "lat is required",
            'lon.required' => "lon is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $lat = $request->get('lat');
            $lon = $request->get("lon");
            if(!empty($request->get("query"))){
                $query=$request->get("query");
                if(!empty($request->get("filterbycity"))){
                    $filterby=$request->get("filterbycity");
                    $data =  $data = DB::table("doctors")
                    //->where('record_type', 'center')->where('services', 'like', '%' . $query . '%',)->orWhere('healthcare', 'like', '%' . $query . '%',)->orWhere('name', 'like', '%' . $query . '%',)->orWhere('address', 'like', '%' . $query . '%',)
                    ->where("record_type", 'center')->where('speciality', 'like', '%' . $query . '%',)->where('address', 'like', '%' . $filterby . '%',)
                    ->select(
                        "doctors.id",
                        "doctors.name",
                        "doctors.address",
                        "doctors.email",
                        "doctors.phoneno",
                        "doctors.department_id",
                        "doctors.image",
                        "doctors.zenoti_id",
                        "doctors.center_id",
                        "doctors.speciality",
                        "doctors.record_type",
                        DB::raw("6371 * acos(cos(radians(" . $lat . "))
                                  * cos(radians(doctors.lat))
                                  * cos(radians(doctors.lon) - radians(" . $lon . "))
                                  + sin(radians(" . $lat . "))
                                  * sin(radians(doctors.lat))) AS distance")
                    )
                    ->orderby('distance')->WhereNotNull("doctors.lat")->paginate(10);
                }else{
                    $data =  $data = DB::table("doctors")
                    //->where('record_type', 'center')->where('services', 'like', '%' . $query . '%',)->orWhere('healthcare', 'like', '%' . $query . '%',)->orWhere('name', 'like', '%' . $query . '%',)->orWhere('address', 'like', '%' . $query . '%',)
                    ->where("record_type", 'center')->where('speciality', 'like', '%' . $query . '%',)
                    ->select(
                        "doctors.id",
                        "doctors.name",
                        "doctors.address",
                        "doctors.email",
                        "doctors.phoneno",
                        "doctors.department_id",
                        "doctors.image",
                        "doctors.zenoti_id",
                        "doctors.center_id",
                        "doctors.speciality",
                        "doctors.record_type",
                        DB::raw("6371 * acos(cos(radians(" . $lat . "))
                                  * cos(radians(doctors.lat))
                                  * cos(radians(doctors.lon) - radians(" . $lon . "))
                                  + sin(radians(" . $lat . "))
                                  * sin(radians(doctors.lat))) AS distance")
                    )
                    ->orderby('distance')->WhereNotNull("doctors.lat")->paginate(10);
                }
            }else{
                $query=$request->get("query");
                $data =  $data = DB::table("doctors")
                //->where("department_id", $request->get("department_id"))
                ->where("record_type", 'center')->where('speciality', 'like', '%' . $query . '%',)
                ->select(
                    "doctors.id",
                    "doctors.name",
                    "doctors.address",
                    "doctors.email",
                    "doctors.phoneno",
                    "doctors.department_id",
                    "doctors.image",
                    DB::raw("6371 * acos(cos(radians(" . $lat . "))
                              * cos(radians(doctors.lat))
                              * cos(radians(doctors.lon) - radians(" . $lon . "))
                              + sin(radians(" . $lat . "))
                              * sin(radians(doctors.lat))) AS distance")
                )
                ->orderby('distance')->WhereNotNull("doctors.lat")->paginate(10);
            }
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = "Doctors Not Found";
            } else {
                foreach ($data as $d) {
                    $dp = Services::find($d->department_id);
                    if ($dp) {
                        $d->department_name = $dp->name;
                    }
                    $d->image = asset('public/upload/doctors') . '/' . $d->image;
                }
                $response['success'] = "1";
                $response['register'] = __("message.Doctor_Get_Success");
                $response['data'] = $data;
            }
        }
        $response['distane_string']="km away";
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function userspastappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required'
        ];
        $messages = array(
            'user_id.required' => "user_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::where("user_id", $request->get("user_id"))->select("id", "doctor_id", "date", "slot_name as slot", 'phone')->where('is_completed', '1')->orderby('id', "DESC")->paginate(15);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                $new = array();
                foreach ($data as $d) {
                    $a = array();
                    $doctors = Doctors::find($d->doctor_id);
                    $department = Services::find($doctors->department_id);
                    if ($doctors) {
                        $d->name = $doctors->name;
                        $d->address = $doctors->address;
                        $d->image = isset($doctors->image) ? asset('public/upload/doctors') . '/' . $doctors->image : "";
                        $d->department_name = isset($department) ? $department->name : "";
                    } else {
                        $d->name = "";
                        $d->address = "";
                        $d->image = "";
                        $d->department_name = "";
                    }
                    unset($d->department_id);
                    unset($d->doctor_id);
                    unset($d->doctorls);
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function usersupcomingappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required'
        ];
        $messages = array(
            'user_id.required' => "user_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::where("date", ">=", date('Y-m-d'))->select("id", "doctor_id", "date", "slot_name as slot", 'phone')->where('is_completed', '1')->where("user_id", $request->get("user_id"))->paginate(15);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                foreach ($data as $d) {
                    $a = array();
                    $doctors = Doctors::find($d->doctor_id);
                    $department = Services::find($doctors->department_id);
                    if ($doctors) {
                        $d->name = $doctors->name;
                        $d->address = $doctors->address;
                        $d->image = isset($doctors->image) ? asset('public/upload/doctors') . '/' . $doctors->image : "";
                        $d->department_name = isset($department) ? $department->name : "";
                    } else {
                        $d->name = "";
                        $d->address = "";
                        $d->image = "";
                        $d->department_name = "";
                    }
                    unset($d->department_id);
                    unset($d->doctor_id);
                    unset($d->doctorls);
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                    //$new[]=$a;
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function reviewlistbydoctor(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = Review::with('patientls')->where("doc_id", $request->get("doctor_id"))->orderby('id', 'DESC')->select('id', 'user_id', 'rating', 'description')->get();
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Review_Not_Found");
            } else {
                $main_array = array();
                foreach ($data as $d) {
                    $ls = array();
                    $ls['name'] = isset($d->patientls->name) ? $d->patientls->name : "";
                    $ls['rating'] = isset($d->rating) ? $d->rating : "";
                    $ls['description'] = isset($d->description) ? $d->description : "";
                    $ls['image'] = isset($d->patientls->profile_pic) ? asset('public/upload/profile') . '/' . $d->patientls->profile_pic : "";
                    $ls['phone'] = isset($d->patientls->phone) ? $d->phone : "";
                    $main_array[] = $ls;
                }
                $response['success'] = "1";
                $response['register'] = __("message.Review_List_Success");
                $response['data'] = $main_array;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function doctorpastappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->select("date", "id", "slot_name as slot", "user_id", "phone", "status")->paginate(10);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                foreach ($data as $d) {
                    $user = Patient::find($d->user_id);
                    if ($user) {
                        $d->name = $user->name;
                        $d->image = isset($user->profile_pic) ? asset('public/upload/profile') . '/' . $user->profile_pic : "";
                    } else {
                        $d->name = "";
                        $d->image = "";
                    }
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                    unset($d->user_id);
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function doctoruappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::where("date", ">=", date('Y-m-d'))->where("doctor_id", $request->get("doctor_id"))->where("is_completed", 1)->orderby('id', 'DESC')->select("date", "id", "slot_name as slot", "user_id", "phone", "status")->paginate(10);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                foreach ($data as $d) {
                    $user = Patient::find($d->user_id);
                    if ($user) {
                        $d->name = $user->name;
                        $d->image = isset($user->profile_pic) ? asset('public/upload/profile') . '/' . $user->profile_pic : "";
                    } else {
                        $d->name = "";
                        $d->image = "";
                    }
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                    unset($d->user_id);
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response);
    }
    public function doctordetail(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'type' => 'required'
        ];
        if ($request->type == '1') {
            $rules = [
                'doctor_id' => 'required'
            ];
        } else if ($request->type == '2') {
            $rules = [
                'pharmacy_id' => 'required'
            ];
        }
        $messages = array(
            'type.required' => "type is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'doctor_id.required' => "doctor_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->type == '1') {
                $data = Doctors::where('id', $request->get("doctor_id"))->where('profile_type', '1')->orderBy('id', 'desc')->first();
                // echo "<pre>";
                // print_r($data);
                // die();
                if (empty($data)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                } else {
                    $d = Services::find($data->department_id);
                    $data->department_name = isset($d) ? $d->name : "";
                    unset($data->department_id);
                    if (isset($data->image) && !empty($data->image)) {
                        $data->image = $data->image;
                    } else {
                        $data->image = 'user.png';
                    }
                    $data->avgratting = round(Review::where("doc_id", $request->get("doctor_id"))->avg('rating'));
                    $mysubscriptionlist = Subscriber::where('doctor_id', $request->get("doctor_id"))->where("status", '2')->orderby('id', 'DESC')->first();
                    if (isset($mysubscriptionlist)) {
                        $mysubscriptionlist->subscription_data = Subscription::find($mysubscriptionlist->subscription_id);
                        $datetime = new DateTime($mysubscriptionlist->date);
                        if (isset($mysubscriptionlist->subscription_data)) {
                            $month = $mysubscriptionlist->subscription_data->month;
                            $datetime->modify('+' . $month . ' month');
                            $date = $datetime->format('Y-m-d H:i:s');
                            //echo $d=strtotime($date);
                            $current_date = $this->getsitedateall();
                            if ($mysubscriptionlist->is_complet == 1) {
                                $data->is_subscription = "1";
                            } else {
                                $data->is_subscription = "0";
                            }
                            //die
                            if (strtotime($current_date) < strtotime($date)) {
                                if ($mysubscriptionlist->status == 2) {
                                    $data->is_approve = 1;
                                } else {
                                    $data->is_approve = 0;
                                }
                            } else {
                                $data->is_subscription = "0";
                                $data->is_approve = 0;
                            }
                        } else {
                            $data->is_subscription = "0";
                            $data->is_approve = 0;
                        }
                    } else {
                        $data->is_subscription = "0";
                        $data->is_approve = 0;
                    }
                    $response['success'] = "1";
                    $response['register'] =  __("message.Doctor_Get_Success");
                    $response['data'] = $data;
                }
            } else if ($request->type == '2') {
                $data = Doctors::where('id', $request->get("pharmacy_id"))->where('profile_type', '2')->orderBy('id', 'desc')->first();
                // echo "<pre>";
                // print_r($data);
                // die();
                if (empty($data)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                } else {
                    unset($data->department_id);
                    if (isset($data->image) && !empty($data->image)) {
                        $data->image = $data->image;
                    } else {
                        $data->image = 'user.png';
                    }
                    $data->avgratting = round(Review::where("doc_id", $request->get("pharmacy_id"))->avg('rating'));
                    $response['success'] = "1";
                    $response['register'] =  __("message.Doctor_Get_Success");
                    $response['data'] = $data;
                }
            }
        }
        // return json_encode($response, JSON_NUMERIC_CHECK);
        return json_encode($response);
    }
    // public function place_subscription(Request $request){
    //     $response = array("success" => "0", "msg" => "Validation error");
    //     $rules = [
    //         'doctor_id' => 'required',
    //         'subscription_id' => 'required',
    //         'payment_method_nonce' => 'required',
    //         'amount' => 'required'
    //     ];
    //     $messages = array(
    //         'doctor_id.required' => "doctor_id is required",
    //         'subscription_id.required' => "subscription_id is required",
    //         'payment_method_nonce.required' => "payment_method_nonce is required",
    //         'amount.required' => "amount is required"
    //     );
    //     $validator = Validator::make($request->all(), $rules, $messages);
    //     if ($validator->fails()) {
    //         $message = '';
    //         $messages_l = json_decode(json_encode($validator->messages()), true);
    //         foreach ($messages_l as $msg) {
    //             $message .= $msg[0] . ", ";
    //         }
    //         $response['register'] = $message;
    //     } else {
    //         $gateway = new \Braintree\Gateway([
    //             'environment' => env('BRAINTREE_ENV'),
    //             'merchantId' => env('BRAINTREE_MERCHANT_ID'),
    //             'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
    //             'privateKey' => env('BRAINTREE_PRIVATE_KEY')
    //         ]);
    //         $nonce = $request->get("payment_method_nonce");
    //         $result = $gateway->transaction()->sale([
    //             'amount' => $request->get("amount"),
    //             'paymentMethodNonce' => $nonce,
    //             'options' => [
    //                 'submitForSettlement' => true
    //             ]
    //         ]);
    //         if ($result->success) {
    //             $transaction = $result->transaction;
    //             DB::beginTransaction();
    //             try {
    //                 $data = new Subscriber();
    //                 $data->doctor_id = $request->get("doctor_id");
    //                 $data->payment_type = '1';
    //                 $data->amount = $request->get("amount");
    //                 $data->date = $this->getsitedateall();
    //                 $data->subscription_id = $request->get("subscription_id");
    //                 $data->status = "2";
    //                 $data->transaction_id = $transaction->id;
    //                 $data->save();
    //                 DB::commit();
    //                 $response['success'] = "1";
    //                 $response['register'] = "Subscription Book Successfully";
    //             } catch (\Exception $e) {
    //                 DB::rollback();
    //                 $response['success'] = "0";
    //                 $response['register'] = $e;
    //             }
    //         } else {
    //             $errorString = "";
    //             foreach ($result->errors->deepAll() as $error) {
    //                 $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    //             }
    //             $response['success'] = "0";
    //             $response['register'] = $errorString;
    //         }
    //     }
    //     return json_encode($response, JSON_NUMERIC_CHECK);
    // }
    public function subscription_upload(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'subscription_id' => 'required',
            'payment_type' => 'required',
            'amount' => 'required',
            // 'description'=>'required'
        ];
        if ($request->payment_type == '5') {
            $rules['stripe_token'] = 'required';
        }
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'subscription_id.required' => "subscription_id is required",
            'payment_type.required' => "payment_type is required",
            'amount.required' => "amount is required",
            'stripe_token.required' => "stripe_token is required",
            // 'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = new Subscriber();
            $data->doctor_id = $request->get("doctor_id");
            $data->subscription_id = $request->get("subscription_id");
            $data->payment_type = $request->get("payment_type");
            $data->amount = $request->get("amount");
            $data->date = $this->getsitedateall();
            if ($request->get("description")) {
                $data->description = $request->get("description");
            }
            if ($request->payment_type == '5') {
                $data->transaction_id = $request->get("stripe_token");
                $data->status = "2";
            }
            // $data->status = "1";
            $data->is_complet = '1';
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/bank_receipt/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('file')->move($destinationPath, $picture);
                $data->deposit_image = $picture;
                $data->status = "2";
            } else {
                if ($request->payment_type != '5') {
                    $data->status = "1";
                }
            }
            $data->save();
            if ($request->get("payment_type") == 2) {
                $url = "";
            } else {
                $url = route('make-payment', ['id' => $data->id, "type" => '2']);
            }
            if ($data) {
                $response['success'] = "1";
                $response['msg'] =  __("message.Your subscription plan add successfully");
                $response['url'] = $url;
                $response['id'] = $data->id;
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.something getting wrong");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function appointmentdetail(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'appointment_id' => 'required',
        ];
        $messages = array(
            'appointment_id.required' => "Zenoti appointment_id is required (param=appointment_id)",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if(!empty($request->get("appointment_id"))){
                $appointCmaDetails=BookAppointment::where('zenoti_appointment_id',$request->get("appointment_id"))->first();
                if($appointCmaDetails){
                    $appointment_cma_id=$appointCmaDetails['id'];
                    $data = BookAppointment::with('doctorls', 'patientls')->find($appointment_cma_id);
                }else{
                    // create data in CMA Appointment
                    $this->create_cma_booking($request->get("appointment_id"));
                    $appointCmaDetails=BookAppointment::where('zenoti_appointment_id',$request->get("appointment_id"))->first();
                    $appointment_cma_id=$appointCmaDetails['id'];
                    $data = BookAppointment::with('doctorls', 'patientls')->find($appointment_cma_id);
                }
            }else{
                $data = BookAppointment::with('doctorls', 'patientls')->find($request->get("id"));
            }
            $doctor = Doctors::with('departmentls')->find($data->doctor_id);
            $doctor->avgratting = round(Review::where("doc_id", $doctor->id)->avg('rating'));
            // return $doctor;
            $image = ap_img_uplod::where('appointment_id', $request->get("id"))->get();
            $p = AppointmentMedicines::where('appointment_id', $request->get("id"))->first();
            if ($p) {
                $prescription = AppointmentMedicines::where('appointment_id', $request->get("id"))->get();
                foreach ($prescription as $p) {
                    $med = $p->medicines;
                    $med_data = json_decode($med);
                    $response['prescription'] = $med_data;
                }
            } else {
                $response['prescription'] = "null";
            }
            $ls = array();
            if ($data) {
                if ($request->get("type") == 1) { //patients
                    $ls['doctor_image'] = isset($data->doctorls->image) ? asset("public/upload/doctors") . '/' . $data->doctorls->image : "";
                    $ls['doctor_name'] = isset($data->doctorls) ? $data->doctorls->name : "";
                    $ls['user_image'] = isset($data->patientls->profile_pic) ? asset("public/upload/profile") . '/' . $data->patientls->profile_pic : "";
                    $ls['user_name'] = isset($data->patientls) ? $data->patientls->name : "";
                    $ls['status'] = $data->status;
                    $ls['doctor_id'] = $data->doctor_id;
                    $ls['user_id'] = $data->user_id;
                    $ls['date'] = $data->date;
                    $ls['slot'] = $data->slot_name;
                    $ls['phone'] = isset($data->doctorls) ? $data->doctorls->phoneno : "";;
                    $ls['email'] = isset($data->doctorls) ? $data->doctorls->email : "";;
                    $ls['description'] = $data->user_description;
                    $ls['connectycube_user_id'] = $data->doctorls->connectycube_user_id;
                    $ls['id'] = $data->id;
                    if ($data->prescription_file != "") {
                        $ls['prescription'] = asset('public/upload/prescription') . '/' . $data->prescription_file;
                    } else {
                        $ls['prescription'] = "";
                    }
                    $ls['device_token'] = TokenData::select('token', 'type')->where("doctor_id", $data->doctor_id)->distinct('token')->get();
                    $date12 = date('Y-m-d H:i:s', strtotime($data->date . ' ' . $data->slot_name));
                    $date22 = $this->getsitedatetime();
                    $date1 = date_create($date12);
                    $date2 = date_create($date22);
                    if ($data->date != $this->getsitedate()) {
                        $ls['remain_time'] = "00:00:00";
                    } else {
                        if (strtotime($date12) < strtotime($date22)) {
                            $ls['remain_time'] = "00:00:00";
                        } else {
                            $diff = $date1->diff($date2);
                            $ls['remain_time'] = $diff->format("%H:%I:%S");
                        }
                    }
                    $sdchule_id = SlotTiming::find($data->slot_id) ? SlotTiming::find($data->slot_id)->schedule_id : '0';
                    $ls['is_appointment_time'] = 0;
                    if ($sdchule_id != 0) {
                        //echo $this->getsitedate();exit;
                        if ($data->date == $this->getsitedate()) {
                            $duration = Schedule::find($sdchule_id) ? Schedule::find($sdchule_id)->duration : 0;
                            $current_time = $this->getsitecurrenttime();
                            $sunrise = SlotTiming::find($data->slot_id) ? date("H:i", strtotime(SlotTiming::find($data->slot_id)->slot)) : 0;
                            $sunset = date("H:i", strtotime("+15 minutes", strtotime($sunrise)));
                            // echo $current_time." sunrise ".$sunrise." sunset".$sunset.' '.$sdchule_id;exit;
                            if (strtotime($current_time) >= strtotime($sunrise) && strtotime($current_time) <= strtotime($sunset)) {
                                $ls['is_appointment_time']  = 1;
                            }
                        }
                    }
                } else { //doctor
                    $ls['user_image'] = isset($data->patientls->profile_pic) ? asset("public/upload/profile") . '/' . $data->patientls->profile_pic : "";
                    $ls['user_name'] = isset($data->patientls) ? $data->patientls->name : "";
                    $ls['doctor_name'] = isset($data->doctorls) ? $data->doctorls->name : "";
                    $ls['doctor_image'] = isset($data->doctorls->image) ? asset("public/upload/doctors") . '/' . $data->doctorls->image : "";
                    $ls['status'] = $data->status;
                    $ls['date'] = $data->date;
                    $ls['doctor_id'] = $data->doctor_id;
                    $ls['user_id'] = $data->user_id;
                    $ls['slot'] = $data->slot_name;
                    $ls['phone'] = $data->phone;
                    $ls['email'] = isset($data->patientls) ? $data->patientls->email : "";
                    $ls['connectycube_user_id'] = $data->patientls->connectycube_user_id;
                    $ls['description'] = $data->user_description;
                    $ls['id'] = $data->id;
                    if ($data->prescription_file != "") {
                        $ls['prescription'] = asset('public/upload/prescription') . '/' . $data->prescription_file;
                    } else {
                        $ls['prescription'] = "";
                    }
                    $ls['device_token'] = TokenData::select('token', 'type')->where("user_id", $data->user_id)->distinct('token')->get();
                    $date12 = date('Y-m-d H:i:s', strtotime($data->date . ' ' . $data->slot_name));
                    $date22 = $this->getsitedatetime();
                    $date1 = date_create($date12);
                    $date2 = date_create($date22);
                    // echo $date12."=>".$date22;exit;
                    if ($data->date != $this->getsitedate()) {
                        $ls['remain_time'] = "00:00:00";
                    } else {
                        if (strtotime($date12) < strtotime($date22)) {
                            $ls['remain_time'] = "00:00:00";
                        } else {
                            $diff = $date1->diff($date2);
                            $ls['remain_time'] = $diff->format("%H:%I:%S");
                        }
                    }
                    $sdchule_id = SlotTiming::find($data->slot) ? SlotTiming::find($data->slot)->schedule_id : '0';
                    $ls['is_appointment_time'] = 0;
                    if ($sdchule_id != 0) {
                        //echo $this->getsitedate();exit;
                        if ($data->date == $this->getsitedate()) {
                            $duration = Schedule::find($sdchule_id) ? Schedule::find($sdchule_id)->duration : 0;
                            $current_time = $this->getsitecurrenttime();
                            $sunrise = SlotTiming::find($data->slot_id) ? date("H:i", strtotime(SlotTiming::find($data->slot_id)->slot)) : 0;
                            $sunset = date("H:i", strtotime("+15 minutes", strtotime($sunrise)));
                            // echo $current_time." sunrise ".$sunrise." sunset".$sunset.' '.$sdchule_id;exit;
                            if (strtotime($current_time) >= strtotime($sunrise) && strtotime($current_time) <= strtotime($sunset)) {
                                $ls['is_appointment_time']  = 1;
                            }
                        }
                    }
                }
                $response['success'] = "1";
                $response['register'] = __("message.appointment Details");
                $response['data'] = $ls;
                $response['image'] = $image;
                $response['doctor'] = $doctor;
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function doctoreditprofile(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            "type" => 'required',
        ];
        if ($request->type == '1') {
            $rules = [
                "doctor_id" => 'required',
                "name" => 'required',
                "email" => "required",
                "aboutus" => "required",
                "working_time" => "required",
                "address" => "required",
                "lat" => "required",
                "lon" => "required",
                "phoneno" => "required",
                "services" => "required",
                "healthcare" => "required",
                "department_id" => "required",
                "consultation_fees" => "required",
                //"time_json"=>"required",
            ];
        } else if ($request->type == '2') {
            $rules = [
                "pharmacy_id" => 'required',
                "name" => 'required',
                "email" => "required",
                "aboutus" => "required",
                "working_time" => "required",
                "address" => "required",
                "lat" => "required",
                "lon" => "required",
                "phoneno" => "required",
                "services" => "required",
            ];
        }
        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
            'doctor_id.required' => "doctor_id is required",
            'name.required' => "name is required",
            'email.required' => "email is required",
            'aboutus.required' => "aboutus is required",
            'working_time.required' => "working_time is required",
            'address.required' => "address is required",
            'lat.required' => "lat is required",
            'lon.required' => "lon is required",
            'phoneno.required' => "phoneno is required",
            'services.required' => "services is required",
            'healthcare.required' => "healthcare is required",
            'department_id.required' => "department_id is required",
            'consultation_fees.required' => "consultation_fees is required",
            //'time_json.required' => "time_json is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->type == '1') {
                $store = Doctors::where('profile_type', '1')->where('id', $request->get("doctor_id"))->first();
                if ($store) {
                    DB::beginTransaction();
                    try {
                        $img_url = $store->image;
                        $rel_url = $store->image;
                        if ($request->file('image')) {
                            $file = $request->file('image');
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension() ?: 'png';
                            $folderName = '/upload/doctors/';
                            $picture = time() . '.' . $extension;
                            $destinationPath = public_path() . $folderName;
                            $request->file('image')->move($destinationPath, $picture);
                            $img_url = $picture;
                            $image_path = public_path() . "/upload/doctors/" . $rel_url;
                            if (file_exists($image_path) && $rel_url != "") {
                                try {
                                    unlink($image_path);
                                } catch (Exception $e) {
                                }
                            }
                        }
                        $store->name = $request->get("name");
                        $store->department_id = $request->get("department_id");
                        // $store->password = $request->get("password");
                        $store->phoneno = $request->get("phoneno");
                        $store->aboutus = $request->get("aboutus");
                        $store->services = $request->get("services");
                        $store->healthcare = $request->get("healthcare");
                        $store->address = $request->get("address");
                        $store->lat = $request->get("lat");
                        $store->lon = $request->get("lon");
                        $store->email = $request->get("email");
                        $store->working_time = $request->get("working_time");
                        $store->consultation_fees = $request->get("consultation_fees");
                        $store->image = $img_url;
                        $store->save();
                        if ($request->get("time_json") != "") {
                            $datadesc = json_decode($request->get("time_json"), true);
                            $arr = $datadesc['timing'];
                            $i = 0;
                            $removedata = Schedule::where("doctor_id", $request->get("doctor_id"))->get();
                            if (count($removedata) > 0) {
                                foreach ($removedata as $k) {
                                    $findslot = SlotTiming::where("schedule_id", $k->id)->delete();
                                    $k->delete();
                                }
                            }
                            foreach ($arr as $k) {
                                foreach ($k as $l) {
                                    $getslot = $this->getslotvalue($l['start_time'], $l['end_time'], $l['duration']);
                                    $store = new Schedule();
                                    $store->doctor_id = $request->get("doctor_id");
                                    $store->day_id = $i;
                                    $store->start_time = $l['start_time'];
                                    $store->end_time = $l['end_time'];
                                    $store->duration = $l['duration'];
                                    $store->save();
                                    foreach ($getslot as $g) {
                                        $aslot = new SlotTiming();
                                        $aslot->schedule_id = $store->id;
                                        $aslot->slot = $g;
                                        $aslot->save();
                                    }
                                }
                                $i++;
                            }
                        }
                        DB::commit();
                        $response['success'] = "1";
                        $response['register'] = __("message.Profile Update Successfully");
                    } catch (Exception $e) {
                        DB::rollback();
                        $response['success'] = "0";
                        $response['register'] = __("message.something getting wrong");
                    }
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                }
            } else if ($request->type == '2') {
                $store = Doctors::where('profile_type', '2')->where('id', $request->get("pharmacy_id"))->first();
                if ($store) {
                    DB::beginTransaction();
                    try {
                        $img_url = $store->image;
                        $rel_url = $store->image;
                        if ($request->file('image')) {
                            $file = $request->file('image');
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension() ?: 'png';
                            $folderName = '/upload/doctors/';
                            $picture = time() . '.' . $extension;
                            $destinationPath = public_path() . $folderName;
                            $request->file('image')->move($destinationPath, $picture);
                            $img_url = $picture;
                            $image_path = public_path() . "/upload/doctors/" . $rel_url;
                            if (file_exists($image_path) && $rel_url != "") {
                                try {
                                    unlink($image_path);
                                } catch (Exception $e) {
                                }
                            }
                        }
                        $store->name = $request->get("name");
                        $store->phoneno = $request->get("phoneno");
                        $store->aboutus = $request->get("aboutus");
                        $store->services = $request->get("services");
                        $store->address = $request->get("address");
                        $store->lat = $request->get("lat");
                        $store->lon = $request->get("lon");
                        $store->email = $request->get("email");
                        $store->working_time = $request->get("working_time");
                        $store->image = $img_url;
                        $store->save();
                        DB::commit();
                        $response['success'] = "1";
                        $response['register'] = __("message.Profile Update Successfully");
                    } catch (Exception $e) {
                        DB::rollback();
                        $response['success'] = "0";
                        $response['register'] = __("message.something getting wrong");
                    }
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.Pharmacy_Not_Found");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getslotvalue($start_time, $end_time, $duration)
    {
        $datetime1 = strtotime($start_time);
        $datetime2 = strtotime($end_time);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        $noofslot = $minutes / $duration;
        $slot = array();
        if ($noofslot > 0) {
            for ($i = 0; $i < $noofslot; $i++) {
                $a = $duration * $i;
                $slot[] = date("h:i A", strtotime("+" . $a . " minutes", strtotime($start_time)));
            }
        }
        return $slot;
    }
    public function getdoctorschedule(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = Doctors::find($request->get("doctor_id"));
            if (empty($data)) {
                $response['success'] = "0";
                $response['register'] = __("message.User not found");
            } else {
                $data = Schedule::with('getslotls')->where("doctor_id", $request->get("doctor_id"))->get();
                $response['success'] = "1";
                $response['register'] = __("message.Doctor_Get_Success");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function usereditprofile(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ];
        $messages = array(
            'id.required' => "id is required",
            'name.required' => "name is required",
            'email.required' => "email is required",
            'phone.required' => "phone is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data1 = Patient::find($request->get("id"));
            if (empty($data1)) {
                $response['success'] = "0";
                $response['register'] = __("message.User not found");
            } else {
                $checkemail = Patient::where("email", $request->get("email"))->where("id", '!=', $request->get("id"))->first();
                if ($checkemail) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Email Id Already Use By Other User");
                } else {
                    $img_url = $data1->profile_pic;
                    $rel_url = $data1->profile_pic;
                    if ($request->file('image')) {
                        $file = $request->file('image');
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension() ?: 'png';
                        $folderName = '/upload/profile/';
                        $picture = time() . '.' . $extension;
                        $destinationPath = public_path() . $folderName;
                        $request->file('image')->move($destinationPath, $picture);
                        $img_url = $picture;
                        $image_path = public_path() . "/upload/profile/" . $rel_url;
                        if (file_exists($image_path) && $rel_url != "") {
                            try {
                                unlink($image_path);
                            } catch (Exception $e) {
                            }
                        }
                    }
                    $data1->name = $request->get("name");
                    $data1->email = $request->get("email");
                    //$data1->password = $request->get("password");
                    $data1->phone = $request->get("phone");
                    $data1->profile_pic = $img_url;
                    $data1->save();
                    $response['success'] = "1";
                    $response['register'] = __("message.Profile Update Successfully");
                    $response['data'] = $data1;
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function saveReportspam(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'title.required' => "title is required",
            'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $store = new Reportspam();
            $store->user_id = $request->get("user_id");
            $store->title = $request->get("title");
            $store->description = $request->get("description");
            $store->save();
            $response['success'] = "1";
            $response['register'] = __("message.Report_Send_Success");
            $response['data'] = $store;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function user_reject_appointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'id' => 'required'
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::where("id", $request->get("id"))->where("user_id", $request->get("user_id"))->first();
            if ($data) {
                $data->status = 5;
                $data->save();
                $response['success'] = "1";
                $response['register'] = __("message.Appointment In Reject");
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function appointmentstatuschange(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'app_id' => 'required',
            'status' => 'required'
        ];
        // if($request->input('status')==4){
        //     $rules['prescription'] = 'required';
        // }
        $messages = array(
            'app_id.required' => "app_id is required",
            'status.required' => "status is required",
            //   "prescription"=>"prescription is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getapp = BookAppointment::with('doctorls', 'patientls')->find($request->get("app_id"));
            if ($getapp) {
                $getapp->status = $request->get("status");
                if ($request->hasFile('prescription')) {
                    $file = $request->file('prescription');
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension() ?: 'png';
                    $folderName = '/upload/prescription/';
                    $picture = time() . '.' . $extension;
                    $destinationPath = public_path() . $folderName;
                    $request->file('prescription')->move($destinationPath, $picture);
                    $getapp->prescription_file = $picture;
                }
                $getapp->save();
                if ($request->get("status") == '3') { // in process
                    $msg = __("message.Your Appointment  has been accept by") . " " . $getapp->doctorls->name . " " . __("message.for time") . "" . $getapp->date . ' ' . $getapp->slot_name;
                } else if ($request->get("status") == '5') { //reject
                    $msg = __("message.Your Appointment  has been reject By") . " " . $getapp->doctorls->name;
                    Settlement::where("book_id", $request->get("app_id"))->delete();
                } else if ($request->get("status") == '4') { //complete
                    $msg = __("message.Your Appointment  with") . " " . $getapp->doctorls->name . " is completed";
                } else if ($request->get("status") == '0') { //absent
                    $msg = __("message.You were absent on your appointment with") . " " . $getapp->doctorls->name;
                } else if ($request->get("status") == '6') { //absent
                    $msg = __("message.Your appointment cancel with") . " " . $getapp->doctorls->name;
                } else {
                    $msg = "";
                }
                $user = User::find(1);
                // $android = $this->send_notification_android($user->android_key, $msg, $getapp->user_id, "user_id", $getapp->id);
                // $ios = $this->send_notification_IOS($user->ios_key, $msg, $getapp->user_id, "user_id", $getapp->id);
                $android = $this->sendNotifications($msg, $getapp->user_id, "user_id", $getapp->id);
                $response['success'] = "1";
                $response['msg'] = $msg;
                try {
                    if ($getapp->prescription_file != "") {
                        $user = Patient::find($getapp->user_id);
                        $user->msg = $msg;
                        $user->prescription = $getapp->prescription_file;
                        $user->email = "redixbit.jalpa@gmail.com";
                        $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                            $message->to($user->email, $user->name)->subject(__('message.System Name'));
                            $message->attach(asset('public/upload/prescription') . '/' . $user->prescription);
                        });
                    } else {
                        $user = Patient::find($getapp->user_id);
                        $user->msg = $msg;
                        //$user->email="redixbit.jalpa@gmail.com";
                        $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                            $message->to($user->email, $user->name)->subject(__('message.System Name'));
                        });
                    }
                } catch (\Exception $e) {
                }
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.Appointment Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function generateAccessToken()
    {
        $setting = Setting::find(1);
        $contents = File::get(public_path('upload/jsonfile/' . $setting->not_json_filename));
        $accountJson = json_decode($contents, true);  // Convert JSON to associative array
        $scopes = array(
            "https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/firebase.database",
            "https://www.googleapis.com/auth/firebase.messaging"
        );
        $client = new Google_Client();
        $client->setAuthConfig($accountJson);
        $client->setScopes($scopes);
        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        return $accessToken;
    }
    public function sendNotifications($msg, $id, $field, $order_id)
    {
        $accessToken = $this->generateAccessToken();
        $getusers = TokenData::where("type", 1)->where($field, $id)->get();
        $setting = Setting::find(1);
        $contents = File::get(public_path('upload/jsonfile/' . $setting->not_json_filename));
        $accountJson = json_decode($contents);
        $api = "https://fcm.googleapis.com/v1/projects/" . $accountJson->project_id . "/messages:send";
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $accessToken
        );
        $responses = [];
        foreach ($getusers as $user) {
            $message = array(
                "message" => array(
                    "token" => $user->token,
                    "notification" => array(
                        "title" => __('message.notification'),
                        "body" => $msg
                    ),
                    "data" => array(
                        'message' => $msg,
                        'title' =>  __('message.notification'),
                    )
                )
            );
            $ch = curl_init($api);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responses[] = [
                'status_code' => $statusCode,
                'response' => json_decode($response)
            ];
            curl_close($ch);
        }
        $succ = 0;
        foreach ($responses as $response) {
            if (isset($response['status_code']) && $response['status_code'] == 200) {
                $succ++;
            }
        }
        if ($succ > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    // public function send_notification_android($key, $msg, $id, $field, $order_id)
    // {
    //     $getuser = TokenData::where("type", 1)->where($field, $id)->get();
    //     $i = 0;
    //     if (count($getuser) != 0) {
    //         $reg_id = array();
    //         foreach ($getuser as $gt) {
    //             $reg_id[] = $gt->token;
    //         }
    //         $regIdChunk = array_chunk($reg_id, 1000);
    //         foreach ($regIdChunk as $k) {
    //             $registrationIds =  $k;
    //             $message = array(
    //                 'message' => $msg,
    //                 'title' =>  __('message.notification')
    //             );
    //             $message1 = array(
    //                 'body' => $msg,
    //                 'title' =>  __('message.notification'),
    //                 'type' => $field,
    //                 'order_id' => $order_id,
    //                 'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
    //             );
    //             //echo "<pre>";print_r($message1);exit;
    //             $fields = array(
    //                 'registration_ids'  => $registrationIds,
    //                 'data'              => $message1,
    //                 'notification'      => $message1
    //             );
    //             // echo "<pre>";print_r($fields);exit;
    //             $url = 'https://fcm.googleapis.com/fcm/send';
    //             $headers = array(
    //                 'Authorization: key=' . $key, // . $api_key,
    //                 'Content-Type: application/json'
    //             );
    //             $json =  json_encode($fields);
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //             $result = curl_exec($ch);
    //             //echo "<pre>";print_r($result);exit;
    //             if ($result === FALSE) {
    //                 die('Curl failed: ' . curl_error($ch));
    //             }
    //             curl_close($ch);
    //             $response[] = json_decode($result, true);
    //         }
    //         $succ = 0;
    //         foreach ($response as $k) {
    //             $succ = $succ + $k['success'];
    //         }
    //         if ($succ > 0) {
    //             return 1;
    //         } else {
    //             return 0;
    //         }
    //     }
    //     return 0;
    // }
    // public function send_notification_IOS($key, $msg, $id, $field, $order_id)
    // {
    //     $getuser = TokenData::where("type", 2)->where($field, $id)->get();
    //     if (count($getuser) != 0) {
    //         $reg_id = array();
    //         foreach ($getuser as $gt) {
    //             $reg_id[] = $gt->token;
    //         }
    //         $regIdChunk = array_chunk($reg_id, 1000);
    //         foreach ($regIdChunk as $k) {
    //             $registrationIds =  $k;
    //             $message = array(
    //                 'message' => $msg,
    //                 'title' =>  __('message.notification')
    //             );
    //             $message1 = array(
    //                 'body' => $msg,
    //                 'title' =>  __('message.notification'),
    //                 'type' => $field,
    //                 'order_id' => $order_id,
    //                 'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
    //             );
    //             $fields = array(
    //                 'registration_ids'  => $registrationIds,
    //                 'data'              => $message1,
    //                 'notification' => $message1
    //             );
    //             $url = 'https://fcm.googleapis.com/fcm/send';
    //             $headers = array(
    //                 'Authorization: key=' . $key, // . $api_key,
    //                 'Content-Type: application/json'
    //             );
    //             $json =  json_encode($fields);
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //             $result = curl_exec($ch);
    //             if ($result === FALSE) {
    //                 die('Curl failed: ' . curl_error($ch));
    //             }
    //             curl_close($ch);
    //             $response[] = json_decode($result, true);
    //         }
    //         $succ = 0;
    //         foreach ($response as $k) {
    //             $succ = $succ + $k['success'];
    //         }
    //         if ($succ > 0) {
    //             return 1;
    //         } else {
    //             return 0;
    //         }
    //     }
    //     return 0;
    // }
    public function forgotpassword(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'type' => 'required',
            'email' => 'required'
        ];
        $messages = array(
            'type.required' => "type is required",
            'email.required' => "email is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->get("type") == 1) { //patient
                $checkmobile = Patient::where("email", $request->get("email"))->first();
            } else { // doctor
                $checkmobile = Doctors::where("email", $request->get("email"))->first();
            }
            if ($checkmobile) {
                $code = mt_rand(100000, 999999);
                $store = array();
                $store['email'] = $checkmobile->email;
                $store['name'] = $checkmobile->name;
                $store['code'] = $code;
                $add = new ResetPassword();
                $add->user_id = $checkmobile->id;
                $add->code = $code;
                $add->type = $request->get("type");
                $add->save();
                Mail::send('email.forgotpassword', ['user' => $store], function ($message) use ($store) {
                    $message->to($store['email'], $store['name'])->subject(__("message.System Name"));
                });
                //   exit();
                try {
                    $result =  Mail::send('email.reset_password', ['user' => $store], function ($message) use ($store) {
                        $message->to($store['email'], $store['name'])->subject(__("message.System Name"));
                    });
                } catch (\Exception $e) {
                }
                $response['success'] = "1";
                $response['msg'] = __("message.Mail Send Successfully");
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.error mail sending");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = Doctor_Hoilday::where("doctor_id", $request->get("doctor_id"))->orderby('id', 'DESC')->get();
            if (count($data) > 0) {
                $response['success'] = "1";
                $response['msg'] =  __("message.My Hoilday List");
                $response['data'] = $data;
            } else {
                $response['success'] = "0";
                $response['msg'] =  __("message.No Hoilday Data");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function saveholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'id.required' => "id is required",
            'start_date.required' => "start_date is required",
            'end_date.required' => "end_date is required",
            'description.required' => "description is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->get('id') == 0) {
                $store = new Doctor_Hoilday();
                $store->doctor_id = $request->get("doctor_id");
                $store->start_date = $request->get("start_date");
                $store->end_date = $request->get("end_date");
                $store->description = $request->get("description");
                $store->save();
                $response['success'] = "1";
                $response['msg'] = __("message.My Hoilday Add Successfully");
                $response['data'] = $store;
            } else {
                $store = Doctor_Hoilday::find($request->get('id'));
                if ($store) {
                    $store->doctor_id = $request->get("doctor_id");
                    $store->start_date = $request->get("start_date");
                    $store->end_date = $request->get("end_date");
                    $store->description = $request->get("description");
                    $store->save();
                    $response['success'] = "1";
                    $response['msg'] = __("message.My Hoilday Add Successfully");
                    $response['data'] = $store;
                } else {
                    $response['success'] = "0";
                    $response['msg'] = __("message.No Hoilday Data");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function deleteholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'id' => 'required'
        ];
        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = $request->get("date");
            $data = Doctor_Hoilday::find($request->get("id"));
            if (!empty($data)) {
                $data->delete();
                $response['success'] = "1";
                $response['msg'] =  __("message.Hoilday Delete Successfully");
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.No Hoilday Data");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function checkholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'date' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'date.required' => "date is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = $request->get("date");
            $data = Doctor_Hoilday::where("start_date", "<=", $date)->where("end_date", ">=", $date)->where("doctor_id", $request->get("doctor_id"))->first();
            // echo "<pre>";print_r($data);exit;
            if (empty($data)) {
                $day = date('N', strtotime($request->get("date"))) - 1;
                $data = Schedule::with('getslotls')->where("doctor_id", $request->get("doctor_id"))->where("day_id", $day)->get();
                $main = array();
                if (count($data) > 0) {
                    foreach ($data as $k) {
                        $slotlist = array();
                        $slotlist['title'] = $k->start_time . " - " . $k->end_time;
                        if (count($k->getslotls) > 0) {
                            foreach ($k->getslotls as $b) {
                                $ka = array();
                                $getappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->whereNotNull('transaction_id')->where('is_completed', '1')->where('status', "!=", 6)->first();
                                $getcodappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('payment_mode', "COD")->where('is_completed', '1')->where('status', "!=", 6)->first();
                                $cancel_appointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('status', 6)->where('is_completed', '1')->first();
                                $ka['id'] = $b->id;
                                $ka['name'] = $b->slot;
                                if ($getappointment || $getcodappointment) {
                                    $ka['is_book'] = '1';
                                } elseif ($cancel_appointment) {
                                    $ka['is_book'] = '0';
                                } else {
                                    $ka['is_book'] = '0';
                                }
                                $slotlist['slottime'][] = $ka;
                            }
                        }
                        $main[] = $slotlist;
                    }
                }
                $response['success'] = "1";
                $response['msg'] = "Working Day";
                $response['data'] = $main;
            } else {
                $response['success'] = "0";
                $response['msg'] = "Hoilday";
                $response['data'] = [];
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function mediaupload(Request $request)
    {
        // dd($request->all());
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            'file' => 'required'
        ];
        $messages = array(
            'file.required' => "file is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $img_url = "";
            $type = "";
            // echo "<pre>";print_r($_FILES);exit;
            if ($request->file("file")) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'mp4';
                $folderName = '/upload/chat';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('file')->move($destinationPath, $picture);
                $img_url = $picture;
                $response = array("status" => 1, "msg" =>  __("message.Media_Upload_Success"), "data" => $img_url);
                return Response::json($response);
            } else {
                $response = array("status" => 0, "msg" => "Media Not Upload", "data" => array());
                return Response::json($response);
            }
        }
        return Response::json($response);
    }
    public function banner_list(Request $request)
    {
        $data = Banner::select('id', 'image')->orderby('id', 'DESC')->get();
        if (count($data) > 0) {
            $response['status'] = 1;
            $response['msg'] = "Banner List";
            $response['data'] = $data;
        } else {
            $data3 = array();
            $response['status'] = 0;
            $response['message'] = "Data Not Found";
            $response['data'] = $data3;
        }
        return Response::json($response);
    }
    public function income_report(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'duration' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'duration.required' => "duration is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = Carbon::now();
            if ($request->get("duration") == "today") {
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', '=', $date)->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 7 days") {
                $date = Carbon::now()->subDays(7);
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 30 days") {
                $date = Carbon::now()->subDays(30);
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            } else {
                $date = explode(',', $request->get("duration"));
                $start = $date[0];
                $end = $date[1];
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            }
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                $report = array();
                foreach ($data as  $d) {
                    $created_at = date('Y-m-d', strtotime($d->created_at));
                    $visitors = BookAppointment::select(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"))->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', $created_at)->sum('consultation_fees');
                    $report[] = array(
                        "date" => $created_at,
                        "amount" => $visitors
                    );
                }
                //  echo "<pre>";
                //  print_r($datess);
                //  exit();
                //  $date_data = array_unique($datess);
                $myArray = array_map("unserialize", array_unique(array_map("serialize", $report)));
                $indexed_data = array_values($myArray);
                $total = 0;
                foreach ($myArray as $my) {
                    $totals = $total + $my['amount'];
                    $total = $totals;
                }
                $temp_array = array("income_record" => $indexed_data, "total_income" => $total);
                $response['success'] = "1";
                $response['register'] = __("message.Appointment List");
                $response['data'] = $temp_array;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function data_list(Request $request)
    {
        $banner = Banner::select('id', 'image')->orderby('id', 'DESC')->get();
        $speciality = Services::select('id', 'name', 'icon')->get();
        if (!empty($request->get("user_id"))) {
            $user_id = $request->get("user_id");
        } else {
            $user_id = 0;
        }
        $data = BookAppointment::with('doctorls')->where("date", ">=", date('Y-m-d'))->select("id", "doctor_id", "date", "slot_name as slot", 'phone')->where('is_completed', '1')->where("user_id", $user_id)->get();
        foreach ($data as $d) {
            $dr = Services::find($d->doctorls->department_id);
            if ($dr) {
                $d->department_name = $dr->name;
            }
            unset($d->doctorls->id);
            // unset($d->doctorls->department_id);
            unset($d->doctorls->aboutus);
            unset($d->doctorls->services);
            unset($d->doctorls->healthcare);
            unset($d->doctorls->facebook_url);
            unset($d->doctorls->twitter_url);
            unset($d->doctorls->created_at);
            unset($d->doctorls->updated_at);
            unset($d->doctorls->is_approve);
            unset($d->doctorls->login_id);
            unset($d->doctorls->connectycube_user_id);
            unset($d->doctorls->connectycube_password);
            unset($d->doctorls->unique_id);
            unset($d->doctorls->gender);
            unset($d->doctorls->title);
            unset($d->doctorls->institution_name);
            unset($d->doctorls->birth_name);
            unset($d->doctorls->spouse_name);
            unset($d->doctorls->state);
            unset($d->doctorls->city);
        }
        $temp_array = array("banner" => $banner, "speciality" => $speciality, "appointment" => $data);
        $response['status'] = 1;
        $response['msg'] = "List";
        $response['data'] = $temp_array;
        return Response::json($response);
    }
    public function about()
    {
        $data = About::find(1);
        if ($data) {
            $response['status'] = 1;
            $response['msg'] = "About List";
            $response['data'] = $data;
        } else {
            $data3 = array();
            $response['status'] = 0;
            $response['message'] = __("message.Result Not Found");
            $response['data'] = $data;
        }
        return Response::json($response);
    }
    public function privecy()
    {
        $data = About::find(1);
        if ($data) {
            $response['status'] = 1;
            $response['msg'] = "Privecy List";
            $response['data'] = $data;
        } else {
            $data3 = array();
            $response['status'] = 0;
            $response['message'] = __("message.Result Not Found");
            $response['data'] = $data;
        }
        return Response::json($response);
    }
    public function pharmacy_income_report(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'pharmacy_id' => 'required',
            'duration' => 'required'
        ];
        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
            'duration.required' => "duration is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = Carbon::now();
            if ($request->get("duration") == "today") {
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', '=', $date)->select("id", "total", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 7 days") {
                $date = Carbon::now()->subDays(7);
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("id", "total", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 30 days") {
                $date = Carbon::now()->subDays(30);
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("id", "total", "created_at")->paginate(10);
            } else {
                $date = explode(',', $request->get("duration"));
                $start = $date[0];
                $end = $date[1];
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->select("id", "total", "created_at")->paginate(10);
            }
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Order_not_found");
            } else {
                $report = array();
                foreach ($data as  $d) {
                    $created_at = date('Y-m-d', strtotime($d->created_at));
                    $visitors = PharmacyOrder::select(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"))->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', $created_at)->sum('total');
                    $report[] = array(
                        "date" => $created_at,
                        "amount" => $visitors
                    );
                }
                //  echo "<pre>";
                //  print_r($datess);
                //  exit();
                //  $date_data = array_unique($datess);
                $myArray = array_map("unserialize", array_unique(array_map("serialize", $report)));
                $indexed_data = array_values($myArray);
                $total = 0;
                foreach ($myArray as $my) {
                    $totals = $total + $my['amount'];
                    $total = $totals;
                }
                $temp_array = array("income_record" => $indexed_data, "total_income" => $total);
                $response['success'] = "1";
                $response['register'] = __("message.Order_List_Get_Success");
                $response['data'] = $temp_array;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
}

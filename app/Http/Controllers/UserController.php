<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use validate;
use Sentinel;
use Illuminate\Support\Facades\DB;
use Mail;
use DataTables;
error_reporting(-1);
ini_set('display_errors', 'On');
use App\Models\Otp;
use App\Models\Patient;
use App\Models\Doctors;
use App\Models\Setting;
use App\Models\BookAppointment;
use App\Models\Services;
use App\Models\Resetpassword;
use App\Models\FavoriteDoc;
use App\Models\Settlement;
use App\Models\Review;
use DateTime;
use DateInterval;
use PaytmWallet;
use Razorpay\Api\Api;
use App\Models\PaymentGatewayDetail;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Models\AppointmentMedicines;
use App\Models\PharmacyOrder;
use Google_Client;
use Illuminate\Support\Facades\File;
use App\Models\TokenData;
use App\Http\Middleware\Zenoti;
use App\Http\Middleware\SmsController;
use App\Http\Middleware\Eshop;

class UserController extends Controller
{
    public function get_user_appointment($id){

        $data = BookAppointment::with('doctorls','patientls')->find($id);

       $medicine = AppointmentMedicines::where('appointment_id', $id)->first();
       if($medicine){
           $data->medicine = json_decode($medicine->medicines);
       }

        return $data;


    }
    public function register_firsttimeuser(Request $request){
        $this->validate($request,[
            'email' =>'required|unique:patient',
            'phone' => 'required|unique:patient',
            'name' =>'required',
            'email' =>'email',
            'agree' => 'required',
  
         ]);
        // STEP 1 : First Create Guest in ZENOTI
       $dataArray=[];
       $dataArray['name']=$request->get("name");
       $dataArray['email']=$request->get("email");
       $dataArray['phone']=$request->get("phone");
       $data=Zenoti::createZenotiGuest($dataArray);
       if (array_key_exists("message",$data)){
            Session::flash('message',$data['message']);
            //Session::flash('message',__("Something Went Wrong!"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
       }else{
            //var_dump($data);SUCCESS ADDED
            $zenoti_id=$data['id'];
            $center_id=$data['center_id'];
       }
              // STEP 2 Create ECOM Account
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
              $getuser=Patient::where("email",$request->get("email"))->first();
              $getusermobile=Patient::where("phone",$request->get("phone"))->first();
              if($getuser){
                  Session::flash('message',__("message.Email Already Existe"));
                  Session::flash('alert-class', 'alert-danger');
                  return redirect()->back();
              }elseif($getusermobile){
                  Session::flash('message',__("message.Phone Already Existe"));
                  Session::flash('alert-class', 'alert-danger');
                  return redirect()->back();
              }
              else{
                  $login_field = "";
                  $user_id = "";
      
                  $store=new Patient();
                  $store->name=$request->get("name");
                  $store->email=$request->get("email");
                  $store->password="123456";
                  $store->phone=$request->get("phone");
                  $store->zenoti_id=$zenoti_id;
                  $store->center_id=$center_id;
                  $store->id_customer_ecom=$customerId;
      
                  if(env('ConnectyCube')==true){
                        $login_field = $request->get("phone").rand()."#1";
                        $user_id = $this->signupconnectycude($request->get("name"),$request->get("password"),$request->get("email"),$request->get("phone"),$login_field);
                  }
      
                  $store->connectycube_user_id = $user_id;
                  $store->login_id = $login_field;
                  $store->connectycube_password = $request->get("password");
      
      
                  $connrctcube = ($store->connectycube_user_id);
                  if($connrctcube == "0-email must be unique"){
      
                      Session::flash('message',__("message.ConnectCube_error_msg"));
                      Session::flash('alert-class', 'alert-danger');
                      return redirect()->back();
                  }
                  else
                  {
                      $store->save();
                      if($request->get("rem_me")==1){
                                  setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                                  //setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                                  setcookie('rem_me',1, time() + (86400 * 30), "/");
                                  setcookie('zenoti_id', $zenoti_id, time() + (86400 * 30), "/");
                                  setcookie('center_id', $center_id ,time() + (86400 * 30), "/");
                      }
      
                      Session::put("user_id",$store->id);
                      Session::put("role_id",'1');
                      Session::put("zenoti_id",$zenoti_id);
                      Session::put("center_id",$center_id);
                      Session::put("user_phone_no",$store->phone);
                      Session::put("id_customer",$customerId);
                      Session::flash('message',__("message.Register Successfully"));
                      Session::flash('alert-class', 'alert-success');
                      return redirect("searchcenter_firsttimeuser");
                  }
              }

    }
    public function userpostregister(Request $request){
     //   dd($request->all());

     $this->validate($request,[
          'email' =>'required|unique:patient',
          'phone' => 'required|unique:patient',
          'name' =>'required',
          'password' => 'required|min:3',
          'password_confirmation' => 'required|min:3|same:password',
          'agree' => 'required',

       ]);
       // STEP 1 : First Create Guest in ZENOTI
       $dataArray=[];
       $dataArray['name']=$request->get("name");
       $dataArray['email']=$request->get("email");
       $dataArray['phone']=$request->get("phone");
       $data=Zenoti::createZenotiGuest($dataArray);
       if (array_key_exists("message",$data)){
            Session::flash('message',$data['message']);
            //Session::flash('message',__("Something Went Wrong!"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
       }else{
                    //var_dump($data);SUCCESS ADDED
                    $zenoti_id=$data['id'];
                    $center_id=$data['center_id'];
       }
       // STEP 2 Create ECOM Account
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
        
        $getuser=Patient::where("email",$request->get("email"))->first();
        $getusermobile=Patient::where("phone",$request->get("phone"))->first();
        if($getuser){
            Session::flash('message',__("message.Email Already Existe"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }elseif($getusermobile){
            Session::flash('message',__("message.Phone Already Existe"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        else{
            $login_field = "";
            $user_id = "";

            $store=new Patient();
            $store->name=$request->get("name");
            $store->email=$request->get("email");
            $store->password=$request->get("password");
            $store->phone=$request->get("phone");
            $store->zenoti_id=$zenoti_id;
            $store->center_id=$center_id;
            $store->id_customer_ecom=$customerId;

            if(env('ConnectyCube')==true){
                  $login_field = $request->get("phone").rand()."#1";
                  $user_id = $this->signupconnectycude($request->get("name"),$request->get("password"),$request->get("email"),$request->get("phone"),$login_field);
            }

            $store->connectycube_user_id = $user_id;
            $store->login_id = $login_field;
            $store->connectycube_password = $request->get("password");


            $connrctcube = ($store->connectycube_user_id);
            if($connrctcube == "0-email must be unique"){

                Session::flash('message',__("message.ConnectCube_error_msg"));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            else
            {
                $store->save();
                if($request->get("rem_me")==1){
                            setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                            setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                            setcookie('rem_me',1, time() + (86400 * 30), "/");
                            setcookie('zenoti_id', $zenoti_id, time() + (86400 * 30), "/");
                            setcookie('center_id', $center_id ,time() + (86400 * 30), "/");
                }

                Session::put("user_id",$store->id);
                Session::put("role_id",'1');
                Session::put("zenoti_id",$zenoti_id);
                Session::put("center_id",$center_id);
                Session::put("user_phone_no",$store->phone);
                Session::put("id_customer",$customerId);
                Session::flash('message',__("message.Register Successfully"));
                Session::flash('alert-class', 'alert-success');
                return redirect("userdashboard");
            }
        }
    }
    public function bookappointmentstep2(Request $request){
            $setting=Setting::find(1);
            $userdata=Patient::find(Session::get("user_id"));
            $centerId=$request->get("center");
            //echo $centerId;
            $centers=Zenoti::listAllCenter();
            //$doctorDetails=Doctors::find($centerId);
            $doctorDetails=Doctors::where("center_id",$centerId)->first();
            //$services=Zenoti::listService($centerId);
            $services=Services::all();
            //var_dump($services);
            //exit;
            $specilaist=Zenoti::listEmployeeFromCenter($centerId);
            return view("user.patient.bookstep2")->with("setting",$setting)->with("userdata",$userdata)->with("centers",$centers)->with("services",$services)->with("specilaist",$specilaist)->with("services",$services)->with("doctorDetails",$doctorDetails);
    }
    public function loginbyotp(Request $request){
        $phone=$request->get("phone");
        $setting=Setting::find(1);
        $data=Zenoti::searchGuest($phone);
        if (!isset($data['page_Info']['total']) || $data['page_Info']['total'] <= 0) {
            // If no record found then redirect to register page
            Session::flash('message',__("No User Found With This Phone Number! Create a new account"));
            Session::flash('alert-class', 'alert-danger');
            return redirect("clientregister");

        }
        // check if phone exist in CMA system or not. if not add record
        $getUser=Patient::where("phone",$request->get("phone"))->first();
        if($getUser){
            $guests = $data['guests']; // Array of guests
            $pageInfo = $data['page_Info']; // Page info data
            foreach ($guests as $guest) {
                $name = htmlspecialchars($guest['personal_info']['first_name'] . " " . $guest['personal_info']['last_name']);
                $mobile = htmlspecialchars($guest['personal_info']['mobile_phone']['number']);
                $email = htmlspecialchars($guest['personal_info']['email']);
                $zenoti_id=htmlspecialchars($guest['id']);
                $center_id=htmlspecialchars($guest['center_id']);
                if(empty($email) OR $email=="null"){
                    $email=$guest['personal_info']['first_name'].$mobile."@dummy.com";
                }
                $centerName = htmlspecialchars($guest['center_name']);
                $address = htmlspecialchars($guest['address_info'] ?? 'N/A'); // Use 'N/A' if address info is null
                $dob = htmlspecialchars($guest['personal_info']['date_of_birth']);
                $gender = htmlspecialchars($guest['personal_info']['gender_name']);
            }

            }else{
            // Add new record in CMA DB
            $guests = $data['guests']; // Array of guests
            $pageInfo = $data['page_Info']; // Page info data
            foreach ($guests as $guest) {
                $name = htmlspecialchars($guest['personal_info']['first_name'] . " " . $guest['personal_info']['last_name']);
                $mobile = htmlspecialchars($guest['personal_info']['mobile_phone']['number']);
                $email = htmlspecialchars($guest['personal_info']['email']);
                $zenoti_id=htmlspecialchars($guest['id']);
                $center_id=htmlspecialchars($guest['center_id']);
                if(empty($email) OR $email=="null"){
                    $email=$guest['personal_info']['first_name'].$mobile."@dummy.com";
                }
                $centerName = htmlspecialchars($guest['center_name']);
                $address = htmlspecialchars($guest['address_info'] ?? 'N/A'); // Use 'N/A' if address info is null
                $dob = htmlspecialchars($guest['personal_info']['date_of_birth']);
                $gender = htmlspecialchars($guest['personal_info']['gender_name']);
            }
            // Save Record
            $login_field = "";
            $user_id = "";
            $randpassword=rand(10000,999999);
            $store=new Patient();
            $store->name=$name;
            $store->email=$email;
            $store->password=$randpassword;
            $store->phone=$mobile;
            $store->zenoti_id=$zenoti_id;
            $store->center_id=$center_id;

            if(env('ConnectyCube')==true){
                  $login_field = $mobile.rand()."#1";
                  $user_id = $this->signupconnectycude($name,$randpassword,$email,$mobile,$login_field);
            }

            $store->connectycube_user_id = $user_id;
            $store->login_id = $login_field;
            $store->connectycube_password = $randpassword;


            $connrctcube = ($store->connectycube_user_id);
            if($connrctcube == "0-email must be unique"){
                Session::flash('message',__("user exist in connectTube"));
                //Session::flash('message',__("message.ConnectCube_error_msg"));
                Session::flash('alert-class', 'alert-danger');
                //return redirect()->back();
                return redirect("auth/loginbyotp?msg=userExistOnConnectTube");
            }
            else
            {
                $store->save();
            }
        }
        $otp=rand(100000,999999);
        //Sending SMS
        $otp_unique_id=md5($otp);
        //$sendSMS=SmsController::sendTwilioPhoneSms($phone,$otp);
        // MSG 91
        $param_array=array(
            'sms_type'=>'otp',
            'number'=>$phone,
            'otp'=>$otp
        );
        $sendSMS=SmsController::SmsPhoneMsg91($param_array);
        

        if(!empty($request->get("request_from"))){
            $request_from=$request->get("request_from");
        }else{
            $request_from="cma_web";
        }
        DB::table('otp')->updateOrInsert(
                ['phone' => $phone],
                ['otp' => $otp,'request_from' => $request_from,'otp_unique_id' => $otp_unique_id,'is_active' => 1]
            );
        return view("user.patient.verifyotp")->with("setting",$setting)->with("phone",$phone)->with("otp",$otp)->with("otp",$otp)->with("zenoti_id",$zenoti_id)->with("center_id",$center_id);
        Session::flash('message',__("OTP SENT to phone!"));
        Session::flash('alert-class', 'alert-success');

    }
    // Verify OTP and Login
    public function postloginuserotp(Request $request){
        $verifyOtp=Otp::where("phone",$request->get("phone"))->where("otp",$request->get("otp"))->where("is_active",1)->first();
        if($verifyOtp){
            $getUser=Patient::where("phone",$request->get("phone"))->first();
                if($getUser){
                    if($request->get("rem_me")==1){
                            setcookie('email', $getUser->email, time() + (86400 * 30), "/");
                            setcookie('phone', $getUser->phone, time() + (86400 * 30), "/");
                            setcookie('zenoti_id', $request->get("zenoti_id"), time() + (86400 * 30), "/");
                            setcookie('center_id', $request->get("center_id") ,time() + (86400 * 30), "/");
                            //setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                            setcookie('rem_me',1, time() + (86400 * 30), "/");
                    }

                    Session::put("user_id",$getUser->id);
                    Session::put("zenoti_id",$request->get("zenoti_id"));
                    Session::put("center_id",$request->get("center_id"));
                    Session::put("role_id",'1');
                    Session::put("user_phone_no",$getUser->phone);
                    $previousUrl = session('previous_url', '/');
                    session()->forget('previous_url');
                    //return  redirect("userdashboard");
                // SET OTP =0 means used
                DB::table('otp')->updateOrInsert(
                    ['phone' => $request->get("phone")],
                    ['is_active' => 0]
                );
                return  redirect("userappointmentdashboard");
                    //return redirect()->intended($previousUrl);

                        return redirect("userdashboard");
                }else{
                    Session::flash('message',__("message.OTP Not Matched"));
                    Session::flash('alert-class', 'alert-danger');
                    return redirect("loginbyotpcontroller?msg=otp_not_matched");
                }
        }else{
            Session::flash('message',__("message.OTP Not Matched"));
            Session::flash('alert-class', 'alert-danger');
            return redirect("auth/loginbyotp?msg=otp_not_matched_OR_expired");
        }
        
    }
    public function postloginuser(Request $request){
        $this->validate($request,[
             'email' =>'required',
             'password' => 'required',
            //  'password_confirmation' => 'required|min:6|same:password',
        ]);

        $getUser=Patient::where("email",$request->get("email"))->where("password",$request->get("password"))->first();

        if($getUser){
                if($request->get("rem_me")==1){
                    setcookie('email', $getUser->email, time() + (86400 * 30), "/");
                    setcookie('phone', $getUser->phone, time() + (86400 * 30), "/");
                    setcookie('zenoti_id', $request->get("zenoti_id"), time() + (86400 * 30), "/");
                    setcookie('center_id', $request->get("center_id") ,time() + (86400 * 30), "/");
                    setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                    setcookie('rem_me',1, time() + (86400 * 30), "/");
                }
                
                Session::put("user_id",$getUser->id);
                Session::put("zenoti_id",$getUser->zenoti_id);
                Session::put("center_id",$getUser->center_id);
                Session::put("role_id",'1');
                Session::put("user_phone_no",$getUser->phone);
                $previousUrl = session('previous_url', '/');
                session()->forget('previous_url');
                $previousUrl = session('previous_url', '/');
                session()->forget('previous_url');
                return  redirect("userappointmentdashboard");
                    //return redirect()->intended($previousUrl);
                //return redirect("userdashboard");
        }else{
            Session::flash('message',__("message.Login Credentials Are Wrong"));
            Session::flash('alert-class', 'alert-danger');
            return redirect("clientlogin?msg=Invalid_username_or_password");
        }
    }
    public function userappointmentdetails($id){
        $setting=Setting::find(1);
        $appointmentDetailData=Zenoti::getAppointmentDetail($id);
        $userdata=Patient::find(Session::get("user_id"));
        // Send Booking Confirmation
        if(!empty($_REQUEST['redirect'])){
            if($_REQUEST['redirect']==1){
                $param_array=array(
                    'sms_type'=>'AppoinmentConfirmation_1',
                    'number'=>$appointmentDetailData[0]['guest']['mobile']['display_number'],
                    'customer_name'=>$appointmentDetailData[0]['guest']['first_name'],
                    'service_name'=>$appointmentDetailData[0]['service']['name'],
                    'city'=>"",
                    'center_name'=>"",
                    'center_phone'=>""
                    );
                //$sendSMS=SmsController::SmsPhoneMsg91($param_array);   
            }
        }
 
        return view("user.patient.appointmentdetail")->with("userdata",$userdata)->with("setting",$setting)->with("appointmentDetail",$appointmentDetailData);
    }

    
    public function userappointmentdashboard(Request $request){
        if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
           $setting=Setting::find(1);
           $userdata=Patient::find(Session::get("user_id"));
           if(empty($userdata)){
               $this->logout();
           }
           $zenotiResponse=Zenoti::searchGuest($userdata->phone);
           $type=$request->get("type");
           if($type==2){ //past
            $startdate = date("Y-m-d", strtotime("-365 day"));
            $enddate=date("Y-m-d", strtotime("-1 day"));
            //$bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date","<",date('Y-m-d'))->paginate(10);
            }elseif($type==3){ //upcoming
                //$startdate = date("Y-m-d", strtotime("+1 day"));
                $startdate=date("Y-m-d"); // from today till next 30 days
                $enddate=date("Y-m-d", strtotime("+30 day"));
                //$bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date",">",date('Y-m-d'))->paginate(10);
            }elseif($type==1){ //upcoming
                $startdate=date("Y-m-d");
                $enddate=date("Y-m-d");
            }else{ //today
                $startdate=date("Y-m-d"); // from today till next 30 days
                $enddate=date("Y-m-d", strtotime("+30 day"));
                 //$bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date",date('Y-m-d'))->paginate(10);
            }
            $bookdatacount=Zenoti::getZenotiGuestAppointment(Session::get("zenoti_id"),null,null);
            $totalPrice = 0; // Initialize total price
            $totalAppointments = 0;
            $completedAppointments = 0;
            $pendingAppointments = 0;
            $completedInvoices = 0;
            $pendingInvoices = 0;
            $bookdata=Zenoti::getZenotiGuestAppointment(Session::get("zenoti_id"),$startdate,$enddate);
            foreach ($bookdatacount['appointments'] as $appointment) {
                if ($appointment['invoice_status'] == 4) {
                    $completedInvoices++;
                } else {
                    $pendingInvoices++;
                }
                foreach ($appointment['appointment_services'] as $service) {
                    $totalAppointments++;
                    // Count completed and pending appointments
                    if ($service['appointment_status'] == 1) {
                        $completedAppointments++;
                    } else {
                        $pendingAppointments++;

                    }
                    $totalPrice += $service['service']['price']['sales'];
                }

            }

           return view("user.patient.appointmentdashboard")->with("setting",$setting)->with("bookdata",$bookdata)->with("type",$type)->with("totalappointment",$totalAppointments)->with("completeappointment",$completedAppointments)->with("pendingappointment",$pendingAppointments)->with("userdata",$userdata)->with('zenotiResponse',$zenotiResponse);
        }else{
           return redirect("/");
        }
 
     }
    public function userdashboard(Request $request){
       if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $type=$request->get("type");
          $bookdata=array();
          $totalappointment=count(BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->get());
          $completeappointment=count(BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("status",4)->get());
          $pendingappointment=count(BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("status","!=",4)->get());
          if($type==2){ //past
              $bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date","<",date('Y-m-d'))->paginate(10);
          }elseif($type==3){ //upcoming
              $bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date",">",date('Y-m-d'))->paginate(10);
          }else{ //today
              $bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date",date('Y-m-d'))->paginate(10);
          }
          foreach ($bookdata as $b) {
              if(isset($b->doctorls->department_id)){
                  $data=Services::find($b->doctorls->department_id);
                   if($data){
                      $b->department_name=$data->name;
                   }else{
                      $b->department_name="";
                   }

              }else{
                   $b->department_name="";
              }
          }

          $userdata=Patient::find(Session::get("user_id"));
          if(empty($userdata)){
              $this->logout();
          }
          $zenotiResponse=Zenoti::searchGuest($userdata->phone);
          return view("user.patient.dashboard")->with("setting",$setting)->with("bookdata",$bookdata)->with("type",$type)->with("totalappointment",$totalappointment)->with("completeappointment",$completeappointment)->with("pendingappointment",$pendingappointment)->with("userdata",$userdata)->with('zenotiResponse',$zenotiResponse);
       }else{
          return redirect("/");
       }

    }

    public function logout(){
       Session::forget("user_id");
       Session::forget("zenoti_id");
       Session::forget("center_id");
       Session::forget("role_id");
       return redirect("/aboutus");
    }

    public function makeappointment(Request $request){

        $this->validate($request, [
            "date"    => "required",
            "slot"    => "required",
            "phone_no"    => "required",
            "message"  => "required"
        ]);
        //var_dump($request);
        $service_therapist_detail=$request->get("service").",".$request->get("therapist");
        $slot=explode("#",$request->get("slot"));
        $getappointment=BookAppointment::where("date",date("Y-m-d",strtotime($request->get("date"))))->where("slot_id",isset($slot[0])?$slot[0]:"")->first();
        if($getappointment){
            Session::flash('message',__('message.Slot Already Booked'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }else{

            if($request->get("payment_type")=="stripe"){

                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $unique_id = uniqid();
                $charge = \Stripe\Charge::create(array(
                       'description' => "Amount: ".$request->get("consultation_fees").' - '. $unique_id,
                       'source' => $request->get("stripeToken"),
                       'amount' => (int)($request->get("consultation_fees") * 100),
                       'currency' => env('STRIPE_CURRENCY')
                ));

                DB::beginTransaction();
                try {
                    $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
                    $data=new BookAppointment();
                    $data->user_id=Session::has("user_id");
                    $data->doctor_id=$request->get("doctor_id");
                    $data->slot_id=isset($slot[0])?$slot[0]:"";
                    $data->slot_name=isset($slot[1])?$slot[1]:"";
                    $data->date=date("Y-m-d",strtotime($request->get("date")));
                    $data->phone=$request->get("phone");
                    $data->payment_mode="Stripe";
                    $data->user_description=$request->get("message");
                    $data->transaction_id=$charge->id;
                    $data->consultation_fees = $request->get("consultation_fees");
                    $data->is_completed = 1;
                    $data->save();
                    $store = new Settlement();
                    $store->book_id = $data->id;
                    $store->status = '0';
                    $store->payment_date = $date->format('Y-m-d');
                    $store->doctor_id = $data->doctor_id;
                    $store->amount = $request->get("consultation_fees");
                    $store->save();
                    DB::commit();
                    $msg = __("message.You have a new upcoming appointment");
                    $android = $this->sendNotifications($msg, $request->get("doctor_id"), "doctor_id", $data->id);
                    Session::flash('message',__('message.Appointment Book Successfully'));
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->back();
                }catch (\Exception $e) {
                          DB::rollback();
                          Session::flash('message',$e);
                          Session::flash('alert-class', 'alert-danger');
                          return redirect()->back();
                }
            }
            else if($request->get("payment_type")=="Braintree"){
                $gateway = new \Braintree\Gateway([
                      'environment' => env('BRAINTREE_ENV'),
                      'merchantId'  => env('BRAINTREE_MERCHANT_ID'),
                      'publicKey'   => env('BRAINTREE_PUBLIC_KEY'),
                      'privateKey'  => env('BRAINTREE_PRIVATE_KEY')
                 ]);
                $nonce = $request->get("payment_method_nonce");
                $result = $gateway->transaction()->sale([
                              'amount' => $request->get("consultation_fees"),
                              'paymentMethodNonce' => $nonce,
                              'options' => [
                                  'submitForSettlement' => true
                              ]
                          ]);
                if ($result->success) {
                      $transaction = $result->transaction;
                      DB::beginTransaction();
                      try {
                              $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));

                              $data=new BookAppointment();
                              $data->user_id=Session::get("user_id");
                              $data->doctor_id=$request->get("doctor_id");
                              $data->slot_id=isset($slot[0])?$slot[0]:"";
                              $data->slot_name=isset($slot[1])?$slot[1]:"";
                               $data->date=date("Y-m-d",strtotime($request->get("date")));
                              $data->phone=$request->get("phone_no");
                              $data->user_description=$request->get("message");
                              $data->payment_mode="Braintree";
                              $data->transaction_id=$transaction->id;
                              $data->consultation_fees = $request->get("consultation_fees");
                              $data->is_completed = 1;
                              $data->save();
                              $store = new Settlement();
                              $store->book_id = $data->id;
                              $store->status = '0';
                              $store->payment_date = $date->format('Y-m-d');
                              $store->doctor_id = $data->doctor_id;
                              $store->amount = $request->get("consultation_fees");
                              $store->save();
                              DB::commit();
                              $msg = __("message.You have a new upcoming appointment");
                    $android = $this->sendNotifications($msg, $request->get("doctor_id"), "doctor_id", $data->id);
                              Session::flash('message',__('message.Appointment Book Successfully'));
                              Session::flash('alert-class', 'alert-success');
                              return redirect()->back();
                      }catch (\Exception $e) {
                              DB::rollback();
                              Session::flash('message',$e);
                              Session::flash('alert-class', 'alert-danger');
                              return redirect()->back();
                      }
                }else{
                        $errorString = "";
                        foreach($result->errors->deepAll() as $error) {
                            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                        }
                        Session::flash('message',$errorString);
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->back();
                }
            }
            else if($request->get("payment_type")=="cod"){


                DB::beginTransaction();
                try {
                      $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));

                      $data=new BookAppointment();
                      $data->user_id=Session::get("user_id");
                      $data->doctor_id=$request->get("doctor_id");
                      $data->slot_id=isset($slot[0])?$slot[0]:"";
                      $data->slot_name=isset($slot[1])?$slot[1]:"";
                       $data->date=date("Y-m-d",strtotime($request->get("date")));
                      $data->phone=$request->get("phone_no");
                      $data->user_description=$request->get("message");
                      $data->service_therapist_detail=$service_therapist_detail;
                      $data->payment_mode="COD";
                    //   $data->transaction_id="";
                      $data->is_completed = "1";
                      $data->consultation_fees = $request->get("consultation_fees");
                      $data->save();
                      $store = new Settlement();
                      $store->book_id = $data->id;
                      $store->status = '0';
                      $store->payment_date = $date->format('Y-m-d');
                      $store->doctor_id = $data->doctor_id;
                      $store->amount = $request->get("consultation_fees");
                      $store->save();
                      DB::commit();
                      $msg = __("message.You have a new upcoming appointment");
                    $android = $this->sendNotifications($msg, $request->get("doctor_id"), "doctor_id", $data->id);
                      Session::flash('message',__('message.Appointment Book Successfully'));
                      Session::flash('alert-class', 'alert-success');
                      return redirect()->back();
                }catch (\Exception $e) {
                      DB::rollback();
                      Session::flash('message',$e);
                      Session::flash('alert-class', 'alert-danger');
                      return redirect()->back();
                }

            }
            else if($request->get("payment_type")=="Flutterwave"){

                $reference = Flutterwave::generateReference();

                $data1 = PaymentGatewayDetail::where("gateway_name","rave")->get();

                $arr = array();
                foreach ($data1 as $k) {
                        $arr[$k->gateway_name."_".$k->key] = $k->value;
                }

                    $user = Session::get("user_id");
                    $userinfo = Patient::find($user);

                    $data = [
                                'payment_options' => 'card,banktransfer',
                                'amount' => $request->get("consultation_fees"),
                                'email' => $userinfo->email,
                                'tx_ref' => $reference,
                                'currency' => $arr['rave_currency'],
                                'redirect_url' => route('web-callback'),
                                'customer' => [
                                    'email' => $userinfo->email,
                                    "phonenumber" => $request->get("phone_no"),
                                    "name" => $userinfo->name
                                ],

                                "customizations" => [
                                    "title" => 'Book Appointment',
                                    "description" => "Book Appointment"
                                ]
                    ];

                $payment = Flutterwave::initializePayment($data);
                // echo "<pre>";print_r($payment);exit;


                          $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
                          $data=new BookAppointment();
                          $data->user_id=Session::get("user_id");
                          $data->doctor_id=$request->get("doctor_id");
                          $data->slot_id=isset($slot[0])?$slot[0]:"";
                          $data->slot_name=isset($slot[1])?$slot[1]:"";
                          $data->date=date("Y-m-d",strtotime($request->get("date")));
                          $data->phone=$request->get("phone_no");
                          $data->user_description=$request->get("message");
                          $data->payment_mode="rave";
                          $data->transaction_id=$reference;
                          $data->consultation_fees = $request->get("consultation_fees");
                          $data->save();
                          $store = new Settlement();
                          $store->book_id = $data->id;
                          $store->status = '0';
                          $store->payment_date = $date->format('Y-m-d');
                          $store->doctor_id = $data->doctor_id;
                          $store->amount = $request->get("consultation_fees");
                          $store->save();
                          DB::commit();


                if ($payment['status'] !== 'success') {
                    return redirect()->route('payment-failed');
                    Session::flash('message',$errorString);
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }else{
                    return redirect($payment['data']['link']);

                }

            }
            else if($request->get("payment_type")=="Razorpay"){
                $data1 = PaymentGatewayDetail::where("gateway_name","razorpay")->get();
                $arr = array();
                if(count($data1)>0){
                    foreach ($data1 as $k) {
                        $arr[$k->gateway_name."_".$k->key] = $k->value;
                    }
                }
                // echo "<pre>";print_r($arr);exit;
                $input = $request->all();

                // $api = new Api($arr['razorpay_razorpay_key'],$arr['razorpay_razorpay_secert']);
                // $payment = $api->payment->fetch($request->get('razorpay_payment_id'));
                // $response = $api->payment->fetch($request->get('razorpay_payment_id'))->capture(array('amount'=>(int)$amount*100));

                DB::beginTransaction();
                try {
                      $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));

                      $data=new BookAppointment();
                      $data->user_id=Session::get("user_id");
                      $data->doctor_id=$request->get("doctor_id");
                      $data->slot_id=isset($slot[0])?$slot[0]:"";
                      $data->slot_name=isset($slot[1])?$slot[1]:"";
                       $data->date=date("Y-m-d",strtotime($request->get("date")));
                      $data->phone=$request->get("phone_no");
                      $data->user_description=$request->get("message");
                      $data->payment_mode="Razorpay";
                      $data->transaction_id=$request->get('razorpay_payment_id');
                      $data->consultation_fees = $request->get("consultation_fees");
                       $data->is_completed = 1;
                      $data->save();
                      $store = new Settlement();
                      $store->book_id = $data->id;
                      $store->status = '0';
                      $store->payment_date = $date->format('Y-m-d');
                      $store->doctor_id = $data->doctor_id;
                      $store->amount = $request->get("consultation_fees");
                      $store->save();
                      DB::commit();

                      $msg = __("message.You have a new upcoming appointment");
                    $android = $this->sendNotifications($msg, $request->get("doctor_id"), "doctor_id", $data->id);
                      Session::flash('message',__('message.Appointment Book Successfully'));
                      Session::flash('alert-class', 'alert-success');
                      return redirect()->back();
                }catch (\Exception $e) {
                      DB::rollback();
                      Session::flash('message',$e);
                      Session::flash('alert-class', 'alert-danger');
                      return redirect()->back();
                }
            }
            else if($request->get("payment_type")=="Paytm"){


                DB::beginTransaction();
                try {
                      $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));

                      $data=new BookAppointment();
                      $data->user_id=Session::get("user_id");
                      $data->doctor_id=$request->get("doctor_id");
                      $data->slot_id=isset($slot[0])?$slot[0]:"";
                      $data->slot_name=isset($slot[1])?$slot[1]:"";
                      $data->date=date("Y-m-d",strtotime($request->get("date")));
                      $data->phone=$request->get("phone_no");
                      $data->user_description=$request->get("message");
                      $data->payment_mode="Paytm";
                      $data->consultation_fees = $request->get("consultation_fees");

                      $data->save();
                      $store = new Settlement();
                      $store->book_id = $data->id;
                      $store->status = '0';
                      $store->payment_date = $date->format('Y-m-d');
                      $store->doctor_id = $data->doctor_id;
                      $store->amount = $request->get("consultation_fees");
                      $store->save();

                        $data1 = PaymentGatewayDetail::where("gateway_name","paytm")->get();
                        $arr = array();

                        if(count($data1)>0){
                            foreach ($data1 as $k) {
                                $arr[$k->gateway_name."_".$k->key] = $k->value;
                            }
                        }
                        $book_id = $data->id;
                        $o_id=$book_id."-3";
                        $payment = PaytmWallet::with('receive');
                        $amount =  $request->get("consultation_fees");
                        $payment->prepare([
                            'order' => $o_id,
                            'user' => 'redixbit',
                            'mobile_number' => '9904444091',
                            'email' => 'redixbit.user10@gmail.com',
                            'amount' => $amount,
                            'callback_url' => route('paytmstatus')
                        ]);

                      DB::commit();
                      return $payment->receive();

                }catch (\Exception $e) {
                      DB::rollback();
                      Session::flash('message',$e);
                      Session::flash('alert-class', 'alert-danger');
                      return redirect()->back();
                }
            }
            else if($request->get("payment_type")=="Paystack"){

                $data1 = PaymentGatewayDetail::where("gateway_name","paystack")->get();

                $arr = array();
                foreach ($data1 as $k) {
                        $arr[$k->gateway_name."_".$k->key] = $k->value;
                }


                $curl = curl_init();
                $email = 'admin@gmail.com';
                $amount = $request->get("consultation_fees");
                $callback_url = route('paystack_callback');
                // echo "<pre>";print_r($amount);exit;

                  curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode([
                      'amount'=>$amount,
                      'email'=>$email,
                      'callback_url' => $callback_url
                    ]),
                    CURLOPT_HTTPHEADER => [
                      "authorization: Bearer ".$arr['paystack_secert_key']."",
                      "content-type: application/json",
                      "cache-control: no-cache"
                    ],
                  ));
                  $response = curl_exec($curl);
                  $err = curl_error($curl);
                  if($err){
                    die('Curl returned error: ' . $err);
                  }
                  $tranx = json_decode($response, true);
                //   echo "<pre>";print_r($tranx);exit;

                if($tranx['data']['reference']){
                    DB::beginTransaction();
                    try {
                          $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));

                          $data=new BookAppointment();
                          $data->user_id=Session::get("user_id");
                          $data->doctor_id=$request->get("doctor_id");
                          $data->slot_id=isset($slot[0])?$slot[0]:"";
                          $data->slot_name=isset($slot[1])?$slot[1]:"";
                          $data->date=date("Y-m-d",strtotime($request->get("date")));
                          $data->phone=$request->get("phone_no");
                          $data->user_description=$request->get("message");
                          $data->payment_mode="Paystack";
                          $data->is_completed='0';
                          $data->transaction_id=$tranx['data']['reference'];
                          $data->consultation_fees = $request->get("consultation_fees");
                          $data->save();
                          $store = new Settlement();
                          $store->book_id = $data->id;
                          $store->status = '0';
                          $store->payment_date = $date->format('Y-m-d');
                          $store->doctor_id = $data->doctor_id;
                          $store->amount = $request->get("consultation_fees");
                          $store->save();
                          DB::commit();

                    }catch (\Exception $e) {
                              DB::rollback();
                    }
                }else{
                    die('something getting worng');
                }

                if(!$tranx['status']){
                    print_r('API returned error: ' . $tranx['message']);
                }
                return Redirect($tranx['data']['authorization_url']);

            }
        }
    }

    // public function paystack_callback(Request $request){
    //   $data1 = PaymentGatewayDetail::where("gateway_name","paystack")->get();

    //   $arr = array();
    //   foreach ($data1 as $k) {
    //         $arr[$k->gateway_name."_".$k->key] = $k->value;
    //   }
    //   $curl = curl_init();
    //     $reference = $request->get("reference");
    //     if(!$reference){
    //       die('No reference supplied');
    //     }
    //     curl_setopt_array($curl, array(
    //       CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_HTTPHEADER => [
    //         "accept: application/json",
    //         "authorization: Bearer ".$arr['paystack_secert_key']."",
    //         "cache-control: no-cache"
    //       ],
    //     ));
    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);
    //     if($err){
    //      return redirect()->route('payment-failed');
    //     }
    //     $tranx = json_decode($response);
    //     if(!$tranx->status){
    //      return redirect()->route('payment-failed');
    //     }
    //     if('success' == $tranx->data->status){
    //         if(Session::get("type")==1){
    //             $data = BookAppointment::where("transaction_id",$reference)->first();
    //             $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
    //             $data->payment_mode="Paystack";
    //             $data->transaction_id=$reference;
    //             $data->is_completed='1';
    //             $data->status='2';
    //             $data->save();
    //             $store = new Settlement();
    //             $store->book_id = $data->id;
    //             $store->status = '0';
    //             $store->payment_date = $date->format('Y-m-d');
    //             $store->doctor_id = $data->doctor_id;
    //             $store->amount = $data->consultation_fees;
    //             $store->save();
    //             $msg="You have a new upcoming appointment";
    //             $user=User::find(1);
    //             $android=$this->send_notification_android($user->android_key,$msg,$request->get("doctor_id"),"doctor_id",$data->id);
    //             $ios=$this->send_notification_IOS($user->ios_key,$msg,$request->get("doctor_id"),"doctor_id",$data->id);
    //             try {
    //                     $user=Doctors::find($request->get("doctor_id"));

    //                     $result=Mail::send('email.Ordermsg', ['user' => $user], function($message) use ($user){
    //                         $message->to($user->email,$user->name)->subject(__('message.System Name'));
    //                     });

    //             } catch (\Exception $e) {
    //             }
    //         }
    //         if(Session::get("type")==2){
    //             $data = Subscriber::where("transaction_id",$reference)->first();
    //             $data->payment_type="4";
    //             $data->transaction_id=$reference;
    //             $data->status='2';
    //             $data->is_complet='1';
    //             $data->save();
    //         }
    //         $doctor_id = $data->doctor_id;
    //         Session::flash('message',__('message.Appointment Book Successfully'));
    //         Session::flash('alert-class', 'alert-success');
    //         return redirect('viewdoctor/'.$doctor_id);
    //     }else{ //fail
    //         Session::flash('message',__('message.Something Wrong'));
    //         Session::flash('alert-class', 'alert-danger');
    //         return redirect()->back();
    //     }
    // }

    public function web_rave_callback(Request $request){
        $transactionID = Flutterwave::getTransactionIDFromCallback();

        $data = Flutterwave::verifyTransaction($transactionID);
            $data1 = BookAppointment::where("transaction_id",$data['data']['tx_ref'])->first();
            $data1->is_completed = 1;
            $data1->save();

        $doctor_id = $data1->doctor_id;
        Session::flash('message',__('message.Appointment Book Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('viewdoctor/'.$doctor_id);
    }

    public function web_rave_callbackorder(Request $request){
        $transactionID = Flutterwave::getTransactionIDFromCallback();

        $data = Flutterwave::verifyTransaction($transactionID);
            $data1 = PharmacyOrder::where("transaction_id",$data['data']['tx_ref'])->first();
            $data1->is_completed = 1;
            $data1->save();

        $doctor_id = $data1->Pharmacy_id;
        Session::flash('message',__('message.medicine_order_palce'));
        Session::flash('alert-class', 'alert-success');
        return redirect('viewpharmacy/'.$doctor_id);
    }



    public function userfavorite($doc_id){
        if(Session::has("user_id")&&Session::get("role_id")=='1'){
            $getFav=FavoriteDoc::where("doctor_id",$doc_id)->where("user_id",Session::get("user_id"))->first();
            if($getFav){
               $msg=__('message.Doctor remove in Favorite list');
               $op="0";
               $getFav->delete();
            }else{
               $store=new FavoriteDoc();
               $store->doctor_id=$doc_id;
               $store->user_id=Session::get("user_id");
               $store->save();
               $op='1';
               $msg=__('message.Doctor add in Favorite list');
            }
            $data=array("msg"=>$msg,"class"=>"alert-success","op"=>$op);
        }else{
            $data=array("msg"=>__('message.Please')." <a href=".url('patientlogin').">".__('message.Login')."</a> ".__('message.Your Account')."","class"=>"alert-danger","op"=>'0');
        }

        return json_encode($data);
    }

    public function favouriteuser(){
       if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get('user_id'));
          $userfavorite=FavoriteDoc::with("doctorls")->where("user_id",Session::get("user_id"))->paginate(9);
          foreach ($userfavorite as $k) {
                if($k->doctorls){
                    $k->doctorls->avgratting=Review::where('doc_id',$k->doctor_id)->avg('rating');
                    $k->doctorls->totalreview=count(Review::where('doc_id',$k->doctor_id)->get());
                    $k->doctorls->is_fav=1;
                    if(isset($k->doctorls->department_id)&&$k->doctorls->department_id!=""){
                        $getservice=Services::find($k->doctorls->department_id);
                        $k->doctorls->department_name=$getservice->name;
                    }else{
                        $k->doctorls->department_name="";
                    }

                }
          }
          return view("user.patient.favourite")->with("userdata",$userdata)->with("setting",$setting)->with("userfavorite",$userfavorite);
       }
       else{
          return redirect('/');
       }
    }

    public function viewschedule(){
       if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get('user_id'));
          return view("user.patient.scheduleappointment")->with("userdata",$userdata)->with("setting",$setting);
       }
       else{
          return redirect('/');
       }
    }

    public function viewappointment($id){
        if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get('user_id'));
          $viewappointment = BookAppointment::with('doctorls')->find($id);
          return view("user.doctor.viewappoint")->with("userdata",$userdata)->with("setting",$setting)->with("viewappointment",$viewappointment);
       }
       else{
          return redirect('/');
       }
    }

    public function changepassword(){
      if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
        $setting=Setting::find(1);
        $userdata=Patient::find(Session::get("user_id"));
        return view("user.patient.changepassword")->with("userdata",$userdata)->with("setting",$setting);
      }else{
         return redirect('/');
      }
    }

    public function checkuserpwd(Request $request){
        $data=Patient::find(Session::get("user_id"));
        if($data){
            if($data->password==$request->get("cpwd")){
                return 1;
            }else{
                return 0;
            }
        }else{
           return redirect("/");
        }
    }

    public function updateuserpassword(Request $request){
          $data=Patient::find(Session::get("user_id"));
          $data->password=$request->get("npwd");
          $data->save();
          Session::flash('message',__('message.Password Change Successfully'));
          Session::flash('alert-class', 'alert-success');
          return redirect()->back();
    }

    public function userreview(){
      if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get("user_id"));
          $datareview=Review::with("doctorls")->where("user_id",Session::get("user_id"))->orderby("id","DESC")->get();
          foreach ($datareview as $k) {
             $ddp=Services::find($k->doctorls->department_id);
             if($ddp){
                $k->doctorls->department_name=$ddp->name;
             }else{
                $k->doctorls->department_name="";
             }
          }
          return view("user.patient.review")->with("setting",$setting)->with("userdata",$userdata)->with("datareview",$datareview);
      }else{
          return redirect("/");
      }
    }

    public function usereditprofile(){
        if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get("user_id"));
          $zenotidata=Zenoti::guestDetailsByID(Session::get("zenoti_id"));
          return view("user.patient.editprofile")->with("setting",$setting)->with("userdata",$userdata)->with("zenotidata",$zenotidata);
        }else{
          return redirect("/");
        }
    }

    public function updateuserprofile(Request $request){
      $user=Patient::find(Session::get("user_id"));
      $findemail=Patient::where("email",$request->get("email"))->where("id","!=",Session::get("user_id"))->first();
      if($findemail){
           Session::flash('message',__('message.Email Id Already Use By Other User'));
           Session::flash('alert-class', 'alert-danger');
           return redirect()->back();
      }else{

           $img=$user->profile_pic;
           $rel_url=$user->profile_pic;
           if ($request->hasFile('image'))
              {
                  $file = $request->file('image');
                  $filename = $file->getClientOriginalName();
                  $extension = $file->getClientOriginalExtension() ?: 'png';
                  $folderName = '/upload/profile/';
                  $picture = time() . '.' . $extension;
                  $destinationPath = public_path() . $folderName;
                  $request->file('image')->move($destinationPath, $picture);
                  $img =$picture;
                  $image_path = public_path() ."/upload/profile/".$rel_url;
                  if(file_exists($image_path)&&$rel_url!="") {
                      try {
                            unlink($image_path);
                      }catch(Exception $e) {

                      }
                  }
            }
            // commented as these fields are disabled in front end edit profile
           //$user->name=$request->get("name");
           //$user->email=$request->get("email");
           //$user->phone=$request->get("phone");
           $user->profile_pic=$img;
           $user->save();
           Session::flash('message',__('message.Profile Update Successfully'));
           Session::flash('alert-class', 'alert-success');
           return redirect()->back();
      }
      //dd($request->all());
    }


      public function resetpassword($code){
            $setting = Setting::find(1);
            $data=Resetpassword::where("code",$code)->first();
            if($data){
              return view('user.resetpwd')->with("id",$data->user_id)->with("code",$code)->with("type",$data->type)->with("setting",$setting);
            }else{
              return view('user.resetpwd')->with("msg",__('message.Code Expired'))->with("setting",$setting);
            }
      }
      public function resetnewpwd(Request $request){
           $setting = Setting::find(1);
            if($request->get('id')==""){
                return view('user.resetpwd')->with("msg",__('message.pwd_reset'))->with("setting",$setting);
            }else{
                if($request->get("type")==1){
                     $user=Patient::find($request->get('id'));
                }else{
                    $user=Doctors::find($request->get('id'));
                }
                $user->password=$request->get('npwd');
                $user->save();
                $codedel=Resetpassword::where('user_id',$request->get("id"))->delete();
                return view('user.pwdsucess')->with("msg",__('message.pwd_reset'))->with("setting",$setting);
            }
      }

    //   public function send_notification_android($key,$msg,$id,$field,$order_id){
    //     $getuser=TokenData::where("type",1)->where($field,$id)->get();

    //     $i=0;
    //     if(count($getuser)!=0){

    //            $reg_id = array();
    //            foreach($getuser as $gt){
    //                $reg_id[]=$gt->token;
    //            }
    //            $regIdChunk=array_chunk($reg_id,1000);
    //            foreach ($regIdChunk as $k) {
    //                    $registrationIds =  $k;
    //                     $message = array(
    //                         'message' => $msg,
    //                         'title' =>  __('message.notification')
    //                       );
    //                     $message1 = array(
    //                         'body' => $msg,
    //                         'title' =>  __('message.notification'),
    //                         'type'=>$field,
    //                         'order_id'=>$order_id,
    //                         'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
    //                     );
    //                     //echo "<pre>";print_r($message1);exit;
    //                    $fields = array(
    //                       'registration_ids'  => $registrationIds,
    //                       'data'              => $message1,
    //                       'notification'      =>$message1
    //                    );

    //                   // echo "<pre>";print_r($fields);exit;
    //                    $url = 'https://fcm.googleapis.com/fcm/send';
    //                    $headers = array(
    //                      'Authorization: key='.$key,// . $api_key,
    //                      'Content-Type: application/json'
    //                    );
    //                   $json =  json_encode($fields);
    //                   $ch = curl_init();
    //                   curl_setopt($ch, CURLOPT_URL, $url);
    //                   curl_setopt($ch, CURLOPT_POST, true);
    //                   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //                   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //                   curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
    //                   $result = curl_exec($ch);
    //                   //echo "<pre>";print_r($result);exit;
    //                   if ($result === FALSE){
    //                      die('Curl failed: ' . curl_error($ch));
    //                   }
    //                  curl_close($ch);
    //                  $response[]=json_decode($result,true);
    //            }
    //           $succ=0;
    //            foreach ($response as $k) {
    //               $succ=$succ+$k['success'];
    //            }
    //          if($succ>0)
    //           {
    //                return 1;
    //           }
    //         else
    //            {
    //               return 0;
    //            }
    //     }
    //     return 0;
    //  }

    // public function send_notification_IOS($key,$msg,$id,$field,$order_id){
    //   $getuser=TokenData::where("type",2)->where($field,$id)->get();
    //      if(count($getuser)!=0){
    //            $reg_id = array();
    //            foreach($getuser as $gt){
    //                $reg_id[]=$gt->token;
    //            }

    //           $regIdChunk=array_chunk($reg_id,1000);
    //            foreach ($regIdChunk as $k) {
    //                    $registrationIds =  $k;
    //                    $message = array(
    //                         'message' => $msg,
    //                         'title' =>  __('message.notification')
    //                       );
    //                     $message1 = array(
    //                         'body' => $msg,
    //                         'title' =>  __('message.notification'),
    //                         'type'=>$field,
    //                         'order_id'=>$order_id,
    //                         'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
    //                     );
    //                    $fields = array(
    //                       'registration_ids'  => $registrationIds,
    //                       'data'              => $message1,
    //                       'notification'=>$message1
    //                    );
    //                    $url = 'https://fcm.googleapis.com/fcm/send';
    //                    $headers = array(
    //                      'Authorization: key='.$key,// . $api_key,
    //                      'Content-Type: application/json'
    //                    );
    //                   $json =  json_encode($fields);
    //                   $ch = curl_init();
    //                   curl_setopt($ch, CURLOPT_URL, $url);
    //                   curl_setopt($ch, CURLOPT_POST, true);
    //                   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //                   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //                   curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
    //                   $result = curl_exec($ch);
    //                   if ($result === FALSE){
    //                      die('Curl failed: ' . curl_error($ch));
    //                   }
    //                  curl_close($ch);
    //                  $response[]=json_decode($result,true);
    //            }
    //           $succ=0;
    //            foreach ($response as $k) {
    //               $succ=$succ+$k['success'];
    //            }
    //          if($succ>0)
    //           {
    //                return 1;
    //           }
    //         else
    //            {
    //               return 0;
    //            }
    //     }
    //     return 0;
    //  }

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

    public function sendNotifications($msg,$id, $field, $order_id)
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


}

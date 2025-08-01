<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Session;
use validate;
use Sentinel;
//use DB;
use Illuminate\Support\Facades\DB;
use App\Models\Doctors;
use App\Models\Services;
use App\Models\SlotTiming;
use App\Models\Schedule;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Patient;
use App\Models\BookAppointment;
use App\Models\Doctor_Hoilday;
use App\Models\VideoConsultation;
use App\Models\VideoConsultationMedicine;
use App\Models\Complement_settlement;
use DataTables;
use App\Models\TokenData;
use App\Models\User;
use App\Models\PaymentGatewayDetail;
use Mail;
use App\Models\Medicines;
use App\Models\Productsecom;
use App\Models\AppointmentMedicines;
use App\Models\ap_img_uplod;
use App\Models\Subscriber;
use Google_Client;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use DateInterval;
use App\Models\Subscription;
use DateTime;
use App\Http\Middleware\Zenoti;
use App\Http\Middleware\Vlc;
use App\Http\Middleware\Eshop;
use App\Http\Middleware\SmsController;
use App\Models\VideoConsultationDiagnosis;
use App\Models\VideoConsultationTreatment;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    public function getmedicines(Request $request)
    {

        $input = $request->input('inputText');

        $demo = Medicines::where('name', 'like', '%' . $input . '%')->pluck('name')->toArray();

        $suggestions = array_filter($demo, function ($tip) use ($input) {
            return stripos($tip, $input) !== false;
        });

        return response()->json(['suggestions' => array_values($suggestions)]);
    }
    public function getproductsecom(Request $request)
    {

        $input = $request->input('inputText');

        $demo = Productsecom::where('name', 'like', '%' . $input . '%')->pluck('name')->toArray();
        $suggestions = array_filter($demo, function ($tip) use ($input) {
            return stripos($tip, $input) !== false;
        });
        //$demo = Productsecom::where('name', 'like', '%' . $input . '%')->get(['id', 'name'])->toArray();// get both id and name->toArray();
        //$suggestions = array_filter($demo, function ($tip) use ($input) {
          //  return stripos($tip['name'], $input) !== false;
        //});


        return response()->json(['suggestions' => array_values($suggestions)]);
    }

    public function backtoappointment()
    {
        return redirect()->route('doctorappointment');
    }
    public function videoconsultation_detail($id)
    {
        $consultation_encryption_id=$id;// $id passed as encryption id here
        $medi = Medicines::get();
        $setting = Setting::find(1);
        //$consultationdata = VideoConsultation::where('encryption_id',$id)->first();
        $consultationdata = Vlc::getConsultationDetails($id);
        $consultation_logs=Vlc::getConsultationLogs($consultation_encryption_id);
        $app_medicine =Vlc::getPrescription($consultationdata->id);
        $consultation_treatment=Vlc::getTreatment($consultationdata->id);
        $consultation_diagnosis=Vlc::getDiagnosis($consultationdata->id);
        $apoid = $consultationdata->id;
        $img = ap_img_uplod::where('consultation_id', $consultationdata->id)->get();

        return view("user.doctor.video_consultation_prescription")->with('consultation_treatment',$consultation_treatment)->with('consultation_diagnosis',$consultation_diagnosis)->with('consultation_logs',$consultation_logs)->with('consultation_encryption_id',$consultation_encryption_id)->with("setting", $setting)->with("medi", $medi)->with("apoid", $apoid)->with("am", $consultationdata)->with("app_medicine", $app_medicine)->with("img", $img);
    }
    public function appointment_detail($id)
    {
        $medi = Medicines::get();
        $setting = Setting::find(1);
        $apoid = $id;
        $app_medicine = AppointmentMedicines::where('appointment_id', $id)->get();
        $appointmentdata = BookAppointment::with('patientls')->find($id);
        $img = ap_img_uplod::where('appointment_id', $id)->get();

        return view("user.doctor.prescription")->with("setting", $setting)->with("medi", $medi)->with("apoid", $apoid)->with("am", $appointmentdata)->with("app_medicine", $app_medicine)->with("img", $img);
    }
    /** VIDEO CONULTATION MODULE */
    public static function create_vlc_products_checkout($vlc_id=NULL){

        //var_dump("Hello");exit;
        $apiUrl = env('BERKOWITS_PRODUCT_API_URL') ;
        $apiKey = env('BERKOWITS_PRODUCT_API_KEY');

        // 1. Get blank schema of cart
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . '/carts?schema=blank');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':');
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            die('Error fetching cart schema: ' . curl_error($ch));
        }
        curl_close($ch);

        // Load XML
        $xml = new \SimpleXMLElement($response);
        //var_dump($xml);exit;

        // Fill in cart info
        $xml->id_customer = 0; // guest
        $xml->id_currency = 2;
        $xml->id_lang = 1;
        //$xml->id_address_delivery = 1; // Must exist
        //$xml->id_address_invoice = 1;

        // Define products to add
        $products = [
            ['id_product' => 20, 'id_product_attribute' => 0, 'quantity' => 1],
            ['id_product' => 21, 'id_product_attribute' => 0, 'quantity' => 1],
            ['id_product' => 22, 'id_product_attribute' => 0, 'quantity' => 1],
        ];

        // Create cart_rows
        $cart_rows = $xml->associations->addChild('cart_rows');
        foreach ($products as $product) {
            $row = $cart_rows->addChild('cart_row');
            $row->addChild('id_product', $product['id_product']);
            $row->addChild('id_product_attribute', $product['id_product_attribute']);
            $row->addChild('id_address_delivery', 1); // Same as cart
            $row->addChild('quantity', $product['quantity']);
        }

        // Convert back to XML
        $cartXml = $xml->asXML();

        // 2. Send POST request to create cart
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . '/carts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':');
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $cartXml);

        $response = curl_exec($ch);
        //var_dump($response);

        if (curl_errno($ch)) {
            die('Error creating cart: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Handle response
        if ($httpCode == 201) {
            $responseXml = new SimpleXMLElement($response);
            echo "Cart created successfully with ID: " . $responseXml->cart->id . "\n";
        } else {
            echo "Failed to create cart. HTTP Code: $httpCode\n";
            echo "Response: $response\n";
        }
        $res['response']=$response;
        $res['cart_id']=$responseXml->cart->id ;
        return $res;


    }
    public function share_video_consulattion_prescription(Request $request){
        if(empty($request->get("phone")) ){
        }
        $param=array(
            'phone'=>$request->get("phone"),
            'client_name'=>$request->get("client_name"),
            'doctor_name'=>$request->get("doctor_name"),
            'prescription_url'=>$request->get("prescription_url"),

        );
        $result=SmsController::sendMultiFormatWhatsAppTelephant("vlc_order_report",$param);
        //$result=SmsController::sendMultiFormatWhatsAppTelephant("vlc_share_prescription_1",$param);
        // Save Logs
        $param['messageId']=$result["messageId"]; 
        $param['log_activity']="Prescription shared with ".$param['client_name']." on whatsapp ".$param['phone']; 
        $param['prescription_url'] = htmlspecialchars($param['prescription_url'] , ENT_QUOTES, 'UTF-8');
        date_default_timezone_set('Asia/Kolkata');
        DB::table('video_consultation_logs')->insert([
            'consultation_id' => $request->get("consultation_id"),  // Replace with actual consultation_id
            'encryption_id' => $request->get("encryption_id"),  // Replace with actual encryption_id
            'log_details' => json_encode($param,true),  // Replace with actual log details
            'log_type' => 'shared_prescription',  // Replace with actual log type
            'created_at' => date('Y-m-d H:i:s'), // Using Laravel helper for the current timestamp
        ]);
        return redirect()->back();

    }
    public function video_consultation_list(Request $request)
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $centerDetails=Doctors::where('id',Session::get("user_id") )->first();
            $center_id=$centerDetails->center_id;
            // VDO CONSULTATION COUNTERS
            $totalconsultation= count(VideoConsultation::where("center_id", $center_id)->where("payment_status", "success")->get());
            $totalCompletedConsultation= count(VideoConsultation::where("center_id", $center_id)->where("status", "completed")->get());
            $totalAbsentConsultation= count(VideoConsultation::where("center_id", $center_id)->where("status", "absent")->get());
            $totalPendingConsultation= count(VideoConsultation::where("center_id", $center_id)->where("payment_status", "success")->where("status", "pending")->get());
            $vlc_counter_array=array(
                'totalCompletedConsultation'=>$totalCompletedConsultation,
                'totalconsultation'=>$totalconsultation,
                'totalAbsentConsultation'=>$totalAbsentConsultation,
                'totalPendingConsultation'=>$totalPendingConsultation,

            );
            //$vlc=VideoConsultation::
            // *************** END  VDO CONSULTATION *************** 
            $setting = Setting::find(1);
            $totalappointment = count(BookAppointment::where("doctor_id", Session::get("user_id"))->get());
            $totalreview = count(Review::where("doc_id", Session::get("user_id"))->get());
            $totalnewappointment = count(BookAppointment::where("doctor_id", Session::get("user_id"))->where("notify", '1')->get());
            $getnewapp = BookAppointment::where("doctor_id", Session::get("user_id"))->where("notify", '1')->get();
            foreach ($getnewapp as $k) {
                $k->notify = '0';
                $k->save();
            }
            //$bookdata = VideoConsultation::all();
           
            $type = $request->get("type");
            if ($type == 1){
                // today
                $bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "pending")->where("payment_status", "success")->where("preferred_date", date('Y-m-d'))->get();

            }elseif ($type == 2) { //past
                //$bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", "<", date('Y-m-d'))->paginate(10);
                $bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "pending")->where("payment_status", "success")->where("preferred_date", "<", date('Y-m-d'))->get();
                //var_dump($bookdata);exit;
            } elseif ($type == 3) { //upcoming
                $bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "pending")->where("payment_status", "success")->where("preferred_date", ">=", date('Y-m-d'))->get();
                //$bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", ">", date('Y-m-d'))->paginate(10);
            } elseif($type == 4){
                $bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "completed")->get();
            }elseif($type == 5){
                $bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "absent")->get();
            }
            else { //today
                //$bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "pending")->where("payment_status", "success")->where("preferred_date", ">=", date('Y-m-d'))->orderBy('preferred_date', 'asc')->get();
                $bookdata = VideoConsultation::where("center_id", $center_id)->where("status", "pending")->where("payment_status", "success")->where("preferred_date", date('Y-m-d'))->get();
                //$bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", date('Y-m-d'))->paginate(10);
            }
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            //return view("user.doctor.video_consultation_list")->with("setting", $setting)->with("doctordata", $doctordata)->with("totalappointment", $totalappointment)->with("totalreview", $totalreview)->with("totalnewappointment", $totalnewappointment)->with("type", $type)->with("bookdata", $bookdata);
            return view("user.doctor.video_consultation_list")->with("setting", $setting)->with("doctordata", $doctordata)->with("type", $type)->with("bookdata", $bookdata)->with('vlc_counter',$vlc_counter_array);
        } else {
            return redirect("/");
        }
    }
    /*public function video_consultation_detail($encryption_id)
    {
        //var_dump($apoid);
        exit;
        $medi = Medicines::get();
        $setting = Setting::find(1);
        $consultationdata = Vlc::getConsultationDetails($encryption_id);
        $app_medicine = Vlc::getPrescription($consultationdata->id);
        $apoid = $consultationdata->id;

        $img = ap_img_uplod::where('appointment_id', $encryption_id)->get();

        return view("user.doctor.prescription")->with("setting", $setting)->with("medi", $medi)->with("apoid", $apoid)->with("am", $consultationdata)->with("app_medicine", $app_medicine)->with("img", $img);
    }*/
    public function share_consultation_checkout_link($encryted_id=NULL){
        $consultationdata = Vlc::getConsultationDetails($encryted_id);
        $app_medicine =Vlc::getPrescriptionForPDF($consultationdata->id);
        $product_list=[];
        foreach ($app_medicine as $medData) {
            foreach ($medData['medicine'] as $medicine) {
                $product_name=$medicine['medicine_name'];
                $id_products_array = Productsecom::where('name', 'like', '%' . $product_name . '%')->select('id')->get();
                foreach ($id_products_array as $product) {
                    $id_product=$product->id;// Accessing the value\
                    //var_dump($id_product);
                    $product_lis[]=$id_product;
                }

             }
        }
        foreach ($product_lis as $id) {
            $products[] = [
                'id_product' => $id,
                'id_product_attribute' => 0, // Default value
                'quantity' => 1,             // Default quantity
            ];
        }
        //var_dump($products);exit;
        $cart_id=Eshop::create_vlc_products_checkout($products);
       // var_dump($cart_id);exit;
        if($cart_id){
        // Save Logs
        $param['log_activity']="Ecom Checkout shared with cart id=".$cart_id; 
        //$param['prescription_url'] = htmlspecialchars($param['prescription_url'] , ENT_QUOTES, 'UTF-8');
        date_default_timezone_set('Asia/Kolkata');
        DB::table('video_consultation_logs')->insert([
            'consultation_id' => $consultationdata->id,  // Replace with actual consultation_id
            'encryption_id' => $encryted_id,  // Replace with actual encryption_id
            'log_details' => json_encode($param,true),  // Replace with actual log details
            'log_type' => 'shared_ecom_checkout_link',  // Replace with actual log type
            'created_at' => date('Y-m-d H:i:s'), // Using Laravel helper for the current timestamp
        ]);
        // Send SMS
        $param=array(
            'phone'=> $consultationdata->phone ,
            'client_name'=>$consultationdata->firstname,
            'doctor_name'=>"DOCTOR",
            'ecom_checkout_url'=>env('BERKOWITS_PRODUCT_URL')."guest-cart.php?cart_id=$cart_id",

        );
        $result=SmsController::sendMultiFormatWhatsAppTelephant("vlc_ecom_order",$param);
        return redirect()->back();
    }
    }
    public function view_consultation_prescription($encryted_id=NULL){
        $consultationdata = Vlc::getConsultationDetails($encryted_id);
        $app_medicine =Vlc::getPrescriptionForPDF($consultationdata->id);
        $doctor_details=json_decode($consultationdata->doctor_details);
        $treatment_details=Vlc::getTreatment($consultationdata->id);
        $diagnosisi_details=Vlc::getDiagnosis($consultationdata->id);
        $setting = Setting::find(1);
        return view("new_prescription")->with("setting", $setting)->with("treatment_details", $treatment_details)->with("diagnosisi_details", $diagnosisi_details)->with("consultationData", $consultationdata)->with("prescription", $app_medicine)->with("doctorDetails", $doctor_details);

    }
    public function save_consultation_prescription(Request $request)
    {
        //  return $request;
        // Add Treatment
        switch($request->input('add_type')){
            case 'add_treatment':
                $treatment_name = $request->input('treatment_name');
                $treatment_details = $request->input('treatment_details');
                $data=new VideoConsultationTreatment();
                $data->consultation_id = $request->id;
                $data->treatment_name = $treatment_name;
                $data->treatment_details = $treatment_details;
                $data->save();
                return redirect()->back();
            break;
            case 'add_diagnosis':
                $disgnosis_details = $request->input('disgnosis_details');
                $data=new VideoConsultationDiagnosis();
                $data->consultation_id = $request->id;
                $data->diagnosis_point = $disgnosis_details;
                $data->save();
                return redirect()->back();
            break;

        }

        if ($request->hasFile('report_img')) {
            $file = $request->file('report_img');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/ap_img_up/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('report_img')->move($destinationPath, $picture);
            $img_url = $picture;

            $data = new ap_img_uplod();
            $data->consultation_id= $request->id;
            $data->name = $request->name;
            $data->image = $picture;
            $data->save();
        } else {

            $data = new VideoConsultationMedicine();

            $medicine_name = $request->input('medicine');
            $type = $request->input('type');
            $notes = $request->input('notes_text');
            //$dosage = $request->input('dosge');
            //$repeat_days = $request->input('repeat_days');
            //$t_time = $request->input('t_time');

            //$medi = compact('medicine_name', 'type', 'dosage', 'repeat_days');
            $medi = compact('medicine_name', 'type', 'notes');
            /*$t_time = array_unique($t_time);
            $t_time_array = [];
            foreach ($t_time as $key => $time) {
                $index = floor($key);
                $t_time_array[$index] = ['t_time' => $time];
            }
            $medi['time'] = $t_time_array;*/

            $data->consultation_id = $request->id;
            $data->medicines = json_encode(['medicine' => [$medi]]);
            $data->save();
        }

        return redirect()->back();
    }
    public function update_consultation($encryption_id=NULL,$status=NULL){
        $retrun_msg=Vlc::updateConsultation($encryption_id,$status);
        return redirect()->back();

    }

    public function save_prescription(Request $request)
    {
        //  return $request;

        if ($request->hasFile('report_img')) {
            $file = $request->file('report_img');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/ap_img_up/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('report_img')->move($destinationPath, $picture);
            $img_url = $picture;

            $data = new ap_img_uplod();
            $data->appointment_id = $request->id;
            $data->name = $request->name;
            $data->image = $picture;
            $data->save();
        } else {

            $data = new AppointmentMedicines();

            $medicine_name = $request->input('medicine');
            $type = $request->input('type');
            $dosage = $request->input('dosge');
            $repeat_days = $request->input('repeat_days');
            $t_time = $request->input('t_time');

            $medi = compact('medicine_name', 'type', 'dosage', 'repeat_days');

            $t_time = array_unique($t_time);
            $t_time_array = [];
            foreach ($t_time as $key => $time) {
                $index = floor($key);
                $t_time_array[$index] = ['t_time' => $time];
            }
            $medi['time'] = $t_time_array;

            $data->appointment_id = $request->id;
            $data->medicines = json_encode(['medicine' => [$medi]]);
            $data->save();
        }

        return redirect()->back();
    }

    public function edit_prescription(Request $request)
    {

        $data = AppointmentMedicines::find($request->id1);

        $medicine_name = $request->input('medicine');
        $type = $request->input('type');
        $dosage = $request->input('dosge');
        $repeat_days = $request->input('repeat_days');
        $t_time = $request->input('t_time');

        $medi = compact('medicine_name', 'type', 'dosage', 'repeat_days');

        $t_time = array_unique($t_time);
        $t_time_array = [];
        foreach ($t_time as $key => $time) {
            $index = floor($key);
            $t_time_array[$index] = ['t_time' => $time];
        }
        $medi['time'] = $t_time_array;

        $data->medicines = json_encode(['medicine' => [$medi]]);
        $data->save();


        return redirect()->back();
    }

    public function delete_prescription($id)
    {

        $data = AppointmentMedicines::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function delete_report($id)
    {

        $data = ap_img_uplod::find($id);
        if ($data) {
            $image_path = public_path('upload/ap_img_up') . '/' . $data->image;
            unlink($image_path);
            $data->delete();
        }

        return redirect()->back();
    }

    public function get_user_appointment1($id)
    {


        $data = AppointmentMedicines::where('id', $id)->first();
        if ($data) {
            $data->medicine = json_decode($data->medicines);
        }

        return $data;
    }

    public function showdoctors()
    {
        return view("admin.doctor.default");
    }

    public function show_post_my_hoilday(Request $request)
    {
        $store = new Doctor_Hoilday();
        $store->start_date = $request->get("start_date");
        $store->end_date = $request->get("end_date");
        $store->description = $request->get("description");
        $store->doctor_id = Session::get("user_id");
        $store->save();
        Session::flash('message', __("message.My Hoilday Add Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function deletedoctorhoilday($id)
    {
        Doctor_Hoilday::where("id", $id)->delete();
        Session::flash('message', __("message.Hoilday Delete Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_complete_doctor_appointment(Request $request)
    {
        $getapp = BookAppointment::with('doctorls', 'patientls')->find($request->get("id"));
        if ($getapp) {
            $getapp->status = 4;
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
            $msg = __('order.complete1') . ' ' . $getapp->doctorls->name . " " . __('order.is completed');
            $user = User::find(1);
            // $android=$this->send_notification_android($user->android_key,$msg,$getapp->user_id,"user_id");
            // $ios=$this->send_notification_IOS($user->ios_key,$msg,$getapp->user_id,"user_id");
            $android = $this->sendNotifications($msg, $getapp->user_id, "user_id", $getapp->id);
            try {
                $user = Patient::find($getapp->user_id);
                $user->msg = $msg;
                $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject(__('message.System Name'));
                });
            } catch (\Exception $e) {
            }
            Session::flash('message', $msg);
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', __('message.Appointment Not Found'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function doctorstable()
    {
        $doctors = Doctors::where('profile_type', '1')->get();

        return DataTables::of($doctors)
            ->editColumn('id', function ($doctors) {
                return $doctors->id;
            })
            ->editColumn('image', function ($doctors) {
                if ($doctors->image != "") {
                    return asset("public/upload/doctors") . '/' . $doctors->image;
                } else {
                    return asset("public/upload/doctors/doctor_default.png");
                }
            })
            ->editColumn('name', function ($doctors) {
                return $doctors->name;
            })
            ->editColumn('email', function ($doctors) {
                return $doctors->email;
            })
            ->editColumn('phone', function ($doctors) {
                return $doctors->phoneno;
            })
            ->editColumn('service', function ($doctors) {

                return isset($doctors->departmentls) ? $doctors->departmentls->name : "";
            })
            ->editColumn('action', function ($doctors) {
                $edit = url('admin/savedoctor', array('id' => $doctors->id));
                $timeing = url('admin/doctortiming', array('id' => $doctors->id));
                $delete = url('admin/deletedoctor', array('id' => $doctors->id));
                $doctorapprove = url('admin/approvedoctor', array('id' => $doctors->id, "approve" => '1'));
                $txt = "";
                $setting = Setting::find(1);
                if ($setting->doctor_approved == '1') {
                    if ($doctors->is_approve == '0') {
                        $txt = '<a  rel="tooltip" title="" href="' . $doctorapprove . '" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-ban f-s-25" style="margin-left: 10px;color:red"></i></a>';
                    } else {
                        $txt = '<i class="fa fa-ban f-s-25" style="margin-left: 10px;color:green"></i>';
                    }
                } else if ($setting->doctor_approved == '0' && $setting->is_demo == '1') {
                    if ($doctors->is_approve == '0') {
                        $txt = '<a  rel="tooltip" title="" href="' . $doctorapprove . '" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-ban f-s-25" style="margin-left: 10px;color:red"></i></a>';
                    } else {
                        $txt = '<i class="fa fa-ban f-s-25" style="margin-left: 10px;color:green"></i>';
                    }
                } else {
                }
                $return = '<a  rel="tooltip" title="" href="' . $edit . '" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-edit f-s-25" style="margin-right: 10px;"></i></a><a  rel="tooltip" title="" href="' . $timeing . '" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-clock f-s-25" style="margin-right: 10px;"></i></a><a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip" title="" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-trash f-s-25"></i></a>' . $txt;
                return $return;
            })
            ->make(true);
    }

    public function postapprovedoctor($id, $status)
    {
        if (Session::get("is_demo") == '0') {
            Session::flash('message', "This Action Disable In Demo");
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        } else {
            $store = Doctors::find($id);
            $store->is_approve = $status;
            $store->save();
            if ($status == '1') {
                $msg = __('message.Profile Enable Successfully');
            } else {
                $msg = __('message.Profile Disable Successfully');
            }
            Session::flash('message', $msg);
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        }
    }

    public function savedoctor($id)
    {
        $setting = Setting::find(1);
        $data = Doctors::find($id);
        $department = Services::all();
        return view("admin.doctor.savedoctor")->with("id", $id)->with("data", $data)->with("department", $department)->with("setting", $setting);
    }

    public function updatedoctor(Request $request)
    {
        if ($request->get("id") == 0) {
            $store = new Doctors();
            $data = Doctors::where("email", $request->get("email"))->first();
            if ($data) {
                Session::flash('message', __("message.Email Already Existe"));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $msg = __("message.Doctor Add Successfully");
            $img_url = "profile.png";
            $rel_url = "";
        } else {
            $store = Doctors::find($request->get("id"));
            //var_dump($store);
            $msg = __("message.Doctor Update Successfully");
            $img_url = $store->image;
            $rel_url = $store->image;
        }
        if ($request->hasFile('upload_image')) {
            $file = $request->file('upload_image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/doctors/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('upload_image')->move($destinationPath, $picture);
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
        $store->password = $request->get("password");
        $store->phoneno = $request->get("phoneno");
        $store->aboutus = $request->get("aboutus");
        $store->services = $request->get("services");
        $store->healthcare = $request->get("healthcare");
        $store->address = $request->get("address");
        $store->lat = $request->get("lat");
        $store->lon = $request->get("lon");
        $store->consultation_fees = $request->get("consultation_fees");
        $store->email = $request->get("email");
        $store->working_time = $request->get("working_time");
        $store->center_id = $request->get("zenoti_Center_Id");
        $store->zenoti_id = $request->get("zenoti_employee_Id");
        $store->speciality = $request->get("speciality_string");
        $store->record_type = $request->get("record_type");
        $store->image = $img_url;
        $store->is_approve = '1';
        $user_id = "";
        $login_field = "";
        if ($request->get("id") == 0 && env('ConnectyCube') == true) {
            $login_field = $request->get("phoneno") . rand() . "#1";
            $user_id = $this->signupconnectycude($request->get("name"), $request->get("password"), $request->get("email"), $request->get("phoneno"), $login_field);
        }
        $store->connectycube_user_id = $user_id;
        $store->login_id = $login_field;
        $store->connectycube_password = $request->get("password");

        $connrctcube = ($store->connectycube_user_id);
        if ($request->get("id") == 0) {
            if ($connrctcube == "0-email must be unique") {
                Session::flash('message', __("Email Or Mobile Number Already Register in ConnectCube"));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            } else {
                $store->save();
            }
        } else {
            $store->save();
        }

        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect("admin/doctors");
    }

    public function doctortiming($id)
    {
        $datats = Schedule::with('getslotls')->where("doctor_id", $id)->get();
        foreach ($datats as $k) {
            $k->options = $this->getdurationoption($k->start_time, $k->end_time, $k->duration);
        }

        return view("admin.doctor.schedule")->with("id", $id)->with("data", $datats);
    }



    public function findpossibletime(Request $request)
    {
        $type = "<option value=''>" . __("message.Select Duration") . "</option>";
        $start_time = $request->get("start_time");
        $end_time = $request->get("end_time");
        $duration = $request->get("duration");
        $datetime1 = strtotime($start_time);
        $datetime2 = strtotime($end_time);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        if ($minutes % 15 == 0) { // 15 mintue
            if ($duration == 15) {
                $type = $type . "<option value='15' selected='selected'>" . __("message.15 Minutes") . "</option>";
            } else {
                $type = $type . "<option value='15'>" . __("message.15 Minutes") . "</option>";
            }
        }
        if ($minutes % 30 == 0) { //30 mintue
            if ($duration == 30) {
                $type = $type . "<option value='30' selected='selected'>" . __("message.30 Minutes") . "</option>";
            } else {
                $type = $type . "<option value='30'>" . __("message.30 Minutes") . "</option>";
            }
        }
        if (abs($duration % 45) < 0.01) { // 45 mintue
            if ($duration == 45) {
                $type = $type . "<option value='45' selected='selected'>" . __("message.45 Minutes") . "</option>";
            } else {
                $type = $type . "<option value='45'>" . __("message.45 Minutes") . "</option>";
            }
        }
        if ($minutes % 60 == 0) { //60 mintue
            if ($duration == 60) {
                $type = $type . "<option value='60' selected='selected'>" . __("message.1 Hour") . "</option>";
            } else {
                $type = $type . "<option value='60'>" . __("message.1 Hour") . "</option>";
            }
        }
        return $type;
    }

    public function getdurationoption($start_time, $end_time, $duration)
    {
        $type = "<option value=''>Select Duration</option>";
        $datetime1 = strtotime($start_time);
        $datetime2 = strtotime($end_time);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);

        $type .= "<option value='15'" . ($duration == 15 ? " selected='selected'" : "") . ">" . __("message.15 Minutes") . "</option>";

        $type .= "<option value='30'" . ($duration == 30 ? " selected='selected'" : "") . ">" . __("message.30 Minutes") . "</option>";

        $type .= "<option value='45'" . ($duration == 45 ? " selected='selected'" : "") . ">" . __("message.45 Minutes") . "</option>";

        $type .= "<option value='60'" . ($duration == 60 ? " selected='selected'" : "") . ">" . __("message.1 Hour") . "</option>";

        return $type;
    }
    public function generateslotfront(Request $request)
    {
        $start_time = $request->get("start_time");
        $end_time = $request->get("end_time");
        $duration = $request->get("duration");
        $datetime1 = strtotime($start_time);
        $datetime2 = strtotime($end_time);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        $noofslot = $minutes / $duration;
        $slot = array();
        if ($noofslot > 0) {
            for ($i = 0; $i < $noofslot; $i++) {
                $a = $duration * $i;
                $slot[] = date("h :i A", strtotime("+" . $a . " minutes", strtotime($start_time)));
            }
        }
        $txt = "";
        for ($i = 0; $i < count($slot); $i++) {
            if (isset($slot[$i])) {
                $txt = $txt . '<li><label>' . $slot[$i] . '</label></li>';
            }
        }
        return $txt;
    }
    public function generateslot(Request $request)
    {
        $start_time = $request->get("start_time");
        $end_time = $request->get("end_time");
        $duration = $request->get("duration");
        $datetime1 = strtotime($start_time);
        $datetime2 = strtotime($end_time);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        $noofslot = $minutes / $duration;
        $slot = array();
        if ($noofslot > 0) {
            for ($i = 0; $i < $noofslot; $i++) {
                $a = $duration * $i;
                $slot[] = date("h :i A", strtotime("+" . $a . " minutes", strtotime($start_time)));
            }
        }
        $txt = "";
        for ($i = 0; $i < count($slot); $i++) {
            $txt = $txt . '<div class="col-md-12 md25">';
            if (isset($slot[$i])) {
                $txt = $txt . '<span class="slotshow">' . $slot[$i] . '</span>';
                $i++;
            }
            if (isset($slot[$i])) {
                $txt = $txt . '<span class="slotshow">' . $slot[$i] . '</span>';
                $i++;
            }
            if (isset($slot[$i])) {
                $txt = $txt . '<span class="slotshow">' . $slot[$i] . '</span>';
                $i++;
            }
            if (isset($slot[$i])) {
                $txt = $txt . '<span class="slotshow">' . $slot[$i] . '</span>';
                $i++;
            }
            if (isset($slot[$i])) {
                $txt = $txt . '<span class="slotshow">' . $slot[$i] . '</span>';
            }
            $txt = $txt . "</div>";
        }
        return $txt;
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

    public function savescheduledata(Request $request)
    {

        $arr = $request->get("arr");
        if (!empty($arr)) {
            $removedata = Schedule::where("doctor_id", $request->get("doc_id"))->get();
            if (count($removedata) > 0) {
                foreach ($removedata as $k) {
                    $findslot = SlotTiming::where("schedule_id", $k->id)->delete();
                    $k->delete();
                }
            }

            for ($i = 0; $i < count($arr); $i++) {
                if ($arr[$i]['start_time']) {
                    for ($j = 0; $j < count($arr[$i]['start_time']); $j++) {
                        if (isset($arr[$i]['start_time'][$j]) && $arr[$i]['start_time'][$j] != "" && isset($arr[$i]['end_time'][$j]) && $arr[$i]['end_time'][$j] != "" && isset($arr[$i]['duration'][$j]) && $arr[$i]['duration'][$j] != "") {
                            $getslot = $this->getslotvalue($arr[$i]['start_time'][$j], $arr[$i]['end_time'][$j], $arr[$i]['duration'][$j]);
                            $store = new Schedule();
                            $store->doctor_id = $request->get("doc_id");
                            $store->day_id = $i;
                            $store->start_time = $arr[$i]['start_time'][$j];
                            $store->end_time = $arr[$i]['end_time'][$j];
                            $store->duration = $arr[$i]['duration'][$j];
                            $store->save();
                            foreach ($getslot as $g) {
                                $aslot = new SlotTiming();
                                $aslot->schedule_id = $store->id;
                                $aslot->slot = $g;
                                $aslot->save();
                            }
                        }
                    }
                }
            }

            Session::flash('message', __("message.Schedule Save Successfully"));
            Session::flash('alert-class', 'alert-success');
            return redirect("admin/doctors");
        }
        return redirect("admin/doctors");
    }

    public function deletedoctor($id)
    {
        $doctor = Doctors::find($id);
        if ($doctor) {
            $deletsolt = Schedule::with('getslotls')->where("doctor_id", $id)->get();
            foreach ($deletsolt as $de) {
                foreach ($de->getslotls as $k) {
                    $k->delete();
                }
                $de->delete();
            }
            $bookappointment = BookAppointment::where("doctor_id", $id)->delete();
            $review = Review::where("doc_id", $id)->delete();
            $subscriber = Subscriber::where("doctor_id", $id)->delete();
            $image_path = public_path() . "/upload/doctors/" . $doctor->image;
            if (file_exists($image_path) && $doctor->image != "") {
                try {
                    unlink($image_path);
                } catch (Exception $e) {
                }
            }
            $doctor->delete();
        }
        Session::flash('message', __("message.Doctor Delete Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function showreviews()
    {
        return view("admin.doctor.review");
    }

    public function reviewtable()
    {
        $review = Review::all();

        return DataTables::of($review)
            ->editColumn('id', function ($review) {
                return $review->id;
            })
            ->editColumn('doctor_name', function ($review) {
                $data = Doctors::find($review->doc_id);
                return isset($data) ? $data->name : "";
            })
            ->editColumn('username', function ($review) {
                $data = Patient::find($review->user_id);
                return isset($data) ? $data->name : "";
            })
            ->editColumn('ratting', function ($review) {
                return isset($review->rating) ? $review->rating : "";
            })
            ->editColumn('comment', function ($review) {
                return isset($review->description) ? $review->description : "";
            })
            ->editColumn('action', function ($review) {
                $delete = url('admin/deletereview', array('id' => $review->id));
                $return = '<a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip" title="" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-trash f-s-25"></i></a>';
                return $return;
            })

            ->make(true);
    }

    public function deletereview($id)
    {
        $store = Review::find($id);
        $store->delete();
        Session::flash('message', __("message.Review Delete Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function newdoctordashboard(Request $request)
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $centerDetails=Doctors::where('id',Session::get("user_id") )->first();
            $center_id=$centerDetails->center_id;
            // VDO CONSULTATION
            $totalconsultation= count(VideoConsultation::where("center_id", $center_id)->where("payment_status", "success")->get());
            $totalCompletedConsultation= count(VideoConsultation::where("center_id", $center_id)->where("status", "completed")->get());
            $totalAbsentConsultation= count(VideoConsultation::where("center_id", $center_id)->where("status", "absent")->get());
            $totalPendingConsultation= count(VideoConsultation::where("center_id", $center_id)->where("payment_status", "success")->where("status", "pending")->get());
            //$vlc=VideoConsultation::
            // *************** END  VDO CONSULTATION *************** 
            $setting = Setting::find(1);
            $totalappointment = count(BookAppointment::where("doctor_id", Session::get("user_id"))->get());
            $totalreview = count(Review::where("doc_id", Session::get("user_id"))->get());
            $totalnewappointment = count(BookAppointment::where("doctor_id", Session::get("user_id"))->where("notify", '1')->get());
            $getnewapp = BookAppointment::where("doctor_id", Session::get("user_id"))->where("notify", '1')->get();
            foreach ($getnewapp as $k) {
                $k->notify = '0';
                $k->save();
            }
            $type = $request->get("type");
            if ($type == 2) { //past
                $bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", "<", date('Y-m-d'))->paginate(10);
            } elseif ($type == 3) { //upcoming
                $bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", ">", date('Y-m-d'))->paginate(10);
            } else { //today
                $bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", date('Y-m-d'))->paginate(10);
            }
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            $mysubscriptionlist = Subscriber::where('doctor_id', Session::get("user_id"))->where("status", '2')->orderby('id', 'DESC')->first();

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
                        $doctordata->is_subscription = "1";
                    } else {
                        $doctordata->is_subscription = "0";
                    }
                    //die
                    if (strtotime($current_date) < strtotime($date)) {

                        if ($mysubscriptionlist->status == 2) {
                            $doctordata->is_subscription = "1";
                        } else {
                            $doctordata->is_subscription = "0";
                        }
                    } else {
                        $doctordata->is_subscription = "0";
                    }
                } else {
                    $doctordata->is_subscription = "0";
                }
            } else {
                $doctordata->is_subscription = "0";
            }


            if ($doctordata->is_subscription == 1) {
                return view("user.doctor.dashboard")->with("setting", $setting)->with("doctordata", $doctordata)->with("totalappointment", $totalappointment)->with("totalreview", $totalreview)->with("totalnewappointment", $totalnewappointment)->with("type", $type)->with("bookdata", $bookdata)->with("totalConsultation", $totalconsultation)->with("totalComplatedConsultation", $totalCompletedConsultation)->with("totalPendingConsultation", $totalPendingConsultation)->with("totalAbsentConsultation", $totalAbsentConsultation);
            } else {
                return view("user.doctor.dashboard")->with("setting", $setting)->with("doctordata", $doctordata)->with("totalappointment", $totalappointment)->with("totalreview", $totalreview)->with("totalnewappointment", $totalnewappointment)->with("type", $type)->with("bookdata", $bookdata)->with("totalConsultation", $totalconsultation)->with("totalComplatedConsultation", $totalCompletedConsultation)->with("totalPendingConsultation", $totalPendingConsultation)->with("totalAbsentConsultation", $totalAbsentConsultation);
                //return view("user.doctor.dashboard")->with("setting", $setting)->with("doctordata", $doctordata)->with("totalappointment", $totalappointment)->with("totalreview", $totalreview)->with("totalnewappointment", $totalnewappointment)->with("type", $type)->with("bookdata", $bookdata);
                //return redirect('doctor_subscription_plan');
            }
        } else {
            return redirect("/");
        }
    }

    public function doctordashboard(Request $request)
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $totalappointment = count(BookAppointment::where("doctor_id", Session::get("user_id"))->get());
            $totalreview = count(Review::where("doc_id", Session::get("user_id"))->get());
            $totalnewappointment = count(BookAppointment::where("doctor_id", Session::get("user_id"))->where("notify", '1')->get());
            $getnewapp = BookAppointment::where("doctor_id", Session::get("user_id"))->where("notify", '1')->get();
            foreach ($getnewapp as $k) {
                $k->notify = '0';
                $k->save();
            }
            $type = $request->get("type");
            if ($type == 2) { //past
                $bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", "<", date('Y-m-d'))->paginate(10);
            } elseif ($type == 3) { //upcoming
                $bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", ">", date('Y-m-d'))->paginate(10);
            } else { //today
                $bookdata = BookAppointment::with("patientls")->where("doctor_id", Session::get("user_id"))->where("date", date('Y-m-d'))->paginate(10);
            }
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            $mysubscriptionlist = Subscriber::where('doctor_id', Session::get("user_id"))->where("status", '2')->orderby('id', 'DESC')->first();

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
                        $doctordata->is_subscription = "1";
                    } else {
                        $doctordata->is_subscription = "0";
                    }
                    //die
                    if (strtotime($current_date) < strtotime($date)) {

                        if ($mysubscriptionlist->status == 2) {
                            $doctordata->is_subscription = "1";
                        } else {
                            $doctordata->is_subscription = "0";
                        }
                    } else {
                        $doctordata->is_subscription = "0";
                    }
                } else {
                    $doctordata->is_subscription = "0";
                }
            } else {
                $doctordata->is_subscription = "0";
            }


            if ($doctordata->is_subscription == 1) {
                return view("user.doctor.dashboard")->with("setting", $setting)->with("doctordata", $doctordata)->with("totalappointment", $totalappointment)->with("totalreview", $totalreview)->with("totalnewappointment", $totalnewappointment)->with("type", $type)->with("bookdata", $bookdata);
            } else {
                return view("user.doctor.dashboard")->with("setting", $setting)->with("doctordata", $doctordata)->with("totalappointment", $totalappointment)->with("totalreview", $totalreview)->with("totalnewappointment", $totalnewappointment)->with("type", $type)->with("bookdata", $bookdata);
                //return redirect('doctor_subscription_plan');
            }
        } else {
            return redirect("/");
        }
    }

    public function postdoctorregister(Request $request)
    {
        //dd($request->all());
        $getuser = Doctors::where("email", $request->get("email"))->first();
        if ($getuser) {
            Session::flash('message', __("message.Email Already Existe"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        } else {
            $store = new Doctors();
            $store->name = $request->get("name");
            $store->email = $request->get("email");
            $store->password = $request->get("password");
            $store->phoneno = $request->get("phone");
            $store->profile_type = 1;

            if (env('ConnectyCube') == true) {
                $login_field = $request->get("phone") . rand() . "#2";
                $user_id = $this->signupconnectycude($request->get("name"), $request->get("password"), $request->get("email"), $request->get("phone"), $login_field);
            }

            $store->connectycube_user_id = $user_id;
            $store->login_id = $login_field;
            $store->connectycube_password = $request->get("password");


            $connrctcube = ($store->connectycube_user_id);
            if ($connrctcube == "0-email must be unique") {

                Session::flash('message', __("message.ConnectCube_error_msg"));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            } else {
                $store->save();
                if ($request->get("rem_me") == 1) {
                    setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                    setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                    setcookie('rem_me', 1, time() + (86400 * 30), "/");
                }

                Session::put("user_id", $store->id);
                Session::put("role_id", '2');
                Session::flash('message', __("message.Register Successfully"));
                Session::flash('alert-class', 'alert-success');
                return redirect("doctordashboard");
                //return redirect("doctor_subscription_plan");
            }
        }
    }

    public function postlogindoctor(Request $request)
    {
        $getUser = Doctors::where("email", $request->get("email"))->where("password", $request->get("password"))->where("profile_type", '1')->first();
        $setting = Setting::find(1);
        if ($getUser) {

            $mysubscriptionlist = Subscriber::where('doctor_id', $getUser->id)->where("status", '2')->orderby('id', 'DESC')->first();

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
                        $getUser->is_subscription = "1";
                    } else {
                        $getUser->is_subscription = "0";
                    }
                    //die
                    if (strtotime($current_date) < strtotime($date)) {

                        if ($mysubscriptionlist->status == 2) {
                            $getUser->is_subscription = "1";
                        } else {
                            $getUser->is_subscription = "0";
                        }
                    } else {
                        $getUser->is_subscription = "0";
                    }
                } else {

                    $getUser->is_subscription = "0";
                }
            } else {
                $getUser->is_subscription = "0";
            }


            if ($setting->doctor_approved == '1' && $getUser->is_approve == '1') {
                if ($request->get("rem_me") == 1) {
                    setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                    setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                    setcookie('rem_me', 1, time() + (86400 * 30), "/");
                    setcookie('center_id', $getUser->center_id  ,time() + (86400 * 30), "/");
                }
                Session::put("user_id", $getUser->id);
                Session::put("role_id", '2');
                Session::put("center_id",$getUser->center_id);

                if ($getUser->is_subscription == 1) {
                    return redirect("doctordashboard");
                } else {
                    return redirect("doctordashboard");
                    //return redirect("doctor_subscription_plan");
                }
            } elseif ($setting->doctor_approved == '0' && $getUser->is_approve == '1') {
                if ($request->get("rem_me") == 1) {
                    setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                    setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                    setcookie('rem_me', 1, time() + (86400 * 30), "/");
                    setcookie('center_id', $getUser->center_id  ,time() + (86400 * 30), "/");
                }
                Session::put("user_id", $getUser->id);
                Session::put("role_id", '2');
                Session::put("center_id",$getUser->center_id);


                if ($getUser->is_subscription == 1) {
                    return redirect("doctordashboard");
                } else {
                    return redirect("doctordashboard");
                    //return redirect("doctor_subscription_plan");
                }
            } elseif ($setting->doctor_approved == '1' && $setting->is_demo == '1') {
                if ($request->get("rem_me") == 1) {
                    setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                    setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                    setcookie('rem_me', 1, time() + (86400 * 30), "/");
                    setcookie('center_id', $getUser->center_id  ,time() + (86400 * 30), "/");
                }
                Session::put("user_id", $getUser->id);
                Session::put("role_id", '2');
                Session::put("center_id",$getUser->center_id);

                if ($getUser->is_subscription == 1) {
                    return redirect("doctordashboard");
                } else {
                    return redirect("doctordashboard");
                    //doctor_subscription_plan bypassed by shak on 6th Dec
                    //return redirect("doctor_subscription_plan");
                }
            } else {
                Session::flash('message', "Your profile is in under process please wait for some time");
                Session::flash('alert-class', 'alert-danger');
                return redirect("profilelogin");
            }
        } else {
            Session::flash('message', __("message.Login Credentials Are Wrong"));
            Session::flash('alert-class', 'alert-danger');
            return redirect("profilelogin");
        }
    }

    public function doctorchangepassword()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.doctor.changepassword")->with("setting", $setting)->with("doctordata", $doctordata);
        } else {
            return redirect("/");
        }
    }

    public function show_doctor_hoilday()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $doctorhoilday = Doctor_Hoilday::where("doctor_id", Session::get("user_id"))->get();
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.doctor.doctor_hoilday")->with("setting", $setting)->with("doctordata", $doctordata)->with("doctorhoilday", $doctorhoilday);
        } else {
            return redirect("/");
        }
    }
    public function show_center_employees()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $employees=Zenoti::listEmployeeFromCenter(Session::get("center_id"));
            $doctorhoilday = Doctor_Hoilday::where("doctor_id", Session::get("user_id"))->get();
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.doctor.employees")->with("employees", $employees['employees'])->with("setting", $setting)->with("doctordata", $doctordata)->with("doctorhoilday", $doctorhoilday);
        } else {
            return redirect("/");
        }
    }

    public function checkdoctorpwd(Request $request)
    {
        $data = Doctors::find(Session::get("user_id"));
        if ($data) {
            if ($data->password == $request->get("cpwd")) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return redirect("/");
        }
    }

    public function updatedoctorpassword(Request $request)
    {
        $data = Doctors::find(Session::get("user_id"));
        $data->password = $request->get("npwd");
        $data->save();
        Session::flash('message', __("message.Password Change Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function doctoreditprofile()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $department = Services::all();
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.doctor.editprofile")->with("setting", $setting)->with("doctordata", $doctordata)->with("department", $department);
        } else {
            return redirect("/");
        }
    }

    public function updatedoctorsideprofile(Request $request)
    {
        //dd($request->all());
        $doctoremail = Doctors::where("email", $request->get("email"))->where("id", "!=", Session::get("user_id"))->first();
        if ($doctoremail) {
            Session::flash('message', __("message.Email Already Existe"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        } else {
            $store = Doctors::find(Session::get("user_id"));
            $msg = __("message.Doctor Update Successfully");
            $img_url = $store->image;
            $rel_url = $store->image;
        }
        if ($request->hasFile('upload_image')) {
            $file = $request->file('upload_image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/doctors/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('upload_image')->move($destinationPath, $picture);
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
        $store->phoneno = $request->get("phoneno");
        $store->aboutus = $request->get("aboutus");
        $store->services = $request->get("services");
        $store->healthcare = $request->get("healthcare");
        $store->address = $request->get("address");
        $store->lat = $request->get("lat");
        $store->lon = $request->get("lon");
        //$store->facebook_url = $request->get("facebook_url");
        //$store->twitter_url = $request->get("twitter_url");
        $store->email = $request->get("email");
        $store->working_time = $request->get("working_time");
        $store->consultation_fees = $request->get("consultation_fees");
        $store->image = $img_url;
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function doctorreview()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $doctordata = Doctors::find(Session::get("user_id"));
            $reviewdata = Review::with('patientls')->where("doc_id", Session::get("user_id"))->get();
            return view("user.doctor.review")->with("setting", $setting)->with("doctordata", $doctordata)->with("reviewdata", $reviewdata);
        } else {
            return redirect("/");
        }
    }

    public function doctorappointment(Request $request)
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $doctordata = Doctors::find(Session::get("user_id"));
            if(!empty($request->get("filterbystatus"))){
                $appointmentdata = BookAppointment::with('patientls')->where("doctor_id", Session::get("user_id"))->where("status",$request->get("filterbystatus"))->orderby("id", "DESC")->paginate(15);
            }else{
                $appointmentdata = BookAppointment::with('patientls')->where("doctor_id", Session::get("user_id"))->orderby("id", "DESC")->paginate(15);
            }
            
            return view("user.doctor.appointmentlist")->with("setting", $setting)->with("doctordata", $doctordata)->with("appointmentdata", $appointmentdata);
        } else {
            return redirect("/");
        }
    }


    public function doctortimingfront(Request $request)
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $doctordata = Doctors::find(Session::get("user_id"));
            $datats = Schedule::with('getslotls')->where("doctor_id", Session::get("user_id"))->get();
            foreach ($datats as $k) {
                $k->options = $this->getdurationoption($k->start_time, $k->end_time, $k->duration);
            }
            return view("user.doctor.doctortiming")->with("setting", $setting)->with("doctordata", $doctordata)->with("data", $datats);
        } else {
            return redirect("/");
        }
    }

    public function paymenthistory()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $setting = Setting::find(1);
            $data = Complement_settlement::where("doctor_id", Session::get("user_id"))->get();
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.doctor.paymenthistory")->with("setting", $setting)->with("data", $data)->with("doctordata", $doctordata);
        } else {
            return redirect("/");
        }
    }

    public function updatedoctortiming(Request $request)
    {
        // dd($request->all());

        $arr = $request->get("arr");
        if (!empty($arr)) {
            $removedata = Schedule::where("doctor_id", $request->get("doctor_id"))->get();
            if (count($removedata) > 0) {
                foreach ($removedata as $k) {
                    $findslot = SlotTiming::where("schedule_id", $k->id)->delete();
                    $k->delete();
                }
            }

            for ($i = 0; $i < count($arr); $i++) {
                if ($arr[$i]['start_time']) {
                    $start_date = array_values($arr[$i]['start_time']);
                    $end_date = array_values($arr[$i]['end_time']);
                    $duration = array_values($arr[$i]['duration']);

                    for ($j = 0; $j < count($start_date); $j++) {
                        if (isset($start_date[$j]) && $start_date[$j] != "" && isset($end_date[$j]) && $end_date[$j] != "" && isset($duration[$j]) && $duration[$j] != "") {
                            $getslot = $this->getslotvalue($start_date[$j], $end_date[$j], $duration[$j]);

                            $store = new Schedule();
                            $store->doctor_id = $request->get("doctor_id");
                            $store->day_id = $i;
                            $store->start_time = $start_date[$j];
                            $store->end_time = $end_date[$j];
                            $store->duration = $duration[$j];
                            $store->save();
                            foreach ($getslot as $g) {
                                $aslot = new SlotTiming();
                                $aslot->schedule_id = $store->id;
                                $aslot->slot = $g;
                                $aslot->save();
                            }
                        }
                    }
                }
            }


            Session::flash('message', __("message.Schedule Save Successfully"));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        }
        return redirect()->back();
    }


    public function changeappointmentdoctor($status, $id)
    {
        $getapp = BookAppointment::with('doctorls', 'patientls')->find($id);
        if ($getapp) {
            $getapp->status = $status;
            $getapp->save();
            if ($status == '3') { // in process
                $msg = __('order.inprocess1') . ' ' . $getapp->doctorls->name . ' ' . __('order.inprocess2') . ' ' . $getapp->date . ' ' . $getapp->slot_name;
            } else if ($status == '5') { //reject
                $msg = __('order.rejectorder') . ' ' . $getapp->doctorls->name;
                Settlement::where("book_id", $id)->delete();
            } else if ($status == '4') { //complete

                $msg = __('order.complete1') . ' ' . $getapp->doctorls->name . " " . ' ' . __('order.is completed');
            } else if ($status == '0') { //absent
                $msg = "absent";
            } else {
                $msg = "";
            }
            $user = User::find(1);
            // $android=$this->send_notification_android($user->android_key,$msg,$getapp->user_id,"user_id");
            // $ios=$this->send_notification_IOS($user->ios_key,$msg,$getapp->user_id,"user_id");
            $android = $this->sendNotifications($msg, $getapp->user_id, "user_id", $getapp->id);
            try {
                $user = Patient::find($getapp->user_id);
                $user->msg = $msg;
                // $user->email="redixbit.jalpa@gmail.com";
                $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject(__('message.System Name'));
                });
            } catch (\Exception $e) {
            }
            Session::flash('message', $msg);
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', __('message.Appointment Not Found'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
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
                        // 'order_id' => $order_id,
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


    public function doctor_subscription_plan(Request $request)
    {
        $setting = Setting::find(1);
        $subscription = Subscription::get();

        $paymentdetail = array();
        $data1 = PaymentGatewayDetail::all();
        foreach ($data1 as $k) {
            $paymentdetail[$k->gateway_name . "_" . $k->key] = $k->value;
        }

        $gateway = new \Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId'  => env('BRAINTREE_MERCHANT_ID'),
            'publicKey'   => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey'  => env('BRAINTREE_PRIVATE_KEY')
        ]);
        $token = $gateway->ClientToken()->generate();
        if (Session::get("user_id") != "" && Session::get("role_id") == '2') {
            $doctor_id = Doctors::find(Session::get("user_id"));
            return view('user.doctor.subscription_plan', compact('subscription', 'setting', 'paymentdetail', 'doctor_id', 'token'));
        } else {
            return redirect('/');
        }
    }

    public function doctor_subscription_payment(Request $request)
    {

        $setting = Setting::find(1);
        $subscription = Subscription::find($request->plan_id);

        $paymentdetail = array();
        $data1 = PaymentGatewayDetail::all();
        foreach ($data1 as $k) {
            $paymentdetail[$k->gateway_name . "_" . $k->key] = $k->value;
        }
        $doctor_id = Session::get("user_id");
        $payment_type = $request->payment_type;
        return view('user.doctor.subscription_payment', compact('subscription', 'setting', 'paymentdetail', 'doctor_id', 'payment_type'));
    }

    public function doctor_add_plan(Request $request)
    {
        // return $request;
        if ($request->get("payment_type") == "stripe") {

            $data1 = PaymentGatewayDetail::where("gateway_name", "stripe")->get();

            $arr = array();
            foreach ($data1 as $k) {
                $arr[$k->gateway_name . "_" . $k->key] = $k->value;
            }

            \Stripe\Stripe::setApiKey($arr["stripe_secert_key"]);
            $unique_id = uniqid();
            $charge = \Stripe\Charge::create(array(
                'description' => "Amount: " . $request->get("amount") . ' - ' . $unique_id,
                'source' => $request->get("stripeToken"),
                'amount' => (int)($request->get("amount") * 100),
                'currency' => $arr["stripe_currency"]
            ));

            DB::beginTransaction();
            try {
                $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
                $data = new Subscriber();
                $data->doctor_id = $request->get("doctor_id");
                $data->subscription_id = $request->get("plan_id");
                $data->payment_type = 5;
                $data->amount = $request->get("amount");
                $data->date = $this->getsitedateall();
                $data->transaction_id = $charge->id;
                $data->status = "2";
                $data->is_complet = 1;
                $data->save();
                DB::commit();
                Session::flash('message', __('message.Your subscription plan add successfully'));
                Session::flash('alert-class', 'alert-success');
                return redirect('doctordashboard');
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('message', $e);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else if ($request->get("payment_type") == "Flutterwave") {

            $reference = Flutterwave::generateReference();

            $data1 = PaymentGatewayDetail::where("gateway_name", "rave")->get();

            $arr = array();
            foreach ($data1 as $k) {
                $arr[$k->gateway_name . "_" . $k->key] = $k->value;
            }

            $user = Session::get("user_id");
            $userinfo = Doctors::find($user);

            $data = [
                'payment_options' => 'card,banktransfer',
                'amount' => $request->get("amount"),
                'email' => $userinfo->email,
                'tx_ref' => $reference,
                'currency' => $arr['rave_currency'],
                'redirect_url' => route('callback'),
                'customer' => [
                    'email' => $userinfo->email,
                    "phonenumber" => $userinfo->phoneno,
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
            $data = new Subscriber();
            $data->doctor_id = $request->get("doctor_id");
            $data->subscription_id = $request->get("plan_id");
            $data->payment_type = 6;
            $data->amount = $request->get("amount");
            $data->date = $this->getsitedateall();
            $data->transaction_id = $reference;
            $data->status = "2";
            $data->save();


            if ($payment['status'] !== 'success') {
                return redirect()->route('payment-failed');
                Session::flash('message', $errorString);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            } else {
                return redirect($payment['data']['link']);
            }
        } else if ($request->get("payment_type") == "Paystack") {

            $data1 = PaymentGatewayDetail::where("gateway_name", "paystack")->get();

            $arr = array();
            foreach ($data1 as $k) {
                $arr[$k->gateway_name . "_" . $k->key] = $k->value;
            }


            $curl = curl_init();
            $email = 'admin@gmail.com';
            $amount = $request->get("amount");
            $callback_url = route('paystack_callback_doctor');
            // echo "<pre>";print_r($amount);exit;

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $amount,
                    'email' => $email,
                    'callback_url' => $callback_url
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . $arr['paystack_secert_key'] . "",
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            if ($err) {
                die('Curl returned error: ' . $err);
            }
            $tranx = json_decode($response, true);
            //   echo "<pre>";print_r($tranx);exit;

            if ($tranx['data']['reference']) {
                DB::beginTransaction();
                try {
                    $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));

                    $data = new Subscriber();
                    $data->doctor_id = $request->get("doctor_id");
                    $data->subscription_id = $request->get("plan_id");
                    $data->payment_type = 4;
                    $data->amount = $request->get("amount");
                    $data->date = $this->getsitedateall();
                    $data->transaction_id = $tranx['data']['reference'];
                    $data->status = "2";
                    $data->save();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
            } else {
                die('something getting worng');
            }

            if (!$tranx['status']) {
                print_r('API returned error: ' . $tranx['message']);
            }
            return Redirect($tranx['data']['authorization_url']);
        } else if ($request->get("payment_type") == "braintree") {
            // return $request;
            $gateway = new \Braintree\Gateway([
                'environment' => env('BRAINTREE_ENV'),
                'merchantId'  => env('BRAINTREE_MERCHANT_ID'),
                'publicKey'   => env('BRAINTREE_PUBLIC_KEY'),
                'privateKey'  => env('BRAINTREE_PRIVATE_KEY')
            ]);
            $nonce = $request->get("payment_method_nonce");
            $result = $gateway->transaction()->sale([
                'amount' => $request->get("amount"),
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);
            // return $result;
            if ($result->success) {
                $transaction = $result->transaction;
                DB::beginTransaction();
                try {
                    $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
                    $data = new Subscriber();
                    $data->doctor_id = $request->get("doctor_id");
                    $data->subscription_id = $request->get("plan_id");
                    $data->payment_type = 1;
                    $data->amount = $request->get("amount");
                    $data->date = $this->getsitedateall();
                    $data->transaction_id = $transaction->id;
                    $data->is_complet = 1;
                    $data->status = "2";
                    $data->save();
                    DB::commit();
                    Session::flash('message', __('message.Your subscription plan add successfully'));
                    Session::flash('alert-class', 'alert-success');
                    return redirect('doctordashboard');
                } catch (\Exception $e) {
                    DB::rollback();
                    Session::flash('message', $e);
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            } else {
                $errorString = "";
                foreach ($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }
                Session::flash('message', $errorString);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else if ($request->get("payment_type") == "Razorpay") {
            // return $request;
            $data1 = PaymentGatewayDetail::where("gateway_name", "razorpay")->get();
            $arr = array();
            if (count($data1) > 0) {
                foreach ($data1 as $k) {
                    $arr[$k->gateway_name . "_" . $k->key] = $k->value;
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

                $data = new Subscriber();
                $data->doctor_id = $request->get("doctor_id");
                $data->subscription_id = $request->get("plan_id");
                $data->payment_type = 3;
                $data->amount = $request->get("amount");
                $data->date = $this->getsitedateall();
                $data->transaction_id = $request->get('razorpay_payment_id');
                $data->is_complet = 1;
                $data->status = "2";
                $data->save();
                DB::commit();
                Session::flash('message', __('message.Your subscription plan add successfully'));
                Session::flash('alert-class', 'alert-success');
                return redirect('doctordashboard');
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('message', $e);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }
    }

    public function callback(Request $request)
    {
        $transactionID = Flutterwave::getTransactionIDFromCallback();

        $data = Flutterwave::verifyTransaction($transactionID);

        $data1 = Subscriber::where("transaction_id", $data['data']['tx_ref'])->first();
        $data1->is_complet = 1;
        $data1->save();

        Session::flash('message', __('message.Your subscription plan add successfully'));
        Session::flash('alert-class', 'alert-success');

        return redirect('doctordashboard');
    }

    public function paystack_callback_doctor(Request $request)
    {
        $data1 = PaymentGatewayDetail::where("gateway_name", "paystack")->get();

        $arr = array();
        foreach ($data1 as $k) {
            $arr[$k->gateway_name . "_" . $k->key] = $k->value;
        }
        $curl = curl_init();
        $reference = $request->get("reference");

        if (!$reference) {
            die('No reference supplied');
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . $arr['paystack_secert_key'] . "",
                "cache-control: no-cache"
            ],
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        $tranx = json_decode($response);
        if (!$tranx->status) {
            return redirect()->route('payment-failed');
        }
        if ('success' == $tranx->data->status) {
            $data1 = Subscriber::where("transaction_id", $reference)->first();
            $data1->is_complet = 1;
            $data1->save();

            Session::flash('message', __('message.Your subscription plan add successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect('doctordashboard');
        } else { //fail
            Session::flash('message', __('message.Something Wrong'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function doctorsubscription(Request $request)
    {
        $setting = Setting::find(1);
        $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
        $mysubscriptionlist = Subscriber::where('doctor_id', Session::get("user_id"))->where("is_complet", '1')->orderby('id', 'DESC')->get();
        return view('user.doctor.mysubscription', compact('setting', 'doctordata', 'mysubscriptionlist'));
    }
}

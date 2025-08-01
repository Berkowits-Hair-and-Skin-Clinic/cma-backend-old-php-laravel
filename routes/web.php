<?php
error_reporting(-1);
ini_set('display_errors', 'On');
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FullCalendarEventMasterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MakePaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cache-clear', function () {
    Artisan::call("optimize:clear");
    echo "done";
});

Route::group(['middleware' => ['DomainCheck']], function () {

Route::group(['middleware' => ['Localization']], function () {
Route::get("make_payment",[MakePaymentController::class,"show_make_payment"])->name('make-payment');
Route::post("save_braintree",[MakePaymentController::class,"save_braintree"])->name("save-braintree");
Route::any("braintree_payment",[MakePaymentController::class,"show_braintree_payment"])->name("braintree-payment");
Route::any("pay_razorpay",[MakePaymentController::class,"show_pay_razorpay"])->name("razorpay-payment");
Route::any("razor_payment",[MakePaymentController::class,"razor_payment"])->name("razor-payment");
Route::any("paystack-payment",[MakePaymentController::class,"show_paystack_payment"])->name("paystack-payment");
Route::any("paystackcallback",[MakePaymentController::class,"paystackcallback"])->name('paystackcallback');
Route::any("rave-payment",[MakePaymentController::class,"show_rave_payment"])->name("rave-payment");
Route::any('/rave/callback',[MakePaymentController::class,"rave_callback"])->name('rave-callback');

Route::any("stripe-payment",[MakePaymentController::class,"show_stripe_payment"])->name("stripe-payment");
Route::any("stripe-callback",[MakePaymentController::class,"stripe_callback"])->name('stripe-callback');

Route::any("paytm-payment",[MakePaymentController::class,"store_paytm_data"])->name("paytm-payment");
Route::any("paytmstatus",[MakePaymentController::class,"paymentpaytmCallback"])->name('paytmstatus');
Route::get("payment_success",[MakePaymentController::class,"payment_success"])->name("payment-success");
Route::get("payment_failed",[MakePaymentController::class,"payment_failed"])->name("payment-failed");

Route::any('/rave/webcallback',[UserController::class,"web_rave_callback"])->name('web-callback');
Route::any('/rave/webcallbackorder',[UserController::class,"web_rave_callbackorder"])->name('web-callbackorder');
Route::any("paystack_callback",[MakePaymentController::class,"paystack_callback"])->name('paystack_callback');


Route::group(['prefix' => '/'], function () {
    Route::post("postforgotpassword",[FrontController::class,"postforgotpassword"]);
	Route::get("/showhome",[FrontController::class,"showhome"]);
	Route::get('aboutus', function () {
		return redirect('showhome');
	});
	//Route::get("/",[FrontController::class,"patientlogin"]);
	Route::get("/",[FrontController::class,"showhome"]);
	//Route::get("/",[FrontController::class,"aboutus"]);
	Route::get("addnewsletter/{email}",[FrontController::class,"addnewsletter"]);
	Route::get("privacy_policy",[FrontController::class,"privacy_policy"]);
	Route::get("site_error",[FrontController::class,"site_error"]);
	Route::get("viewspecialist",[FrontController::class,"viewspecialist"]);
	Route::get('viewdoctor/{id}', function () {
		return redirect('bookingv2/{id}');
	});
	Route::get("viewdoctor/{id}",[FrontController::class,"viewdoctor"]);
	Route::any("bookingv2/{id}",[FrontController::class,"bookingv2"]);
	//Route::get("booking/{id}",[FrontController::class,"booking"]);
	Route::get("booking/{id}",[FrontController::class,"bookingv2"]);
	Route::get("booking_firsttimeuser/{id}",[FrontController::class,"booking_firsttimeuser"]);
	Route::get('searchdoctor', function () {
		return redirect('searchcenterall');
	});
	Route::get("searchdoctor",[FrontController::class,"searchdoctor"]);

	Route::get("searchcenterall",[FrontController::class,"searchdoctor"]);
	Route::get("searchcenter_firsttimeuser",[FrontController::class,"searchdoctor_firsttimeuser"]);
	Route::get("bookappointment",[FrontController::class,"bookappointmentzenoti"]);
	//Route::get("aboutus",[FrontController::class,"showhome"]);
	Route::get("contactus",[FrontController::class,"contactus"]);
	// Patient / Client Route 
	Route::get('patientlogin', function () {
		return redirect('auth/loginbyotp');
	});
	//Route::get("patientlogin",[FrontController::class,"patientlogin"]);

	Route::get("patientregister",[FrontController::class,"patientregister"]);
	Route::get("forgotpassword",[FrontController::class,"forgotpassword"]);
	Route::get("profilelogin",[FrontController::class,"doctorlogin"]);
	Route::get('clientlogin', function () {
		return redirect('auth/loginbyotp');
	});
	//Route::get("clientlogin",[FrontController::class,"patientlogin"]);
	Route::get("clientregister",[FrontController::class,"patientregister"]);
	Route::get("register_firsttimeuser",[FrontController::class,"register_firsttimeuser"]);
	Route::get("auth/loginbyotp",[FrontController::class,"loginbyotp"]);
	Route::get("auth/verifyotp",[FrontController::class,"verifyotp"]);
	Route::post("loginbyotpcontroller",[UserController::class,"loginbyotp"]);
	// Patient / Client Route  END

	// Route::get("doctorlogin",[FrontController::class,"doctorlogin"]);
	Route::get("doctorregister",[FrontController::class,"doctorregister"]);
	Route::get("getslotlist",[FrontController::class,"getslotlist"]);
	Route::get("getschedule",[FrontController::class,"getschedule"]);
	Route::post("savecontact",[FrontController::class,"savecontact"]);

	Route::post("userpostregister",[UserController::class,"userpostregister"]);
	Route::post("registerfirsttimeuser",[UserController::class,"register_firsttimeuser"]);
	Route::post("bookappointmentstep2",[UserController::class,"bookappointmentstep2"]);
	Route::post("postloginuser",[UserController::class,"postloginuser"]);
	Route::post("postloginuserotp",[UserController::class,"postloginuserotp"]);
	Route::get("userdashboard",[UserController::class,"userdashboard"]);
	Route::get("userappointmentdashboard",[UserController::class,"userappointmentdashboard"]);
	Route::get("appointmentdetails/{id}",[UserController::class,"userappointmentdetails"]);
	Route::get("logout",[UserController::class,"logout"]);
	Route::post("makeappointment",[UserController::class,"makeappointment"]);
	Route::get("userfavorite/{doc_id}",[UserController::class,"userfavorite"]);
	Route::get("favouriteuser",[UserController::class,"favouriteuser"]);
	Route::get("viewschedule",[UserController::class,"viewschedule"]);

	Route::get("viewappointment/{id}",[UserController::class,"viewappointment"]);
	Route::get('/fullcalendareventmaster',[FullCalendarEventMasterController::class,'index']);
	Route::get("changepassword",[UserController::class,"changepassword"]);
	Route::get("checkuserpwd",[UserController::class,"checkuserpwd"]);
	Route::post("updateuserpassword",[UserController::class,"updateuserpassword"]);
	Route::get("userreview",[UserController::class,"userreview"]);
	Route::get("usereditprofile",[UserController::class,"usereditprofile"]);
	Route::post("updateuserprofile",[UserController::class,"updateuserprofile"]);

	Route::get("get-user-appointment/{id}",[UserController::class,"get_user_appointment"]);

    Route::post("postreview",[FrontController::class,"show_postreview"]);
	//Route::get("doctordashboard",[DoctorController::class,"doctordashboard"]);//old
	Route::get("doctordashboard",[DoctorController::class,"newdoctordashboard"]);
	Route::post("postdoctorregister",[DoctorController::class,"postdoctorregister"]);
	Route::post("postlogindoctor",[DoctorController::class,"postlogindoctor"]);
	Route::get("doctorchangepassword",[DoctorController::class,"doctorchangepassword"]);
	Route::get("checkdoctorpwd",[DoctorController::class,"checkdoctorpwd"]);
	Route::post("updatedoctorpassword",[DoctorController::class,"updatedoctorpassword"]);
	Route::get("doctoreditprofile",[DoctorController::class,"doctoreditprofile"]);
	Route::post("updatedoctor",[DoctorController::class,"updatedoctorsideprofile"]);
	Route::get("doctorreview",[DoctorController::class,"doctorreview"]);
	Route::get("doctorappointment",[DoctorController::class,"doctorappointment"])->name('doctorappointment');
	Route::get("doctortiming",[DoctorController::class,"doctortimingfront"]);
    Route::get("findpossibletime",[DoctorController::class,"findpossibletime"]);
	Route::get("generateslot",[DoctorController::class,"generateslotfront"]);
	Route::post("updatedoctortiming",[DoctorController::class,"updatedoctortiming"]);
	Route::get("changeappointment/{status}/{id}",[DoctorController::class,"changeappointmentdoctor"]);
	Route::get("resetpassword/{code}",[UserController::class,"resetpassword"]);
    Route::any("resetnewpwd",[UserController::class,"resetnewpwd"]);
    Route::post("braintree_payment",[FrontController::class,"braintree_payment"]);
    Route::post("deposit_payment",[FrontController::class,"deposit_payment"]);

    Route::get("paymenthistory",[DoctorController::class,"paymenthistory"]);
    Route::get("deletedoctorhoilday/{id}",[DoctorController::class,"deletedoctorhoilday"]);
    Route::get("rejectuserappointment/{id}",[FrontController::class,"show_rejectuserappointment"])->name("rejectuserappointment");
	Route::post("complete-doctor-appointment",[DoctorController::class,"show_complete_doctor_appointment"])->name("complete-doctor-appointment");
	Route::get("doctor_hoilday",[DoctorController::class,"show_doctor_hoilday"]);
	Route::get("center_employees",[DoctorController::class,"show_center_employees"]);
	Route::post("post_my_hoilday",[DoctorController::class,"show_post_my_hoilday"])->name("post-my-hoilday");

	Route::get("videoconsultationlist",[DoctorController::class,"video_consultation_list"]);
	Route::get("videoconsultation_detail/{id}",[DoctorController::class,"videoconsultation_detail"]);
	Route::post("update_consultation/{encryption_id}/{status}",[DoctorController::class,"update_consultation"]);
	Route::get("appointment_detail/{id}",[DoctorController::class,"appointment_detail"]);
	Route::post("save_prescription",[DoctorController::class,"save_prescription"]);
	Route::post("save_consultation_prescription",[DoctorController::class,"save_consultation_prescription"]);
	Route::any("share_consultation_checkout_link/{id}",[DoctorController::class,"share_consultation_checkout_link"]);
	
	Route::get("view_consultation_prescription/{encryted_id}",[DoctorController::class,"view_consultation_prescription"]);
	//share_video_consulattion_prescription
	Route::post("share_video_consulattion_prescription",[DoctorController::class,"share_video_consulattion_prescription"]);
	Route::get('/getmedicines', [DoctorController::class, 'getmedicines']);
	Route::get('/getproductsecom', [DoctorController::class, 'getproductsecom']);
	Route::get('backtoappointment', [DoctorController::class, 'backtoappointment']);
	Route::get('delete_prescription/{id}', [DoctorController::class, 'delete_prescription']);
	Route::get('delete_report/{id}', [DoctorController::class, 'delete_report']);
	Route::post('edit_prescription', [DoctorController::class, 'edit_prescription']);
	Route::get("get-user-appointment1/{id}",[DoctorController::class,"get_user_appointment1"]);

    Route::get("doctor_subscription_plan",[DoctorController::class,"doctor_subscription_plan"]);
	Route::get("doctor_subscription_payment",[DoctorController::class,"doctor_subscription_payment"]);
	Route::post("doctor_add_plan",[DoctorController::class,"doctor_add_plan"]);
	Route::get("callback",[DoctorController::class,"callback"])->name('callback');
	Route::get("paystack_callback_doctor",[DoctorController::class,"paystack_callback_doctor"])->name('paystack_callback_doctor');
	Route::get("doctorsubscription",[DoctorController::class,"doctorsubscription"]);

	Route::get("privacy-user",[FrontController::class,"privacy_admin"]);

	Route::get("Privacy_Policy",[FrontController::class,"privacy_front_app"]);
    Route::get("accountdeletion",[FrontController::class,"accountdeletion"]);
    Route::post("savereview",[FrontController::class,"savereview"]);


    Route::get("searchpharmacy",[PharmacyController::class,"searchpharmacy"]);
	Route::get("searchcentre",[PharmacyController::class,"searchpharmacy"]);
    Route::get("viewpharmacy/{id}",[PharmacyController::class,"viewpharmacy"]);

    Route::get('addToCart/{id}', [PharmacyController::class, 'addToCart']);
    Route::get('removeCartItem/{id}', [PharmacyController::class, 'removeCartItem']);
    Route::post('addpharmacyorder', [PharmacyController::class, 'addpharmacyorder']);
    Route::post('upload_pre_order', [PharmacyController::class, 'upload_pre_order']);

    Route::get('usermedicineorder', [PharmacyController::class, 'usermedicineorder']);
	Route::get('userpurchaseproduct', [PharmacyController::class, 'userpurchaseproducts']);
    Route::get('get_orderdata/{id}', [PharmacyController::class, 'get_orderdata']);

    Route::post('pharmacylogin', [PharmacyController::class, 'pharmacylogin']);
    Route::post("postpharmacyregister",[PharmacyController::class,"postpharmacyregister"]);
    Route::get('pharmacydashboard', [PharmacyController::class, 'pharmacydashboard']);
    Route::get("pharmacyeditprofile",[PharmacyController::class,"pharmacyeditprofile"]);
	Route::post("updatepharmacy",[PharmacyController::class,"updatepharmacysideprofile"]);
	Route::get("pharmacyreview",[PharmacyController::class,"pharmacyreview"]);
    Route::get("pharmacychangepassword",[PharmacyController::class,"pharmacychangepassword"]);
    Route::get("pharmacyorderchangestatus/{id}/{status}",[PharmacyController::class,"pharmacyorderchangestatus"]);
    Route::post("addprice",[PharmacyController::class,"addprice"]);

    Route::get("pharmacymedicine",[PharmacyController::class,"pharmacymedicine"]);
    Route::get("medicinedeletefront/{pharmacy_id}",[PharmacyController::class,"medicinedeletefront"])->name('medicinedeletefront');
    Route::post("updatemedicinefront",[PharmacyController::class,"updatemedicinefront"]);
    Route::get("getdatapharmmacy/{id}",[PharmacyController::class,"getdatapharmmacy"]);
    Route::get("deleteimgpharmmacy/{id}",[PharmacyController::class,"deleteimgpharmmacy"]);

});


Route::prefix('admin/languages')->group(function () {
    Route::get('/{lang}', [LanguageController::class, 'index'])->name('languages.index');
    Route::get('/{lang}/edit/{key}', [LanguageController::class, 'edit'])->name('languages.edit');
    Route::put('/{lang}/update/{key}', [LanguageController::class, 'update'])->name('languages.update');
    // Route::get('/{lang}/create', [LanguageController::class, 'create'])->name('languages.create');
    // Route::post('/{lang}/store', [LanguageController::class, 'store'])->name('languages.store');
    // Route::delete('/{lang}/delete/{key}', [LanguageController::class, 'destroy'])->name('languages.destroy');
});

Route::get('local/{lang}', [LanguageController::class, 'setlocal']);



Route::group(['prefix' => 'admin'], function () {

    Route::get("/",[AuthenticationController::class,"showlogin"]);
    Route::post("postlogin",[AuthenticationController::class,"postlogin"]);

    Route::group(['middleware' => ['AdminCheck']], function () {
			/** Added by shak admin dashboard*/
			Route::post("create_cma_user",[AuthenticationController::class,"create_cma_user"]);

            Route::get('medicines',[ MedicinesController::class,'showmedicines'])->name('medicines');
            Route::get('medicinesadd',[ MedicinesController::class,'medicinesadd1']);
            Route::any('addmedicinessave',[ MedicinesController::class,'addmedicinessave'])->name('add');
            Route::any('deletemedicines/{id}',[ MedicinesController::class,'deletemedicines'])->name('deletemedicines');
            Route::any('editmedicines/{id}',[ MedicinesController::class,'editmedicines'])->name('editmedicines');
            Route::any('editmedicinessave',[ MedicinesController::class,'editmedicinessave'])->name('editmedicinessave');
            Route::get("medicine",[MedicinesController::class,"medicine"]);

    	    Route::get("dashboard",[AuthenticationController::class,'showdashboard'])->name('dashboard');
		    Route::get("logout",[AuthenticationController::class,'logout']);
		    Route::get("reset_password/{code}",[AuthenticationController::class,"reset_password"]);
		    Route::get("services",[ProductController::class,'showservice']);
		    Route::any("reset_new_pwd",[AuthenticationController::class,"reset_new_pwd"]);

		    Route::get("saveservices/{id}",[ProductController::class,"saveservices"]);
		    Route::post("updateservice",[ProductController::class,"updateservice"]);
		    Route::get("servicestable",[ProductController::class,"servicestable"]);
		    Route::get("deleteservices/{id}",[ProductController::class,"deleteservices"]);

		    Route::get("doctors",[DoctorController::class,"showdoctors"]);
		    Route::get("doctorstable",[DoctorController::class,"doctorstable"]);
		    Route::get("savedoctor/{id}",[DoctorController::class,"savedoctor"]);
		    Route::post("updatedoctor",[DoctorController::class,"updatedoctor"]);
		    Route::get("doctortiming/{id}",[DoctorController::class,"doctortiming"]);
		    Route::get("findpossibletime",[DoctorController::class,"findpossibletime"]);
		    Route::get("generateslot",[DoctorController::class,"generateslot"]);
		    Route::post("savescheduledata",[DoctorController::class,"savescheduledata"]);
		    Route::get("deletedoctor/{id}",[DoctorController::class,"deletedoctor"]);
		    Route::get("approvedoctor/{id}/{status}",[DoctorController::class,"postapprovedoctor"]);

		    Route::get("reviews",[DoctorController::class,'showreviews']);
		    Route::get("reviewtable",[DoctorController::class,"reviewtable"]);
		    Route::get("deletereview/{id}",[DoctorController::class,"deletereview"]);

		    Route::get("patients",[AuthenticationController::class,"showsuser"]);
		    Route::get("userstable",[AuthenticationController::class,"userstable"]);
		    Route::get("deleteuser/{id}",[AuthenticationController::class,"deleteuser"]);

		    Route::get("editprofile",[AuthenticationController::class,"editprofile"]);
		    Route::post("updateprofile",[AuthenticationController::class,"updateprofile"]);

		    Route::get("changepassword",[AuthenticationController::class,"changepassword"]);
		    Route::post("updatepassword",[AuthenticationController::class,"updatepassword"]);
		    Route::get("check_password_same/{val}",[AuthenticationController::class,"checkcurrentpassword"]);
            Route::post("updateaccount",[AuthenticationController::class,"updateaccount"]);

            Route::get("appointment",[AppointmentController::class,"showappointment"]);
            Route::get("appointmenttable",[AppointmentController::class,"appointmenttable"]);

            Route::get("changeappstatus/{id}/{status_id}",[AppointmentController::class,"changeappstatus"]);
			Route::get("payment_by_link",[AppointmentController::class,"payment_by_link"]);
			Route::get("ai_analysis_list",[AppointmentController::class,"ai_analysis_list"]);
			Route::get("video_consultation_list",[AppointmentController::class,"video_consultation_list"]);
            Route::get("sendnotification",[NotificationController::class,"showsendnotification"]);
            Route::get("notificationkey",[NotificationController::class,"notificationkey"]);
            Route::post("updatenotificationkey",[NotificationController::class,"updatenotificationkey"]);
            Route::get("notificationtable",[NotificationController::class,"notificationtable"]);

            Route::get("savenotification",[NotificationController::class,"savenotification"]);
            Route::post("sendnotificationtouser",[NotificationController::class,"sendnotificationtouser"]);
            Route::get("notification/{id}",[AppointmentController::class,"notification"]);
            Route::get("latsrappointmenttable",[AppointmentController::class,"latsrappointmenttable"]);
		    Route::post("updatesettingfour",[AuthenticationController::class,"updatesettingfour"]);
		    Route::get("complain",[AuthenticationController::class,"showcomplain"]);
		    Route::get("compaintable",[AuthenticationController::class,"compaintable"]);

		    Route::get("setting",[AuthenticationController::class,"showsetting"]);
		    Route::post("updatesettingone",[AuthenticationController::class,"updatesettingone"]);
		    Route::post("updatesettingtwo",[AuthenticationController::class,"updatesettingtwo"]);

		    Route::post("store_keys",[AuthenticationController::class,"store_keys"])->name("store_keys");

		    Route::get("pending_payment",[PaymentController::class,"show_pending_payment"])->name("pending_payment");
		    Route::get("pendingpaymenttable",[PaymentController::class,"show_pendingpaymenttable"])->name("pendingpaymenttable");
		    Route::get("payamount/{doc_id}",[PaymentController::class,"show_payamount"]);
		    Route::post("updatepayment",[PaymentController::class,"updatepayment"]);
		    Route::get("complete_payment",[PaymentController::class,"complete_payment"])->name("complete_payment");
		    Route::get("completepaymenttable",[PaymentController::class,"show_completepaymenttable"])->name("completepaymenttable");
		    Route::get("refundappointment/{id}",[AppointmentController::class,"show_refundappointment"]);

		    Route::get("payment-setting",[PaymentSettingController::class,"show_payment_setting"])->name('payment-setting');
            Route::post("updategateway",[PaymentSettingController::class,"show_update_gateway"])->name('updategateway');

            Route::get("contact_list",[PaymentController::class,"show_contact_list"])->name("contact_list");
		    Route::get("contact_list_table",[PaymentController::class,"contact_list_table"])->name("contact_list_table");

		    Route::get("news",[PaymentController::class,"show_news"])->name("news");
		    Route::post("sendnews",[PaymentController::class,"sendnews"])->name("sendnews");

		    Route::get("subscription", [SubscriptionController::class, "show_subscription"])->name("Subscription");
            Route::get("subscriptiontable", [SubscriptionController::class, "show_subscriptiontable"])->name("subscriptiontable");
            Route::get("edit_subscription_price/{id}", [SubscriptionController::class, "edit_subscription_price"]);

            Route::get("subscriber_doc", [SubscriptionController::class, "subscriber_doc"])->name("subscriber_doc");
            Route::get("subscribetable", [SubscriptionController::class, "show_subscribetable"])->name("subscribetable");

            Route::get("view_subscription_price/{id}", [SubscriptionController::class, "view_subscription_price"]);

            Route::post("update_subscriptio_price", [SubscriptionController::class, "update_subscriptio_price"]);

            Route::any("disable_order", [SubscriptionController::class, "disable_order"])->name("disable-order");

            Route::any("active_order", [SubscriptionController::class, "active_order"])->name("active-order");

            Route::get("banner",[BannerController::class,"showbanner"]);
	        Route::get("bannertable",[BannerController::class,"bannertable"]);
            Route::post("savebanner",[BannerController::class,"savebanner"]);
	        Route::get("edit-img/{id}",[BannerController::class,"edit_banner"]);
	        Route::post("updatebanner",[BannerController::class,"updatebanner"]);
	        Route::get("deletebanner/{id}",[BannerController::class,"deletebanner"]);

    	    Route::get("about",[FrontController::class,"about"]);
    		Route::get("Terms_condition",[FrontController::class,"admin_privacy"]);
    		Route::get("app_privacy",[FrontController::class,"app_privacy"]);
    		Route::get("data_deletion",[FrontController::class,"data_deletion"]);

    		Route::post("edit_about",[FrontController::class,"edit_about"]);
    		Route::post("edit_terms",[FrontController::class,"edit_terms"]);
    		Route::post("edit_app_privacy",[FrontController::class,"edit_app_privacy"]);
    		Route::post("edit_data_deletion",[FrontController::class,"edit_data_deletion"]);

    		Route::get("doctor_report",[ReportController::class,"doctor_report"])->name('doctor_report');
    		Route::get("user_report",[ReportController::class,"user_report"])->name('user_report');
    		Route::get("do_sub_report",[ReportController::class,"do_sub_report"])->name('do_sub_report');
    		Route::get("app_book_report",[ReportController::class,"app_book_report"])->name('app_book_report');

			Route::get("pharmacy",[PharmacyController::class,"pharmacy"])->name('pharmacy');
			Route::get("addpharmacy/{id}",[PharmacyController::class,"addpharmacy"])->name('addpharmacy');
			Route::post("updatepharmacy",[PharmacyController::class,"updatepharmacy"])->name('updatepharmacy');
			Route::get("deletepharmacy/{id}",[PharmacyController::class,"deletepharmacy"])->name('deletepharmacy');

			Route::get("medicine/{pharmacy_id}",[PharmacyController::class,"medicine"])->name('medicine');
			Route::get("medicinedelete/{pharmacy_id}",[PharmacyController::class,"medicinedelete"])->name('medicinedelete');
			Route::get("addmedicine/{pharmacy_id}/{medicine_id}",[PharmacyController::class,"addmedicine"]);
			Route::post("updatemedicine",[PharmacyController::class,"updatemedicine"]);

            Route::get("pharmacyorder",[PharmacyController::class,"pharmacyorder"])->name('pharmacyorder');

    });

});
});
});

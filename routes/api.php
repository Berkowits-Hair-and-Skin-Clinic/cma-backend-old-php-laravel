<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['Localization']], function () {
    /**  APIs for Admin Dashboard & Emails */
    //ecom_abandoned_cart
    Route::get("ecom_abandoned_cart", [ApiController::class, "ecom_abandoned_cart"]);
    Route::get("website_contact_form_data", [ApiController::class, "website_contact_form_data"]);
    Route::get("landing_page_form_data", [ApiController::class, "landing_page_form_data"]);
    Route::get("ai_hair_generator", [ApiController::class, "ai_hair_generator"]);
    Route::get("pay_by_link", [ApiController::class, "pay_by_link"]);
    Route::get("ai_analysis_list", [ApiController::class, "ai_analysis_list"]);
    Route::get("dashboard_counters", [ApiController::class, "dashboard_counters"]);
    Route::get("zenoti_service_booking_list", [ApiController::class, "zenoti_service_booking_list"]);
    Route::get("video_consultation_booking_list", [ApiController::class, "video_consultation_booking_list"]);
    /** Ecommerce Shop API */
    Route::any("order_payments", [ApiController::class, "order_payments"]);
    Route::any("reorder", [ApiController::class, "reorder"]);
    Route::any("orders", [ApiController::class, "orders"]);
    Route::any("show_cart", [ApiController::class, "show_cart"]);
    Route::any("add_to_cart", [ApiController::class, "add_to_cart"]);
    Route::any("addresses", [ApiController::class, "addresses"]);
    Route::post("add_customer_ecom", [ApiController::class, "add_customer_ecom"]);
    Route::any("product_list", [ApiController::class, "product_list"]);
    Route::get("product_details", [ApiController::class, "product_details"]);
    Route::any("product_search", [ApiController::class, "product_search"]);
    /** Ecommerce Shop API END add_customer_ecom */
    Route::any("searchdoctor", [ApiController::class, "showsearchdoctor"]);
    Route::any("nearbydoctor", [ApiController::class, "nearbydoctor"]);
    Route::post("register", [ApiController::class, "postregisterpatient"]);
    Route::any("user_reject_appointment", [ApiController::class, "user_reject_appointment"]);

    Route::post("connectycube_register",[ApiController::class,"connectycube_register"]);

    Route::any("savetoken", [ApiController::class, "storetoken"]);
    Route::any("login", [ApiController::class, "showlogin"]);
    Route::post("doctorregister", [ApiController::class, "doctorregister"]);
    Route::any("doctorlogin", [ApiController::class, "doctorlogin"]);
    Route::any("getspeciality", [ApiController::class, "getspeciality"]);
    Route::any("bookappointment", [ApiController::class, "bookappointment"]);
    Route::any("viewdoctor", [ApiController::class, "viewdoctor"]);
    Route::any("addreview", [ApiController::class, "addreview"]);
    Route::any("getslot", [ApiController::class, "getslotdata"]);
    Route::any("getlistofdoctorbyspecialty", [ApiController::class, "getlistofdoctorbyspecialty"]);
    Route::any("usersuappointment", [ApiController::class, "usersupcomingappointment"]);
    Route::any("userspastappointment", [ApiController::class, "userspastappointment"]);
    Route::any("doctoruappointment", [ApiController::class, "doctoruappointment"]);
    Route::any("doctorpastappointment", [ApiController::class, "doctorpastappointment"]);
    Route::any("reviewlistbydoctor", [ApiController::class, "reviewlistbydoctor"]);
    Route::any("doctordetail", [ApiController::class, "doctordetail"]);
    Route::any("appointmentdetail", [ApiController::class, "appointmentdetail"]);
    Route::any("doctoreditprofile", [ApiController::class, "doctoreditprofile"]);
    Route::any("usereditprofile", [ApiController::class, "usereditprofile"]);
    Route::any("getdoctorschedule", [ApiController::class, "getdoctorschedule"]);
    Route::any("Reportspam", [ApiController::class, "saveReportspam"]);
    Route::any("appointmentstatuschange", [ApiController::class, "appointmentstatuschange"]);
    Route::any("forgotpassword", [ApiController::class, "forgotpassword"]);
    Route::get("getalldoctors", [ApiController::class, "getalldoctors"]);

    Route::get("getholiday", [ApiController::class, "getholiday"]);
    Route::any("saveholiday", [ApiController::class, "saveholiday"]);
    Route::get("deleteholiday", [ApiController::class, "deleteholiday"]);
    Route::get("checkholiday", [ApiController::class, "checkholiday"]);

    Route::get("get_all_doctor", [ApiController::class, "get_all_doctor"]);
    Route::get("get_all_center", [ApiController::class, "get_all_center"]);
    Route::get("get_all_city", [ApiController::class, "get_all_city"]);
    Route::get("get_all_cta", [ApiController::class, "get_all_cta"]);
    Route::get("get_all_category", [ApiController::class, "get_all_category"]);
    Route::get("get_all_enabled_service", [ApiController::class, "get_all_enabled_service"]);
    Route::get("delete_my_account", [ApiController::class, "delete_my_account"]);

    //POST
    Route::post("lead_pushtocma", [ApiController::class, "lead_pushtocma"]);
    Route::post("lead_pushaltius_savecma", [ApiController::class, "lead_pushaltius_savecma"]);
    Route::post("create_vlc_products_checkout",[ApiController::class,"create_vlc_products_checkout"]);
    Route::post("save_lead_send_to_altius", [ApiController::class, "save_lead_send_to_altius"]);
    Route::post("create_cma_user",[ApiController::class,"create_cma_user"]);
    Route::post("create_cma_role",[ApiController::class,"create_cma_role"]);
    Route::post("attach_cma_role_user",[ApiController::class,"attach_cma_role_user"]);
    
    Route::post("save_general_lead", [ApiController::class, "save_general_lead"]);
    Route::post("old2newurl", [ApiController::class, "old2newurl"]);
    Route::post("analytics_admin_check", [ApiController::class, "analytics_admin_check"]);
    Route::post("send_otp", [ApiController::class, "send_otp"]);
    Route::post("send_voucher", [ApiController::class, "send_voucher"]);
    Route::post("verify_otp", [ApiController::class, "verify_otp"]);
    Route::post("send_whatsapp_telephant", [ApiController::class, "sendWhatsAPPTelephant"]);
    Route::post("update_service_cma", [ApiController::class, "update_service_cma"]);
    Route::post("create_service_cma", [ApiController::class, "create_service_cma"]);
    Route::post("create_cma_booking/{appointment_id}", [ApiController::class, "create_cma_booking"]);

    //ZENOTI
    Route::post("create_zenoti_giftcard_invoice", [ApiController::class, "createZenotiGiftCardInvoice"]);
    // END POST

    Route::get("get_subscription_list", [ApiController::class, "get_subscription_list"]);

    // Route::post("place_subscription",[ApiController::class,"place_subscription"]);

    Route::any("subscription_upload", [ApiController::class, "subscription_upload"]);

    Route::any("mediaupload", [ApiController::class, "mediaupload"]);
    Route::any("doctor_subscription_list", [ApiController::class, "doctor_subscription_list"]);
    Route::any("change_password_doctor", [ApiController::class, "change_password_doctor"]);

    Route::any("bannerlist", [ApiController::class, "banner_list"]);

    Route::any("income_report", [ApiController::class, "income_report"]);

    Route::any("data_list", [ApiController::class, "data_list"]);
    Route::any("about", [ApiController::class, "about"]);
    Route::any("privecy", [ApiController::class, "privecy"]);


    Route::any("search_medicine", [ApiController::class, "search_medicine"]);
    Route::any("add_medicine_to_app", [ApiController::class, "add_medicine_to_app"]);
    Route::any("upload_image", [ApiController::class, "upload_image"]);
    Route::any('delete_upload_image', [ApiController::class, 'delete_upload_image']);
    Route::any("most_used_medicine", [ApiController::class, "most_used_medicine"]);

    Route::any('add_bankdetails', [ApiController::class, 'add_bankdetails']);
    Route::any("get_bankdetails", [ApiController::class, "get_bankdetails"]);

    Route::any("medicine_order", [ApiController::class, "medicine_order"]);
    Route::post("prescription_order", [ApiController::class, "prescription_order"]);
    Route::any("change_pharmacyorder_status", [ApiController::class, "change_pharmacyorder_status"]);
    Route::any("prescription_addprice", [ApiController::class, "prescription_addprice"]);

    Route::any("get_user_order_list", [ApiController::class, "get_user_order_list"]);
    Route::any("set_session", [ApiController::class, "set_session"]);
    Route::any("get_pharmacy_order_list", [ApiController::class, "get_pharmacy_order_list"]);
    Route::any("view_order", [ApiController::class, "view_order"]);

    Route::any("pharmacy_medicines", [ApiController::class, "pharmacy_medicines"]);
    Route::any("medicines_detail", [ApiController::class, "medicines_detail"]);
    Route::any("add_pharmacy_medicine", [ApiController::class, "add_pharmacy_medicine"]);
    Route::any("delete_pharmacy_medicine", [ApiController::class, "delete_pharmacy_medicine"]);

    Route::any("pharmacy_income_report", [ApiController::class, "pharmacy_income_report"]);
});

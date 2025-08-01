<?php 

namespace App\Http\Middleware;
use Closure;
use Sentinel;
use App\Posts;
use Illuminate\Support\Facades\Http;
use App\Models\Doctors;
use App\Models\VideoConsultation;
use App\Models\VideoConsultationLogs;
use App\Http\Middleware\Zenoti;
use App\Http\Middleware\SmsController;
use App\Models\VideoConsultationDiagnosis;
use App\Models\VideoConsultationMedicine;
use App\Models\VideoConsultationTreatment;
use Exception;

class Vlc{

    public function dashboardCounters($center_id=NULL){
        $return_array=array();
        if(empty($center_id) OR $center_id==NULL){

        }else{
            //$records=VideoConsultation::where('center_id', $center_id)->where('status',"paid")->orderBy('id', 'desc')->get();
            $totalPendingConsultation=VideoConsultation::where('center_id', $center_id)->where('status',"paid")->count();
            $totalCompletedConsultation=VideoConsultation::where('center_id', $center_id)->where('status',"completed")->count();
            $totalAbsentConsultation=VideoConsultation::where('center_id', $center_id)->where('status',"absent")->count();
            $return_array['totalPendingConsultation']=$totalPendingConsultation;
            $return_array['totalCompletedConsultation']=$totalCompletedConsultation;
            $return_array['totalAbsentConsultation']=$totalAbsentConsultation;
        }
        return $return_array;
    }

    public static function getAllConsultation($center_id=NULL){
        $return_array=array();
        if(empty($center_id) OR $center_id==NULL){
            //$records=VideoConsultation::orderBy('id', 'desc')->all();
            $records = VideoConsultation::orderBy('id', 'desc')->get();
            return $records;
        }else{
            $records=VideoConsultation::where('center_id', $center_id)->where('status',"paid")->orderBy('id', 'desc')->get();
            //$totalPendingConsultation=VideoConsultation::where('center_id', $center_id)->where('status',"paid")->count();
            //$totalCompletedConsultation=VideoConsultation::where('center_id', $center_id)->where('status',"completed")->count();
            //$totalAbsentConsultation=VideoConsultation::where('center_id', $center_id)->where('status',"absent")->count();
        }
        return $records;

    }

    public static function updateConsultation($encryption_id=NULL,$status=NULL){
        $return_array=array();
        switch($status){
            case 'completed':
                $updateStatus="completed";
            break;
            case 'absent':
                $updateStatus="absent";
            break;
        }
        try{
            $affectedRows = VideoConsultation::where('encryption_id', $encryption_id)
                                 ->where('status', 'pending')
                                 ->update(['status' => $updateStatus]);
            $return_array['status']="success";
            $return_array['affectedRows']=$affectedRows;
            return $return_array;

        }catch(Exception $e){

        }

    }

    public static function addPrescription($encryption_id=NULL){
        

    }
    public static function getTreatment($id){
        try{
            $consultationTreatmentdata = VideoConsultationTreatment::where('consultation_id',$id)->get();
            return $consultationTreatmentdata;

        }catch(EXCEPTION $e){
            return $e;
        }
    }
    public static function getDiagnosis($id){
        try{
            $consultationDiagnosisdata = VideoConsultationDiagnosis::where('consultation_id',$id)->get();
            return $consultationDiagnosisdata;

        }catch(EXCEPTION $e){
            return $e;
        }
    }
    public static function getPrescription($id){
        try{
            $consultationMedicinedata = VideoConsultationMedicine::where('consultation_id',$id)->get();
            return $consultationMedicinedata;

        }catch(EXCEPTION $e){
            return $e;
        }
    }
    public static function getPrescriptionForPDF($id){
        try{
            $medicineList=array();
            $consultationMedicinedata = VideoConsultationMedicine::where('consultation_id',$id)->get();
            foreach($consultationMedicinedata as $row){
                $medi=json_decode($row['medicines'],true);
                $medicineList[]=$medi;

            }
            //return $consultationMedicinedata;
            return $medicineList;

        }catch(EXCEPTION $e){
            return $e;
        }
    }

    public static function getConsultationDetails($id=NULL){
        try{
            $consultationdata = VideoConsultation::where('encryption_id',$id)->first();
            return $consultationdata;

        }catch(EXCEPTION $e){
            return $e;
        }

    }
    public static function getConsultationLogs($encryption_id=NULL){
        try{
            $consultation_logs = VideoConsultationLogs::where('encryption_id',$encryption_id)->get();
            return $consultation_logs;

        }catch(EXCEPTION $e){
            return $e;
        }

    }
        

}
?>
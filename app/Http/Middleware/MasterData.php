<?php 
namespace App\Http\Middleware;
use Closure;
use Sentinel;
use App\Posts;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;
use App\Http\Middleware\Zenoti;
use App\Http\Middleware\SmsController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Eshop;
use Illuminate\Support\Facades\DB;
class MasterData{
    public static function checkDataZenoti($dataArray){
    }
    public static function checkDataCMA($dataArray){
    }
    public static function checkDataECOM($dataArray){
    }

    public static function createkRecordZenoti($dataArray){
    }
    public static function createkRecordECOM($dataArray){
    }
    public static function createkRecordCMA($dataArray){
    }

}

?>
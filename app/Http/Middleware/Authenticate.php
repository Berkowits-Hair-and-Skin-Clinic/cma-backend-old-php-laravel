<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\ApiKey;
use App\Models\SiteLogActivity;
use Illuminate\Support\Facades\DB;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    public static function validateApiKey($apikey){
        $getApiKey=ApiKey::where("api_auth_key",$apikey)->where("is_active",1)->first();
        if($getApiKey){
            //var_dump($getApiKey);exit;
            return true;
        }else{
            return false;
        }
    }
    public static function logActivity($apiName,$keyName,$source){
        /*DB::table('site_log_activity')->insert([
            'user_id' => $keyName,
            'url' => $apiName,
            'source' => $source,
        ]);*/
        $store=new SiteLogActivity();
        $store->user_id=$keyName;
        $store->url=$apiName;
        $store->source=$source;
        $store->save();
        return true;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicines extends Model
{
    protected $table = 'medicines';
    protected $primaryKey = 'id';

    /*use HasFactory;
    public function speciality(){
    	return $this->hasone("App\Models\Speciality",'id','specialities_id');
    }*/
}

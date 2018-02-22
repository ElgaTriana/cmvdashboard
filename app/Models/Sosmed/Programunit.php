<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;

class Programunit extends Model
{
    protected $table="program_unit";

    public function businessunit(){
    	return $this->belongsTo('\App\Models\Sosmed\Businessunit','business_unit_id')
    		->select(
    			[
    				'id',
    				'unit_name',
    				'logo'
    			]
    		);
	}
	
	public function sosmed(){
		return $this->belongsToMany('App\Models\Sosmed\Sosmed','unit_sosmed','business_program_unit','sosmed_id')
			->withPivot('id','type_sosmed','unit_sosmed_name')
			->where('type_sosmed','program');
	}
}

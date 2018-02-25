<?php

namespace App\Models\Sosmed;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Unitsosmed extends Model
{
    protected $table="unit_sosmed";

	public function sosmed(){
		return $this->belongsTo('App\Models\Sosmed\Sosmed','sosmed_id')
			->select(
				[
					'id',
					'sosmed_name'
				]
			);
	}

	public function followers(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmedfollower','unit_sosmed_id');
	}

	public function target(){
		return $this->hasOne('App\Models\Sosmed\Unitsosmedtarget','id','target_use');
	}

	public function alltarget(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmedtarget','id','target_use');
	}
}

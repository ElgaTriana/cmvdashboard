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
	
	// public function sosmed(){
	// 	return $this->belongsToMany('App\Models\Sosmed\Sosmed','unit_sosmed','business_program_unit','sosmed_id')
	// 		->withPivot('id','type_sosmed','unit_sosmed_name')
	// 		->where('type_sosmed','program');
	// }

	public function sosmed(){
		return $this->hasMany('App\Models\Sosmed\Unitsosmed','business_program_unit')
			->where('type_sosmed','program')
			->select(
				[
					'id',
					'type_sosmed',
					'business_program_unit',
					'sosmed_id',
					'unit_sosmed_name',
					'status_active',
					'unit_sosmed_account_id',
					'target_use',
					'youtube_json',
					'youtube_activity'
				]
			);
	}

	public function followers(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','program');
	}

	public function follower_twitter(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','program')
			->where('sosmed_id',1);
	}

	public function follower_facebook(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','program')
			->where('sosmed_id',2);
	}

	public function follower_instagram(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','program')
			->where('sosmed_id',3);
	}

	public function follower_youtube(){
		return $this->hasManyThrough('\App\Models\Sosmed\Unitsosmedfollower','\App\Models\Sosmed\Unitsosmed','business_program_unit','unit_sosmed_id')
			->select(
				[
					'unit_sosmed_id',
					'tanggal',
					'follower'
				]
			)->where('type_sosmed','program')
			->where('sosmed_id',4);
	}
}

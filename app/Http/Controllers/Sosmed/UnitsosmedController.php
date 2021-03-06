<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Unitsosmed;

class UnitsosmedController extends Controller
{
    public function index(){
        $var=Unitsosmed::with('sosmed','programunit','businessunit');

        return \Datatable::of($var)->make(true);
    }

    public function store(Request $request){
        if($request->input('sosmedid')==5){
            $rules=[
                'type'=>'required',
                'program_unit'=>'required',
                'gambar'=>'required',
                'sosmedid'=>'required'
            ];
        }else{
            $rules=[
                'type'=>'required',
                'program_unit'=>'required',
                'name_sosmed'=>'required',
                'sosmedid'=>'required'
            ];
        }

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            // $sosmedid=$request->input('sosmedid');
            $cek=Unitsosmed::where('type_sosmed',$request->input('type'))
                ->where('sosmed_id',$request->input('sosmedid'))
                ->where('business_program_unit',$request->input('program_unit'))
                ->get();

            if(count($cek)>0){
                return array('success'=>false,'error'=>'Data sosmed ini sudah ada');
            }

            $var=new Unitsosmed;
            $var->type_sosmed=$request->input('type');
            $var->business_program_unit=$request->input('program_unit');
            $var->sosmed_id=$request->input('sosmedid');

            if($request->input('sosmedid')==4){
                $var->unit_sosmed_name=$request->input('name_sosmed');

                if($request->has('withcek') && $request->input('withcek')!=null){
                    $var->unit_sosmed_account_id=$request->input('account_id');
                }else{
                    $params = [
                        'q'             => $request->input('account_id'),
                        'part'          => 'id, snippet',
                        'maxResults'    => 1
                    ];

                    // Make intial call. with second argument to reveal page info such as page tokens
                    $search = \Youtube::searchAdvanced($params);
                    
                    $youtube=array();
                    
                    foreach($search as $key=>$val){
                        $youtube=$val->id->channelId;
                    }

                    $var->unit_sosmed_account_id=$youtube;
                }
            }else if($request->input('sosmedid')==5){
                if($request->hasFile('gambar')){
                    $file=$request->file('gambar');
    
                    if (!is_dir('uploads/web/')) {
                        mkdir('uploads/web/', 0777, TRUE);
                    }

                    $folder='uploads/web/';
                    $filename=$file->getClientOriginalName();
                    $destinationPath='uploads/web/';

                    if($file->move($destinationPath,$filename)){
                        $var->unit_sosmed_name=$filename;
                        $var->unit_sosmed_account_id=$request->input('account_id');
                    }
                }
            }else{
                $var->unit_sosmed_name=$request->input('name_sosmed');
                $var->unit_sosmed_account_id=$request->input('account_id');
            }
            
            $var->status_active='Y';

            $simpan=$var->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil disimpan',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function edit($id){
        $var=Unitsosmed::find($id);

        return $var;
    }

    public function show(Request $request,$id){
        if($request->input('type')=="corporate"){
            $var=Unitsosmed::with('businessunit')->findOrFail($id);
        }elseif($request->input('type')=='program'){
            $var=Unitsosmed::with('program')->findOrFail($id);
        }else{
            $var=Unitsosmed::findOrFail($id);
        }

        return $var;
    }

    public function update(Request $request,$id){
        if($request->input('sosmedid')==5){
            $rules=[
                'type'=>'required',
                'program_unit'=>'required',
                'gambar'=>'required',
                'sosmedid'=>'required'
            ];
        }else{
            $rules=[
                'type'=>'required',
                'program_unit'=>'required',
                'name_sosmed'=>'required',
                'sosmedid'=>'required'
            ];
        }

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Unitsosmed::find($id);
            $var->type_sosmed=$request->input('type');
            $var->sosmed_id=$request->input('sosmedid');

            if($request->input('sosmedid')==4){
                $params = [
                    'q'             => $request->input('account_id'),
                    'part'          => 'id, snippet',
                    'maxResults'    => 1
                ];
                
                // Make intial call. with second argument to reveal page info such as page tokens
                $search = \Youtube::searchAdvanced($params);
                
                $youtube=array();
                
                foreach($search as $key=>$val){
                    if(isset($val->id->channelId)){
                        $youtube=$val->id->channelId;
                    }else{
                        $youtube=$val->snippet->channelId;
                    }
                }
                
                $var->unit_sosmed_name=$request->input('name_sosmed');
                $var->unit_sosmed_account_id=$youtube;

            }else if($request->input('sosmedid')==5){
                if($request->hasFile('gambar')){
                    $file=$request->file('gambar');
    
                    if (!is_dir('uploads/web/')) {
                        mkdir('uploads/web/', 0777, TRUE);
                    }

                    $folder='uploads/web/';
                    $filename=$file->getClientOriginalName();
                    $destinationPath='uploads/web/';

                    if($file->move($destinationPath,$filename)){
                        $var->unit_sosmed_name=$filename;
                        $var->unit_sosmed_account_id=$request->input('account_id');
                    }
                }
            }else{
                $var->unit_sosmed_name=$request->input('name_sosmed');
                $var->unit_sosmed_account_id=$request->input('account_id');
            }

            if($request->has('programtujuan') && $request->input('programtujuan')!=""){
                $var->business_program_unit=$request->input('programtujuan');
            }

            $simpan=$var->save();

            if($simpan){
                $data=array(
                    'success'=>true,
                    'pesan'=>'Data berhasil update',
                    'error'=>''
                );
            }else{
                $data=array(
                    'success'=>false,
                    'pesan'=>'Data gagal disimpan',
                    'error'=>''
                );
            }
        }

        return $data;
    }

    public function destroy($id){
        $var=Unitsosmed::find($id);

        $fl=\App\Models\Sosmed\Unitsosmedfollower::where('unit_sosmed_id',$id)->delete();

        $hapus=$var->delete();

        if($hapus){
            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil dihapus',
                'error'=>''
            );
        }else{
            $data=array(
                'success'=>false,
                'pesan'=>'Data gagal dihapus',
                'error'=>''
            );
        }

        return $data;
    }

    public function live_socmed_by_id(Request $request,$id){
        $var=Unitsosmed::where('business_program_unit',$id)
            ->where('type_sosmed',$request->input('type'))
            ->orderBy('sosmed_id')
            ->get();
        
        $channel=array();
        $activities=array();
        $youtube_json= array();
        $youtube_activity = array();

        foreach($var as $row){
            if($row->sosmed_id==4){
                // $channel = \Youtube::getChannelById($row->unit_sosmed_account_id);

                // $activities = \Youtube::getActivitiesByChannelId($row->unit_sosmed_account_id);

                $channel = $row->youtube_json;
                $activities = $row->youtube_activity;

                if($row->youtube_json != null)
                {
                    $youtube_json= json_decode($channel, true);
                    $youtube_activity = json_decode($activities, true);
                }
            }
        }

        return view('sosmed.view.live_socmed')
            ->with('sosmed',$var)
            ->with('youtube',$channel)
            ->with('youtube_json',$youtube_json)
            ->with('youtube_activity', $youtube_activity)
            ->with('activity',$activities);
    }

    public function aktif_non_aktif_program(Request $request,$id){
        $var=Unitsosmed::find($id);
        $var->status_active=request('status');
        $var->save();

        $data=array(
            'success'=>true,
            'pesan'=>'Data ',
            'errors'=>''
        );

        return $data;
    }
}
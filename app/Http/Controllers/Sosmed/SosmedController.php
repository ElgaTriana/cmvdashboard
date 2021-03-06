<?php

namespace App\Http\Controllers\Sosmed;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \App\Models\Sosmed\Sosmed;

class SosmedController extends Controller
{
    public function index(){
        \DB::statement(\DB::raw('set @rownum=0'));

        $var=Sosmed::select('id','sosmed_name',\DB::raw('@rownum := @rownum + 1 AS no'));

        return \Datatables::of($var)
            ->addColumn('action',function($query){
                $html="<div class='btn-group' data-toggle='buttons'>";
                if(auth()->user()->can('Edit Sosmed')){
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='fa fa-edit'></i></a>";
                }

                if(auth()->user()->can('Delete Sosmed')){
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='fa fa-trash'></i></a>";
                }
                
                $html.="</div>";

                return $html;
            })
            ->make(true);
    }

    public function store(Request $request){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=new Sosmed;
            $var->sosmed_name=$request->input('name');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/sosmed/')) {
                    mkdir('uploads/logo/sosmed/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/sosmed/';
                $file->move($destinationPath,$filename);

                $var->logo=$filename;
            }

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
        $var=Sosmed::find($id);

        return $var;
    }

    public function show($id){
        $var=Sosmed::findOrFail($id);

        return $var;
    }

    public function update(Request $request,$id){
        $rules=[
            'name'=>'required'
        ];

        $validasi=\Validator::make($request->all(),$rules);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            $var=Sosmed::find($id);
            $var->sosmed_name=$request->input('name');

            if($request->hasFile('file')){
                if (!is_dir('uploads/logo/sosmed/')) {
                    mkdir('uploads/logo/sosmed/', 0777, TRUE);
                }

                $file=$request->file('file');
                $filename=str_random(5).'-'.$file->getClientOriginalName();
                $destinationPath='uploads/logo/sosmed/';
                $file->move($destinationPath,$filename);
                
                $var->logo=$filename;
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
        $var=Sosmed::find($id);

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

    public function list_sosmed(Request $request){
        $var=Sosmed::select('id','sosmed_name')
            ->get();

        return $var;
    }
}
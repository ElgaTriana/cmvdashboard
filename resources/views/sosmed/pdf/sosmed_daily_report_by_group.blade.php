<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socmed Daily Report {{date('d-m-Y')}}</title>
    @php 
        if(count($sosmed)>3){
            $besar=20+(15*count($sosmed));
        }else{
            $besar=30+(20*count($sosmed));
        }
    @endphp
    <style>
        .page-break {
            page-break-after: always;
        }
        table, td, th {    
            border: 1px solid #ddd;
            text-align: left;
            font-size:12px;
        }

        table {
            border-collapse: collapse;
            width: {{$besar}}%;
            margin: 0px auto;
        }
        th{
            text-align:center;
        }

        th, td {
            padding: 6px;
        }

        .text-center{
            text-align:center;
        }

        i {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }

        .right {
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
        }

        .left {
            transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
        }

        .up {
            transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            color:green;
        }

        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            color:red;
        }

        .icon-arrow-up16{
            
        }
    </style>
</head>
<body>
    <div style="margin-top:40%;"></div>
    <h1 class="text-center">MNC GROUP SOCMED & YOUTUBE REPORT</h1>
    <p class="text-center">( {{date('d-m-Y',strtotime($sekarang))}} )</p>

    <div class="page-break"></div>


    <h3 class="text-center">OFFICIAL ACCOUNT ALL MNC GROUP</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%" style="background:#419F51;color:white" class="align-middle text-white">
                    @if($typeunit=="TV")
                        Channel
                    @elseif($typeunit=="Radio")
                        Station
                    @elseif($typeunit=="Publisher")
                        Website
                    @else 

                    @endif
                </th>
                @foreach($sosmed as $row)
                    @if($row->id!=4)
                        <th width="20%" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody style="color:#222">
            $listTotal=[];
            @foreach($officialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                    <?php 
                            $nama="TOTAL ".strtoupper($of->type_unit);
                            // $nama=$of->group_name;
                            $color="background:#f2eff2;color:#222;font-weight:700";

                            $listTotal[]=array(
                                'nama'=>'Total MNC Group',
                                'tw_kemarin'=>$of->tw_kemarin,
                                'tw_sekarang'=>$of->tw_sekarang,
                                'growt_tw'=>round($of->growth_tw,2),
                                'fb_kemarin'=>$of->fb_kemarin,
                                'fb_sekarang'=>$of->fb_sekarang,
                                'growt_fb'=>round($of->growth_fb,2),
                                'ig_kemarin'=>$of->ig_kemarin,
                                'ig_sekarang'=>$of->ig_sekarang,
                                'growt_ig'=>round($of->growth_ig,2),
                                'yt_kemarin'=>$of->yt_kemarin,
                                'yt_sekarang'=>$of->yt_sekarang,
                                'growt_yt'=>round($of->growth_yt,2)
                            );
                        ?>

                        @if($of->group_id==1)
                            <!-- menampilkan total group mncgroup di publisher -->
                            @if($typeunit=="Publisher")
                                <tr style="{{$color}}">
                                    <td>
                                        {{$nama}}
                                    </td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($of->tw_sekarang)}}</td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($of->fb_sekarang)}}</td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($of->ig_sekarang)}}</td>
                                        @endif

                                        <!-- @if($row->id==4)
                                            <td>{{number_format($of->yt_sekarang)}}</td>
                                        @endif -->
                                    @endforeach
                                </tr>
                            @endif
                            <!-- end menampilkan total group mncgroup di publisher -->

                            <!-- tambahkan untuk inews -->
                            @for($a=0;$a<count($tambahanInews);$a++)
                                @if($tambahanInews[$a]->id=="TOTAL" && $tambahanInews[$a]->group_unit_id==$of->group_id)
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        @foreach($sosmed as $row)
                                            @if($row->id==1)
                                                <td>{{number_format($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang)}}</td>
                                            @endif

                                            @if($row->id==2)
                                                <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                            @endif

                                            <!-- @if($row->id==4)
                                                <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                            @endif -->
                                        @endforeach
                                    </tr>
                                @endif
                            @endfor
                        @else  
                            <!-- menampilkan total group selain others --> 
                            @if($of->group_id!=5)
                                @if($of->group_id!=12)
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        @foreach($sosmed as $row)
                                            @if($row->id==1)
                                                <td>{{number_format($of->tw_sekarang)}}</td>
                                            @endif

                                            @if($row->id==2)
                                                <td>{{number_format($of->fb_sekarang)}}</td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($of->ig_sekarang)}}</td>
                                            @endif

                                            <!-- @if($row->id==4)
                                                <td>{{number_format($of->yt_sekarang)}}</td>
                                            @endif -->
                                        @endforeach
                                    </tr>
                                @endif
                            @endif
                            <!-- menampilkan total group selain others -->
                        @endif
                    @else    
                        
                    @endif
                @else 
                    <?php 
                        $nama=$of->unit_name;
                        $color="";
                    ?>

                    @if($of->id==4)
                        @for($a=0;$a<count($tambahanInews);$a++)
                            @if($tambahanInews[$a]->id=="TOTAL" && $tambahanInews[$a]->business_unit_id==$of->id)
                                <tr style="{{$color}}">
                                    <td>
                                        {{$nama}}
                                    </td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($tambahanInews[$a]->tw_sekarang+$of->tw_sekarang)}}</td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($tambahanInews[$a]->fb_sekarang+$of->fb_sekarang)}}</td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($tambahanInews[$a]->ig_sekarang+$of->ig_sekarang)}}</td>
                                        @endif

                                        <!-- @if($row->id==4)
                                            <td>{{number_format($tambahanInews[$a]->yt_sekarang+$of->yt_sekarang)}}</td>
                                        @endif -->
                                    @endforeach
                                </tr>
                            @endif
                        @endfor

                    @else
                        <tr style="{{$color}}">
                            <td>
                                {{$nama}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td>{{number_format($of->tw_sekarang)}}</td>
                                @endif

                                @if($row->id==2)
                                    <td>{{number_format($of->fb_sekarang)}}</td>
                                @endif

                                @if($row->id==3)
                                    <td>{{number_format($of->ig_sekarang)}}</td>
                                @endif

                                <!-- @if($row->id==4)
                                    <td>{{number_format($of->yt_sekarang)}}</td>
                                @endif -->
                            @endforeach
                        </tr>
                    @endif

                    <!-- menampilkan tambahan inews -->
                    @if($of->id==4)
                        @foreach($tambahanInews as $t)
                            @if($t->id!="TOTAL")
                                <tr>
                                    <td style='color:red'>{{$t->program_name}}</td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($t->tw_sekarang)}}</td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($t->fb_sekarang)}}</td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($t->ig_sekarang)}}</td>
                                        @endif

                                        <!-- @if($row->id==4)
                                            <td>{{number_format($t->yt_sekarang)}}</td>
                                        @endif -->
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    <!-- end menampilkan tambahan inews -->

                @endif
            @endforeach
            
            @php 
                $pertama=0;
                $kedua=0;
                $ketiga=0;
                $keempat=0;
            @endphp
            @foreach($listTotal as $key=>$val)
                @php 
                    $pertama+=$val['tw_sekarang'];
                    $kedua+=$val['fb_sekarang'];
                    $ketiga+=$val['ig_sekarang'];
                    $keempat+=$val['yt_sekarang'];
                @endphp 
            @endforeach
            <tr style="background:#419F51;color:white;font-weight:700">
                <td>TOTAL MNC GROUP</td>
                <td>{{number_format($pertama)}}</td>
                <td>{{number_format($kedua)}}</td>
                <td>{{number_format($ketiga)}}</td>
                <!-- <td>{{number_format($keempat)}}</td> -->
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>

    <h3 class="text-center">OVERALL ALL  MNC GROUP</h3>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%" style="background:#419F51;color:white" class="align-middle text-white">
                    Channel
                </th>
                @foreach($sosmed as $row)
                    <th class='text-center' width="20%" style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="color:#222">
            @php 
                $listprogram=array();
                $listtotal=array();
                $total2=array();
                $totalKol=array();
            @endphp
            @foreach($overallOfficialTv as $key=>$of)
                @if($of->id=="SUBTOTAL")
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                        ?>
                    @else    
                        <?php 
                            $nama="TOTAL ".strtoupper($of->type_unit);
                            $color="background:#f2eff2;color:#222;font-weight:700";

                            if($of->type_unit!="KOL"){
                                $total2[]=array(
                                    'nama'=>'Total MNC Group',
                                    'tw_kemarin'=>$of->total_tw_kemarin,
                                    'tw_sekarang'=>$of->total_tw_sekarang,
                                    'fb_kemarin'=>$of->total_fb_kemarin,
                                    'fb_sekarang'=>$of->total_fb_sekarang,
                                    'ig_kemarin'=>$of->total_ig_kemarin,
                                    'ig_sekarang'=>$of->total_ig_sekarang,
                                    'yt_kemarin'=>$of->total_yt_kemarin,
                                    'yt_sekarang'=>$of->total_yt_sekarang
                                );
                            }else{
                                $totalKol[]=array(
                                    'nama'=>'Total KOL',
                                    'tw_kemarin'=>$of->total_tw_kemarin,
                                    'tw_sekarang'=>$of->total_tw_sekarang,
                                    'fb_kemarin'=>$of->total_fb_kemarin,
                                    'fb_sekarang'=>$of->total_fb_sekarang,
                                    'ig_kemarin'=>$of->total_ig_kemarin,
                                    'ig_sekarang'=>$of->total_ig_sekarang,
                                    'yt_kemarin'=>$of->total_yt_kemarin,
                                    'yt_sekarang'=>$of->total_yt_sekarang
                                );
                            }
                        ?>

                        <!--tampilkan totalnya kecuali yang dari group others -->
                        @if($of->group_id!=5)
                            @if($of->group_id!=12)
                                @if($of->type_unit!="KOL")
                                    <tr style="{{$color}}">
                                        <td>
                                            {{$nama}}
                                        </td>
                                        @foreach($sosmed as $row)
                                            @if($row->id==1)
                                                <td>{{number_format($of->total_tw_sekarang)}}</td>
                                            @endif

                                            @if($row->id==2)
                                                <td>{{number_format($of->total_fb_sekarang)}}</td>
                                            @endif

                                            @if($row->id==3)
                                                <td>{{number_format($of->total_ig_sekarang)}}</td>
                                            @endif

                                            @if($row->id==4)
                                                <td>{{number_format($of->total_yt_sekarang)}}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                            @endif
                            
                        @endif
                    @endif
                @else 
                    <!--jika unitnya adalah other publisher, maka data disimpan ke array dulu, karena nantinya
                    data ini akan ditampilkan di list paling bawah -->
                    <?php 
                        $nama=$of->unit_name;
                        $color="";
                    ?>

                    @if($of->group_id!=12)
                        <!--tampilkan unitnya -->
                        @if($of->type_unit!="KOL")
                            <tr style="{{$color}}">
                                <td>
                                    {{$nama}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->total_tw_sekarang)}}</td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->total_fb_sekarang)}}</td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->total_ig_sekarang)}}</td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($of->total_yt_sekarang)}}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @else 
                        <!--simpan unit other publisher ke dalam array -->
                        @php 
                            if($of->type_unit!="KOL"){
                                $listprogram[]=array(
                                    'nama'=>$nama,
                                    'color'=>$color,

                                    'tw_kemarin'=>number_format($of->total_tw_kemarin),
                                    'tw_sekarang'=>number_format($of->total_tw_sekarang),
                                    'growth_tw'=>round($of->total_growth_tw,2),

                                    'fb_kemarin'=>number_format($of->total_fb_kemarin),
                                    'fb_sekarang'=>number_format($of->total_fb_sekarang),
                                    'growth_fb'=>round($of->total_growth_fb,2),

                                    'ig_kemarin'=>number_format($of->total_ig_kemarin),
                                    'ig_sekarang'=>number_format($of->total_ig_sekarang),
                                    'growth_ig'=>round($of->total_growth_ig,2),

                                    'yt_kemarin'=>number_format($of->total_yt_kemarin),
                                    'yt_sekarang'=>number_format($of->total_yt_sekarang),
                                    'growth_yt'=>round($of->total_growth_yt,2)
                                );
                            }
                        @endphp 
                    @endif

                @endif
            @endforeach
            
            @foreach($listprogram as $l)
                <tr style="{{$l['color']}}">
                    <td>{{$l['nama']}}</td>
                    @foreach($sosmed as $row)
                        @if($row->id==1)
                            <td>{{$l['tw_sekarang']}}</td>
                        @endif

                        @if($row->id==2)
                            <td>{{$l['fb_sekarang']}}</td>
                        @endif

                        @if($row->id==3)
                            <td>{{$l['ig_sekarang']}}</td>
                        @endif

                        @if($row->id==4)
                            <td>{{$l['yt_sekarang']}}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach

            @php 
                $pertama2=0;
                $kedua2=0;
                $ketiga2=0;
                $keempat2=0;
            @endphp
            @foreach($total2 as $key=>$val)
                @php 
                    $pertama2+=$val['tw_sekarang'];
                    $kedua2+=$val['fb_sekarang'];
                    $ketiga2+=$val['ig_sekarang'];
                    $keempat2+=$val['yt_sekarang'];
                @endphp 
            @endforeach
            <tr style="background:#419F51;color:white;font-weight:700">
                <td>TOTAL MNC GROUP</td>
                <td>{{number_format($pertama2)}}</td>
                <td>{{number_format($kedua2)}}</td>
                <td>{{number_format($ketiga2)}}</td>
                <td>{{number_format($keempat2)}}</td>
            </tr>
            <tr style="background:#419F51;color:white;font-weight:700">
                <td>TOTAL SMN ARTIST</td>
                @foreach($totalKol as $k)
                    <td>{{number_format($k['tw_sekarang'])}}</td>
                    <td>{{number_format($k['fb_sekarang'])}}</td>
                    <td>{{number_format($k['ig_sekarang'])}}</td>
                    <td>{{number_format($k['yt_sekarang'])}}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>
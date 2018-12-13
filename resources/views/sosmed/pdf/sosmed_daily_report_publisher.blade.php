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
    @if(count($sosmed)<2)
        @foreach($sosmed as $row)
            @if($row->id==4)
                <h1 class="text-center">
                    @if($typeunit==2)
                        {{strtoupper($mtype->name)}} YOUTUBE REPORT
                    @else 
                        {{strtoupper($mtype->name)}} YOUTUBE REPORT
                    @endif
                </h1>
            @else 
                <h1 class="text-center">
                    @if($typeunit==2)
                        {{strtoupper($mtype->name)}} {{strtoupper($row->sosmed_name)}} REPORT
                    @else 
                        {{strtoupper($mtype->name)}} {{strtoupper($row->sosmed_name)}} REPORT
                    @endif
                </h1>
            @endif
        @endforeach
    @elseif(count($sosmed)>3)
        @if($typeunit==1)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @elseif($typeunit==3)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @elseif($typeunit==2)
            <h1 class="text-center">{{strtoupper($mtype->name)}} & YOUTUBE REPORT</h1>
        @elseif($typeunit==4)
            <h1 class="text-center">{{strtoupper($mtype->name)}} & YOUTUBE REPORT</h1>
        @else
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @endif
    @else 
        @if($typeunit==1)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED DAILY REPORT</h1>
        @elseif($typeunit==3)
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED REPORT</h1>
        @elseif($typeunit==2)
            <h1 class="text-center">{{strtoupper($mtype->name)}} REPORT</h1>
        @elseif($typeunit==4)
            <h1 class="text-center">{{strtoupper($mtype->name)}} REPORT</h1>
        @else
            <h1 class="text-center">{{strtoupper($mtype->name)}} SOCMED & YOUTUBE REPORT</h1>
        @endif
    @endif
    
    <p class="text-center">( {{date('d-m-Y',strtotime($sekarang))}} vs {{date('d-m-Y',strtotime($kemarin))}} )</p>

    <div class="page-break"></div>

    <!-- jika youtube maka tidak ada official -->
    @php $youtubedoang="tidak"; @endphp 
    @if(count($sosmed)<=1)
        @foreach($sosmed as $row)
            @if($row->id==4)
                @php $youtubedoang="ya"; @endphp
            @else 
                @php $youtubedoang="tidak"; @endphp
            @endif
        @endforeach
    @endif
    
    @if($youtubedoang!="ya")
        <h3 class="text-center">OFFICIAL ACCOUNT ALL {{strtoupper($mtype->name)}}</h3>
        <br>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%" rowspan="2" style="background:#419F51;color:white" class="align-middle text-white">
                        Channel
                    </th>
                    @foreach($sosmed as $row)
                        <th colspan='3' width="20%" class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{$row->sosmed_name}}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach($sosmed as $row)
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($kemarin))}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>{{date('d-m-Y',strtotime($sekarang))}}</th>
                        <th class='text-center' style='background:{{$row->sosmed_color}};color:white'>Growth</th>
                    @endforeach
                </tr>
            </thead>
            <tbody style="color:#222">
                @php $no=0; @endphp
                @foreach($officialTv as $key=>$of)
                    @if($of->id=="SUBTOTAL")
                        @if($of->group_id=="TOTAL")
                            
                        @else 
                            @if($of->group_id!=12)
                                <tr style="background:#f2eff2;color:#222;font-weight:700">
                                    <td>{{$of->group_name}}</td>
                                    @foreach($sosmed as $row)
                                        @if($row->id==1)
                                            <td>{{number_format($of->tw_kemarin)}}</td>
                                            <td>{{number_format($of->tw_sekarang)}}</td>
                                            <td>
                                                @if($of->growth_tw>0)
                                                    <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==2)
                                            <td>{{number_format($of->fb_kemarin)}}</td>
                                            <td>{{number_format($of->fb_sekarang)}}</td>
                                            <td>
                                                @if($of->growth_fb>0)
                                                    <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==3)
                                            <td>{{number_format($of->ig_kemarin)}}</td>
                                            <td>{{number_format($of->ig_sekarang)}}</td>
                                            <td>
                                                @if($of->growth_ig>0)
                                                    <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif

                                        @if($row->id==4)
                                            <td>{{number_format($of->yt_kemarin)}}</td>
                                            <td>{{number_format($of->yt_sekarang)}}</td>
                                            <td>
                                                @if($of->growth_yt>0)
                                                    <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                                @else
                                                    <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                        @endif
                    @else 
                        @if($of->group_id!=12)
                            <tr style="">
                                <td>
                                    {{$of->unit_name}}
                                </td>
                                @foreach($sosmed as $row)
                                    @if($row->id==1)
                                        <td>{{number_format($of->tw_kemarin)}}</td>
                                        <td>{{number_format($of->tw_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_tw>0)
                                                <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==2)
                                        <td>{{number_format($of->fb_kemarin)}}</td>
                                        <td>{{number_format($of->fb_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_fb>0)
                                                <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==3)
                                        <td>{{number_format($of->ig_kemarin)}}</td>
                                        <td>{{number_format($of->ig_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_ig>0)
                                                <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif

                                    @if($row->id==4)
                                        <td>{{number_format($of->yt_kemarin)}}</td>
                                        <td>{{number_format($of->yt_sekarang)}}</td>
                                        <td>
                                            @if($of->growth_yt>0)
                                                <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                            @else
                                                <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endif
                @endforeach

                @foreach($officialTv as $key=>$of)
                    @if($of->group_id==12)
                        <tr style="">
                            <td>
                                {{$of->unit_name}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td>{{number_format($of->tw_kemarin)}}</td>
                                    <td>{{number_format($of->tw_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_tw>0)
                                            <a style="color:green;"> {{round($of->growth_tw,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_tw,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==2)
                                    <td>{{number_format($of->fb_kemarin)}}</td>
                                    <td>{{number_format($of->fb_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_fb>0)
                                            <a style="color:green;"> {{round($of->growth_fb,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_fb,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==3)
                                    <td>{{number_format($of->ig_kemarin)}}</td>
                                    <td>{{number_format($of->ig_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_ig>0)
                                            <a style="color:green;"> {{round($of->growth_ig,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_ig,2)}} % </a>
                                        @endif
                                    </td>
                                @endif

                                @if($row->id==4)
                                    <td>{{number_format($of->yt_kemarin)}}</td>
                                    <td>{{number_format($of->yt_sekarang)}}</td>
                                    <td>
                                        @if($of->growth_yt>0)
                                            <a style="color:green;"> {{round($of->growth_yt,2)}} % </a>
                                        @else
                                            <a style="color:red;"> {{round($of->growth_yt,2)}} % </a>
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                @endforeach

                @foreach($officialTv as $key=>$of)
                    @if($of->group_id=="TOTAL")
                        <?php 
                            $nama="NILAI RATA - RATA";
                            $color="background:#419F51;color:white;font-weight:700";
                            $satu_tw=0;
                            $satu_fb=0;
                            $satu_ig=0;
                            $satu_yt=0;

                            $pembagi=13;
                        ?>

                        <!-- menampilkan nilai rata rata -->
                        <tr>
                            <td style="{{$color}}">
                                {{$nama}}
                            </td>
                            @foreach($sosmed as $row)
                                @if($row->id==1)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->tw_sekarang+$satu_tw)/$pembagi)}}</td>
                                @endif

                                @if($row->id==2)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->fb_sekarang+$satu_fb)/$pembagi)}}</td>
                                @endif

                                @if($row->id==3)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->ig_sekarang+$satu_ig)/$pembagi)}}</td>
                                @endif

                                @if($row->id==4)
                                    <td colspan="3" class="text-center" style='background:{{$row->sosmed_color}};color:white'>{{number_format(($of->yt_sekarang+$satu_yt)/$pembagi)}}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="page-break"></div>      
    @endif
</body>
</html>
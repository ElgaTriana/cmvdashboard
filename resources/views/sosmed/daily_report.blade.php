@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">Export Daily Report</div>
        <div class="card-body">
            <div class="default-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#highlight-tab1" role="tab" aria-controls="nav-home" aria-selected="true">ALL</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#highlight-tab2" role="tab" aria-controls="nav-profile" aria-selected="false">BY GROUP</a>
                    </div>
                </nav>
                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="highlight-tab1" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form class="form-horizontal" action="{{URL::to('sosmed/data/report/pdf-sosmed-daily-report')}}" method="GET" target="new target">
                            <div class="form-group">
                                <label class="col-lg-2">Type Unit</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-archive"></i></span>
                                        <select name="typeunit" id="typeunit" class="form-control" required>
                                            <option value="TV">TV</option>
                                            <option value="Publisher">Publisher</option>
                                            <option value="Radio">Radio</option>
                                            <option value="KOL">KOL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2">Social Media</label>
                                <div class="col-lg-4">
                                    @foreach($sosmed as $row)
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sosmed[]" value="{{$row->id}}" checked="checked">{{$row->sosmed_name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input class="form-control daterange-single-sekarang" name="tanggal" id="tanggal">
                                    </div>
                                </div>
                            </div>
                            <div id="anotherDate"></div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pilih" id="pilih"> <small>check to compare data with another date?</small>
                                </label>
                            </div>
                            <br>
                            <div class="form-group well">
                                <label class="col-lg-2"></label>
                                <div class="col-lg-4">
                                    <button class='btn btn-primary'>
                                        <i class="icon-file-pdf"></i> Export PDF
                                    </button>
                                </div>
                            </div>
                        </form> 
                    </div>

                    <div class="tab-pane fade" id="highlight-tab2" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form class="form-horizontal" action="{{URL::to('sosmed/data/report/pdf-sosmed-daily-report-by-group')}}" method="GET" target="new target">
                            <div class="form-group">
                                <label for="" class="col-lg-2">Group</label>
                                <div class="col-lg-4">
                                    <select name="group" id="group" class="form-control">
                                        @foreach($group as $row)
                                            <option value="{{$row->id}}">{{$row->group_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-lg-2">Media</label>
                                <div class="col-lg-4">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media[]" value="TV" checked="checked">TV</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media[]" value="Publisher" checked="checked">Publisher</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media[]" value="Radio" checked="checked">Radio</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input class="form-control daterange-single-sekarang2" name="tanggal2" id="tanggal2">
                                    </div>
                                </div>
                            </div>
                            <div id="anotherDate2"></div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pilih2" id="pilih2"> <small>check to compare data with another date?</small>
                                </label>
                            </div>
                            <br>
                            <div class="form-group well">
                                <label class="col-lg-2"></label>
                                <div class="col-lg-4">
                                    <button class='btn btn-primary'>
                                        <i class="icon-file-pdf"></i> Export PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="divModal"></div>
@stop

@section('js')
    <script>
        $(function(){
            var sekarang = new Date();
            var kemarin = new Date(sekarang);
            kemarin.setDate(sekarang.getDate() - 1);

            var sekarang2 = new Date();
            var kemarin2 = new Date(sekarang);
            kemarin2.setDate(sekarang2.getDate() - 1);

            $('.daterange-single-sekarang').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single-sekarang2').datepicker({ 
                singleDatePicker: true,
                selectMonths: true,
                selectYears: true
            });

            $('.daterange-single-sekarang').datepicker('setDate',sekarang);
            $('.daterange-single-sekarang2').datepicker('setDate',sekarang2);
            
            $(document).on("click","#pilih",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="col-lg-2">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="icon-calendar"></i></span>'+
                                '<input class="form-control daterange-single-kemarin" name="kemarin" id="kemarin">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate").empty().html(el);

                    $('.daterange-single-kemarin').datepicker({ 
                        singleDatePicker: true,
                        selectMonths: true,
                        selectYears: true
                    });

                    $('.daterange-single-kemarin').datepicker('setDate',kemarin);
                }else{
                    $("#anotherDate").empty();
                }
            })

            $(document).on("click","#pilih2",function(){
                if($(this).is(':checked')){
                    var el="";
                    el+='<div class="form-group">'+
                        '<label class="col-lg-2">Compare With</label>'+
                        '<div class="col-lg-4">'+
                            '<div class="input-group">'+
                                '<span class="input-group-addon"><i class="icon-calendar"></i></span>'+
                                '<input class="form-control daterange-single-kemarin2" name="kemarin2" id="kemarin2">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                    $("#anotherDate2").empty().html(el);

                    $('.daterange-single-kemarin2').datepicker({ 
                        singleDatePicker: true,
                        selectMonths: true,
                        selectYears: true
                    });

                    $('.daterange-single-kemarin2').datepicker('setDate',kemarin);
                }else{
                    $("#anotherDate").empty();
                }
            })
        })
    </script>
@stop
@extends('layouts.dashboard')

@section('js')
    <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
    {{Html::script('limitless1/assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js')}}

    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
	<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
	ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/pie.js"></script>

    <script>
        $(function(){
            var alldata={};

            $(".remote-data-brand").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-category").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-category')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-brand-competitive").select2({
                multiple:true,
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            category:$("#category").val(),
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            $(".remote-data-brand-compare").select2({
                ajax: {
                    url: "{{URL::to('cmv/data/list-brand')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params, // search term
                            category:$("#category").val(),
                            page_limit: 30
                        };
                    },
                    results: function (data, page){
                        return {
                            results: data.data
                        };
                    },
                    cache: true,
                    pagination: {
                        more: true
                    }
                },
                formatResult: function(m){
                    var markup="<option value='"+m.id+"'>"+m.text+"</option>";
    
                    return markup;                
                },
                formatSelection: function(m){
                    return m.text;
                },
                escapeMarkup: function (m) { return m; }
            })

            function tabelData(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/filter-demography-by-brand')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){
                        $("#showData").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        $("#showData").empty().html(result);

                        $("#tabelBrand").DataTable({
                            colVis: {
                                buttonText: "<i class='icon-three-bars'></i> <span class='caret'></span>",
                                align: "right",
                                overlayFade: 200,
                                showAll: "Show all",
                                showNone: "Hide all"
                            },
                            scrollX: true,
                            scrollY: '450px',
                            scrollCollapse: true,
                            fixedColumns: true,
                            fixedColumns: {
                                leftColumns: 2,
                                rightColumns: 0
                            },
                            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                if ( aData[2] == "5" )
                                {
                                    $('td', nRow).css('background-color', 'Red');
                                }
                                else if ( aData[2] == "4" )
                                {
                                    $('td', nRow).css('background-color', 'Orange');
                                }
                            },
                            bDestroy: true
                        })

                        // Launch Uniform styling for checkboxes
                        $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
                            $('.ColVis_collection input').uniform();
                        });


                        // Add placeholder to the datatable filter option
                        $('.dataTables_filter input[type=search]').attr('placeholder', 'Type and Enter...');


                        // Enable Select2 select for the length option
                        $('.dataTables_length select').select2({
                            minimumResultsForSearch: "-1"
                        }); 

                    },
                    error:function(){
                        $("#showData").empty().html("<div class='alert alert-danger'>Data failed to load</div>");
                    }
                })
            }

            function showGender(data){
                var gender=[];
                var color=["#5d9edb","#f38542"];
                var br="";

                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){
                        br=b.brand_name;
                        if(a==1){
                            gender.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }else{
                            gender.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"55%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":2,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"5%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : gender
               };
                
               zingchart.render({ 
                   id : 'divGender', 
                   data : myConfig
               });
            }

            function showSec(data){
                var sec=[];
                var color=["#599cdb","#f67b28","#a9a9a9"];
                var br="";

                $.each(data,function(a,b){
                    if(b.demo_id=="D3"){
                        br=b.brand_name;
                        sec.push({
                            values:[parseInt(b.totals_thousand)],
                            backgroundColor:color[a],
                            text:b.subdemo_name
                        })
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"65%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"5%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : sec
               };
            
                zingchart.render({ 
                    id : 'divSec', 
                    data : myConfig
                });
                
                
            }

            function showAge(data){
                var age=[];
                var color=["#5b9ddb","#f67c2a","#a0a0a0","#ffc720","#557dcb"];
                var br="";

                $.each(data,function(a,b){
                    if(b.demo_id=="D2"){
                        br=b.brand_name;
                        age.push({
                            values:[parseInt(b.totals_thousand)],
                            backgroundColor:color[a],
                            text:b.subdemo_name
                        })
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"58%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"5%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : age
               };
            
                zingchart.render({ 
                    id : 'divAge', 
                    data : myConfig
                });
                
                
            }

            function showEducation(data){
                var education=[];
                var color=["#5197d7","#ef7421","#aaaaaa"];
                var br="";

                $.each(data,function(a,b){
                    if(b.demo_id=="D4"){
                        br=b.brand_name;
                        education.push({
                            values:[parseInt(b.totals_thousand)],
                            backgroundColor:color[a],
                            text:b.subdemo_name
                        })
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"23%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"25%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : education
               };
            
                zingchart.render({ 
                    id : 'divEducation', 
                    data : myConfig
                });
                
                
            }

            function showOccupation(data){
                var occupation=[];
                var color=["#3260af","#6aa047","#4b8ac2","#da712d","#949494","#edaf02"];
                var br="";
                var no=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D5"){
                        no++;
                        br=b.brand_name;
                        if(no==2 || no==4 || no==5){
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }else{
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"35%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"30%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : occupation
               };
            
                zingchart.render({ 
                    id : 'divOccupation', 
                    data : myConfig
                });
                
                
            }

            function showHobby(data){
                var occupation=[];
                var color=["#4887c0","#da6f2a","#979797","#edb111","#3260af","#649e3d","#99bae3","#f5ac8f","#c2c2c2","#ffd68e"];
                var br="";
                var no=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D6"){
                        no++;
                        br=b.brand_name;
                        if(no==2 || no==4 || no==5){
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                                // "detached":true
                            })
                        }else{
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"50%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"5%",
                        "margin-left":"5%",
                        "margin-top":"30%",
                        "margin-bottom":"5%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        }
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : occupation
               };
            
                zingchart.render({ 
                    id : 'divHobby', 
                    data : myConfig
                });
                
                
            }

            function showPsiko(data){
                var occupation=[];
                var color=["#6ba148","#96b9e3","#f3a282","#c1c1c1","#4a89c2","#d86a20","#959595","#edb10e","#3a66b4"];
                var br="";
                var no=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D9"){
                        no++;
                        br=b.brand_name;
                        if(no==2 || no==4 || no==5){
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                                // "detached":true
                            })
                        }else{
                            occupation.push({
                                values:[parseInt(b.totals_thousand)],
                                backgroundColor:color[a],
                                text:b.subdemo_name
                            })
                        }
                    }
                })

                var myConfig = {
                    type: "pie", 
                    backgroundColor: "#fff",
                    title: {
                        text: br,
                        backgroundColor: "#fff",
                        height: 40,
                        fontColor: "#1A1B26",
                        fontSize: 16
                    },
                    "legend":{
                        "x":"65%",
                        "y":"10%",
                        "border-width":1,
                        "border-color":"gray",
                        "border-radius":"5px",
                        "header":{
                            "text":"Legend",
                            "font-family":"Georgia",
                            "font-size":12,
                            "font-color":"white",
                            "font-weight":"normal"
                        },
                        "marker":{
                            "type":"circle"
                        },
                        "toggle-action":"remove",
                        "minimize":true,
                        "icon":{
                            "line-color":"#9999ff"
                        },
                        "max-items":8,
                        "overflow":"scroll"
                    },
                    "plotarea":{
                        "margin-right":"20%",
                        "margin-top":"10%"
                    },
                    plot: {
                        refAngle: 270,
                        valueBox: [
                        {
                            placement: "in",
                            text: "%npv%",
                            fontColor: "#1A1B26",
                            fontSize: 16
                        }],
                        "tooltip":{
                            "text":"%t: %v (%npv%)",
                            "font-color":"black",
                            "font-family":"Georgia",
                            "text-alpha":1,
                            "background-color":"white",
                            "alpha":0.7,
                            "border-width":1,
                            "border-color":"#cccccc",
                            "line-style":"dotted",
                            "border-radius":"10px",
                            "padding":"10%",
                            "placement":"node:out" //"node:out" or "node:center"
                        },
                    },
                    tooltip: {
                        fontSize: 12,
                        fontColor: "#1A1B26",
                        shadow: 0,
                        borderRadius: 3,
                        borderWidth: 1,
                        borderColor: "#fff"
                    },
                    series : occupation
               };
            
                zingchart.render({ 
                    id : 'divPsiko', 
                    data : myConfig
                });
                
                
            }

            function showMedia(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D7"){
                        no++;
                        br=b.brand_name;
                        labels.push(b.subdemo_name);
                        values.push(parseInt(b.totals_thousand));
                        // occupation.push({
                        //         values:[parseInt(b.totals_thousand)],
                        //         backgroundColor:color[a],
                        //         text:b.subdemo_name
                        //     })
                    }
                })

                var myConfig = {
                    type: "bar",
                    utc:true,
                    plotarea: {
                      adjustLayout:true
                    },
                    scaleX:{
                      label:{
                        text:br
                      },
                      "labels": labels,
                      minValue:1420070400000,
                      step:"day",
                      transform:{
                        type:"date",
                        all:"%M %d"
                      }
                    },
                    series: [
                      {
                        values:values,
                        "background-color": "#599cdb"
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divMedia', 
                    data : myConfig
                });
            }

            function showCity(data){
                var labels=[];
                var values=[];
                var br="";
                var no=0;
                $.each(data,function(a,b){
                    if(b.demo_id=="D8"){
                        no++;
                        br=b.brand_name;
                        labels.push(b.subdemo_name);
                        values.push(parseInt(b.totals_thousand));
                    }
                })

                var myConfig = {
                    type: "bar",
                    utc:true,
                    plotarea: {
                      adjustLayout:true
                    },
                    scaleX:{
                      label:{
                        text:br
                      },
                      "labels":labels,
                      minValue:1420070400000,
                      step:"day",
                      transform:{
                        type:"date",
                        all:"%M %d"
                      }
                    },
                    series: [
                      {
                        values:values,
                        "background-color": "#599cdb"
                      }
                    ]
                };
                   
                zingchart.render({ 
                    id : 'divCity', 
                    data : myConfig
                });
            }

            function allData(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/chart/all-data')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){

                    },
                    success:function(result){
                        alldata=result;

                        showGender(alldata);
                        showSec(alldata);
                        showAge(alldata);
                        showEducation(alldata);
                        showOccupation(alldata);
                        showHobby(alldata);
                        showPsiko(alldata);
                        showMedia(alldata);
                        showCity(alldata);
                    },
                    error:function(){

                    }
                })
            }

            function topbrand(){
                var brand=$("#brand").val();
                var quartal=$("#quartal").val();

                $.ajax({
                    url:"{{URL::to('cmv/data/top-brand-by-category')}}",
                    type:"GET",
                    data:"brand="+brand+"&quartal="+quartal,
                    beforeSend:function(){
                        $("#topBrand").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var primaryColor = "#4184F3";
                        var primaryColorHover = "#3a53c5";
                        var secondaryColor = '#DCDCDC'
                        var scaleTextColor = '#999';
                        
                        $("#topBrand").empty();

                        var chartConfig = {
                            "type": "hbar",
                            "plot": {
                                "stacked": true,
                                "valueBox":{
                                    "text":"%total",
                                    "rules": [
                                        {
                                            "rule": '%stack-top == 0',
                                            "visible": 0
                                        }
                                    ]
                                }
                            },
                            "plotarea": {
                                "margin": "2% 2% 15% 15%"
                            },
                            "legend":{
                                "align": 'center',
                                "verticalAlign": 'bottom',
                                "layout": 'x3',
                                "toggleAction": 'remove'
                            },
                            "backgroundColor": "#fff",
                            "scaleX": {
                                "values": result.label,
                                "lineWidth": 0,
                                "lineColor":"none",
                                "tick": {
                                    "visible": false
                                },
                                "guide": {
                                    "visible": false
                                },
                                "item": {
                                    "font-color": "#999"
                                }
                            },
                            "tooltip": {
                                "htmlMode": true,
                                "backgroundColor": "none",
                                "padding": 0,
                                "placement": "node:center",
                                "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                            },
                            "series": [
                                {
                                    "values": result.data,
                                    "alpha": 1,
                                    "background-color": "#008ef6",
                                    "hover-state": {
                                        "backgroundColor": "#2956A0"
                                    }
                                }
                            ]
                        };

                        chartConfig.plot.animation = {
                            'method': 'LINEAR',
                            'delay': 0,
                            'effect': 'ANIMATION_EXPAND_VERTICAL',
                            'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                            'speed': 10
                        }
                        
                        zingchart.render({
                            id: 'topBrand',
                            data: chartConfig,
                            output: 'canvas',
                            height:'100%',
                            width:'100%'
                        });
                    },
                    error:function(){

                    }
                })
            }

            $(document).on("submit","#formSearch",function(e){
                topbrand();
                allData();
                tabelData();  
            })

            $(document).on("submit","#formCompetitive",function(e){
                var data = new FormData(this);
                data.append("_token","{{ csrf_token() }}");
                if($("#formCompetitive")[0].checkValidity()) {
                    //updateAllMessageForms();
                    e.preventDefault();
                    $.ajax({
                        url         : "{{URL::to('cmv/data/list-competitive-map')}}",
                        type        : 'post',
                        data        : data,
                        dataType    : 'JSON',
                        contentType : false,
                        cache       : false,
                        processData : false,
                        beforeSend  : function (){
                            $('#competitiveMap').empty().html('<div class="alert alert-info"><i class="fa fa-spinner fa-2x fa-spin"></i>&nbsp;Please wait for a few minutes</div>');
                        },
                        success : function (data) {
                            var el="<div class='row'>"+
                                '<div class="col-lg-5">'+
                                    '<div class="panel panel-primary">'+
                                        '<div class="panel-heading">'+data.brand.brand_name+'</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">GENDER</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveGender" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">SEC</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveSec" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">AGE</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveAge" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">EDUCATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveEducation" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    
                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">OCCUPATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveOccupation" style="width:100%;height:200px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">HOBBY</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveHobby" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">MEDIA</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveMedia" style="width:100%;height:220px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">CITIES</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="competitiveCities" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+

                                '<div class="col-lg-7">'+
                                    '<div class="row">'+
                                        '<div id="comparewith"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                            $("#competitiveMap").empty().html(el);
                            competitiveGender(data.list);
                            competitiveSec(data.list);
                            competitiveAge(data.list);
                            competitiveEducation(data.list);
                            competitiveOccupation(data.list);
                            competitiveHobby(data.list);
                            competitiveMedia(data.list);
                            competitiveCities(data.list);
                            comparewith();
                        },
                        error   :function() {  
                            $('#competitiveMap').html('<div class="alert alert-danger">Your request not Sent...</div>');
                        }
                    });
                }else console.log("invalid form");
            })

            function competitiveGender(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D1"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveGender").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 20%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#3a76bf",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveGender',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveSec(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D3"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveSec").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 20%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#92d050",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveSec',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveAge(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D2"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveAge").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 25%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#31859c",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveAge',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveEducation(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D4"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveEducation").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 25%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#e46c0a",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveEducation',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveOccupation(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D5"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveOccupation").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 30%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999",
                            "font-size":"10px"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#948a54",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveOccupation',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveHobby(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D6"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveHobby").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 30%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999",
                            "font-size":"10px"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#604a7b",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveHobby',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveMedia(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D7"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveMedia").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 30%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999",
                            "font-size":"10px"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#c0504d",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveMedia',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function competitiveCities(data){
                var value=[];
                var nama=[];

                $.each(data,function(a,b){
                    if(b.demo_id=="D8"){
                        nama.push(b.subdemo_name);
                        value.push(parseInt(b.totals_ver));
                    }
                })
                
                $("#competitiveCities").empty();

                var chartConfig = {
                    "type": "hbar",
                    "plot": {
                        "stacked": true,
                        "valueBox":{
 	                        "text":"%total",
 	                        "rules": [
   	                            {
   	                                "rule": '%stack-top == 0',
   	                                "visible": 0
   	                            }
   	                        ]
 	                    }
                    },
                    "plotarea": {
                        "margin": "2% 2% 15% 25%"
                    },
                    "backgroundColor": "#fff",
                    "scaleX": {
                        "values": nama,
                        "lineWidth": 0,
                        "lineColor":"none",
                        "tick": {
                            "visible": false
                        },
                        "guide": {
                            "visible": false
                        },
                        "item": {
                            "font-color": "#999",
                            "font-size":"10px"
                        }
                    },
                    "tooltip": {
                        "htmlMode": true,
                        "backgroundColor": "none",
                        "padding": 0,
                        "placement": "node:center",
                        "text": "<div class='zingchart-tooltip'><div class='scalex-value'>%kt<\/div><div class='scaley-value'>%v<\/div><\/div>"
                    },
                    "series": [
                        {
                            "values": value,
                            "alpha": 1,
                            "background-color": "#632523",
                            "hover-state" : {
                                backgroundColor: '#2956A0'
                            }
                        }
                    ]
                };

                chartConfig.plot.animation = {
                    'method': 'LINEAR',
                    'delay': 0,
                    'effect': 'ANIMATION_EXPAND_VERTICAL',
                    'sequence': 'ANIMATION_BY_PLOT_AND_NODE',
                    'speed': 10
                }
                
                zingchart.render({
                    id: 'competitiveCities',
                    data: chartConfig,
                    output: 'canvas',
                    height:'100%',
                    width:'100%'
                });
            }

            function comparewith(){
                var brand=$("#brand2").val();
                var compare=$("#compare2").val();
                $.ajax({
                    url:"{{URL::to('cmv/data/compare-with')}}",
                    type:"GET",
                    data:"brand="+brand+"&compare="+compare,
                    beforeSend:function(){
                        $("#comparewith").empty().html("<div class='alert alert-info'>Please Wait. . .</div>");
                    },
                    success:function(result){
                        var el="";
                        $.each(result.compare,function(a,b){
                            el+="<div class='col-lg-4'>"+
                                    '<div class="panel panel-info">'+
                                        '<div class="panel-heading">'+
                                            b.brand_name+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">GENDER</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareGender'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">SEC</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareSec'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">AGE</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareAge'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">EDUCATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareEducation'+b.brand_id+'" style="width:100%;height:130px;"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    
                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">OCCUPATION</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareOccupation'+b.brand_id+'" style="width:100%;height:200px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">HOBBY</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareHobby'+b.brand_id+'" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">MEDIA</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareMedia'+b.brand_id+'" style="width:100%;height:220px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">CITIES</div>'+
                                        '<div class="panel-body">'+
                                            '<div id="compareCities'+b.brand_id+'" style="width:100%;height:300px;"></div>'+
                                        '</div>'+
                                    '</div>'+

                                '</div>';
                        })

                        $("#comparewith").empty().html(el);

                        compareGender(result.compare,result.list);
                        compareSec(result.compare,result.list);
                        compareAge(result.compare,result.list);
                        compareEducation(result.compare,result.list);
                        compareOccupation(result.compare,result.list);
                        compareHobby(result.compare,result.list);
                        compareMedia(result.compare,result.list);
                        compareCities(result.compare,result.list);
                    },
                    error:function(){
                        $("#comparewith").empty().html("<div class='alert alert-danger'>Opss.. failed data to load</div>");
                    }
                })
            }

            function compareGender(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D1" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareGender'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareSec(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D3" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareSec'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareAge(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D2" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareAge'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareEducation(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D4" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareEducation'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareOccupation(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D5" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareOccupation'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareHobby(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D6" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareHobby'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareMedia(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D7" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareMedia'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }

            function compareCities(compare,list){
                $.each(compare,function(a,b){
                    var val=[];

                    $.each(list,function(c,d){
                        if(d.demo_id=="D8" && d.brand_id==b.brand_id){
                            if(d.total>0){
                                var bg="#68d7c6";
                                var text=d.subdemo_name;
                            }else{
                                var bg="#fd625e";
                                var text=d.subdemo_name
                            }
                            val.push(
                                {
                                    values: [parseInt(d.total)],
                                    stack: c,
                                    'data-custom-token': [parseInt(d.total)],
                                    text:text,
                                    valueBox:{  
                                        "text":'%data-custom-token',
                                        "placement":'bottom'
                                    },
                                    backgroundColor:bg
                                }
                            )
                        }
                    })

                    var myConfig = {
                        type: 'hbar',
                        stacked: true,
                        plotarea:{
                            margin: 'dynamic'
                        },
                        tooltip:{
                            text:"%t %negation%v",
                            decimals: 2,
                            align: 'left',
                            borderRadius: 3,
                            fontColor:"#ffffff",
                            negation: 'currency'
                        },
                        plot:{
                            valueBox:{
                                text:"%total",
                                rules: [
                                    {
                                        rule: '%stack-top == 0',
                                        visible: 0
                                    }
                                ]
                            }
                        },
                        series: val
                    };
                    
                    zingchart.render({ 
                        id : 'compareCities'+b.brand_id, 
                        data: myConfig, 
                        height: '100%', 
                        width: '100%' 
                    });
                })
            }
        })
    </script>
@stop

@section('css')
    <style>
        #topBrand {
            height: 450px;
            width: 750px;
        }

        #divGender {
            height: 100%;
            width: 100%;
        }

        #divAge {
            height: 100%;
            width: 100%;
        }

        #divSec {
            height: 100%;
            width: 100%;
        }

        #divEducation {
            height: 100%;
            width: 100%;
        }

        #divOccupation {
            height: 100%;
            width: 100%;
        }

        #divHobby {
            height: 100%;
            width: 100%;
        }

        #divPsiko {
            height: 100%;
            width: 100%;
        }

        #divMedia {
            height: 100%;
            width: 100%;
        }

        #divCity {
            height: 100%;
            width: 100%;
        }

        .zingchart-tooltip {
            padding: 7px 5px;
            border-radius: 1px;
            line-height: 20px;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            -webkit-font-smoothing: antialiased;
        }
        .zingchart-tooltip .scalex-value {
            font-size: 14px !important;
            font-weight: normal !important;
            line-height: 24px;
            color: #838383;
        }
        .zingchart-tooltip .scaley-value {
            color: #4184f3;
            font-size: 24px !important;
            font-weight: normal !important;
        }

        .zc-ref {
            display: none;
        }

    </style>
@stop

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form id="formSearch" onsubmit="return false" name="formSearch">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <input type="text" name="brand" id="brand" class="remote-data-brand">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Quartal</label>
                            <select name="quartal" id="quartal" class="form-control">
                                <option value="42017">42017</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <button class="btn btn-primary" style="margin-top:25px;">
                                <i class="icon-filter4"></i>
                                Filter 
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            TOP 10 BRAND
        </div>
        <div class="panel-body">
            <div id="topBrand"></div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">DEMOGRAPHY</h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>GENDER</strong></h6>
                        </div>
                        <div id="divGender"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>SEC</strong></h6>
                        </div>
                        <div id="divSec"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>AGE</strong></h6>
                        </div>
                        <div id="divAge"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>EDUCATION</strong></h6>
                        </div>
                        <div id="divEducation"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>OCCUPATION</strong></h6>
                        </div>
                        <div id="divOccupation"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h6 class="panel-title"><strong>HOBBY</strong></h6>
                        </div>
                        <div id="divHobby"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">PENETRATION</h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">MEDIA</h6>
                        </div>
                        <div id="divMedia"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">CITIES</h6>
                        </div>
                        <div id="divCity"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title">PSYCHOGRAPHICS</h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-7">
                    <div id="divPsiko"></div>
                </div>

                <div class="col-lg-5">
                    <div class="panel-group panel-group-control content-group-lg" id="accordion-control">
        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2">TRADITIONALIST</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group2" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Hold traditional value, dreaming of wealth, Non Brand Minded, Less Health Conscious, Non Ad Believer” 
                                </div>
                            </div>
                        </div>
        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group3">SETTLED</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group3" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Nested. Practical (Prefer buying new than fixing), TV is entertainment, Enjoying Ad, Enjoying Shopping” 
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group4">YOUNG LOYALIST</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group4" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Value friendship, Self sacrificing for greater result, Less environment concern” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group5">WESTERN MINDED</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group5" class="panel-collapse collapse">
                                <div class="panel-body">
                                        “Brand Minded, Career oriented, Enjoying life, Lonely and Challenge” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group6">SKEPTICAL</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Worried, Critical on life, Cynical on money, Information seekers (on labels), Non career Minded” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group7">RESTLESS</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Restless (tend to dislike a regular pattern of life), No confidence” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group8">APATHETIC</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group8" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Non Opinioned (goes with the flow), Career is important, Believe in gender equal opportunities” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group9">MATERIAL COMFORT</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group9" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Makin good money and financially secured, Not price conscious, Appearance concerns” 
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group10">OPTIMIST</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group10" class="panel-collapse collapse">
                                <div class="panel-body">
                                    “Trusting, Do not fear failure, Outspoken, Health Conscious” 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="panel panel-flat">
        <div class="panel-body">
            <div id="showData"></div>   
        </div>
    </div>

    <div class="panel panel-warning">
        <div class="panel-heading">
            <h5 class="text-center">Competitive MAP</h5>
        </div>
        <div class="panel-body">
            <form id="formCompetitive" onsubmit="return false">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <input type="text" name="category" id="category" class="remote-data-category">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <input type="text" name="brand" id="brand2" class="remote-data-brand-compare">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Compare With</label>
                            <input type="text" name="compare" id="compare2" class="remote-data-brand-competitive">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="control-label">Quartal</label>
                            <select name="quartal" class="form-control">
                                <option value="42017">42017</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <button class="btn btn-primary" style="margin-top:25px;">
                                <i class="icon-filter4"></i>
                                Filter 
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div id="competitiveMap"></div>
        </div>
    </div>

    
@stop
var data_trend=[];
var last_two_data=[];
var input_volt_l2n_r=[];
var input_volt_l2n_y=[];
var input_volt_l2n_b=[];
var input_volt_l2n_avg=[];
var limit_slice=0;
function setupWebSocket() {
  var ws = new WebSocket('wss://srpmonitoringcambay.com/ws2/'); // Change the URL to your WebSocket server
  var well_id=document.getElementById('hdn_well_id').value;
  ws.onopen = function() {
    console.log('WebSocket connected');
    ws.send(JSON.stringify({ action : 'subscribe' , topic : well_id}));
  };

  ws.onmessage = function(event) {
    if(event.data!=null){
      //debugger
      var temp_data=JSON.parse(event.data).message;
      var final_data=JSON.parse(temp_data);
      console.log('Message from server ',final_data);
      let last_date_time=final_data.offline_device_timestamp;
      let device_last_status=parseInt(final_data.device_last_status);
      let power_supply=parseFloat(final_data.smps_Voltage)>5?1:0;
      let olr_status=parseInt(final_data.olr_status);
      let elr_status=parseInt(final_data.elr_status);;
      let spp_fault=parseInt(final_data.spp_status);;
      let upper_out_thresold_current=0;
      let lower_out_thresold_current=0;
      let smps_voltage=parseFloat(final_data.smps_Voltage);
      let battery_voltage=parseFloat(final_data.battery_Voltage);
      let output_Voltage_L2N_R=parseFloat(final_data.output_Voltage_L2N_R);
      let output_Voltage_L2N_Y=parseFloat(final_data.output_Voltage_L2N_Y);
      let output_Voltage_L2N_B=parseFloat(final_data.output_Voltage_L2N_B);
      let output_Average_Voltage_L2N=parseFloat(final_data.output_Average_Voltage_L2N);
      let output_Voltage_P2P_RY=parseFloat(final_data.output_Voltage_P2P_RY);
      let output_Voltage_P2P_YB=parseFloat(final_data.output_Voltage_P2P_YB);
      let output_Voltage_P2P_BR=parseFloat(final_data.output_Voltage_P2P_BR);
      let output_Average_Voltage_P2P=parseFloat(final_data.output_Average_Voltage_P2P);
      let output_Current_R=parseFloat(final_data.output_Current_R);
      let output_Current_Y=parseFloat(final_data.output_Current_Y);
      let output_Current_B=parseFloat(final_data.output_Current_B);
      let output_Average_Current=parseFloat(final_data.output_Average_Current);
      let Frequecy=parseFloat(final_data.output_System_Frequency);
      let active_power=parseFloat(final_data.output_System_Running_KW);
      let power_factor=parseFloat(final_data.output_System_PowerFactor1);
      $('#out_p2p_voltage').text(output_Average_Voltage_P2P);
      $('#out_avg_current').text(output_Average_Current);
      $('#output_Voltage_P2PRY').text(output_Voltage_P2P_RY);
      $('#output_Voltage_P2PYB').text(output_Voltage_P2P_YB);
      $('#output_Voltage_P2PBR').text(output_Voltage_P2P_BR);
      $('#out_p2p_average_voltage').text(output_Average_Voltage_P2P);
      $('#outputCurrent_R').text(output_Current_R);
      $('#outputCurrent_Y').text(output_Current_Y);
      $('#outputCurrent_B').text(output_Current_B);
      $('#outputAverage_Current').text(output_Average_Current);
      $('#frequency_output').text(Frequecy);
      $('#active_power_output').text(active_power);
      $('#power_factor_output').text(power_factor);
      $('#olr_fault').text((olr_status==1?'Healthy':'Faulty'));
      $('#olr_fault').css("color",(olr_status==1?'green':'red'));
      $('#elr_fault').text((elr_status==1?'Healthy':'Faulty'));
      $('#elr_fault').css("color",(elr_status==1?'green':'red'));
      $('#spp_fault').text((spp_fault==1?'Healthy':'Faulty'));
      $('#spp_fault').css("color",(spp_fault==1?'green':'red'));
      $('#battery_voltage_count').text(battery_voltage);
      $('#smps_voltage_field').text(smps_voltage);
      $('#battery_voltage').text(battery_voltage);
      $('#smps_voltage').text(smps_voltage);
      var well_running=parseInt(document.getElementById('hdn_well_running').value);
      var well_no=document.getElementById('hdn_well_name').value;
      var table = document.getElementById('alert_table');
      var rowCount =  parseInt(table.rows.length);
      var avg_output_current_ut=parseFloat(document.getElementById('out_current_ut').value);
      var avg_output_current_lt=parseFloat(document.getElementById('out_current_lt').value);
      var last_alert=document.getElementById('input_hdn_last_alert').value;
      var last_alert_datetime=document.getElementById('input_hdn_last_datetime').value;
      var timediff=60;
      if(last_alert_datetime!=''){
        //console.log(last_alert_datetime);
        var l_date_time=new Date(last_alert_datetime);
        var today = new Date();
        //console.log(today);
        var diffMs = (today-l_date_time);
        timediff = Math.round(((diffMs % 86400000) % 3600000) / 60000);
        //console.log(timediff);
      }
      if(output_Average_Current>0 && output_Average_Current<=avg_output_current_lt){
          if(last_alert!='Low Current'){
              let msg=well_no +' Crossed Low Current Thresold at  ' + last_date_time +' Current is  ' +output_Average_Current +' Amp';
              $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>Low Current</td><td>' + msg +'</td><td>'+ last_date_time+'</td></tr>');
              swal('Alert',msg,'warning');
              document.getElementById('input_hdn_last_alert').value='Low Current';
              document.getElementById('input_hdn_last_datetime').value=last_date_time;
          }else if(last_alert=='Low Current' && timediff>=60){
              let msg=well_no +' Crossed Low Current Thresold at  ' + last_date_time +' Current is  ' +output_Average_Current +' Amp';
              $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>Low Current</td><td>' + msg +'</td><td>'+ last_date_time+'</td></tr>');
              swal('Alert',msg,'warning');
              document.getElementById('input_hdn_last_alert').value='Low Current';
              document.getElementById('input_hdn_last_datetime').value=last_date_time;
          }
      }
      if(output_Average_Current>=avg_output_current_ut){
          if(last_alert!='High Current'){
              let msg=well_no +' Crossed High Current Thresold at  ' + last_date_time +' Current is  ' +output_Average_Current +' Amp';
              $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>High Current</td><td>' + msg +'</td><td>'+ last_date_time+'</td></tr>');
              swal('Alert',msg,'error');
              document.getElementById('input_hdn_last_alert').value='High Current';
              document.getElementById('input_hdn_last_datetime').value=last_date_time;
          }else if(last_alert=='High Current' && timediff>=60){
              let msg=well_no +' Crossed High Current Thresold at  ' + last_date_time +' Current is  ' +output_Average_Current +' Amp';
              $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>High Current</td><td>' + msg +'</td><td>'+ last_date_time+'</td></tr>');
              swal('Alert',msg,'error');
              document.getElementById('input_hdn_last_alert').value='High Current';
              document.getElementById('input_hdn_last_datetime').value=last_date_time;
          }
      }
      var current_status='';
    if(parseFloat(output_Average_Current)>0){
        if(well_running==0){
            current_status="Started"
            document.getElementById('hdn_well_running').value=1;
            let msg=well_no +' Started at ' + last_date_time;
            $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>Started</td><td>' + last_date_time +'</td></tr>');
            swal('Alert',msg,'info');
        }
    }else{
        if(last_two_data.length>=1){
            if(parseFloat(output_Average_Current)<=0 && parseFloat(last_two_data[0])<=0 && well_running==1){
                current_status="Stopped"
                document.getElementById('hdn_well_running').value=0;
                let msg=well_no +' Stopped at ' + last_date_time;
                swal('Alert',msg,'error');
                $("#alert_table").append('<tr><td>'+(rowCount +1)+'</td><td>Stopped</td><td>' + last_date_time +'</td></tr>');
            }
        }
    }
    if(last_two_data.length<1)
        last_two_data.push(output_Average_Current); 
    else 
        {last_two_data.shift();last_two_data.push(output_Average_Current); }
      var selectedOption = document.getElementById("show_data").value;
      if(selectedOption==="1"){
        updateGuage(parseFloat(output_Voltage_L2N_R),0);
        updateGuage(parseFloat(output_Voltage_L2N_Y),1);
        updateGuage(parseFloat(output_Voltage_L2N_B),2);
        $('#out_l2n_r').text(output_Voltage_L2N_R);
        $('#out_l2n_y').text(output_Voltage_L2N_Y);
        $('#out_l2n_b').text(output_Voltage_L2N_B);
        input_volt_l2n_r.push({x:last_date_time,y:output_Voltage_L2N_R});
        input_volt_l2n_y.push({x:last_date_time,y:output_Voltage_L2N_Y});
        input_volt_l2n_b.push({x:last_date_time,y:output_Voltage_L2N_B});
        input_volt_l2n_avg.push({x:last_date_time,y:output_Average_Voltage_L2N});
      }
      if(selectedOption==="3"){
        updateGuage(parseFloat(output_Voltage_P2P_RY),3);
        updateGuage(parseFloat(output_Voltage_P2P_YB),4);
        updateGuage(parseFloat(output_Voltage_P2P_BR),5);
        $('#out_p2p_r').text(output_Voltage_P2P_RY);
        $('#out_p2p_y').text(output_Voltage_P2P_YB);
        $('#out_p2p_b').text(output_Voltage_P2P_BR);
        input_volt_l2n_r.push({x:last_date_time,y:output_Voltage_P2P_RY});
        input_volt_l2n_y.push({x:last_date_time,y:output_Voltage_P2P_YB});
        input_volt_l2n_b.push({x:last_date_time,y:output_Voltage_P2P_BR});
        input_volt_l2n_avg.push({x:last_date_time,y:output_Average_Voltage_P2P});
      }
      if(selectedOption==="5"){
        updateGuage(parseFloat(output_Current_R),6);
        updateGuage(parseFloat(output_Current_Y),7);
        updateGuage(parseFloat(output_Current_B),8);
        $('#output_current_r').text(output_Current_R);
        $('#output_current_y').text(output_Current_Y);
        $('#output_current_b').text(output_Current_B);
        input_volt_l2n_r.push({x:last_date_time,y:output_Current_R});
        input_volt_l2n_y.push({x:last_date_time,y:output_Current_Y});
        input_volt_l2n_b.push({x:last_date_time,y:output_Current_B});
        input_volt_l2n_avg.push({x:last_date_time,y:output_Average_Current});
        
      } if(selectedOption==="2"){
       
        input_volt_l2n_r.push({x:last_date_time,y:battery_voltage});
        input_volt_l2n_y.push({x:last_date_time,y:battery_voltage});
        input_volt_l2n_b.push({x:last_date_time,y:battery_voltage});
        input_volt_l2n_avg.push({x:last_date_time,y:battery_voltage});
        
      } if(selectedOption==="4"){
       
        input_volt_l2n_r.push({x:last_date_time,y:smps_voltage});
        input_volt_l2n_y.push({x:last_date_time,y:smps_voltage});
        input_volt_l2n_b.push({x:last_date_time,y:smps_voltage});
        input_volt_l2n_avg.push({x:last_date_time,y:smps_voltage});
        
      }
      
    }  
  };

  ws.onerror = function(error) {
    console.log('WebSocket error: ' + error);
    // Handle the error if needed
  };

  ws.onclose = function(event) {
    console.log('WebSocket is closed. Attempting to reconnect...',event.code, event.reason);
    // Attempt to reconnect after a delay
    setTimeout(function() {
      setupWebSocket();
    }, 10000); // Reconnect after 10 second
  };
}
function getDateTime(varDateTime){
    let date_ob = new Date();
    let date = ("0" + date_ob.getDate()).slice(-2);
    let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
    let year = date_ob.getFullYear();
    let hours = date_ob.getHours();
    let minutes = date_ob.getMinutes();
    let seconds = date_ob.getSeconds();
    let dateTime=year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds;
    return dateTime;
  
  }
function loadchart(mychart, mytitle,name1,name2,name3,name4, minYVal,maxYVal) {
    var dataPoints1 = [];
    var dataPoints2 = [];
    var dataPoints3 = [];
    var dataPoints4 = [];

    var chart = new CanvasJS.Chart(mychart, {
        zoomEnabled: true,
        title: {
            text: mytitle,
            fontSize: 14
        },
        axisX:{  
            //Try Changing to MMMM
                          valueFormatString: "DD-MM-YYYY HH:mm:ss",
                          labelFontSize: 9,
                          labelAutoFit: true,
                          labelAngle: 180,
                  },
        axisY:{
            prefix: " ",
            labelFontSize: 9,
        }, 
        toolTip: {
            shared: true
        },
        legend: {
            cursor:"pointer",
            verticalAlign: "top",
            fontSize: 16,
            fontColor: "dimGrey",
            itemclick : toggleDataSeries
        },
        data: [{ 
            type: "line",
            xValueType: "dateTime",
            xValueFormatString: "DD-MM-YYYY HH:mm:ss",
            showInLegend: true,
            name: name1,
            dataPoints: dataPoints1
            },
            {       
                type: "line",
                xValueType: "dateTime",
                xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                showInLegend: true,
                name: name2 ,
                dataPoints: dataPoints2
            },
            {       
                type: "line",
                xValueType: "dateTime",
                xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                showInLegend: true,
                name: name3 ,
                dataPoints: dataPoints3
            },
            {       
                type: "line",
                xValueType: "dateTime",
                xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                showInLegend: true,
                name: name4 ,
                dataPoints: dataPoints4
        }]
    });
    chart.options.data[0].visible = false;
    chart.options.data[1].visible = false;
    chart.options.data[2].visible = false;     
    function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else {
            e.dataSeries.visible = true;
        }
        chart.render();
    }
    
    var updateInterval = 1000;
    function updateChart() {
      
        console.log('Limit',limit_slice);
        for (var i = 0; i < input_volt_l2n_r.length; i++) {
                var yValue1 = parseFloat(input_volt_l2n_r[i].y);
                var yValue2 = parseFloat(input_volt_l2n_y[i].y);
                var yValue3 = parseFloat(input_volt_l2n_b[i].y);
                var yValue4 = parseFloat(input_volt_l2n_avg[i].y);
                var xValue1 =new Date(input_volt_l2n_r[i].x).getTime();
                var xValue2 =new Date(input_volt_l2n_y[i].x).getTime();
                var xValue3 =new Date(input_volt_l2n_b[i].x).getTime();
                var xValue4 =new Date(input_volt_l2n_avg[i].x).getTime();
                var prevlnr=0;
                var nextlnr=0;
                var prevlny=0;
                var nextlny=0;
                var prevlnb=0;
                var nextlnb=0;
                var prevAvg=0;
                var nextAvg=0;
                if(i>0){
                    prevlnr=parseFloat(input_volt_l2n_r[i-1].y);
                    prevlny=parseFloat(input_volt_l2n_y[i-1].y);
                    prevlnb=parseFloat(input_volt_l2n_b[i-1].y);
                    prevAvg=parseFloat(input_volt_l2n_avg[i-1].y);
                } 
                if(i<input_volt_l2n_r.length-1){
                    nextlnr=parseFloat(input_volt_l2n_r[i+1].y);
                    nextlny=parseFloat(input_volt_l2n_y[i+1].y);
                    nextlnb=parseFloat(input_volt_l2n_b[i+1].y);
                    nextAvg=parseFloat(input_volt_l2n_avg[i+1].y);
                }   
                if(dataPoints1.length<limit_slice){
                   if(!(prevlnr>0 && parseFloat(input_volt_l2n_r[i].y)<=0 && nextlnr>0)){
                    dataPoints1.push({
                        x: xValue1,
                        y: yValue1
                   });   
                  }
                  if(!(prevlny>0 && parseFloat(input_volt_l2n_y[i].y)<=0 && nextlny>0)){
                    dataPoints2.push({
                        x: xValue2,
                        y: yValue2
                    });
                  }
                  if(!(prevlnb>0 && parseFloat(input_volt_l2n_b[i].y)<=0 && nextlnb>0)){
                    dataPoints3.push({
                        x: xValue3,
                        y: yValue3
                    });
                  }
                   if(!(prevAvg>0 && parseFloat(input_volt_l2n_avg[i].y)<=0 && nextAvg>0)){
                        dataPoints4.push({
                            x: xValue4,
                            y: yValue4
                        });
                   }
                   
                }else{
                    if(!(prevlnr>0 && parseFloat(input_volt_l2n_r[i].y)<=0 && nextlnr>0)){
                        dataPoints1.shift();
                        dataPoints1.push({
                            x: xValue1,
                            y: yValue1
                       });   
                      }
                      if(!(prevlny>0 && parseFloat(input_volt_l2n_y[i].y)<=0 && nextlny>0)){
                        dataPoints2.shift();
                        dataPoints2.push({
                            x: xValue2,
                            y: yValue2
                        });
                      }
                      if(!(prevlnb>0 && parseFloat(input_volt_l2n_b[i].y)<=0 && nextlnb>0)){
                        dataPoints3.shift();
                        dataPoints3.push({
                            x: xValue3,
                            y: yValue3
                        });
                      }
                       if(!(prevAvg>0 && parseFloat(input_volt_l2n_avg[i].y)<=0 && nextAvg>0)){
                        dataPoints4.shift();    
                        dataPoints4.push({
                                x: xValue4,
                                y: yValue4
                            });
                       }
                  
                   
                
            }
                
        }
        // console.log(dataPoints1);
        //  console.log(dataPoints2);
        //   console.log(dataPoints3);
        //    console.log(dataPoints3);
        // updating legend text with  updated with y Value 
        chart.options.data[0].legendText = name1+ yValue1;
        chart.options.data[1].legendText = name2+ yValue2; 
        chart.options.data[2].legendText = name3+ yValue3;
        chart.options.data[3].legendText = name4+ yValue4; 
        chart.render();
    }
    // generates first set of dataPoints 
    updateChart();
    setInterval(function(){updateChart()}, updateInterval);
    
}
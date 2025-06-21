/// MQTT Start

var mqtt;
var data_trend=[];
var reconnectTimeout = 1000;
var host = "mc.vidaniautomations.com"; //change this
var port = 20012;
var last_two_data=[];
var input_volt_l2n_r=[];
var input_volt_l2n_y=[];
var input_volt_l2n_b=[];
var input_volt_l2n_avg=[];
var limit_slice=0;
function onFailure(message) {
    console.log("Connection Attempt to Host " + host + " is Failed");
    setTimeout(MQTTconnect, reconnectTimeout);
}
function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:" + responseObject.errorMessage);
    }
    MQTTconnect();
    console.log(responseObject);
}
function onConnect() {
    // Once a connection has been made, make a subscription and send a message.
    console.log("Connected");
    var imei_no=document.getElementById('hdn_imei_no').value;
    mqtt.subscribe("vidani/vm/"+imei_no+"/data");
}
function sendmsg(switchId, command) {
    // MQTTconnect();
    setTimeout(() => {
        message = new Paho.MQTT.Message(JSON.stringify(text));
        message.destinationName = topic + imei;
        console.log(message);
        mqtt.send(message);
    }, 500);
}
function MQTTconnect() {
    console.log("connecting to " + host + " " + port);
    mqtt = new Paho.MQTT.Client(host, port, Math.random().toString());
    //document.write("connecting to "+ host);
    var options = {
        timeout: 3,
        onSuccess: onConnect,
        onFailure: onFailure,
        userName: "z",
        password: "2acc", 
    };
    mqtt.onMessageArrived = onMessageArrived
    mqtt.onConnectionLost = onConnectionLost;
    mqtt.connect(options); //connect
}
function dec2bin(dec) {
    return (dec >>> 0).toString(2);
}
function BinToFloat32(str) {
    var int = parseInt(str, 2);
    if (int > 0 || int < 0) {
        var sign = (int >>> 31) ? -1 : 1;
        var exp = (int >>> 23 & 0xff) - 127;
        var mantissa = ((int & 0x7fffff) + 0x800000).toString(2);
        var float32 = 0
        for (i = 0; i < mantissa.length; i += 1) {
            float32 += parseInt(mantissa[i]) ? Math.pow(2, exp) : 0;
            exp--
        }
        return float32 * sign;
    } else return 0
}
function onMessageArrived(bufferdata) {
    
    const imei_no = bufferdata.destinationName.split("/")[2];
    const data = [...bufferdata.payloadBytes];
    var dttime=getDateTime();
    //document.getElementById('connecting').style.display = 'none';
    //console.log(imei, data);
    const result = []
    let i = 0;
    for (let index = 0; index < 1000; index++) {
        const st = data[index];
        const nd = data[++index];
        const rd = data[++index];
        const th = data[++index];
        result.push((BinToFloat32(dec2bin((rd * 256 + th) * 65536 + (st * 256 + nd)))).toFixed(2));
        
    }
    let device_last_status=0;
    let power_supply=0;
    let vfd_status_normal=0;
    let vfd_status_trip=0;
    let in_over_voltage=0;
    let in_under_voltage=0;
    let out_over_current=0;
    let out_under_current=0;
    let olr_status=0;
    let elr_status=0;
    let spp_fault=0;
    let phase_overload=0;
    let upper_out_thresold_current=0;
    let lower_out_thresold_current=0;
    let upper_in_thresold_voltage=270;
    let lower_in_thresold_voltage=180;
    let input_run=parseInt(data[1200])+parseInt(data[1201])+parseInt(data[1202]);
    let output_run=parseInt(data[1203])+parseInt(data[1204])+parseInt(data[1205]);
    let smps_voltage=parseFloat((data[1050]*256+data[1051])*0.01).toFixed(2);
    let input_Average_Voltage_L2N=parseFloat(parseFloat(result[12])+parseFloat(result[13])).toFixed(2);
    let input_Voltage_L2N_R=parseFloat(parseFloat(result[6])+parseFloat(result[7])).toFixed(2);
    let input_Voltage_L2N_Y=parseFloat(parseFloat(result[8])+parseFloat(result[9])).toFixed(2);
    let input_Voltage_L2N_B=parseFloat(parseFloat(result[10])+parseFloat(result[11])).toFixed(2);
    // let input_Kwh=parseFloat(parseFloat(result[0])+parseFloat(result[1])).toFixed(2); //active energy
    // let input_Kvah=parseFloat(parseFloat(result[2])+parseFloat(result[3])).toFixed(2);
    // let input_Kvarh=parseFloat(parseFloat(result[4])+parseFloat(result[5])).toFixed(2);
    let input_Voltage_P2P_RY=parseFloat(parseFloat(result[14])+parseFloat(result[15])).toFixed(2);
    let input_Voltage_P2P_YB=parseFloat(parseFloat(result[16])+parseFloat(result[17])).toFixed(2);
    let input_Voltage_P2P_BR=parseFloat(parseFloat(result[18])+parseFloat(result[19])).toFixed(2);
    let input_Average_Voltage_P2P=parseFloat(parseFloat(result[20])+parseFloat(result[21])).toFixed(2);
    let input_Current_R=parseFloat(parseFloat(result[22])+parseFloat(result[23])).toFixed(2);
    let input_Current_Y=parseFloat(parseFloat(result[24])+parseFloat(result[25])).toFixed(2);
    let input_Current_B=parseFloat(parseFloat(result[26])+parseFloat(result[27])).toFixed(2);
    let input_Average_Current=parseFloat(parseFloat(result[28])+parseFloat(result[29])).toFixed(2);
    // let input_System_PowerFactor=parseFloat(result[33]).toFixed(2);
    // let input_System_PowerFactor1=parseFloat(result[34]).toFixed(2);
    // let input_System_Frequency=parseFloat(result[35]).toFixed(2);
    // let input_System_Running_KW=parseFloat(result[42]).toFixed(2); //active power
    // let input_Total_Kva=parseFloat(result[50]).toFixed(2);
    // let input_Total_Kvar=parseFloat(result[58]).toFixed(2);
    // let input_Load_Hour=parseFloat(result[60]).toFixed(2);
    // let input_Load_Minute=parseFloat(result[61]).toFixed(2);
    // let input_NoLoad_Hour=parseFloat(result[62]).toFixed(2);
    // let input_NoLoad_Minute=parseFloat(result[63]).toFixed(2);
    // let input_System_Motor_RPM=parseFloat(result[64]).toFixed(2);
    ////output
    // let output_Kwh=parseFloat(parseFloat(result[80])+parseFloat(result[81])).toFixed(2); //active energy
    // let output_Kvah=parseFloat(parseFloat(result[82])+parseFloat(result[83])).toFixed(2);
    // let output_Kvarh=parseFloat(parseFloat(result[84])+parseFloat(result[85])).toFixed(2);
    let output_Voltage_L2N_R=parseFloat(parseFloat(result[86])+parseFloat(result[87])).toFixed(2);
    let output_Voltage_L2N_Y=parseFloat(parseFloat(result[88])+parseFloat(result[89])).toFixed(2);
    let output_Voltage_L2N_B=parseFloat(parseFloat(result[90])+parseFloat(result[91])).toFixed(2);
    let output_Average_Voltage_L2N=parseFloat(parseFloat(result[92])+parseFloat(result[93])).toFixed(2);
    let output_Voltage_P2P_RY=parseFloat(parseFloat(result[94])+parseFloat(result[95])).toFixed(2);
    let output_Voltage_P2P_YB=parseFloat(parseFloat(result[96])+parseFloat(result[97])).toFixed(2);
    let output_Voltage_P2P_BR=parseFloat(parseFloat(result[98])+parseFloat(result[99])).toFixed(2);
    let output_Average_Voltage_P2P=parseFloat(parseFloat(result[100])+parseFloat(result[101])).toFixed(2);
    let output_Current_R=parseFloat(parseFloat(result[102])+parseFloat(result[103])).toFixed(2);
    let output_Current_Y=parseFloat(parseFloat(result[104])+parseFloat(result[105])).toFixed(2);
    let output_Current_B=parseFloat(parseFloat(result[106])+parseFloat(result[107])).toFixed(2);
    let output_Average_Current=parseFloat(parseFloat(result[108])+parseFloat(result[109])).toFixed(2);
    // let output_System_PowerFactor=parseFloat(result[113]).toFixed(2);
    // let output_System_PowerFactor1=parseFloat(result[114]).toFixed(2);
    // let output_System_Frequency=parseFloat(result[115]).toFixed(2);
    // let output_System_Running_KW=parseFloat(result[122]).toFixed(2); //active power
    // let output_Total_Kva=parseFloat(result[130]).toFixed(2);
    // let output_Total_Kvar=parseFloat(result[138]).toFixed(2);
    // let output_Load_Hour=parseFloat(result[140]).toFixed(2);
    // let output_Load_Minute=parseFloat(result[141]).toFixed(2);
    // let output_NoLoad_Hour=parseFloat(result[142]).toFixed(2);
    // let output_NoLoad_Minute=parseFloat(result[143]).toFixed(2);
    // let output_System_Motor_RPM=parseFloat(result[144]).toFixed(2);
    // let battery_Voltage=parseFloat((data[1052]*256+data[1053])*0.01).toFixed(2);
    $('#inp_p2p_voltage').text(input_Average_Voltage_P2P);
	$('#out_p2p_voltage').text(output_Average_Voltage_P2P);
    $('#inp_avg_current').text(input_Average_Current);
    $('#out_avg_current').text(output_Average_Current);
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
        console.log(timediff);
    }
    if(output_Average_Current>0 && output_Average_Current<=avg_output_current_lt){
        if(last_alert!='Low Current'){
            let msg=well_no +' Crossed Low Current Thresold at  ' + dttime +' Current is  ' +output_Average_Current +' Amp';
            //$("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>Low Current</td><td>' + msg +'</td><td>'+ dttime+'</td></tr>');
            swal('Alert',msg,'warning');
            document.getElementById('input_hdn_last_alert').value='Low Current';
            document.getElementById('input_hdn_last_datetime').value=dttime;
        }else if(last_alert=='Low Current' && timediff>=60){
            let msg=well_no +' Crossed Low Current Thresold at  ' + dttime +' Current is  ' +output_Average_Current +' Amp';
            //$("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>Low Current</td><td>' + msg +'</td><td>'+ dttime+'</td></tr>');
            swal('Alert',msg,'warning');
            document.getElementById('input_hdn_last_alert').value='Low Current';
            document.getElementById('input_hdn_last_datetime').value=dttime;
        }
    }
    if(output_Average_Current>=avg_output_current_ut){
        if(last_alert!='High Current'){
            let msg=well_no +' Crossed High Current Thresold at  ' + dttime +' Current is  ' +output_Average_Current +' Amp';
            $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>High Current</td><td>' + msg +'</td><td>'+ dttime+'</td></tr>');
            swal('Alert',msg,'error');
            document.getElementById('input_hdn_last_alert').value='High Current';
            document.getElementById('input_hdn_last_datetime').value=dttime;
        }else if(last_alert=='High Current' && timediff>=60){
            let msg=well_no +' Crossed High Current Thresold at  ' + dttime +' Current is  ' +output_Average_Current +' Amp';
            $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>High Current</td><td>' + msg +'</td><td>'+ dttime+'</td></tr>');
            swal('Alert',msg,'error');
            document.getElementById('input_hdn_last_alert').value='High Current';
            document.getElementById('input_hdn_last_datetime').value=dttime;
        }
    }
    // console.log('Average Current',output_Average_Current);
    // console.log('ut',avg_output_current_ut);
    // console.log('lt',avg_output_current_lt);
    // console.log('ut warning',avg_output_current_ut_warning);
    // console.log('lt warning',avg_output_current_lt_warning);
    // //console.log('row',rowCount);
    // console.log(well_no);
    var current_status='';
    if(parseFloat(output_Average_Current)>0){
        if(well_running==0){
            current_status="Started"
            document.getElementById('hdn_well_running').value=1;
            let msg=well_no +' Started at ' + dttime;
            $("#alert_table").append('<tr><td>'+(rowCount+1)+'</td><td>Started</td><td>' + dttime +'</td></tr>');
            swal('Alert',msg,'info');
        }
    }else{
        if(last_two_data.length>=1){
            if(parseFloat(output_Average_Current)<=0 && parseFloat(last_two_data[0])<=0 && well_running==1){
                current_status="Stopped"
                document.getElementById('hdn_well_running').value=0;
                let msg=well_no +' Stopped at ' + dttime;
                swal('Alert',msg,'error');
                $("#alert_table").append('<tr><td>'+(rowCount +1)+'</td><td>Stopped</td><td>' + dttime +'</td></tr>');
            }
        }
    }
    if(last_two_data.length<1)
        last_two_data.push(output_Average_Current); 
    else 
        {last_two_data.shift();last_two_data.push(output_Average_Current); }
    if(smps_voltage>5) {
    power_supply=1;
    }
    if((output_run<147) && (input_Average_Voltage_L2N<upper_in_thresold_voltage) && (input_Average_Voltage_L2N>lower_in_thresold_voltage)){
    vfd_status_normal=1;
    vfd_status_trip=0;
    }
    if((output_run<147) && ((input_Average_Voltage_L2N>upper_in_thresold_voltage) || (input_Average_Voltage_L2N<lower_in_thresold_voltage))){
    vfd_status_normal=0;
    vfd_status_trip=1;
    }
    if(input_Average_Voltage_L2N>upper_in_thresold_voltage){
    in_over_voltage=1;
    }
    if(input_Average_Voltage_L2N>0 && input_Average_Voltage_L2N<lower_in_thresold_voltage){
    in_under_voltage=1;
    }
    if(output_Average_Current>upper_out_thresold_current){
    out_over_current=1;
    phase_overload=1;
    }
    if(output_Average_Current>0 && output_Average_Current<lower_out_thresold_current){
    out_under_current=1;
    }
    if(input_Voltage_L2N_R<=0 || input_Voltage_L2N_Y<=0 || input_Voltage_L2N_B<=0){
    spp_fault=1;
    }
    if(output_Average_Current>0){
        device_last_status=1;
    }
    var selectedOption = document.getElementById("show_data").value;
    if(selectedOption==="0"){
        updateGuage(parseFloat(input_Voltage_L2N_R),0);
        updateGuage(parseFloat(input_Voltage_L2N_Y),1);
        updateGuage(parseFloat(input_Voltage_L2N_B),2);
        $('#inp_l2n_r').text(input_Voltage_L2N_R);
	    $('#inp_l2n_y').text(input_Voltage_L2N_Y);
	    $('#inp_l2n_b').text(input_Voltage_L2N_B);
        input_volt_l2n_r.push({x:getDateTime(),y:input_Voltage_L2N_R});
        input_volt_l2n_y.push({x:getDateTime(),y:input_Voltage_L2N_Y});
        input_volt_l2n_b.push({x:getDateTime(),y:input_Voltage_L2N_B});
        input_volt_l2n_avg.push({x:getDateTime(),y:input_Average_Voltage_L2N});
    }
    if(selectedOption==="1"){
        updateGuage(parseFloat(output_Voltage_L2N_R),3);
        updateGuage(parseFloat(output_Voltage_L2N_Y),4);
        updateGuage(parseFloat(output_Voltage_L2N_B),5);
        $('#out_l2n_r').text(output_Voltage_L2N_R);
        $('#out_l2n_y').text(output_Voltage_L2N_Y);
        $('#out_l2n_b').text(output_Voltage_L2N_B);
        input_volt_l2n_r.push({x:getDateTime(),y:output_Voltage_L2N_R});
        input_volt_l2n_y.push({x:getDateTime(),y:output_Voltage_L2N_Y});
        input_volt_l2n_b.push({x:getDateTime(),y:output_Voltage_L2N_B});
        input_volt_l2n_avg.push({x:getDateTime(),y:output_Average_Voltage_L2N});
    }
    if(selectedOption==="2"){
        updateGuage(parseFloat(input_Voltage_P2P_RY),6);
        updateGuage(parseFloat(input_Voltage_P2P_YB),7);
        updateGuage(parseFloat(input_Voltage_P2P_BR),8);
        $('#inp_p2p_r').text(input_Voltage_P2P_RY);
	    $('#inp_p2p_y').text(input_Voltage_P2P_YB);
	    $('#inp_p2p_b').text(input_Voltage_P2P_BR);
        input_volt_l2n_r.push({x:getDateTime(),y:input_Voltage_P2P_RY});
        input_volt_l2n_y.push({x:getDateTime(),y:input_Voltage_P2P_YB});
        input_volt_l2n_b.push({x:getDateTime(),y:input_Voltage_P2P_BR});
        input_volt_l2n_avg.push({x:getDateTime(),y:input_Average_Voltage_P2P});
    }
    if(selectedOption==="3"){
        updateGuage(parseFloat(output_Voltage_P2P_RY),9);
        updateGuage(parseFloat(output_Voltage_P2P_YB),10);
        updateGuage(parseFloat(output_Voltage_P2P_BR),11);
        $('#out_p2p_r').text(output_Voltage_P2P_RY);
        $('#out_p2p_y').text(output_Voltage_P2P_YB);
        $('#out_p2p_b').text(output_Voltage_P2P_BR);
        input_volt_l2n_r.push({x:getDateTime(),y:output_Voltage_P2P_RY});
        input_volt_l2n_y.push({x:getDateTime(),y:output_Voltage_P2P_YB});
        input_volt_l2n_b.push({x:getDateTime(),y:output_Voltage_P2P_BR});
        input_volt_l2n_avg.push({x:getDateTime(),y:output_Average_Voltage_P2P});
    }
    if(selectedOption==="4"){
        updateGuage(parseFloat(input_Current_R),12);
        updateGuage(parseFloat(input_Current_Y),13);
        updateGuage(parseFloat(input_Current_B),14);
        $('#input_current_r').text(input_Current_R);
        $('#input_current_y').text(input_Current_Y);
        $('#input_current_b').text(input_Current_B);
        input_volt_l2n_r.push({x:getDateTime(),y:input_Current_R});
        input_volt_l2n_y.push({x:getDateTime(),y:input_Current_Y});
        input_volt_l2n_b.push({x:getDateTime(),y:input_Current_B});
        input_volt_l2n_avg.push({x:getDateTime(),y:input_Average_Current});
    }
    if(selectedOption==="5"){
        updateGuage(parseFloat(output_Current_R),15);
        updateGuage(parseFloat(output_Current_Y),16);
        updateGuage(parseFloat(output_Current_B),17);
        $('#output_current_r').text(output_Current_R);
        $('#output_current_y').text(output_Current_Y);
        $('#output_current_b').text(output_Current_B);
        input_volt_l2n_r.push({x:getDateTime(),y:output_Current_R});
        input_volt_l2n_y.push({x:getDateTime(),y:output_Current_Y});
        input_volt_l2n_b.push({x:getDateTime(),y:output_Current_B});
        input_volt_l2n_avg.push({x:getDateTime(),y:output_Average_Current});
        
    }
    ///Graph L2N  Input
  
    //Graph L2N Output

//////////////////    
}
/// MQTT END

function getDateTime(){
    let date_ob = new Date();
  // current date
  // adjust 0 before single digit date
  let date = ("0" + date_ob.getDate()).slice(-2);
  // current month
  let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
  // current year
  let year = date_ob.getFullYear();
  // current hours
  let hours = date_ob.getHours();
  // current minutes
  let minutes = date_ob.getMinutes();
  // current seconds
  let seconds = date_ob.getSeconds();
  // prints date in YYYY-MM-DD format
  //console.log(year + "-" + month + "-" + date);
  // prints date & time in YYYY-MM-DD HH:MM:SS format
  let dateTime=year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds;
  return dateTime;
  // prints time in HH:MM forma
  }

function loadchart(mychart, mytitle,name1,name2,name3,name4, minYVal,maxYVal) {
    var dataPoints1 = [];
    var dataPoints2 = [];
    var dataPoints3 = [];
    var dataPoints4 = [];
    //console.log(myvalue);
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
        // console.log(dataPoints1.length);
        // console.log(dataPoints2.length);
        // console.log(dataPoints3.length);
        // console.log(dataPoints4.length);
        // console.log('Limit',limit_slice);
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
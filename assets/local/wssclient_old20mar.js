var data_trend=[];
var last_two_data=[];
var input_volt_l2n_r=[];
var input_volt_l2n_y=[];
var input_volt_l2n_b=[];
var input_volt_l2n_avg=[];
var input_volt_l2n_tht =[];
var input_volt_l2n_battery =[];
var limit_slice=0;

function setupWebSocket() {
  var ws = new WebSocket('wss://rtmsankleshwar.com/ws2/'); 
  var well_id=document.getElementById('well_id').value;


  ws.onopen = function() {
    console.log('WebSocket connected');
    ws.send(JSON.stringify({ action : 'subscribe' ,topic: "mon_" + well_id,}));
    ws.send(JSON.stringify({ action : 'subscribe' ,topic: "sov_" + well_id,}));
  };

   ws.onmessage = function(event) {
        try {
            var responseData = JSON.parse(event.data);
            if (responseData && responseData.message) {
                var dataArray = JSON.parse(responseData.message);
                
                if (Array.isArray(dataArray) && dataArray.length > 0) {
                     updateGraph(dataArray);
                    var final_data = dataArray[dataArray.length - 1];
                   
                    if (final_data.sovstatus !== "started") {
                        updateUI(final_data);
                    }
                }
            }
        } catch (error) {
            console.error("Error parsing WebSocket message:", error);
        }
    };

 function updateUI(final_data) {
     // console.log(final_data,'Message from server');
      let last_date_time=final_data.rtc_date_time;
      let bv=parseFloat(final_data.bv).toFixed(2);
      let bvf= parseInt(final_data.bvf);
      let doors= parseInt(final_data.doors);
      let lat= parseFloat(final_data.lat);
      let lng= parseFloat(final_data.lng);
      let off_time= parseInt(final_data.offt);
      let on_time= parseInt(final_data.ont);
      let psf1= parseInt(final_data.psf1);
      let psf2= parseInt(final_data.psf2);
      let psf3= parseInt(final_data.psf3);
      let psf4= parseInt(final_data.psf4);
      let sf= parseInt(final_data.sf);
      let trgt= final_data.trgt;
      let next_cycle = final_data.next_injection_cycle;
      let last_cycle = final_data.prev_injection_cycle;
      let tsf= parseInt(final_data.tsf);
      let rtc_date_time= final_data.rtc_date_time;
      let tht_image = parseFloat(final_data.ts1).toFixed(2);
      let thp_image=parseFloat(final_data.ps3).toFixed(2);
      let abp_image=parseFloat(final_data.ps4).toFixed(2);
      let chp_image=parseFloat(final_data.ps2).toFixed(2);
      let gip_image=parseFloat(final_data.ps1).toFixed(2);
      $('#battery_value').text(bv);
      $('#tht_image').text(tht_image);
      $('#thp_image').text(thp_image);
      $('#abp_image').text(abp_image);
      $('#chp_image').text(chp_image);
      $('#gip_image').text(gip_image);
      $('#last_updated_datetime').text(last_date_time);
      $('#on_time').text(on_time);
      $('#off_time').text(off_time);
      $('#targettime').text(trgt);
      $('#next_cycle').text(next_cycle);
      $('#last_cycle').text(last_cycle);
 
     
    }

function updateGraph(dataArray) 
{

    dataArray.forEach((data) => {
        let bv=parseFloat(data.bv).toFixed(2);
        let rtc_datetime = data.rtc_date_time;
        let output_chp = parseFloat(data.ps2).toFixed(2);
        let output_gip = parseFloat(data.ps1).toFixed(2);
        let output_thp = parseFloat(data.ps3).toFixed(2);
        let output_abp = parseFloat(data.ps4).toFixed(2);
        let output_tht = parseFloat(data.ts1).toFixed(2);
        let output_battery = parseFloat(data.bv).toFixed(2);

       var selectedOption = "1";
       if(selectedOption=== "1")
       {

        input_volt_l2n_r.push({ x: rtc_datetime, y: output_chp });
        input_volt_l2n_y.push({ x: rtc_datetime, y: output_gip });
        input_volt_l2n_b.push({ x: rtc_datetime, y: output_thp });
        input_volt_l2n_avg.push({ x: rtc_datetime, y: output_abp });
        input_volt_l2n_tht.push({ x: rtc_datetime, y: output_tht });
        input_volt_l2n_battery.push({ x: rtc_datetime, y: output_battery });
       }

    });

    updateChart();
}  
  

  ws.onerror = function(error) {
    console.log('WebSocket error: ' + error);
    
  };

   ws.onclose = function(event) {
    console.log('WebSocket is closed. Attempting to reconnect...',event.code, event.reason);
   
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

    function loadchart(mychart, mytitle, name1, name2, name3, name4,name5,name6, minYVal, maxYVal)
    {
        var dataPoints1 = [];
        var dataPoints2 = [];
        var dataPoints3 = [];
        var dataPoints4 = [];
        var dataPoints5 = [];
        var dataPoints6 = [];
   
        var chart = new CanvasJS.Chart(mychart, {
            zoomEnabled: true,
            title: {
                text: mytitle,
                fontSize: 14
            },
            axisX: {
              
                valueFormatString: "DD-MM-YYYY HH:mm:ss",
                labelFontSize: 9,
                labelAutoFit: true,
                labelAngle: 180,
            },
            axisY: {
                prefix: " ",
                labelFontSize: 9,
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                verticalAlign: "top",
                fontSize: 16,
                fontColor: "dimGrey",
                itemclick: toggleDataSeries
            },
            data: [{
                    type: "line",
                    xValueType: "dateTime",
                    xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                    showInLegend: true,
                    name: name1,
                    dataPoints: dataPoints1,
                    lineColor: '#ec344c',
                    color:'#ec344c',
                    legendMarkerColor: '#ec344c',
                    markerColor:'#ec344c'

                },
                {
                    type: "line",
                    xValueType: "dateTime",
                    xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                    showInLegend: true,
                    name: name2,
                    dataPoints: dataPoints2,
                    lineColor: '#f59440',
                    color:'#f59440',
                    legendMarkerColor: '#f59440',
                    markerColor:'#f59440'
                },
                {
                    type: "line",
                    xValueType: "dateTime",
                    xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                    showInLegend: true,
                    name: name3,
                    dataPoints: dataPoints3,
                    lineColor: '#287f71e0',
                    legendMarkerColor: '#287f71e0',
                    color:'#287f71e0',
                    markerColor:'#287f71e0'
                },
                {
                    type: "line",
                    xValueType: "dateTime",
                    xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                    showInLegend: true,
                    name: name4,
                    dataPoints: dataPoints4,
                    lineColor: '#402fd4',
                    legendMarkerColor: '#402fd4',
                    color:'#402fd4',
                    markerColor:'#402fd4'
                },

                {
                    type: "line",
                    xValueType: "dateTime",
                    xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                    showInLegend: true,
                    name: name5,
                    dataPoints: dataPoints5,
                    lineColor: '#2786f1',
                    legendMarkerColor: '#2786f1',
                    markerColor:'#2786f1',
                    color:'#2786f1'
                },
                {
                    type: "line",
                    xValueType: "dateTime",
                    xValueFormatString: "DD-MM-YYYY HH:mm:ss",
                    showInLegend: true,
                    name: name6,
                    dataPoints: dataPoints6,
                    lineColor: '#dd33ff',
                    legendMarkerColor: '#dd33ff',
                    markerColor:'#dd33ff',
                    color:'#dd33ff'
                   
                }
            ]
        });
          var chped = parseInt($('#chped').val());
          var thped = parseInt($('#thped').val());
          var abped = parseInt($('#abped').val());
          var giped = parseInt($('#giped').val());

            chart.options.data[0].visible = chped === 1; 
            chart.options.data[1].visible = giped === 1; 
            chart.options.data[2].visible = thped === 1;
            chart.options.data[3].visible = abped === 1; 
            chart.options.data[4].visible = false; 
            chart.options.data[5].visible = false; 

            chart.options.data[0].showInLegend = chped === 1;
            chart.options.data[1].showInLegend = giped === 1;
            chart.options.data[2].showInLegend = thped === 1;
            chart.options.data[3].showInLegend = abped === 1;
            chart.options.data[4].showInLegend = true; 
            chart.options.data[5].showInLegend = true; 


        function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }

        var updateInterval = 1000;
      
    function updateChart() {

            for (var i = 0; i < input_volt_l2n_r.length; i++) {
                var yValue1 = parseFloat(input_volt_l2n_r[i].y);
                var yValue2 = parseFloat(input_volt_l2n_y[i].y);
                var yValue3 = parseFloat(input_volt_l2n_b[i].y);
                var yValue4 = parseFloat(input_volt_l2n_avg[i].y);
                var yValue5 = parseFloat(input_volt_l2n_tht[i].y);
                var yValue6 = parseFloat(input_volt_l2n_battery[i].y);

                var xValue1 = new Date(input_volt_l2n_r[i].x).getTime();
                var xValue2 = new Date(input_volt_l2n_y[i].x).getTime();
                var xValue3 = new Date(input_volt_l2n_b[i].x).getTime();
                var xValue4 =new Date(input_volt_l2n_avg[i].x).getTime();
                var xValue5 =new Date(input_volt_l2n_tht[i].x).getTime();
                var xValue6 =new Date(input_volt_l2n_battery[i].x).getTime();

                var prevlnr = 0;
                var nextlnr = 0;
                var prevlny = 0;
                var nextlny = 0;
                var prevlnb = 0;
                var nextlnb = 0;
                var prevAvg = 0;
                var nextAvg = 0;
                var prevtht = 0;
                var nexttht = 0;
                var prevbattery = 0;
                var nextbattery = 0;

                if (i > 0) {
                    prevlnr = parseFloat(input_volt_l2n_r[i - 1].y);
                    prevlny = parseFloat(input_volt_l2n_y[i - 1].y);
                    prevlnb = parseFloat(input_volt_l2n_b[i - 1].y);
                    prevAvg=parseFloat(input_volt_l2n_avg[i-1].y);
                    prevtht=parseFloat(input_volt_l2n_tht[i-1].y);
                    prevbattery=parseFloat(input_volt_l2n_battery[i-1].y);
                }
                if (i < input_volt_l2n_r.length - 1) {
                    nextlnr = parseFloat(input_volt_l2n_r[i + 1].y);
                    nextlny = parseFloat(input_volt_l2n_y[i + 1].y);
                    nextlnb = parseFloat(input_volt_l2n_b[i + 1].y);
                    nextAvg=parseFloat(input_volt_l2n_avg[i+1].y);
                    nexttht=parseFloat(input_volt_l2n_tht[i+1].y);
                    nextbattery=parseFloat(input_volt_l2n_battery[i+1].y);
                }
                if (dataPoints1.length < limit_slice) {
                    if (!(prevlnr > 0 && parseFloat(input_volt_l2n_r[i].y) <= 0 && nextlnr > 0)) {
                        dataPoints1.push({
                            x: xValue1,
                            y: yValue1
                        });
                    }
                    if (!(prevlny > 0 && parseFloat(input_volt_l2n_y[i].y) <= 0 && nextlny > 0)) {
                        dataPoints2.push({
                            x: xValue2,
                            y: yValue2
                        });
                    }
                    if (!(prevlnb > 0 && parseFloat(input_volt_l2n_b[i].y) <= 0 && nextlnb > 0)) {
                        dataPoints3.push({
                            x: xValue3,
                            y: yValue3
                        });
                    }
                    if (!(prevAvg > 0 && parseFloat(input_volt_l2n_avg[i].y) <= 0 && nextAvg > 0)) {
                        dataPoints4.push({
                            x: xValue4,
                            y: yValue4
                        });
                    }
                    if (!(prevtht > 0 && parseFloat(input_volt_l2n_tht[i].y) <= 0 && nexttht > 0)) {
                        dataPoints5.push({
                            x: xValue5,
                            y: yValue5
                        });
                    }

                    if (!(prevbattery > 0 && parseFloat(input_volt_l2n_battery[i].y) <= 0 && nextbattery > 0)) {
                        dataPoints6.push({
                            x: xValue6,
                            y: yValue6
                        });
                    }

                   } else {
                    if (!(prevlnr > 0 && parseFloat(input_volt_l2n_r[i].y) <= 0 && nextlnr > 0)) {
                        dataPoints1.shift();
                        dataPoints1.push({
                            x: xValue1,
                            y: yValue1
                        });
                    }
                    if (!(prevlny > 0 && parseFloat(input_volt_l2n_y[i].y) <= 0 && nextlny > 0)) {
                        dataPoints2.shift();
                        dataPoints2.push({
                            x: xValue2,
                            y: yValue2
                        });
                    }
                    if (!(prevlnb > 0 && parseFloat(input_volt_l2n_b[i].y) <= 0 && nextlnb > 0)) {
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

                    if(!(prevtht>0 && parseFloat(input_volt_l2n_tht[i].y)<=0 && nexttht>0)){
                     dataPoints5.shift();    
                     dataPoints5.push({
                             x: xValue5,
                             y: yValue5
                         });
                    }

                    if(!(prevbattery>0 && parseFloat(input_volt_l2n_battery[i].y)<=0 && nextbattery>0)){
                     dataPoints6.shift();    
                     dataPoints6.push({
                             x: xValue6,
                             y: yValue6
                         });
                    }
                }

            }

            chart.options.data[0].legendText = name1 + yValue1;
            chart.options.data[1].legendText = name2 + yValue2;
            chart.options.data[2].legendText = name3 + yValue3;
            chart.options.data[3].legendText = name4 + yValue4; 
            chart.options.data[4].legendText = name5 + yValue5; 
            chart.options.data[5].legendText = name6 + yValue6; 
            chart.render();
        } 
        updateChart();
        setInterval(function() {
            updateChart()
        }, updateInterval);

    }



    
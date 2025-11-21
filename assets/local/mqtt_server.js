
console.log('hii');
const mqttUrl = "ws://dl.iotasonl.com:20012";
const client = mqtt.connect(mqttUrl, {
    username: "YOUR_MQTT_USERNAME",
    password: "YOUR_MQTT_PASSWORD",
    reconnectPeriod: 2000
});

client.on("connect", () => {
    console.log("MQTT Connected!");
});

client.on("error", (err) => {
    console.error("MQTT Error:", err);
});

function sendConfigCommand(command_data, imei_no) {

    if (!imei_no) {
        swal("Error", "IMEI is required!", "error");
        return;
    }

    if (!command_data) {
        swal("Error", "Command Data missing!", "error");
        return;
    }

    const payload = (command_data);
    const topic = `ongc/rj/${imei_no}/ack`;

    client.publish(topic, payload, { qos: 1 });

    console.log("Published Topic:", topic);
    console.log("Payload:", payload);

    swal("Success", "Command Sent Successfully!", "success");
}



#define LevelSensor A0 //define the analog pin for the sensor

#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif

#include <Wire.h>


//wireless network credentials
const char* ssid     = "AndroidAP";
const char* password = "egov0445";

// domain name where the file that update db is saved 
const char* serverName = "http://arduino-alcohol.000webhostapp.com/update_values.php";

// this variable is for confirming to the server that this is the endpoint that we want to post values from
String apiKeyValue = "tPmAT5Ab3j7F9";

int level; //initiate an empty variable for storing the water level data from sensor

void setup() {
  Serial.begin(115200);
  pinMode(LevelSensor,INPUT); 
  
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

}

void loop() {
  //Check WiFi connection status
  level=analogRead(A0); // read the analog pin A0 for data
  Serial.print("Sensor Level: "); 
  Serial.println(level);
  
  if(WiFi.status()== WL_CONNECTED){
    HTTPClient http;
    http.begin(serverName);
    
    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    // Prepare your HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + "&level=" + String(level);

    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);
        
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: "); // if it is 200, it means that the server responded "OK" to the request
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: "); //catch error
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 10 minutes
  delay(3000);  
}

//void levelMessage(level){
//  if (level )
//}


#include <ESP8266WiFi.h>
// ERROR //
// 101 can't connect
// 102 can't receive data from node
// 
////////////////////// CONFIG ///////////////////////

const char* ssid                  = "OHMAMP";
const char* password              = "a029453745";

const int rootId                  = 1;

IPAddress ipaddr                  = {192, 168,   1,  2};
IPAddress gateway                 = {192, 168,   1,  1};
IPAddress subnet                  = {255, 255, 255,  0};

////////////////////////////////////////////////////

String strInput = "";
String strNode[40] = "";
IPAddress server_ip      = {192,168,1,3};
const uint16_t port         = 8000;
WiFiServer server(8000);
WiFiClient client;
const int maxIp = 4;
int countAdd = 0;

void setup() {
  pinMode(LED_BUILTIN, OUTPUT);
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  Serial.println();
  Serial.print("Connecting to :");
  Serial.println(ssid);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(200);
    Serial.print(".");
  }
  WiFi.config(ipaddr, gateway, subnet);

  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  //server.begin();
  WiFiClient client;
  digitalWrite(LED_BUILTIN, HIGH);
}

void loop() {

  //  client = server.available();
  //  if (client) {
  //    //Serial.println("new client");
  //    for(int i=0 ; i<=100 ; i++){
  //      if (client.available()) {
  //        strInput = client.readStringUntil('\n');
  //        Serial.println(strInput);
  //        client.println(strInput.substring(0,9));
  //        break;
  //      }
  //      delay(50);
  //    }
  //    client.stop();
  //    digitalWrite(LED_BUILTIN,LOW);
  //    delay(100);
  //    digitalWrite(LED_BUILTIN,HIGH);
  //    //Serial.println("client disconnect");
  //  }
  for (int ip = 3 ; ip <= maxIp ; ip++) {
    server_ip[3] = ip;
    Serial.print("connect to : 192.168.1.");
    Serial.println(ip);
    
    int tmp = 0;
    while(!client.connect(server_ip, port)) {
      Serial.print(".");
      delay(200);
      tmp++;
      if(tmp == 5){
        Serial.println();
        String strTmp = "Node:";
        strTmp += ip-2; 
        strTmp += ",101ERROR";
        Serial.println(strTmp);
        goto endfor;
      }
    }
    client.print("require");
    Serial.println("send require");
    for (int i = 0 ; i <= 100 ; i++) {
      if (client.available()) {
        strInput = client.readStringUntil('\n');
        strNode[countAdd] = strInput;
        Serial.println(strNode[countAdd]);
        countAdd++;
        break;
      }
      if(i == 100){
        String strTmp = "Node:"; 
        strTmp += ip-2; 
        strTmp += ",102ERROR"; //102ERROR is can't receive data from node
        Serial.println(strTmp);
        break; 
      }
      delay(50);
    }
    endfor:
    client.stop();
  }
  
  Serial.println("/////  data sumary /////");
  for(int i=0 ; i<countAdd ; i++){
    Serial.println(strNode[i]);
  }
  Serial.println(); 
  countAdd = 0;
  digitalWrite(LED_BUILTIN, LOW);
  delay(500);
  digitalWrite(LED_BUILTIN, HIGH);
  delay(20000);
}

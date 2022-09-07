/*
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  # RFID MFRC522 / RC522 Library : https://github.com/miguelbalboa/rfid #
  #                                                                     #
  #                 Installation :                                      #
  # NodeMCU ESP8266/ESP12E    RFID MFRC522 / RC522                      #
  #         D2       <---------->   SDA/SS                              #
  #         D5       <---------->   SCK                                 #
  #         D7       <---------->   MOSI                                #
  #         D6       <---------->   MISO                                #
  #         GND      <---------->   GND                                 #
  #         D1       <---------->   RST                                 #
  #         3V/3V3   <---------->   3.3V                                #
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  #🙂 🙂 🙂 #
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
*/

//----------------------------------------Incluir a biblioteca NodeMCU ESP8266---------------------------------------------------------------------------------------------------------------//
//----------------------------------------Veja aqui: https: para adicionar biblioteca e placa NodeMCU ESP8266
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Inclua as bibliotecas SPI e MFRC522-------------------------------------------------------------------------------------------------------------//
//----------------------------------------Baixe a biblioteca MFRC522 / RC522 aqui: https://github.com/miguelbalboa/rfid
#include <SPI.h>
#include <MFRC522.h>
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

#define SS_PIN D2  //--> SDA/SS está conectado à pinagem D2
#define RST_PIN D1  //--> RST está conectado à pinagem D1
MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Cria instância MFRC522.

#define ON_Board_LED 2  //--> Definindo um LED On Board, usado para indicadores quando o processo de conexão a um roteador wifi

//----------------------------------------SSID e senha do seu roteador WiFi-------------------------------------------------------------------------------------------------------------//
const char* ssid = "FABIO";
const char* password = "1029384756";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

ESP8266WebServer server(80);  //--> Servidor na porta 80

int readsuccess;
byte readcard[4];
char str[32] = "";
String StrUID;

//-----------------------------------------------------------------------------------------------SETUP--------------------------------------------------------------------------------------//
void setup() {
  Serial.begin(115200); //--> Inicialize as comunicações seriais com o PC
  SPI.begin();      //--> Iniciar barramento SPI
  mfrc522.PCD_Init(); //--> Inicialize o cartão MFRC522

  delay(500);

  WiFi.begin(ssid, password); //--> Conecte-se ao seu roteador WiFi
  Serial.println("");

  pinMode(ON_Board_LED, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH); //--> Desligue o Led On Board

  //---------------------------------------- Aguarde a conexão
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //---------------------------------------- Faça o LED intermitente da placa no processo de conexão ao roteador wifi.
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
  }
  digitalWrite(ON_Board_LED, HIGH); //--> Desligue o LED On Board quando estiver conectado ao roteador wifi.
  //---------------------------------------- Se conectado com sucesso ao roteador wifi, o endereço IP que será visitado é exibido no monitor serial
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  Serial.println("Por favor escaneie um cartão para ver os dados !");
  Serial.println("");
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------------------------------------------LOOP---------------------------------------------------------------------------------------//
void loop() {
  // coloque seu código principal aqui, para executar repetidamente
  readsuccess = getid();

  if (readsuccess) {
    digitalWrite(ON_Board_LED, LOW);
    HTTPClient http;    //Declara objeto da classe HTTPClient

    String UIDresultSend, postData;
    UIDresultSend = StrUID;

    //Post Data
    postData = "UIDresult=" + UIDresultSend;

    http.begin("http://10.0.0.107/NodeMCU-and-RFID-RC522-IoT-Projects/getUID.php");  //Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header

    int httpCode = http.POST(postData);   //Envia o pedido de conecxão
    String payload = http.getString();    //Pega a carga da resposta

    Serial.println(UIDresultSend);
    Serial.println(httpCode);   // Print o código de retorno HTTP
    Serial.println(payload);    //Print solicitação de resposta payload

    http.end();  //Fechar conexão
    delay(1000);
    digitalWrite(ON_Board_LED, HIGH);
  }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//---------------------------------------- Procedimento para ler e obter um ID de um cartão ou chaveiro ---------------------------------------------------------------------------------//
int getid() {
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if (!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }


  Serial.print("O ID DO CARTÃO DIGITALIZADO É : ");

  for (int i = 0; i < 4; i++) {
    readcard[i] = mfrc522.uid.uidByte[i]; //armazenando o ID da tag no readcard
    array_to_string(readcard, 4, str);
    StrUID = str;
  }
  mfrc522.PICC_HaltA();
  return 1;
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//---------------------------------------- Procedimento para alterar o resultado da leitura de um ID de matriz em uma string ------------------------------------------------------------------------------//
void array_to_string(byte array[], unsigned int len, char buffer[]) {
  for (unsigned int i = 0; i < len; i++)
  {
    byte nib1 = (array[i] >> 4) & 0x0F;
    byte nib2 = (array[i] >> 0) & 0x0F;
    buffer[i * 2 + 0] = nib1  < 0xA ? '0' + nib1  : 'A' + nib1  - 0xA;
    buffer[i * 2 + 1] = nib2  < 0xA ? '0' + nib2  : 'A' + nib2  - 0xA;
  }
  buffer[len * 2] = '\0';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

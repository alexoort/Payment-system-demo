#include <MFRC522.h>
#include <SPI.h>
#include <LiquidCrystal_I2C.h>
#include <Ethernet.h>
#include <Adafruit_NeoPixel.h>

Adafruit_NeoPixel strip(12, 5, NEO_GRB + NEO_KHZ800);
MFRC522 RFID(9, 8); //SS, RST
EthernetClient client;
LiquidCrystal_I2C lcd = LiquidCrystal_I2C(0x27, 16, 2);

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xEF }; //assigned MAC address for Ethernet Shield
char server[] = "cashfreecanteen.com";
char uid[20];




const char serialnumbers[][20] PROGMEM = {"23723217587", "10764243136", "13023125291", "21115423255", "5959104135", "19521319255", "46214234200", "1828192", "32182198145", "77166136189", "43156242136", "219118100135", "623179194", "2279423255", "18715252136", "232444960", "107113242136", "146249192", "110220238200", "1581405201", "22710821255", "627246200", "20378252136", "91136253136", "102107130179", "190198248200", "94161251200", "1902253200", "66186192", "20611252200", "23513107239", "9129137", "182255132179", "17140254136", "251144253136", "621307201", "203118253136", "155132253136", "5018125291", "2793107239", "2746252136", "20364254136", "155240105239", "17117510137", "187226253136", "1154107239", "25125110137", "251142253136", "11184252136", "7590253136", "322196145", "4364253136", "150179128179", "3410825391", "171192253136", "4315107239", "1187253136", "7525106239", "5959243136", "75111254136", "2061307201", "11879130179", "5973225136", "13176139189", "12515818287", "24217325491", "251212103239", "985125491", "2032254136", "20852193145", "12639253200", "91148253136", "91116254136", "9190108239", "4103104828430128", "226129092", "17142110239", "15035130179", "251238110239", "242173092", "6168131179", "7589242136", "2215192", "12338254136", "171117253136", "1447195145", "91163242136", "4369101239", "38222255", "194137092", "24212925291", "27249106239", "64116198145", "25113129136", "171110254136", "10998140189", "2534618087", "20523017887", "21014925491", "169164222139"}; //accounts
const char names[][13] PROGMEM = {"Francis", "Bruenler", "Ferres","Schuhmacher","Wittig","Reddig","Rippinger","Albano","Bogushevitch","Foerster", "Chenault", "Degirmenci", "Rose", "Clearman", "Hoke", "Eickelposch", "Ennenbach", "Guelcan", "Wragg", "Ebert", "Eichmann", "Negusse", "Endara", "Wragg", "Hercher", "Cimiotti", "Lange", "Vernon", "Krueger", "Best", "Witcomb", "Blumthal", "Arathoon", "Grey", "Sagide", "Francis", "Armaou", "Brazell", "Mann", "Bracklo", "Grambart", "Matthiessen", "Schmidt", "Hinde", "Sengstmann", "Brott", "Walker", "Ferraris", "Kohler", "Guss", "Vives", "Sibbitt", "Koenig", "Taylor", "Weaver", "Brazell", "Eikelboom", "Haefner", "Murray", "Abadel", "Dodd", "Smart", "Rodriguez", "Czerny", "Dodd", "Ingram", "Idayat", "Yamaguchi", "Robertson", "Touzet", "Eichner", "Santandrea", "Kaldenbach", "Michalowska", "Preysing", "Youmes", "Kim", "Homburg", "Goedel", "Schorge", "Johnson", "Petrini", "Ettin", "Chute", "Davis", "Robinson", "Dominey", "Dodier", "Smolla", "Botsford", "Foust", "Zaldivar", "Coppes", "Antcliff", "Henkel", "McLennan", "Kroll", "De Rouge", "Cade", "test"};
const int numberOfStudents= sizeof(names)/sizeof(names[1]);
const boolean teacher[] = {true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true};

bool knownCard;

void setup() {
  Serial.begin(9600);
  SPI.begin(); //begin SPI bus
  
  lcd.init();
  lcd.backlight();

  RFID.PCD_Init();
  RFID.PCD_DumpVersionToSerial();

  strip.begin(); //initalize the LED ring
  strip.show();
  strip.setBrightness(50);

  pinMode(2, OUTPUT); // for buzzer

  pinMode(4, OUTPUT); //SD card pin
  digitalWrite(4, HIGH); //this prevents the SD card from interfering with the SPI bus
  
  ethernetConnect();

  
  
}

void loop() {
  knownCard=false;
  if (!(RFID.PICC_IsNewCardPresent() && RFID.PICC_ReadCardSerial())){ //check if a new card is present
    return;
  }

  Serial.print(F("Card UID: "));
  getuid(RFID.uid.uidByte, RFID.uid.size);
  Serial.println(uid);

  for (int c=0;c<numberOfStudents; c++){
    char serialNumber[20];
    for (byte k = 0; k < strlen_P(serialnumbers[c]); k++) {
      char nr = pgm_read_byte_near(serialnumbers[c] + k);
      serialNumber[k] = nr;
      serialNumber[k+1] = 0;
    }
    
    if (strcmp(uid,serialNumber) ==0){
      Serial.println("Known card");
      knownCard=true;
      tone(2, 1700); //make the buzzer sound
      delay(100);
      noTone(2);
      tone(2, 1300);
      delay(100);
      noTone(2);
      Lunch(c);
      delay(1000);
    }
  }
  if (knownCard == false){ //make a different sound if an unknown card is read
    tone(2, 1300);
    lcd.clear();
    lcd.print("Unknown card");
    delay(200);
    noTone(2);
    delay(500);
    lcd.clear();
    lcd.print("Ready");
  }
}


void ethernetConnect(){
  Serial.println(F("Initialize Ethernet with DHCP:"));
  if (Ethernet.begin(mac) == 0) {
    Serial.println(F("Failed to configure Ethernet using DHCP"));
    // Check for Ethernet hardware present
    if (Ethernet.hardwareStatus() == EthernetNoHardware) {
      Serial.println(F("Ethernet shield was not found.  Sorry, can't run without hardware. :("));
      while (true) {
        delay(1); // do nothing, no point running without Ethernet hardware
      }
    }
    if (Ethernet.linkStatus() == LinkOFF) {
      Serial.println(F("Ethernet cable is not connected."));
    }
    // try to congifure using IP address instead of DHCP:
   
  } else {
    Serial.print(F("  DHCP assigned IP "));
    Serial.println(Ethernet.localIP());
  }

  
  // give the Ethernet shield a second to initialize:
  delay(1000);
  Serial.print(F("connecting to "));
  Serial.print(server);
  Serial.println(F("..."));

  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.print(F("connected to "));
    Serial.println(client.remoteIP());
    // Make a HTTP request:
    lcd.clear();
    lcd.print(F("Connected!"));
  } else {
    // if you didn't get a connection to the server:
    Serial.println(F("connection failed"));
  }
}

void getuid(byte *buffer, byte bufferSize) {
  uid[0] = 0;
  for (byte i = 0; i < bufferSize; i++) {
    char buf[4] = {0} ;  // big enough for 3 digits + terminator
    sprintf( buf, "%d", buffer[ i ]  ) ;
    strcat( uid, buf ) ;
    
  }
}


void Lunch(int i){
  lcd.clear();
  lcd.setCursor(0,0);
  char Name[15] = "";
  for (byte k = 0; k < strlen_P(names[i]); k++) {
     char letter = pgm_read_byte_near(names[i] + k);
     Name[k] = letter;
     
  }
  Serial.println(Name);
  lcd.print(Name);
  postData(i+1);
  successLight();
  delay(500);
  lcd.clear();
  lcd.print(F("Ready"));
}

void postData(int id){
  
  String data = "id=" + String(id);
  if (client.connect(server, 80)){
    client.println(F("POST /xxx.php  HTTP/1.1"));//REPLACE WITH YOUR URLS
    client.println(F("Host: www.cashfreecanteen.com"));
    client.println(F("Content-Type: application/x-www-form-urlencoded"));
    client.println(F("Connection:close"));
    client.print(F("Content-Length:"));
    client.println(data.length());
    client.println();
    client.print(data);
    client.flush();
String serverData="";
while(client.connected() && !client.available()) delay(1); //waits for data
  while (client.connected() || client.available()) { //connected or data available
    char c = client.read(); //gets byte from ethernet buffer
    serverData.concat(c);
    Serial.print(c); //prints byte to serial monitor
  }
client.stop();
if (serverData.indexOf("200 OK") > 0){
  lcd.setCursor(0,1);
  lcd.print(F("Success!"));
  Serial.println(F("Successful connection"));
  
} else{
  delay(100);
  postData(id);
}
} else {
  delay(100);
  postData(id);
}
  
}

void successLight(){

  for(int i=0; i<strip.numPixels(); i++) { // For each pixel in strip...
    
    strip.setPixelColor(i, strip.Color(0,55,0));         //  Set pixel's color (in RAM)
    strip.show();                          //  Update strip to match
    delay(10);
                                   
  }
  delay(500);
  for(int i=0; i<strip.numPixels(); i++) { // For each pixel in strip...
    strip.setPixelColor(i, strip.Color(0,0,0));         //  Set pixel's color (in RAM)
    strip.show();                          //  Update strip to match
                                   
  }
}

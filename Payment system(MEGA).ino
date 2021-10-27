#include <LiquidCrystal_I2C.h>
#include <Wire.h>
#include <SPI.h>
#include <MFRC522.h>
#include <Keypad.h>

#include <Adafruit_NeoPixel.h>
#include <Ethernet.h>


#define RST_PIN         8          // Configurable, see typical pin layout above
#define SS_1_PIN        53         // Configurable, take a unused pin, only HIGH/LOW required, must be diffrent to SS 2
#define SS_2_PIN        11          // Configurable, take a unused pin, only HIGH/LOW required, must be diffrent to SS 1

#define NR_OF_READERS   2

byte ssPins[] = {SS_1_PIN, SS_2_PIN};

MFRC522 mfrc522[NR_OF_READERS];

// Which pin on the Arduino is connected to the NeoPixels?
#define LED_PIN    5

#define LED_PIN2    3

// How many NeoPixels are attached to the Arduino?
#define LED_COUNT 12

Adafruit_NeoPixel strip(LED_COUNT, LED_PIN, NEO_GRB + NEO_KHZ800);

Adafruit_NeoPixel strip2(LED_COUNT, LED_PIN2, NEO_GRB + NEO_KHZ800);

String lastuid="";
String section;
size_t endOfNumber;
String response;
bool payBill = false;
int lineNr = 0;
int charsInLine=0;
int ids[10] = {};
String uid;
bool sent = false;
bool repeatItem = false;
int repeats[3] = {1};
String lunches;
String serverPassword = "xxx";

EthernetClient client;
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
char server[] = "cashfreecanteen.com"; // example.com
String uri = "/xxx.php";
String uri2 = "/xxx.php";
String lunchUri = "/xxx.php";
String data= "";
const byte ROWS = 4; //four rows
const byte COLS = 4; //three columns
char keys[ROWS][COLS] = {
    {'1','2','3','A'},
    {'4','5','6','B'},
    {'7','8','9','C'},
    {'*','0','#','D'}
};
int btn;
float  nums[20] ={};
byte rowPins[ROWS] = {A11, A10, A9, A8}; //connect to the row pinouts of the keypad
byte colPins[COLS] = {A15, A14, A13, A12}; //connect to the column pinouts of the keypad
int decimal =0;
LiquidCrystal_I2C lcd = LiquidCrystal_I2C(0x27, 16, 2); 
Keypad keypad = Keypad( makeKeymap(keys), rowPins, colPins, ROWS, COLS );
 


   // Create MFRC522 instance 2 RFID readers


float price = 0;
char MoneyLeft = 10;

float cost = 0;
float change;
int c = 0;
boolean add =false;


int t= 0;
float nrofElements;
float addition = 0;
const int buzzer =2;
boolean entered[20] = {};
String thirdscan;
String lastscan;
String currentScan="";
bool lunchTime=true;
int repeat =1;
bool newItem;

bool newline=false;
bool cancel=false;
int indexForLastNum;
int totalItems;
unsigned long previousTime;
unsigned long currentTime;
unsigned long day = 86400000; //one day in milliseconds
unsigned long oldTime = 0;

//account information

const char serialnumbers[][13] PROGMEM = {"23723217587", "10764243136", "13023125291", "21115423255", "5959104135", "19521319255", "46214234200", "1828192", "32182198145", "77166136189", "43156242136", "219118100135", "623179194", "2279423255", "18715252136", "232444960", "107113242136", "146249192", "110220238200", "1581405201", "22710821255", "627246200", "20378252136", "91136253136", "102107130179", "190198248200", "94161251200", "1902253200", "66186192", "20611252200", "23513107239", "9129137", "182255132179", "17140254136", "251144253136", "621307201", "203118253136", "155132253136", "5018125291", "2793107239", "2746252136", "20364254136", "155240105239", "17117510137", "187226253136", "1154107239", "25125110137", "251142253136", "11184252136", "7590253136", "322196145", "4364253136", "150179128179", "3410825391", "171192253136", "4315107239", "1187253136", "7525106239", "5959243136", "75111254136", "2061307201", "11879130179", "5973225136", "13176139189", "12515818287", "24217325491", "251212103239", "985125491", "2032254136", "20852193145", "12639253200", "91148253136", "91116254136", "9190108239", "4103104828430128", "226129092", "17142110239", "15035130179", "251238110239", "242173092", "6168131179", "7589242136", "2215192", "12338254136", "171117253136", "1447195145", "91163242136", "4369101239", "38222255", "194137092", "24212925291", "27249106239", "64116198145", "25113129136", "171110254136", "10998140189", "2534618087", "20523017887", "21014925491", "169164222139"}; //accounts
const char names[][13] PROGMEM = {"Francis", "Bruenler", "Ferres","Schuhmacher","Wittig","Reddig","Rippinger","Albano","Bogushevitch","Foerster", "Chenault", "Degirmenci", "Rose", "Clearman", "Hoke", "Eickelposch", "Ennenbach", "Guelcan", "Wragg", "Ebert", "Eichmann", "Negusse", "Endara", "Wragg", "Hercher", "Cimiotti", "Lange", "Vernon", "Krueger", "Best", "Witcomb", "Blumthal", "Arathoon", "Grey", "Sagide", "Francis", "Armaou", "Brazell", "Mann", "Bracklo", "Grambart", "Matthiessen", "Schmidt", "Hinde", "Sengstmann", "Brott", "Walker", "Ferraris", "Kohler", "Guss", "Vives", "Sibbitt", "Koenig", "Taylor", "Weaver", "Brazell", "Eikelboom", "Haefner", "Murray", "Abadel", "Dodd", "Smart", "Rodriguez", "Czerny", "Dodd", "Ingram", "Idayat", "Yamaguchi", "Robertson", "Touzet", "Eichner", "Santandrea", "Kaldenbach", "Michalowska", "Preysing", "Youmes", "Kim", "Homburg", "Goedel", "Schorge", "Johnson", "Petrini", "Ettin", "Chute", "Davis", "Robinson", "Dominey", "Dodier", "Smolla", "Botsford", "Foust", "Zaldivar", "Coppes", "Antcliff", "Henkel", "McLennan", "Kroll", "De Rouge", "Cade", "test"};
const int numberOfStudents= sizeof(names)/sizeof(names[1]);
const boolean teacher[] = {true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true, true};

float account[numberOfStudents];
bool schoolLunch[numberOfStudents]; 
int lunchPortions[numberOfStudents]= {0};

int index=0;
float accounts2[numberOfStudents];
String serverAccounts;

float dailyRevenue=0; //statistics and food info
String bestSeller;
int highestSnackCount=0;
int snackCount[]= {0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0};
String snackName[]= {"Coffee", "Croissant", "A. Juice", "Cookie", "Brezel", "Cherry Pastry", "Pingui", "Water", "C. Croissant", "Laugen stange", "Cheese Brezel", "Panini", "Bagel", "C. Biscuit", "Capri Sun", "O. Juice", "Choc. Bar", "A. Pastry", "S. Sandwhich", "C. Sandwhich", "Muffin"};
float snackPrice[]={1.50, 1.30, 1.70, 1.5, 0.7, 1.6, 0.8, 1.2, 1.70,0.8,1.4,2.4, 1.8, 0.3, 0.8, 1.5, 0.5, 1.6, 2, 1.9, 1.5};
bool foodType[]= {false, true, false, true, true, true, true, false, true, true, true, true, true, true, false, false, true, true, true, true, true};
float drinkRevenue=0;
float foodRevenue=0;
String purchase="";

float profit; //statistics and food info


void setup() {
  SPI.begin(); 
  
  Serial.println(teacher[0]);
  Serial.begin(9600);   // Initialize serial communications with the PC
  while (!Serial);   // Do nothing if no serial port is opened (added for Arduinos based on ATMEGA32U4)
    
  lcd.init();
  lcd.backlight();// Init SPI bus
  for (uint8_t reader = 0; reader < NR_OF_READERS; reader++) {
    mfrc522[reader].PCD_Init(ssPins[reader], RST_PIN); // Init each MFRC522 card
    Serial.print(F("Reader "));
    Serial.print(reader);
    Serial.print(F(": "));
    mfrc522[reader].PCD_DumpVersionToSerial();
  }  
  lcd.print("test");
  Serial.println(F("Scan PICC to see UID, SAK, type, and data blocks..."));
  strip.begin();           // INITIALIZE NeoPixel strip object (REQUIRED)
  strip.show();            // Turn OFF all pixels ASAP
  strip.setBrightness(50); // Set BRIGHTNESS to about 1/5 (max = 255)
  strip2.begin();           // INITIALIZE NeoPixel strip object (REQUIRED)
  strip2.show();            // Turn OFF all pixels ASAP
  strip2.setBrightness(50); // Set BRIGHTNESS to about 1/5 (max = 255)
  pinMode(buzzer, OUTPUT);
  Serial.println("Initialize Ethernet with DHCP:");
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // Check for Ethernet hardware present
    if (Ethernet.hardwareStatus() == EthernetNoHardware) {
      Serial.println("Ethernet shield was not found.  Sorry, can't run without hardware. :(");
      while (true) {
        delay(1); // do nothing, no point running without Ethernet hardware
      }
    }
    if (Ethernet.linkStatus() == LinkOFF) {
      Serial.println("Ethernet cable is not connected.");
    }
    // try to congifure using IP address instead of DHCP:
   
  } else {
    Serial.println("Successfull");
    Serial.print("  DHCP assigned IP ");
    Serial.println(Ethernet.localIP());
  }

  
  // give the Ethernet shield a second to initialize:
  delay(1000);
  Serial.print("connecting to ");
  Serial.print(server);
  Serial.println("...");

  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.print("connected to ");
    Serial.println(client.remoteIP());
    // Make a HTTP request:
    lcd.clear();
    lcd.print("Connected!");
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  Serial.println(names[1]);
  Serial.println(schoolLunch[1]);
  Serial.println(account[1]);
}

void loop() {
  uid = "";
Serial.println(mfrc522[0].PICC_IsNewCardPresent());
  // Reset the loop if no new card present on the sensor/reader. This saves the entire process when idle.
lcd.setCursor(0,0);
for (int reader = 0; reader < NR_OF_READERS; reader++) { // Look for new cards
  if (!(mfrc522[reader].PICC_IsNewCardPresent() && mfrc522[reader].PICC_ReadCardSerial())) {
      
      continue;
    }
  Serial.println("Card");
  //Show UID on serial monitor
  Serial.print(F("Reader "));
      Serial.print(reader);
      // Show some details of the PICC (that is: the tag/card)
      Serial.print(F(": Card UID:"));  
      getuid(mfrc522[reader].uid.uidByte, mfrc522[reader].uid.size);
      Serial.println(uid);
 
  
  if (uid == ""){ //replace with assigned 'special' card
    tone(buzzer, 1300);
    delay(150);
    noTone(buzzer);
    tone(buzzer, 1650);
    delay(100);
    noTone(buzzer);
    cafeteriaMenu();
    
  }
  else{
    Serial.print("ID:");
    
  for (c = 0; c < numberOfStudents; c++){
    String serialNumber = "";
    for (byte k = 0; k < strlen_P(serialnumbers[c]); k++) {
    char nr = pgm_read_byte_near(serialnumbers[c] + k);
    serialNumber += nr;
    
  }
       if (uid == serialNumber) //change here the UID of the card/cards that you want to give access
  {
      if (lastuid == uid){
        lcd.clear();
        lcd.print(F("Thank you for"));
        lcd.setCursor(0,1);
        lcd.print(F("Scanning"));
        delay(1000);
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print(F("Ready"));
      } else{
      currentTime=millis();
      if (currentTime-previousTime>=500){
      tone(buzzer, 1600);
        delay(100);// ...for 0.1 sec
        noTone(buzzer);
        lcd.clear();
        lastuid=uid;
      if (lunchTime){
        Lunch(c, reader);
        
      }
      else{
        Snack(uid, c, lastscan);
      }
      previousTime=currentTime;
  }
  }
  }
  
  }
  }
  
  lastscan = uid;
  currentScan ="";
}
}


void Lunch(int i, int reader){
  lcd.clear();
  
  lcd.setCursor(0,0);
  String Name = "";
  for (byte k = 0; k < strlen_P(names[c]); k++) {
     char letter = pgm_read_byte_near(names[c] + k);
     Name += letter;
  }
  lcd.print(Name);

  lcd.setCursor(0,1);
  Serial.println(i);
  Serial.println(teacher[i]);
  
    
  teacherLunch(i+1); 
  
}

void Snack(String currentScan, int i, String previousScan){ /// snack code 
  add=false;
  
  if (previousScan != currentScan){
          
          String Name = "";
          for (byte k = 0; k < strlen_P(names[c]); k++) {
            char letter = pgm_read_byte_near(names[c] + k);
            Name += letter;
          }
          lcd.print(Name);
          if (Name.length() <= 5){
            lcd.print(F("'s account:"));
            lcd.setCursor(0,1);
          }
          else{
            lcd.print(F("'s"));
            lcd.setCursor(0,1);
            lcd.print(F("account: "));
          }
          lcd.print(account[i]);
         

          }
        else{  
          lcd.clear();
          delay(50);
     Serial.print(F("What items would you like?"));
       lcd.print(F("Items: "));
       
int c=0;
    int key=0;
   float price = 0;
   int decimal = 0;
   charsInLine=5;
   lineNr=0;
   for (int z=0;z<20;z++){
    nums[z] = 0;
    entered[z] = false;
   }
  int itemnr=1;
 String purchase="";

payBill = false;
iteminput(key,itemnr,newItem); //call function to input items


if (cancel){
  cancel=false;
  for (int x=0; x<20;x++){
    nums[x]=0;
    entered[x]=false;
  }
  return;
}
 
  if (add==false and lunchTime==false){
    
   
   nrofElements = sizeof(snackName)/sizeof(snackName[0]);
   
   for (int k=0; k<totalItems;k++){
    for (int x=0;x<=1;x++){
    ids[k] += nums[k*2 + x];
   }
    if (ids[k] > nrofElements or ids[k]<0){
    invalidItem();
    ids[k]=0;
    return;
   }
   else{
   snackCount[ids[k]]+=1;
   price+=snackPrice[ids[k]];
   if (foodType[ids[k]]){
    foodRevenue+=snackPrice[ids[k]];
   }
   else{
    drinkRevenue+=snackPrice[ids[k]];
   }
   
   if (k>0){
       purchase = purchase + ", " + snackName[ids[k]];
   } else{
       purchase += snackName[ids[k]];
   }
   }
   Serial.print(F("Length"));
    
    int charsLeft = 16 - (snackName[ids[k]].length() + 2 + charsInLine);
    Serial.println(charsLeft);
    if (charsLeft >=0){
    
      if (k>0){
        lcd.print(F(", "));
        lcd.print(snackName[ids[k]]);
        charsInLine += (snackName[ids[k]].length() +2);
      } else{
        lcd.print(snackName[ids[k]]);
        charsInLine += snackName[ids[k]].length();
      }   
   } else{
      Serial.print("new line");
      charsInLine=0;
      if (lineNr >0){
        delay(1000);
        lcd.clear();
        lcd.setCursor(0,0);
        lineNr = 0;
        lcd.print(F(", "));
        lcd.print(snackName[ids[k]]);
        charsInLine += (snackName[ids[k]].length() +2);
   } else{
    lcd.setCursor(0,1);
    lcd.print(snackName[ids[k]]);
   charsInLine += (snackName[ids[k]].length() +2);
   }
   lineNr+=1;
   }
   }
    delay(1000);
    lcd.clear();
    lcd.print(F("Cost: "));
    lcd.print(price); 
   }

        
        
        
 if (add==true and lunchTime==false) {
          lcd.clear();
          lcd.print (F("How much do"));
          lcd.setCursor(0,1);
          lcd.print(F("you want to add?"));

          for (int x=1; x<=4; x++){
    int key = keypad.getKey();
    while(key == NO_KEY) {
      key = keypad.getKey();
    }
    if (key >= 48 and key<=57){
      key = key-48;
      nums[x] = key;
      entered[x] = true;
    }
    else{
      if (key==67){
        cancel=true;
        break;
        
      }
      if (key==42){
        decimal =x;
      }
      if (key==65){
        add=true;
        break;
      }
      if (key==35){
        break;
      }
     }

 if (x-decimal==1 and decimal > 0){
  nums[x] = nums[x]/10  ;
 }
 if (x-decimal==2 and decimal > 0){
  nums[x] = nums[x]/100  ;
 }
 if (decimal == 0 and x ==2){
  nums[1] = nums[1]*10;
 }
 if (decimal ==0 and x==3){
  nums[1] = nums[1]*10;
  nums[2] = nums[2]*10;
 }
if (entered[x]){
  Serial.print(key);
  lcd.print(key);

}
else{
  if (decimal==x){
    lcd.print(F("."));
  }
}

  }
  
if (cancel){
  cancel=false;
  for (int x=0; x<20;x++){
    nums[x]=0;
    entered[x]=false;
  }
  return;
}
 
   for (int x=1;x<=4;x++){
    addition += nums[x];
   }
          lcd.clear();
          lcd.print(F("Added: "));
          
          lcd.print(addition);
          account[i] += addition;
          delay(1000);
          lcd.setCursor(0,1);
          lcd.print(F("Account: "));
          
          Serial.println(account[i]);
          lcd.print(account[i]);
          purchase= "Addition";
          String additionData = "Money=" + String(account[i]) + "&change=" + String(addition) + "&id=" + String(i) + "&purchase=" + purchase + "&passcode=" + serverPassword;
          sent=false;
          httppost(additionData);
          delay(1500);
          lcd.clear();
          lcd.setCursor(4,0);
    lcd.print(F("Success!"));
    delay(1000);
    lcd.clear();
    lcd.print(F("Ready"));

          addition = 0;
        }
      else{
    if (lunchTime==false){
        delay(1000);
        lcd.setCursor(0,1);
      float money = account[i];
      if (money - price >= 0){
      float (money -= price);
      account[i] = (float)money;
    Serial.println();
    Serial.println(money);
    lcd.print(F("Account: "));
    
    lcd.print(money);
    change = -1*price;
    String purchaseData = "Money=" + String(account[i]) + "&change=" + String(change) + "&id=" + String(i) + "&purchase=" + purchase + "&passcode=" + serverPassword;
    httppost(purchaseData);
    
    
   }
    else{
      lcd.clear();
      lcd.print(F("Error: Not enough"));
      lcd.setCursor(0,1);
      lcd.print(F("money"));
    }
      }
      else{
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print(F("Lunch Time!"));
      }
        }
        }

  for (int x=0; x<10;x++){
    ids[x] = 0;
  }
  
  for (int x=0;x<=5; x++){
    nums[x]=0;
  }

  }


void iteminput(int key, int itemnr, bool newItem) {
  while (payBill == false){
   
  Serial.println("Input item");
  for (int x=0; x<=3; x++){
    int key = keypad.getKey();

    while(key == NO_KEY) {
      key = keypad.getKey();
    }
    
                                   
    
    if (key >= 48 and key<=57){
      for(int i=0; i<strip.numPixels(); i++) { // For each pixel in strip...
    strip.setPixelColor(i, strip.Color(0,100,0));         //  Set pixel's color (in RAM)
    strip.show();                          //  Update strip to match
                                   
    }
    delay(50);
    for(int i=0; i<strip.numPixels(); i++) { // For each pixel in strip...
    strip.setPixelColor(i, strip.Color(0,0,0));         //  Set pixel's color (in RAM)
    strip.show();    
    }//  Update strip to match
      key = key-49;
      Serial.println(key);
      
      nums[x + (itemnr*2 -2)] = key;
      entered[x + (itemnr*2 -2)] = true;
        
      
    }
    else{
      if (key==67){
        cancel=true;
        break;
      }
      if (key==42){
        newItem=true;
        
      }
      if (key==65){
        add=true;
        payBill = true; //exits the function when A is pressed
      }
      if (key==35){
        totalItems=itemnr;
        payBill = true; //this exits the function
        Serial.println(totalItems);
        break;
      }
      if (key == 68){
        Serial.println(F("Repeat"));
        int repeatKey = keypad.getKey();
        while(repeatKey == NO_KEY) {
        repeatKey = keypad.getKey();
        }
        Serial.println(repeatKey);
        if (repeatKey >=48 and repeatKey <=57){
          repeatKey -= 48;
          repeats[itemnr-1] = repeatKey;
          Serial.println(F("itemnr:"));
          Serial.println(repeats[itemnr-1]);
        }
        
        
      }
    }
    indexForLastNum=2*itemnr-1;
 
 if (entered[indexForLastNum] and newItem==false){
  
  nums[indexForLastNum-1]= (nums[indexForLastNum-1]+1)*10;
  Serial.println(nums[indexForLastNum-1]);
 }
if (newItem){
  itemnr+=1;
  newItem = false;
  break;
}

  } 
  }
}


void analytics(){
  
  for (int i=0; i< nrofElements; i++){
    
    if (snackCount[i] > 0){
      lcd.clear();
      lcd.print(snackName[i]);
      if (snackCount[i] >1){
        lcd.print(F("s"));
      }
      lcd.print(F(": "));
      lcd.print(snackCount[i]);
      
      delay(2000);
    }
    if (snackCount[i] > highestSnackCount){
      highestSnackCount = snackCount[i];
      bestSeller=snackName[i];
    }
    
  }
  lcd.clear();
  dailyRevenue=drinkRevenue+foodRevenue;
  lcd.print(F("Revenue: "));
  lcd.print(dailyRevenue);
  delay(500);
  lcd.setCursor(0,1);
  profit= drinkRevenue*0.9 + foodRevenue*0.93;
  lcd.print("Profit : ");
  lcd.print(profit);
  delay(2500);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print(F("Most sold item:"));
  lcd.setCursor(0,1);
  lcd.print(bestSeller);
  dailyRevenue=0;
  profit=0;
 
}


void cafeteriaMenu(){
  
  lcd.clear();
  lcd.print(F("1:  Snack"));
  lcd.setCursor(0,1);
  lcd.print(F("2:  Lunch"));
  int choice = keypad.getKey();

    while(choice == NO_KEY) {
      choice = keypad.getKey();
    }
    
    if (choice == 49){
      lunchTime=false;
      lcd.clear();
      lcd.print(F("Snack time!!!"));
      return;
    }
    else{
      if (choice==50){
        lunchTime=true;
        lcd.clear();
        lcd.print(F("Lunch time!!!"));
        return;
      }
      
    }
}







void httppost(String data){
  String PostData = data;
  Serial.println(PostData);
 Serial.println(F("Http post request starting"));
    if (client.connect(server, 80)) {
    Serial.println("connected");
  client.println("POST /accounts.php HTTP/1.1");
  client.println("Host: cashfreecanteen.com");
  client.println("User-Agent: Arduino/1.0");
  client.println("Connection: close");
  client.println("Content-Type: application/x-www-form-urlencoded;");
  client.print("Content-Length: ");
  client.println(PostData.length());
  client.println();
  client.println(PostData);

if (client.available()) {
  Serial.print("Server info:");
    char c = client.read();
    Serial.print(c);
  } 
}
}





void getData(){ ///retrieve data from database
String PostData = "";
 Serial.println(F("Http post request starting"));
    if (client.connect(server, 80)) {
    Serial.println("connected");
  client.println("POST /retrieve.php HTTP/1.1");
  client.println("Host:  www.cashfreecanteen.com");
  client.println("User-Agent: Arduino/1.0");
  client.println("Connection: close");
  client.println("Content-Type: application/x-www-form-urlencoded;");
  client.print("Content-Length: ");
  client.println(PostData.length());
  client.println();
  client.println(PostData);

if (client.available()) {
    char c = client.read();
    Serial.print(c);
  } 
Serial.print(response);
int startOfData = response.indexOf("Results=");
int endOfData = response.indexOf("Lunch=");
serverAccounts = response.substring(startOfData + 8, endOfData);
Serial.println(serverAccounts);

if (startOfData < 0){
  getData();
}

}

int startOfLunch = response.indexOf("Lunch=");
int endOfLunch = response.indexOf("CLOSED");
String lunchList = response.substring(startOfLunch + 6, endOfLunch);
Serial.println(lunchList);
for (int x=0; x<= serverAccounts.length();x++){

  if (serverAccounts[x] == ','){
    
    endOfNumber = serverAccounts.indexOf(',', x+1);
    section = serverAccounts.substring(x+2, endOfNumber);
    
    float value = section.toFloat();
    index+=1;
    account[index] = value;
    
  }
}

index=1;
for (int x=0; x<= lunchList.length();x++){

  if (lunchList[x] == ','){
    
    endOfNumber = lunchList.indexOf(',', x+1);
    section = lunchList.substring(x+2, endOfNumber);
    Serial.println(section);
    if (section == "No"){
      Serial.println("FALSE");
      Serial.println(names[index]);
      schoolLunch[index] = false;
    } else{
      schoolLunch[index] = true;
    }
    index+=1;
    
  }
}

// close the connection
lcd.clear();
lcd.print(F("Success!"));
delay(1000);
  lcd.clear();
  lcd.print("Ready");


}

void teacherLunch(int id){ //teacher lunches POST
 strip.clear();
 Serial.print("id=");
 Serial.println(id);
 String data = "id=" + String(id);
 Serial.println(data);
 Serial.println(F("HTTP request starting..."));
 
   if (client.connect(server,80)) { // REPLACE WITH YOUR SERVER ADDRESS
    Serial.println("Connected");
client.println("POST /newTeacherLunch.php  HTTP/1.1");//REPLACE WITH YOUR URLS
client.println("Host: www.cashfreecanteen.com");
client.println("Content-Type: application/x-www-form-urlencoded");
client.println("Connection:close");
client.print("Content-Length:");
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
  lcd.print("Success!");
  Serial.println("Successful connection");
  delay(500);
  lcd.clear();
  lcd.print("Ready");
} else{
  delay(100);
  teacherLunch(id);
}
} else {
  delay(100);
  teacherLunch(id);
}
}

void getuid(byte *buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
    uid+=buffer[i];
    
  }
}


void invalidItem(){
  lcd.clear();
    lcd.print(F("Error:"));
    lcd.setCursor(0,1);
    lcd.print(F("Invalid item"));
}


void trafficLight(uint32_t color, int reader) {
  if (reader == 0){
   strip.clear(); // first LED ring
  for(int i=0; i<strip.numPixels(); i++) { // For each pixel in strip...
    strip.setPixelColor(i, strip.Color(0,0,0));         //  Set pixel's color (in RAM)
    strip.show();                          //  Update strip to match
                                   
  }
  delay(100);
  for(int i=0; i<strip.numPixels(); i++) { // For each pixel in strip...
    strip.setPixelColor(i, color);         //  Set pixel's color (in RAM)
    strip.show();                          //  Update strip to match
                                    
  } 
  } else{
    strip2.clear();  //second LED ring
  for(int i=0; i<strip2.numPixels(); i++) { // For each pixel in strip...
    strip2.setPixelColor(i, strip2.Color(0,0,0));         //  Set pixel's color (in RAM)
    strip2.show();                          //  Update strip to match
                                   
  }
  delay(100);
  for(int i=0; i<strip2.numPixels(); i++) { // For each pixel in strip...
    strip2.setPixelColor(i, color);         //  Set pixel's color (in RAM)
    strip2.show();                          //  Update strip to match
                                    
  }
  }
  
}

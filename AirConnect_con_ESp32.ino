#include <WiFi.h>
#include <FirebaseESP32.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include "DHT.h"
#include "time.h"

// --- 1. CONFIGURACIÓN ---
#define WIFI_SSID "Tah"
#define WIFI_PASSWORD "noviembre12"
#define FIREBASE_HOST "airconnect-f6bdc-default-rtdb.firebaseio.com"
#define FIREBASE_AUTH "2TBqss9sZKiYshG29F63JoZ9WtglOcYWW51LMBn7"

// --- 2. HARDWARE ---
LiquidCrystal_I2C lcd(0x27, 16, 2);
#define DHTPIN 15
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

const int pinMQ135 = 34, pinMQ2 = 35, pinMQ7 = 32;
const int ledVerde = 13, ledAmarillo = 12, ledRojo = 14;
const int pinBuzzer = 2;

// --- 3. VARIABLES DE CONTROL ---
FirebaseData firebaseData;
FirebaseConfig config;
FirebaseAuth auth;

unsigned long tEnvio = 0;
unsigned long tBranding = 0;
bool mostrandoNombre = false;

const int umbralAlerta = 900;

void setup() {
  Serial.begin(115200);
  delay(1000);
  Serial.println("\n>>> AIRCONNECT <<<");
  
  Wire.begin(21, 22, 100000); 
  dht.begin();
  
  pinMode(ledVerde, OUTPUT); pinMode(ledAmarillo, OUTPUT); 
  pinMode(ledRojo, OUTPUT); pinMode(pinBuzzer, OUTPUT);

  digitalWrite(pinBuzzer, HIGH); delay(200); digitalWrite(pinBuzzer, LOW);

  lcd.init();
  lcd.backlight();
  lcd.print("Cargando...");

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500); Serial.print(".");
  }
  
  configTime(0, 0, "pool.ntp.org", "time.nist.gov");
  while (time(nullptr) < 1000) { delay(500); }

  config.host = FIREBASE_HOST;
  config.signer.tokens.legacy_token = FIREBASE_AUTH;
  Firebase.begin(&config, &auth);
  Firebase.reconnectWiFi(true);

  lcd.clear();
}

void loop() {
  unsigned long ahora = millis();

  // 1. LECTURAS
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  int mq135 = analogRead(pinMQ135); 
  int mq2   = analogRead(pinMQ2);   
  int mq7   = analogRead(pinMQ7);   

  // 2. MONITOR SERIE
  if (ahora % 1000 < 100) {
    Serial.printf("T:%0.1f H:%0.1f | CO2:%d GLP:%d CO:%d\n", t, h, mq135, mq2, mq7);
  }

  // 3. ENVÍO FIREBASE
  if (ahora - tEnvio >= 10000) {
    tEnvio = ahora;
    FirebaseJson json;
    json.set("temperatura", isnan(t) ? 0 : t);
    json.set("humedad", isnan(h) ? 0 : h);
    json.set("co2_mq135", mq135);
    json.set("glp_mq2", mq2);
    json.set("co_mq7", mq7);
    Firebase.pushJSON(firebaseData, "/lecturas", json);
  }

  // 4. LÓGICA DE PANTALLA
  if (ahora - tBranding >= 10000) {
    tBranding = ahora;
    mostrandoNombre = true;
  }

  if (mostrandoNombre) {
    lcd.clear();
    lcd.setCursor(1, 0);
    lcd.print(">> AIRCONNECT <<");
    lcd.setCursor(0, 1);
    lcd.print("  UTRM RIVIERA  ");
    delay(2000); 
    mostrandoNombre = false;
    lcd.clear();
  } 
  else {
    // PANTALLA DE DATOS NORMAL
    if (mq2 > umbralAlerta || mq7 > umbralAlerta) {
      digitalWrite(ledRojo, HIGH); digitalWrite(ledVerde, LOW);
      digitalWrite(pinBuzzer, HIGH); delay(100); digitalWrite(pinBuzzer, LOW);
      
      lcd.setCursor(0, 0); lcd.print("!!! ALERTA !!!  ");
      lcd.setCursor(0, 1); 
      if(mq2 > umbralAlerta) lcd.print("GAS GLP DETECT. "); 
      else                   lcd.print("CO PELIGROSO    ");
    } 
    else {
      digitalWrite(ledRojo, LOW); digitalWrite(ledVerde, HIGH);
      digitalWrite(pinBuzzer, LOW);

      lcd.setCursor(0, 0);
      if (isnan(t)) {
        lcd.print("Error Sensor DHT");
      } else {
        lcd.print("T:"); lcd.print((int)t); lcd.print("C  H:"); lcd.print((int)h); lcd.print("%    ");
      }

      lcd.setCursor(0, 1);
      char buf[17];
      // CO2 (MQ135), G (GLP), C (CO)
      sprintf(buf, "CO2:%d G:%d C:%d", mq135, mq2/100, mq7/100);
      lcd.print(buf);
    }
  }

  delay(200); 
}
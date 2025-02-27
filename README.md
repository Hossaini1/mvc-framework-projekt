# MVC Design-Pattern in der Anwendungen

- MVC steht für Model-View-Controller und ist ein Architektur-Pattern / Design-Pattern, das in Anwendungen verwendet wird, um den Code sauber, strukturiert und leichter wartbar zu machen.

### Das Konzept hinter MVC

- MVC trennt eine Anwendung in drei Hauptkomponenten:

1. Model (Datenlogik)

- Enthält die Geschäftslogik der Anwendung.
  Verantwortlich für das Abrufen, Speichern und Verarbeiten von Daten aus der Datenbank.

2. View (Präsentationsebene)

- Zeigt die Daten aus dem Model an.
  Enthält HTML, CSS und manchmal einfache Skripte zur Darstellung.
  Controller (Steuerungsebene)

3. Controller ist Vermittler zwischen Model und View.

- Nimmt Benutzereingaben entgegen, ruft die entsprechenden Model-Methoden auf und gibt die Daten an die View weiter.

## 1. Beispiel Projektstruktur in PHP-Anwendung

```
/mvc-app
 ├── index.php
 ├── controllers/
 │   ├── UserController.php
 ├── models/
 │   ├── User.php
 ├── views/
 │   ├── users.php
 ├── config/
 │   ├── database.php
```

---

## 2. Model – `models/User.php`

```php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUsers() {
        $query = $this->db->query("SELECT * FROM users");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

---

## 3. Controller – `controllers/UserController.php`

```php
require_once 'models/User.php';
require_once 'config/database.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User($db);
    }

    public function index() {
        $users = $this->userModel->getUsers();
        require 'views/users.php';
    }
}
```

---

## 4. View – `views/users.php`

```php
<!DOCTYPE html>
<html>
<head><title>User List</title></head>
<body>
    <h2>User List</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= htmlspecialchars($user['name']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
```

---

## 5. Hauptdatei – `index.php`

```php
require_once 'controllers/UserController.php';

$controller = new UserController();
$controller->index();
```

---

## 6. Datenbankverbindung – `config/database.php`

```php
$dsn = 'mysql:host=localhost;dbname=mydatabase;charset=utf8';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindungsfehler: " . $e->getMessage());
}
```

---

## Vorteile von MVC

- **Trennung von Logik und Darstellung** → Bessere Wartbarkeit
- **Wiederverwendbare Komponenten** → Views und Models können wiederverwendet werden
- **Bessere Code-Organisation** → Code ist sauberer und verständlicher
- **Leichtere Zusammenarbeit** → Entwickler können sich auf einzelne Teile konzentrieren

---

Dieses MVC-System stellt eine grundlegende Implementierung dar. Es kann durch Routing, Middleware und weitere Features erweitert werden.

---

![MVC Design-Pattern](./images/mvc.png)
---

### Tag 2 ( Virtual-Host )

- Ein Virtual Host (Virtueller Host) in Apache erlaubt es, mehrere Websites oder Projekte auf einem einzigen Server zu hosten und ihnen individuelle Domains oder Subdomains zuzuweisen. Statt localhost/projektname/public zu verwenden, kann man mit einem Virtual Host beispielsweise projekt.local oder mvc.local aufrufen.

---
### Konzept hinter Virtual Hosts:
#### 1. Bessere Struktur für Projekte 
- Ohne Virtual Hosts sieht es so aus:  localhost/mvc/public
- Mit Virtual Hosts: mvc.local

#### 2. Erleichterung der Entwicklung
- Statt umständliche Pfade mit /public zu verwenden, kann man die URL direkt nutzen. Und es Erlaubt eine realistischere Umgebung, ähnlich einer echten Domain.

#### 3.Unabhängige Konfiguration für Projekte
- Jedes Projekt kann eigene Apache- und PHP-Einstellungen haben. Und somit jedes Projekt eigene Error Logs, eigene SSL-Zertifikate für HTTPS-Testing.


#### 4. Vermeidung von Konflikten mit .htaccess
- In vielen Frameworks (z. B. Laravel, Symfony, MVC-Strukturen) erwartet die .htaccess, dass der public-Ordner der Einstiegspunkt ist. Und Ohne Virtual Hosts müsstest du /public immer manuell angeben.

---
# Virtual Host in XAMPP einrichten (Windows)

## 1️⃣ Apache Virtual Host Datei bearbeiten

Öffne die Datei `httpd-vhosts.conf` in XAMPP. Der Standardpfad ist:

📂 **Windows (XAMPP)**
```
C:\xampp\apache\conf\extra\httpd-vhosts.conf
```

Füge folgenden Code am Ende der Datei hinzu:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/mvc/public"
    ServerName mvc.local
    ErrorLog "C:/xampp/apache/logs/mvc.local-error.log"
    CustomLog "C:/xampp/apache/logs/mvc.local-access.log" common
    <Directory "C:/xampp/htdocs/mvc/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<!-- Hinweis wenn vor ihnen ## steht dann mussen wir sie weglöschen damit virtuale-host active werden. -->
```

🚀 **Was passiert hier?**
- `DocumentRoot` gibt an, wo sich das Projekt befindet.
- `ServerName` gibt den Namen an, unter dem das Projekt erreichbar wird.
- `AllowOverride All` erlaubt `.htaccess`-Regeln.
- `"ErrorLog "C:/xampp/apache/logs/mvc.local-error.log"` , Speichert alle Fehler, die während des Betriebs deiner Website auftreten, in der Datei mvc-error.log.
- `"CustomLog "C:/xampp/apache/logs/mvc.local-access.log" common` Speichert alle Anfragen an deinen Virtual Host in der Datei `mvc.local-access.log` und enthält Informationen zu jeder Anfrage, wie IP-Adresse des Clients, Zeitpunkt, HTTP-Statuscode und angeforderte Ressourcen.

---

## 2️⃣ Host-Datei bearbeiten

Da `mvc.local` keine echte Domain ist, muss sie lokal in die Hosts-Datei eingetragen werden.

📂 **Windows (Notepad als Admin öffnen)**
```
C:\Windows\System32\drivers\etc\hosts
```

➡ **Füge am Ende der Datei hinzu:**

```
127.0.0.1   mvc.local
```

---

## 3️⃣ Apache neu starten

Damit die Änderungen greifen, muss der Apache-Server neugestartet werden:

➡ **XAMPP Control Panel öffnen** → **Apache neu starten**
 
 ---

- Für mehrere Projekte müssen wir für jedes Projekt eigene virtual-host wie folgende bespiele erstellen.

```apache
<!-- Das ist für MVC Projekt. -->
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/mvc/public"
    ServerName mvc.local
    ErrorLog "logs/dummy-host2.example.com-error.log"
    CustomLog "logs/dummy-host2.example.com-access.log" common
    <Directory "C:/xampp/htdocs/mvc/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

<!-- Und das ist für blog Projekt. -->
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/blog/public"
    ServerName blog.local
    ErrorLog "logs/dummy-host2.example.com-error.log"
    CustomLog "logs/dummy-host2.example.com-access.log" common
    <Directory "C:/xampp/htdocs/blog/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

```
---
### Tag 3  Composer in PHP: Einführung und Installation
### Was ist Composer?
Composer ist ein **Paketmanager für PHP**, der die Verwaltung von Abhängigkeiten und Bibliotheken erleichtert. Er ermöglicht Entwicklern, externe PHP-Bibliotheken einfach in ein Projekt einzubinden und aktuell zu halten.

## Konzept von Composer
Das Hauptkonzept von Composer ist die **abhängigkeitsbasierte Paketverwaltung**:
- **Zentrale Paketverwaltung** – Pakete werden aus dem [Packagist-Repository](https://packagist.org/) bezogen.
- **Automatische Abhängigkeitsauflösung** – Falls ein Paket weitere Pakete benötigt, kümmert sich Composer um die Installation der richtigen Versionen.
- **Autoloading** – Composer generiert automatisch eine `autoload.php`, um Klassen einfach in PHP zu laden.
- **Versionsmanagement** – Composer nutzt Semantische Versionierung (SemVer), um kompatible Paketversionen zu verwenden.

## Installation von Composer

### 1. Global Installation (empfohlen)
#### **Linux/MacOS**
```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
```

#### **Windows**
1. [Offizielle Composer-Setup-Datei](https://getcomposer.org/download/) herunterladen.
2. Installation ausführen und `composer` in der PATH-Variable hinzufügen.

Nach der Installation kann mit `composer -V` geprüft werden, ob Composer korrekt installiert wurde.

### 2. Lokale Installation (im Projektverzeichnis)
```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
```
Dies lädt `composer.phar` ins Projektverzeichnis.

## Initialisierung eines Composer-Projekts (`init` Methoden)
Es gibt zwei Hauptwege, um Composer in einem Projekt zu initialisieren:

### 1. Manuelle Initialisierung (`composer init`)
```sh
composer init
```
Dieser Befehl startet einen interaktiven Prozess zur Erstellung der `composer.json`-Datei.

### 2. Automatische Initialisierung (`composer require`)
Falls man direkt ein Paket installieren möchte, kann man `composer require` nutzen:
```sh
composer require monolog/monolog
```
Dadurch wird `composer.json` automatisch erstellt und das Paket **Monolog** installiert.

#### Oder alternative Methode
Erst eine composer.json erstellen mit leere object drin {} dann führe folgende Befehl aus in Terminal.
```sh
composer dump-autoload -o
```

- Was macht composer dump-autoload?

Der Befehl composer dump-autoload generiert die Autoload-Dateien neu. Diese Dateien enthalten eine Zuordnung von Klassen zu ihren jeweiligen Dateipfaden. Dadurch wird es PHP ermöglicht, Klassen automatisch zu laden, sobald sie im Code verwendet werden. Dies ist besonders wichtig, da PHP standardmäßig nicht weiß, wo sich die Dateien der verschiedenen Klassen befinden.

- Was bewirkt der Parameter -o?

Der Parameter -o steht für "optimize" (optimieren). Er bewirkt, dass Composer die Autoload-Dateien so generiert, dass sie für den Produktionseinsatz optimiert sind. Dies führt zu einer schnelleren Ladezeit der Klassen, da die Zuordnungen effizienter gespeichert werden.


## Fazit
Composer ist ein **unverzichtbares Tool für PHP-Entwicklung**, das eine saubere Verwaltung von Bibliotheken und Abhängigkeiten ermöglicht. Es kann entweder **global** oder **lokal** installiert werden und bietet verschiedene Möglichkeiten zur Initialisierung eines Projekts.








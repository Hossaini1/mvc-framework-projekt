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

3. Vermittler zwischen Model und View.

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




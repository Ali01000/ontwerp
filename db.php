/* ==========================================================
   📁 Bestand: db.sql
   ========================================================== */

-- Maak de database aan
CREATE DATABASE IF NOT EXISTS login_db;
USE login_db;

-- Maak de tabel aan
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);



/* ==========================================================
   📁 Bestand: db.php
   ========================================================== */

<?php
class User {
    private $conn;

    // 🔌 Database connectie
    public function dbConnect() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login_db";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Verbinding mislukt: " . $this->conn->connect_error);
        }
        return $this->conn;
    }

    // 📝 Registreren
    public function registerUser($username, $email, $password) {
        $conn = $this->dbConnect();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Gebruiker succesvol geregistreerd.</p>";
        } else {
            echo "<p style='color:red;'>❌ Fout bij registreren: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }

    // 🔐 Inloggen
    public function loginUser($username, $password) {
        $conn = $this->dbConnect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "<p style='color:red;'>❌ Ongeldig wachtwoord.</p>";
            }
        } else {
            echo "<p style='color:red;'>❌ Gebruiker niet gevonden.</p>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>



/* ==========================================================
   📁 Bestand: register.php
   ========================================================== */

<?php
require_once 'db.php'; // <-- aangepast!
$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user->registerUser($username, $email, $password);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
</head>
<body>
    <h2>📝 Registratie</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Gebruikersnaam" required><br><br>
        <input type="email" name="email" placeholder="E-mail" required><br><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br><br>
        <button type="submit">Registreer</button>
    </form>
    <p>Al een account? <a href="login.php">Login hier</a></p>
</body>
</html>



/* ==========================================================
   📁 Bestand: login.php
   ========================================================== */

<?php
require_once 'db.php'; // <-- aangepast!
$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user->loginUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>🔐 Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Gebruikersnaam" required><br><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Nog geen account? <a href="register.php">Registreer hier</a></p>
</body>
</html>



/* ==========================================================
   📁 Bestand: dashboard.php
   ========================================================== */

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welkom, <?php echo $_SESSION['username']; ?> 👋</h2>
    <p>Je bent succesvol ingelogd!</p>
    <a href="logout.php">Uitloggen</a>
</body>
</html>



/* ==========================================================
   📁 Bestand: logout.php
   ========================================================== */

<?php
session_start();
session_destroy();
header("Location: login.php");
exit;
?>

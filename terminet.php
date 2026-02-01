<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Terminet.php';
require_once 'Classes/Doktoret.php';

$database = new Database();
$db = $database ->getConnection();
$doktoret = new Doktoret($db);

$message = '';
if ($_POST) {
    $termin = new Terminet($db);
    
    $termin->fullname = $_POST['fullname'];
    $termin->email = $_POST['email'];
    $termin->phone = $_POST['phone'] ?? '';
    $termin->doctor = $_POST['doctor'];
    $termin->appointment_date = $_POST['date'];
    $termin->appointment_time = $_POST['time'];
    $termin->symptoms = $_POST['symptoms'];
    
    if ($termin->create()) {
        $message = "Termini u ruajt me sukses!";
        $_POST = [];
    } else {
        $message = "Gabim gjatë ruajtjes";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- duhet me rregullu style.css per krejt imazhet -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical - Health Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $isLoggedIn = isset($_SESSION['user_id']);
    $isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    ?>

    <header>
        <div class="header-container header-row">
            <div class="brand">
                <div class="logo-box">
                    <img src="Library/Logo.png" alt="logo">
                </div>
            </div>

            <button class="hamburger" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav>
                <a href="index.php">Ballina</a>
                <a href="rrethnesh.php">Rreth Nesh</a>
                <a href="galeria.php">Galeria</a>
                <a href="cmimet.php">Çmimet</a>
                <a href="terminet.php">Terminet</a>

                <?php if ($isAdmin): ?>
                    <a href="dashboard.php">Dashboard</a>
                <?php endif; ?>

                <?php if ($isLoggedIn): ?>
                    <a href="logout.php">Dil</a>
                <?php else: ?>
                    <a href="login.php">Kyçu</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <section class="section appointment">
    <div class="container text-center">

        <h2 class="title">Cakto një Termin</h2>
        <p class="subtitle">Plotesoni formularin e mëposhtëm për të planifikuar vizitën tuaj</p>

        <?php if($message): ?>
        <div style="padding:15px; margin:20px 0; background:#d4edda; color:#155724; border:1px solid green; border-radius:8px;">
            <?= $message ?>
        </div>
    <?php endif; ?>
        
        <form class="form" id="appointmentForm" method="POST">

            <div class="row">
                <input type="text" name="fullname" placeholder="Emri i plotë" required>
                <input type="email" name="email" placeholder="Email Adresa" required>
            </div>

            <div class="row">
                <input type="tel" name="phone" placeholder="Nr. Telefonit">
                <select name="doctor" required>
                    <?php 
                    $doktor_stmt = $doktoret->read();
                    while($doktor_row = $doktor_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = $edit_termin->doctor == $doktor_row['emri'].' '.$doktor_row['mbiemri'] ? 'selected' : '';
                        echo "<option value=\"{$doktor_row['emri']} {$doktor_row['mbiemri']}\" $selected>{$doktor_row['emri']} {$doktor_row['mbiemri']} ({$doktor_row['specializimi']})</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="row">
                <input type="date" name="date" required min="<?= date('Y-m-d') ?>">
                <input type="time" name="time" required>
            </div>

            <div class="row full">
                <textarea name="symptoms" placeholder="Përshkruaj simptomat tuaja" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-appointment">Rezervo Terminin</button>

        </form>

    </div>
</section>

    <footer>
        <div class="footer-row">

            <div>
                <h4>Rreth Kompanise</h4>
                <ul>
                    <li><a href="rrethnesh.php">Rreth nesh</a></li>
                    <li><a href="galeria.php">Foto</a></li>
                    <li><a href="cmimet.php">Cmimet</a></li>
                    <li><a href="terminet.php">Cakto Termin</a></li>
                </ul>
            </div>

            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Serviset</a></li>
                    <li><a href="#">Departamentet</a></li>
                    <li><a href="#">Doktoret</a></li>
                    <li><a href="#">Kontakt</a></li>
                </ul>
            </div>

            <div>
                <h4>Orari i punës</h4>
                <ul>
                    <li>Mon - Fri: 9:00 AM - 6:00 PM</li>
                    <li>Sat: 10:00 AM - 4:00 PM</li>
                    <li>Sun: Vetem emergjencat</li>
                    <li>24/7 Emergency</li>
                </ul>
            </div>

            <div>
                <h4>Mediat Sociale</h4>
                <div class="social-links">
                    <a href="facebook.com">Facebook</a>
                    <a href="twitter.com">X</a>
                    <a href="linkedin.com">LinkedIn</a>
                    <a href="instagram.com">Instagram</a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 WEB UBT. All rights reserved. | Privacy Policy | Terms & Conditions| </p>
        </div>
    </footer>
    <script src="script.js"></script>    
    <script src="validimet.js"></script>

</body>
</html>
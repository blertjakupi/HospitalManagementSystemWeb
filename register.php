<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $perdoruesi = trim($_POST['username']);
    $email = trim($_POST['email']);
    $fjalekalimi = $_POST['password'];
    $perserit_fjalekalimi = $_POST['cpassword'];
    
    if (empty($perdoruesi) || empty($email) || empty($fjalekalimi)) {
        $error = 'Mbushni të gjitha fushat!';
    } elseif (strlen($fjalekalimi) < 6) {
        $error = 'Fjalëkalimi duhet të ketë minimumi 6 karaktere!';
    } elseif ($fjalekalimi !== $perserit_fjalekalimi) {
        $error = 'Fjalëkalimet nuk përputhen!';
    } else {
        $user->perdoruesi = $perdoruesi;
        $user->email = $email;
        $user->fjalekalimi = $fjalekalimi;
        $user->role = 'user';
        
        if ($user->create()) {
            $success = 'Regjistrimi u krye! Mund të kyçesh tani.';
        } else {
            $error = 'Gabim gjatë regjistrimit. Provo përsëri.';
        }
    }
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical</title>
    <link rel="stylesheet" href="loginregister.css">
    <style>
        .alert { 
            padding: 12px; margin: 15px 0; border-radius: 5px; text-align: center;
         }
        .alert-error { 
            background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
        }
        .alert-success { 
            background: #d4edda; color: #155724; border: 1px solid #c3e6cb; 
        }
    </style>
</head>

<body>

    <header>
        <div class="header-container header-row">
            <div class="brand">
                <div class="logo-box"><img src="Library/Logo.png" alt="logo"></div>
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
                <a href="login.php">Kyçu</a>
            </nav>
        </div>
    </header>

    <div class="container" id="registerID">
        <form action="" method="post" class="login-email" id="registerForm">

            <p class="login-text">Medical Health - Regjistrohu Tani!</p>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <div class="input-group">
                <input type="text" placeholder="Perdoruesi" name="username" required>
            </div>

            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>

            <div class="input-group">
                <input type="password" placeholder="Fjalekalimi" name="password" required>
            </div>

            <div class="input-group">
                <input type="password" placeholder="Perserit Fjalekalimin" name="cpassword" required>
            </div>

            <div class="input-group">
                <button name="submit" class="btn">Regjistrohu</button>
            </div>

            <p class="login-register-text">Ke llogari? <a href="login.php">Kyqu Tani!</a></p>
            <p id="formError" style="color:red; text-align:center; margin-top:10px; min-height: 20px;"></p>

        </form>

    </div>


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

<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$error = '';
$input_email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_email = trim($_POST['email']);
    $input_password = $_POST['password'];
    
    if (empty($input_email) || empty($input_password)) {
        $error = 'Mbushni email dhe fjalëkalimin!';
    } else {
        $user->email = $input_email;
        $user->fjalekalimi = $input_password;
        
        if ($user->login()) {
            if ($user->isAdmin()) {
                header('Location: dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = 'Email ose fjalëkalim i gabuar!';
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
                <?php if ($user->isLoggedIn()): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Dil</a>
                <?php else: ?>
                <a href="login.php">Kyçu</a>
                 <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="container">
        <form action="" method="post" class="login-email" id="loginForm">

            <p class="login-text">Medical Health - Kyçu</p>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required 
                       value="<?php echo htmlspecialchars($input_email); ?>">
            </div>


            <div class="input-group">
                <input type="password" placeholder="Fjalekalimi" name="password" required>
            </div>

            <div class="input-group">
                <button name="submit" class="btn" >Kyqu</button>
            </div>

            <p class="login-register-text">Nuk ke llogari? <a href="register.php">Regjistrohu Tani!</a></p>
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

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'classes/Database.php';
require_once 'classes/Abonimet.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $error = 'Duhet të jeni të kyçur për të zgjedhur një plan.';
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $abonim = new Abonimet($db);
        $abonim->user_id = $_SESSION['user_id'];
        $abonim->pako = $_POST['pako'];
        $abonim->cmimi = $_POST['cmimi'];
        $abonim->status = 'aktiv';

        if ($abonim->hasActiveSubscription()) {
                $error = 'Ju tashmë keni një abonim aktiv.';
        } else {
            if ($abonim->create()) {
                  $message = 'U abonuat me sukses në planin e zgjedhur.';
             } else {
                    $error = 'Ndodhi një gabim. Ju lutem provoni përsëri.';
             }
        }
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
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

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


    <section class="pricing section">
                <?php if ($error): ?>
                    <div style="
                        text-align:center;
                        font-size:1.2rem;
                        margin:20px auto;
                        padding:10px 15px;
                        border-radius:5px;
                        width:fit-content;
                        color:#721c24;
                        background-color:#f8d7da;
                        border:1px solid #f5c6cb;
                    ">
                <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div style="
                        text-align:center;
                        font-size:1.2rem;
                        margin:20px auto;
                        padding:10px 15px;
                        border-radius:5px;
                        width:fit-content;
                        color:#155724;
                        background-color:#d4edda;
                        border:1px solid #c3e6cb;
                    ">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>


        <div class="container text-center">

            <h2 class="title">Çmimet tona</h2>
            <p class="subtitle">Zgjidhni planin më të mirë për nevojat tuaja mjekësore</p>

            <div class="grid grid-3">

                <!-- Card 1 -->
        <div class="pricing-card">
            <h3>Pako Bazike</h3>
            <div class="pricing-price">$50</div>
            <div class="pricing-period">Muaji</div>
            <ul class="pricing-features">
                <li>✔ Kontrolle të përgjithshme</li>
                <li >✔ Diagnostike bazë</li>
                <li>✔ 24/7 Support</li>
                <li>✖ Vizita nga specialistët</li>
            </ul>
            <form method="POST">
                <input type="hidden" name="pako" value="Pako Bazike">
                <input type="hidden" name="cmimi" value="50">
                <button type="submit" class="pricing-btn">Zgjedh Planin</button>
            </form>
        </div>

                <!-- Card 2 -->
        <div class="pricing-card">
            <h3>Pako e Avancuar</h3>
            <div class="pricing-price">$79</div>
            <div class="pricing-period">Muaji</div>
            <ul class="pricing-features">
                <li>✔ Kontrolle të përgjithshme</li>
                <li >✔ Diagnostikë e plotë</li>
                <li>✔ Vizita nga Specialistët</li>
                <li>✔ Support me prioritet</li>
            </ul>
            <form method="POST">
                <input type="hidden" name="pako" value="Pako e Avancuar">
                <input type="hidden" name="cmimi" value="79">
                <button type="submit" class="pricing-btn">Zgjedh Planin</button>
            </form>
        </div>

                <!-- Card 3 -->
        <div class="pricing-card">
            <h3>Pako Premium</h3>
            <div class="pricing-price">$129</div>
            <div class="pricing-period">Muaji</div>
            <ul class="pricing-features">
                <li>✔ All inclusive</li>
                <li >✔ Vizita te Specialistet pa limit</li>
                <li>✔ Trajtim VIP</li>
                <li>✔ Vizita nga specialistët</li>
            </ul>
            <form method="POST">
                <input type="hidden" name="pako" value="Pako Premium">
                <input type="hidden" name="cmimi" value="129">
                <button type="submit" class="pricing-btn">Zgjedh Planin</button>
            </form>
        </div>

            </div>

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
                <ul class="social-links">
                    <li><a href="facebook.com">Facebook</a></li>
                    <li><a href="twitter.com">X</a></li>
                    <li><a href="linkedin.com">LinkedIn</a></li>
                    <li><a href="instagram.com">Instagram</a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 WEB UBT. All rights reserved. | Privacy Policy | Terms & Conditions| </p>
        </div>
    </footer>
    
    <script src="script.js"></script>
</body>
</html>
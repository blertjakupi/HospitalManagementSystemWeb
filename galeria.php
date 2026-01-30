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

    <section class="gallery section">
        <div class="container text-center">

            <h2 class="title">Galeria jonë</h2>
            <p class="subtitle">Një vështrim brenda ambienteve dhe shërbimeve tona</p>

            <div class="grid grid-4">

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/1.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/2.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/3.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/4.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/5.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/6.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/7.jpg" alt=""></div>
                </div>

                <div class="gallery-item card-hover">
                    <div class="placeholder h-200"><img src="Library/11.jpg" alt=""></div>
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
</body>
</html>
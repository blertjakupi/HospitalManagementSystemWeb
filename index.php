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

    <section class="hero section">
        <div class="container">
            <div class="hero-content">
                <h1>Ne Ofrojmë Zgjidhje të Plotë për Kujdesin Shëndetësor<h1>
                        <p>Në qendrën tonë, shendeti juaj është prioriteti ynë kryesor. Ofrojmë konsulta mjeksore,
                            ekzaminime të detajuara dhe trajtim të personalizuar nga doktorë të licencuar. Besoni tek ne
                            për kujdes cilësor dhe rezultate të shkëlqyera në çdo hap të trajtimit tuaj.</p>
                        <button class="btn-hero" onclick="location.href='terminet.html'">Cakto Terminin</button>
            </div>
            <div class="hero-image center">
                <div class="img-hero"><img src="Library/Doctors.png"></div>
            </div>
        </div>
    </section>

    <section class="features section">

        <div class="container">
            <div class="grid grid-4">
                <div class="card feature-box card hover">
                    <div class="icon-box">🏥</div>
                    <h3>Pajisje Moderne</h3>
                    <p>Pajisje dhe teknologji inovative</p>
                </div>
                <div class="card feature-box card hover">
                    <div class="icon-box">🧑‍⚕️</div>
                    <h3>Staf Profesional </h3>
                    <p>Profesionistë mjekësorë me kualifikim të lartë</p>
                </div>
                <div class="card feature-box card hover">
                    <div class="icon-box">⏰</div>
                    <h3>Shërbim 24/7</h3>
                    <p>Ndihmë mjekësore 24/7</p>
                </div>
                <div class="card feature-box card hover">
                    <div class="icon-box">💊</div>
                    <h3>Kujdes Cilësor</h3>
                    <p>Praktikat dhe standardet më të mira mjekësore</p>
                </div>
            </div>
        </div>
    </section>

    <section class="team section">
        <div class="container text-center">
            <h2 class="title">Ekipi</h2>
            <p class="subtitle">Njoftohuni me doktorët tanë të perkushtuar</p>
            <!-- Slider -->
            <div class="team-slider">
                <!-- Shigjeta Majtas -->
                <button class="slider-btn slider-prev" onclick="moveSlide(-1)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <div class="slider-track" id="sliderTrack">
                    <div class="card card-hover">
                        <div class="placeholder h-280"><img src="Library/news1.jpg" alt="Nazmi Kolgeci"></div>
                        <div class="meta">
                            <h4>Nazmi Kolgeci</h4>
                            <p class="text-muted">Kirurg Torakal</p>
                        </div>
                    </div>

                    <div class="card card-hover">
                        <div class="placeholder h-280"><img src="Library/12.jpg" alt="Fatmire Berisha"></div>
                        <div class="meta">
                            <h4>Fatmire Berisha</h4>
                            <p class="text-muted">Dentiste</p>
                        </div>
                    </div>

                    <div class="card card-hover">
                        <div class="placeholder h-280"><img src="Library/news3.jpg" alt="Fatmir Ramadani"></div>
                        <div class="meta">
                            <h4>Fatmir Ramadani</h4>
                            <p class="text-muted">Kardiolog</p>
                        </div>
                    </div>

                    <div class="card card-hover">
                        <div class="placeholder h-280"><img src="Library/6.jpg" alt="Dr. Ahmed"></div>
                        <div class="meta">
                            <h4>Ahmed Morina</h4>
                            <p class="text-muted">Pediatër</p>
                        </div>
                    </div>

                    <div class="card card-hover">
                        <div class="placeholder h-280"><img src="Library/11.jpg" alt="Kastriot Llugagjiu"></div>
                        <div class="meta">
                            <h4>Kastriot Llugagjiu</h4>
                            <p class="text-muted">Radiolog</p>
                        </div>
                    </div>

                    <div class="card card-hover">
                        <div class="placeholder h-280"><img src="Library/10.jpg" alt="Dr. Besnik"></div>
                        <div class="meta">
                            <h4>Besnik Krasniqi</h4>
                            <p class="text-muted">Ortoped</p>
                        </div>
                    </div>
                </div>

                <button class="slider-btn slider-next" onclick="moveSlide(1)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <div class="slider-dots" id="sliderDots"></div>
        </div>
    </section>

    <section class="services section">
        <div class="container">
            <div class="grid grid-2">

                <div class="card service-row">
                    <div class="icon-box">🔬</div>
                    <div>
                        <h4>Shërbime Laboratorike</h4>
                        <p class="text-muted">Testime dhe analiza gjithëpërfshirëse</p>
                    </div>
                </div>

                <div class="card service-row">
                    <div class="icon-box">🩺</div>
                    <div>
                        <h4>Kontroll shëndetësor</h4>
                        <p class="text-muted">Monitorim i rregullt i shëndetit dhe kujdes parandalues</p>
                    </div>
                </div>

                <div class="card service-row">
                    <div class="icon-box">🏥</div>
                    <div>
                        <h4>Shërbime Dentare</h4>
                        <p class="text-muted">Kujdes dhe trajtim profesional dentar</p>
                    </div>
                </div>

                <div class="card service-row">
                    <div class="icon-box">🚑</div>
                    <div>
                        <h4>Ndihmë Emergjente</h4>
                        <p class="text-muted">24/7 Ekipi i emergjencave në gatishmëri 24/7</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="departments section">
        <div class="container text-center">

            <h2 class="title">Departamentet tona</h2>
            <p class="subtitle">Departamente mjekësore të specializuara për kujdes gjithëpërfshirës</p>

            <div class="grid grid-5">

                <div class="department-box card-hover">
                    <div class="department-icon">🏥</div>
                    <h3>Ortopedi</h3>
                </div>

                <div class="department-box card-hover">
                    <div class="department-icon">❤️</div>
                    <h3>Kardiologji</h3>
                </div>

                <div class="department-box card-hover">
                    <div class="department-icon">🧠</div>
                    <h3>Neurologji</h3>
                </div>

                <div class="department-box card-hover">
                    <div class="department-icon">👶</div>
                    <h3>Pediatri</h3>
                </div>

                <div class="department-box card-hover">
                    <div class="department-icon">🔬</div>
                    <h3>Patologji</h3>
                </div>

            </div>

        </div>
    </section>

    <section class="stats section">
        <div class="container">
            <div class="grid grid-4">

                <div class="stat-item">
                    <h3>420</h3>
                    <p>Nr. i Pacienteve</p>
                </div>

                <div class="stat-item">
                    <h3>83</h3>
                    <p>Nr. i Doktoreve</p>
                </div>

                <div class="stat-item">
                    <h3>31</h3>
                    <p>Nr. i Departamenteve</p>
                </div>

                <div class="stat-item">
                    <h3>5</h3>
                    <p>Nr. i Lokacioneve</p>
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

    <script src="slider.js"></script>
    <script src="script.js"></script>
</body>

</html>
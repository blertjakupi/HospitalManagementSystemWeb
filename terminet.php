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
    <header>
        <div class="container header-row">
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

    <section class="section appointment">
    <div class="container text-center">

        <h2 class="title">Cakto një Termin</h2>
        <p class="subtitle">Plotesoni formularin e mëposhtëm për të planifikuar vizitën tuaj</p>

        
        <form class="form" id="appointmentForm">
            
            <p id="formError" class="error-message" style="color: red; margin-bottom: 10px;"></p>

            <div class="row">
                <input type="text" name="fullname" placeholder="Emri i plotë">
                <input type="email" name="email" placeholder="Email Adresa">
            </div>

            <div class="row">
                <input type="tel" name="phone" placeholder="Nr. Telefonit">
                <input type="text" name="doctor" placeholder="Mjeku i Preferuar">
            </div>

            <div class="row">
                <input type="date" name="date" placeholder="Cakto Datën">
                <input type="time" name="time" placeholder="Cakto Kohën">
            </div>

            <div class="row full">
                <textarea name="symptoms" placeholder="Përshkruaj simptomat tuaja" rows="5"></textarea>
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
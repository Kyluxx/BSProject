<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyluxx Hotel Reservation</title>
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="css/offcanvas.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Kyluxx Hotel</div>
        <div class="auth">
<?php if(isset($_SESSION['user_id'])): ?>
    <a href='profile.php'><?php echo htmlspecialchars($_SESSION['name']); ?></a>
    <a class='o-menu-btn' onclick='toggleOffcanvas()'>☰</a>
<?php else: ?>
    <a href='login.php'>Login</a>
    <a href='register.php'>Sign Up</a>
<?php endif; ?>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-title">RELAX AND ENJOY THE LUXURY </div>
        
    </div>

    <!-- About Section -->
    <div class="about">
        <h2>About Us</h2>
        <p>Experience the best hospitality with world-class services and luxurious comfort.</p>
    </div>

    <!-- Facilities -->
    <div class="facilities">
        <h2>Our Facilities</h2>
        <div class="facility-list">
            <div class="facility">🏊 Swimming Pool</div>
            <div class="facility">🍽️ Restaurant</div>
            <div class="facility">💪 Gym & Fitness</div>
            <div class="facility">🛀 Spa & Wellness</div>
        </div>
    </div>

    <!-- Rooms Preview -->
    <div class="rooms">
        <div class="room-card">
            <img src="assets/rooms/r1.jpg" alt="Room 1">
            <div class="details">
                <h3>Deluxe Room</h3>
                <p>Spacious room with sky view.</p>
                <a href="booking.php?r=1" class="btn">Book Now</a>
            </div>
        </div>
        <div class="room-card">
            <img src="assets/rooms/r2.jpg" alt="Room 2">
            <div class="details">
                <h3>Suite Room</h3>
                <p>Luxury suite with king-size bed.</p>
                <a href="booking.php?r=2" class="btn">Book Now</a>
            </div>
        </div>
        <div class="room-card">
            <img src="assets/rooms/r3.jpg" alt="Room 3">
            <div class="details">
                <h3>Standard Room</h3>
                <p>Cozy and comfortable room.</p>
                <a href="booking.php?r=3" class="btn">Book Now</a>
            </div>
        </div>
    </div>

    <?php
    if(isset($_SESSION['user_id'])):
?>
    <div class="o-offcanvas" id="offcanvas">
        <div class="o-offcanvas-header">
            <h3>Akun Anda</h3>
            <button class="o-close-btn" onclick="toggleOffcanvas()">✖</button>
        </div>
        <div class="o-offcanvas-body">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>
            <p><strong>Balance:</strong> Rp1.500.000</p>
            <hr class="o-divider">
            <button class="o-btn o-btn-primary" onclick="location.href='reservasi.php'">Reservasi Anda</button>
            <button class="o-btn o-btn-danger" onclick="location.href='logout.php'">Log Out</button>
        </div>
    </div>
<?php endif; ?>


    <script>
        function toggleOffcanvas() {
            document.getElementById("offcanvas").classList.toggle("active");
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("DOM Loaded")
            const images = ["assets/hero/hero1.jpg", "assets/hero/hero2.jpg", "assets/hero/hero3.jpg"];
            let index = 0;
            const hero = document.querySelector(".hero");

            function changeBackground() {
                hero.style.backgroundImage = `url('${images[index]}')`;
                /*
                hero.style.opacity = 0;
                setTimeout(() => {
                    hero.style.opacity = 1;
                }, 1000);
                */
                index = (index + 1) % images.length;
            }

            setInterval(changeBackground, 5000);
        });
    </script>
</body>
</html>

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
    <a ><?php echo htmlspecialchars($_SESSION['name']); ?></a>
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
        <h2 class="ab">About Us</h2>
        <p class="ab">Experience the best hospitality with world-class services and luxurious comfort.</p>
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
    <?php include 'conn.php';
    $stmt = $conn->prepare('SELECT * FROM users WHERE uid = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    ?>
    <div class="o-popup" id="popup">
        <div class="o-popup-content">
            <h3>Your Account</h3>
            <p>Name: <?php echo htmlspecialchars($user['name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Balance: $<?php echo htmlspecialchars($user['account_balance']); ?></p>
            <button class="o-btn o-btn-danger" onclick="deleteAccount();">Delete account</button>
            <button class="o-btn o-btn-primary" onclick="togglePopup()">Close</button>
        </div>
    </div>
    <div class="o-popup" id="popup-reservation">
        <div class="o-popup-content">
        <h3>Reserved Room</h3>
        <div class="scroll-container">
        <ul id="reserved-li">

        </ul>
        </div>
            <button class="o-btn o-btn-primary" onclick="togglePopupReserve()">Close</button>
        </div>
    </div>
    <div class="o-popup" id="popup-room-details">
        <div class="o-popup-content">
            <h3>Room Details</h3>
            <p id="rname"></p>
            <p id="rprice"></p>
            <p id="rdays"></p>
            <p id="radult"></p>
            <p id="rchild"></p>
            <p id="rcin"></p>
            <p id="rcout"></p>
            <p id="rtday"></p>
            
            <button class="o-btn o-btn-primary" onclick="closeRoomInfo()">Close</button>
        </div>
    </div>
    <div class="o-offcanvas" id="offcanvas">
        <div class="o-offcanvas-header">
            <h3>Hello! <?php echo htmlspecialchars($_SESSION['name']); ?></h3>
            <button class="o-close-btn" onclick="toggleOffcanvas()">✖</button>
        </div>
        <div class="o-offcanvas-body">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>
            <p><strong>Balance:</strong> <?php echo htmlspecialchars("$" . $user['account_balance']); ?></p>
            <hr class="o-divider">
            <button class="o-btn o-btn-primary" onclick="showPopup()">Profile</button>
            <button class="o-btn o-btn-primary" onclick="getReservation()">Reservation</button>
            <button class="o-btn o-btn-primary" onclick="topupBal()">Top-up Balance</button>
            <button class="o-btn o-btn-danger" onclick="location.href='logout.php'">Log Out</button>
        </div>
    </div>
<?php endif; ?>


    <script>
        function deleteAccount(){
            if (confirm("This action will DELETE your account and all its associated data PERMANENTLY! Including the ACCOUNT BALANCE. Are you sure?")) {
                window.location.href = 'delete-account.php';
            }
        }
    </script>
    
    <script>
        function topupBal(){
            window.location.href = 'topup.php';
        }
    </script>
    <script>
        function getReservation(){
            fetch('get-reserved-room.php')
                .then(response => response.json())
                .then(data => {
                    const ul = document.getElementById('reserved-li');
                    if(data.length === 0) {
                        const li = document.createElement('li');
                        li.textContent = "You have no reserved room.";
                        ul.prepend(li);
                        return;
                    }
                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.room_name;
                        li.textContent = item.room_name + " "; // Tambahin spasi biar ga nempel
                
                        const btn = document.createElement('button');
                        btn.textContent = 'Cancel';
                        btn.classList.add('cancel-btn'); // Bisa styling nanti
                        btn.onclick = function() {
                            cancelReservation(item.bid); // Panggil function cancel dengan ID
                        };
                        const btninfo = document.createElement('button');
                        btninfo.textContent = '? ';
                        btninfo.classList.add('info-btn'); // Bisa styling nanti
                        btninfo.onclick = function() {
                            infoReservation(item.bid); // Panggil function cancel dengan ID
                        };
                        li.prepend(btninfo);
                        li.appendChild(btn);
                        ul.appendChild(li);
                    });
                });
            let popup = document.getElementById('popup-reservation');
            popup.classList.toggle('o-popup-active');
        }
        function togglePopupReserve() {
            let popup = document.getElementById('popup-reservation');
            let lidata = document.getElementById('reserved-li');
            popup.classList.toggle('o-popup-active');
            lidata.innerHTML='';
        }
        function cancelReservation(bid){
            fetch('cancel-reservation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ bid: bid })
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(err => console.error(err));
        }
        function infoReservation(bid){
            document.getElementById("popup-room-details").classList.add("o-popup-active");
            fetch('get-reserved-room.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ bid: bid })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("rname").textContent = `Room Name: ${data.room_name}`;
                    document.getElementById("rprice").textContent = `Price per Night: $${data.price}`;
                    document.getElementById("rdays").textContent = `Total Nights: ${data.total_day}`;
                    document.getElementById("radult").textContent = `Adults: ${data.adult}`;
                    document.getElementById("rchild").textContent = `Children: ${data.child}`;
                    document.getElementById("rcin").textContent = `Check-in Date: ${data.check_in}`;
                    document.getElementById("rcout").textContent = `Check-out Date: ${data.check_out}`;
                    document.getElementById("rtday").textContent = `Total Price: $${data.total_price}`;
                });
        }
        function closeRoomInfo(){
            document.getElementById("popup-room-details").classList.remove("o-popup-active");
        }
    </script>
    <script>
        function togglePopup() {
            let popup = document.getElementById('popup');
            popup.classList.toggle('o-popup-active');
        }
        function showPopup() {
            let popup = document.getElementById('popup');
            popup.classList.add('o-popup-active');
        }
    </script>
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
            hero.style.backgroundImage = `url('assets/hero/hero1.jpg')`;
            
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

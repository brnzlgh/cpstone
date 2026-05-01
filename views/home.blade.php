<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Saint John Bosco Institute</title>

<!-- ✅ FIXED CSS PATHS -->
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<header>
    <div class="header-text">
        <h1>Saint John Bosco Institute of Arts and Sciences - Angono</h1>
        <p>"Here, You're a student, a friend, and a family."</p>
    </div>

    <nav class="nav">
        <a href="/">Home</a>
        <a href="/enroll">Online Application</a>
        <a href="#">Strands</a>
        <a href="#">Bills</a>
        <a href="#">About Us</a>
    </nav>

    <a href="/login" class="profile"></a>
</header>

<section class="hero">
    <div class="hero-content">
        <h2>Start Your Enrollment Journey Today</h2>
        <p>Manage enrollment, payments, and student information securely.</p>
        
        <div class="hero-buttons">
            <!-- ✅ FIXED LINKS -->
            <button class="btn btn-primary" onclick="window.location.href='/enroll'">Submit Online Application Now</button>
            <button class="btn btn-outline">Explore Strands</button>
        </div>
    </div>
</section>

<section class="section">
    <h2>Services</h2>
    <div class="cards">
        <div class="card" onclick="window.location.href='/enroll'">
            <h3>Online Application</h3>
            <p>Start your Saint John Bosco journey today!</p>
        </div>

        <div class="card">
            <h3>Strands</h3>
            <p>View Strands and School Requirements</p>
        </div>

        <div class="card">
            <h3>Bills</h3>
            <p>Pay student bills</p>
        </div>

        <div class="card">
            <h3>About Us</h3>
            <p>Know more about us</p>
        </div>
    </div>
</section>

<footer>
    <p>© 2026 Saint John Bosco Institute</p>
</footer>

<!-- ✅ FIXED JS PATH -->
<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
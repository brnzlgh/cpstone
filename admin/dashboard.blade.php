<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
body {
    font-family: Arial;
    background: #0d2c6c;
    margin: 0;
}

/* HEADER */
.header {
    background: #081f4a;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
}

/* LEFT HEADER */
.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-left img {
    height: 40px;
}

/* NAV LINKS */
.nav-links a {
    margin-right: 15px;
    text-decoration: none;
    color: white;
    font-weight: bold;
}

.nav-links a:hover {
    text-decoration: underline;
}

/* RIGHT HEADER */
.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* LOGOUT */
.logout-btn {
    background: red;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.logout-btn:hover {
    background: darkred;
}

/* CONTENT */
.container {
    padding: 30px;
    color: white;
}

/* CARDS */
.cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 250px;
    background: white;
    color: black;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.card h3 {
    margin-top: 0;
    color: #0d2c6c;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">

    <!-- LEFT: LOGO + TITLE + NAV -->
    <div class="header-left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <h2>Enrollment System</h2>

        <div class="nav-links">
            <a href="/dashboard">Dashboard</a>
            <a href="/enrollees">Enrollees</a>
            <a href="/students">Students</a>
        </div>
    </div>

    <!-- RIGHT: USER + LOGOUT -->
    <div class="header-right">
        <span>{{ auth()->user()->name }}</span>

        <form method="POST" action="/logout">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

</div>

<!-- CONTENT -->
<div class="container">

    <h2>Welcome, {{ auth()->user()->name }}</h2>
    <p>Manage student enrollments here.</p>

    <div class="cards">

        <div class="card">
            <h3>📊 Enrollment Overview</h3>
            <p>View total enrollees, approved students, and archived records.</p>
        </div>

        <div class="card">
            <h3>📁 Student Submissions</h3>
            <p>Check new applications in the Enrollees section.</p>
        </div>

        <div class="card">
            <h3>🎓 Manage Students</h3>
            <p>View and manage enrolled students, strands, and sections.</p>
        </div>

    </div>

</div>

</body>
</html>
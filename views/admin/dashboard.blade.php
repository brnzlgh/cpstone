<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<style>
body {
    font-family: Arial;
    margin: 0;
    background: #f4f7fb; /* ✅ lighter background */
}

/* HEADER */
.header {
    background: #0f2a5c; /* ✅ cleaner blue */
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    color: white;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* NAV LINKS */
.nav-links a {
    margin-right: 15px;
    color: white;
    text-decoration: none;
    font-weight: bold;
}

/* LAYOUT */
.wrapper {
    display: flex;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    background: #0b1f47; /* ✅ darker navy */
    min-height: 100vh;
    padding: 20px;
}

.sidebar h3 {
    color: white;
    margin-bottom: 15px;
}

.sidebar a {
    display: block;
    background: #1e88e5; /* ✅ clean blue */
    color: white;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.2s;
}

.sidebar a:hover {
    background: #1565c0;
}

/* MAIN CONTENT */
.main {
    flex: 1;
    padding: 30px;
    color: #333; /* ✅ readable */
}

/* CARD */
.card {
    background: white;
    color: black;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.card h3 {
    margin-top: 0;
    color: #0f2a5c;
}

/* STATS */
.stats {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.stat-box {
    flex: 1;
    background: #f4f7fb;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #e0e6f0;
}

h2, h3 {
    letter-spacing: 0.5px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="header-left">

        <!-- ✅ CLICKABLE LOGO -->
        <a href="/dashboard" style="display:flex; align-items:center; gap:10px; text-decoration:none; color:white;">
            <img src="{{ asset('images/logo.png') }}" style="height:40px;">
            <h2 style="margin:0;">Enrollment System</h2>
        </a>

        <div class="nav-links">
            <a href="/dashboard">Dashboard</a>
        </div>
    </div>

    <div>
        {{ auth()->user()->name }}
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button style="background:red;color:white;border:none;padding:5px 10px;border-radius:5px;">Logout</button>
        </form>
    </div>
</div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Navigation</h3>

        <a href="/enrollees">📁 Student Submissions</a>
        <a href="/students">🎓 Manage Students</a>
        <a href="/students/archived">📦 Archived Students</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <h2>Enrollment Overview</h2>
        <p>View total enrollees, approved students, and archived records.</p>

        <div class="card">

            <div class="stats">

                <div class="stat-box">
                    <h3>{{ \App\Models\Enrollee::count() }}</h3>
                    <p>Total Enrollees</p>
                </div>

                <div class="stat-box">
                    <h3>{{ \App\Models\Student::count() }}</h3>
                    <p>Approved Students</p>
                </div>

                <div class="stat-box">
                    <h3>{{ \App\Models\ArchivedStudent::count() }}</h3>
                    <p>Archived</p>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
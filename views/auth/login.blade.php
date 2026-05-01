<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #0d2c6c;
}

/* MAIN CONTAINER */
.main-container {
    display: flex;
    height: 100vh;
    align-items: center;
    justify-content: center;
}

/* LEFT SIDE (LOGIN NOW) */
.left {
    flex: 1;
    display: flex;
    justify-content: center;
}

/* RIGHT SIDE (LOGO NOW) */
.right {
    flex: 1;
    text-align: center;
}

.right img {
    width: 300px;
}

/* LOGIN CARD */
.login-container {
    width: 350px;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.login-container h2 {
    text-align: center;
    color: #0d2c6c;
}

/* INPUTS */
input {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* BUTTON */
button {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    background: #0d2c6c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #09306b;
}

.link {
    display: block;
    margin-top: 10px;
    text-align: right;
    font-size: 12px;
}
</style>

</head>
<body>

<div class="main-container">

    <!-- LEFT: LOGIN -->
    <div class="left">
        <div class="login-container">

            <h2>Admin / Registrar Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <label style="font-size:12px;">
                    <input type="checkbox" name="remember"> Remember Me
                </label>

                <button type="submit">Login</button>

                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif

            </form>

        </div>
    </div>

    <!-- RIGHT: LOGO -->
    <div class="right">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

</div>

</body>
</html>
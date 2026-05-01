

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enrollment</title>

<!-- ✅ FIXED CSS -->
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/enroll.css') }}">
</head>
<body>

<header>
    <h2>Online Application</h2>
</header>

<!-- STEP PROGRESS -->
<div class="steps">
    <div class="step active">1</div>
    <div class="step">2</div>
    <div class="step">3</div>
    <div class="step">4</div>
</div>

<div class="step-labels">
    <span>Student Type</span>
    <span>Personal Info</span>
    <span>Validation</span>
    <span>Finish</span>
</div>

<!-- STEP 1 -->
<div class="form-container">
    <h3>What type of student are you?</h3>

    <label class="radio-box">
        <input type="radio" name="type">
        New Student
    </label>

    <label class="radio-box">
        <input type="radio" name="type">
        Existing Student
    </label>

    <!-- ✅ FIXED BUTTON LINK -->
    <button onclick="window.location.href='/step2'" class="next-btn">Next</button>
</div>

<!-- ✅ FIXED JS -->
<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
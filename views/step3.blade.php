<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Step 3 - Review & Submit</title>

<style>
body { font-family: Arial; background:#f4f6f9; margin:0; }

.header {
    background: linear-gradient(90deg,#0d2c6c,#1565c0);
    color:white; padding:15px 30px;
}

.container {
    max-width:1000px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
}

.section { margin-bottom:25px; }

.section-title {
    font-weight:bold;
    color:#0d2c6c;
    border-left:5px solid #1565c0;
    padding-left:10px;
    margin-bottom:10px;
}

.review-box {
    background:#f9fbff;
    padding:15px;
    border-radius:8px;
    border:1px solid #e0e6f0;
}

.preview-box img { max-width:200px; }
.preview-box iframe { width:100%; height:250px; }

.actions {
    display:flex;
    justify-content:space-between;
    margin-top:30px;
}

button {
    padding:10px 20px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.submit-btn { background:#1565c0; color:white; }
.back-btn { background:#ccc; }

.error-box {
    background:#ffe0e0;
    color:red;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
}
</style>
</head>

<body>

<div class="header">Online Application</div>

@php
$data = session('enrollment');
@endphp

@if(!$data)
<script>
alert("Session expired. Please fill Step 2 again.");
window.location.href="/step2";
</script>
@endif

<div class="container">

<h2>Review & Submit</h2>

@if ($errors->any())
<div class="error-box">
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<form method="POST" action="/enroll/store">
@csrf

<!-- ✅ SEND ALL SESSION DATA -->
@foreach($data as $key => $value)
    @if(!is_array($value))
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endif
@endforeach

<!-- PERSONAL -->
<div class="section">
<div class="section-title">Personal Info</div>
<div class="review-box">
LRN: {{ $data['lrn'] ?? '' }} <br>
Name: {{ $data['first_name'] ?? '' }} {{ $data['middle_name'] ?? '' }} {{ $data['last_name'] ?? '' }} <br>
Birthdate: {{ $data['birthdate'] ?? '' }} <br>
Gender: {{ $data['gender'] ?? '' }} <br>
Place of Birth: {{ $data['place_of_birth'] ?? '' }} <br>
Nationality: {{ $data['nationality'] ?? '' }}
</div>
</div>

<!-- CONTACT -->
<div class="section">
<div class="section-title">Contact</div>
<div class="review-box">
Email: {{ $data['email'] ?? '' }} <br>
Mobile: {{ $data['mobile'] ?? '' }} <br>
Telephone: {{ $data['telephone'] ?? '' }} <br>
Address: {{ $data['street'] ?? '' }}, {{ $data['barangay'] ?? '' }}, {{ $data['city'] ?? '' }}, {{ $data['province'] ?? '' }}
</div>
</div>

<!-- SCHOOL -->
<div class="section">
<div class="section-title">School Info</div>
<div class="review-box">
Elementary: {{ $data['elementary_school'] ?? '' }} <br>
Completion: {{ $data['elem_completion'] ?? '' }} <br>
Last School: {{ $data['last_school'] ?? '' }}
</div>
</div>

<!-- PARENTS -->
<div class="section">
<div class="section-title">Parents</div>
<div class="review-box">
Father: {{ $data['father_name'] ?? '' }} ({{ $data['father_contact'] ?? '' }}) <br>
Mother: {{ $data['mother_name'] ?? '' }} ({{ $data['mother_contact'] ?? '' }})
</div>
</div>

<!-- EMERGENCY -->
<div class="section">
<div class="section-title">Emergency Contact</div>
<div class="review-box">
Name: {{ $data['emergency_name'] ?? '' }} <br>
Contact: {{ $data['emergency_contact'] ?? '' }}
</div>
</div>

<!-- PREFERRED -->
<div class="section">
<div class="section-title">Preferred</div>
<div class="review-box">
Grade: {{ $data['grade_level'] ?? '' }} <br>
Strand: {{ $data['strand'] ?? '' }}
</div>
</div>

<!-- FILES -->
<div class="section">
<div class="section-title">Requirements</div>
<div class="review-box">

@foreach(['psa','form137','form138','good_moral'] as $file)
<div style="margin-bottom:15px;">
<b>{{ strtoupper($file) }}</b><br>

@if(!empty($data[$file]))
    @php
        $ext = pathinfo($data[$file], PATHINFO_EXTENSION);
        $url = asset('storage/'.$data[$file]);
    @endphp

    @if(in_array($ext,['jpg','jpeg','png']))
        <img src="{{ $url }}">
    @elseif($ext=='pdf')
        <iframe src="{{ $url }}"></iframe>
    @else
        <a href="{{ $url }}" target="_blank">Open File</a>
    @endif

    <br>
    <a href="{{ $url }}" target="_blank">🔍 View Full</a>
@else
    No file uploaded
@endif

</div>
@endforeach

</div>
</div>

<div class="actions">
<button type="button" class="back-btn" onclick="window.location.href='/step2'">Back</button>
<button type="submit" class="submit-btn">Submit</button>
</div>

</form>

</div>

</body>
</html>
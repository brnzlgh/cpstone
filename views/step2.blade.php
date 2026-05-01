<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Step 2 - Personal Info</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    margin: 0;
}

.header {
    background: linear-gradient(90deg, #0d2c6c, #1565c0);
    color: white;
    padding: 15px 30px;
}

.container {
    max-width: 1100px;
    margin: 40px auto;
    background: white;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.grid-2, .grid-3 {
    display: grid;
    gap: 20px;
    margin-bottom: 15px;
}

.grid-2 { grid-template-columns: repeat(2, 1fr); }
.grid-3 { grid-template-columns: repeat(3, 1fr); }

input, select {
    padding: 12px;
    border: 2px solid #dbe3f0;
    border-radius: 8px;
}

.section-title {
    margin-top: 30px;
    font-weight: bold;
    color: #0d2c6c;
    border-left: 5px solid #1565c0;
    padding-left: 10px;
}

.actions {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.next {
    background: #1565c0;
    color: white;
}

</style>
</head>

<body>

<div class="header">Online Application</div>

<div class="container">

<h2>Step 2 - Personal Information</h2>

<form method="POST" action="/step2/store" enctype="multipart/form-data">
@csrf

<!-- PERSONAL -->
<div class="section-title">Personal Information</div>

<div class="grid-2">
<input name="lrn" placeholder="LRN (12 digits)" required>
<input name="last_name" placeholder="Last Name" required>
<input name="first_name" placeholder="First Name" required>
<input name="middle_name" placeholder="Middle Name">
</div>

<div class="grid-2">
<select name="gender">
<option value="">Gender</option>
<option>Male</option>
<option>Female</option>
</select>

<input type="date" name="birthdate">
</div>

<input name="place_of_birth" placeholder="Place of Birth">
<input name="nationality" placeholder="Nationality">

<!-- ADDRESS -->
<div class="section-title">Address</div>

<div class="grid-2">
<input name="street" placeholder="Street">
<input name="barangay" placeholder="Barangay">
</div>

<div class="grid-2">
<input name="city" placeholder="City">
<input name="province" placeholder="Province">
</div>

<!-- CONTACT -->
<div class="section-title">Contact</div>

<div class="grid-2">
<input name="email" placeholder="Email">
<input name="mobile" placeholder="Mobile">
</div>

<input name="telephone" placeholder="Telephone">

<!-- ELEMENTARY -->
<div class="section-title">Elementary School</div>

<input name="elementary_school" placeholder="School Name">

<div class="grid-2">
<input name="elem_completion" placeholder="Month/Year of Completion">
<input name="elem_region" placeholder="Region">
</div>

<input name="elem_address" placeholder="School Address">

<!-- LAST SCHOOL -->
<div class="section-title">Last School Attended</div>

<input name="last_school" placeholder="School Name">

<div class="grid-3">
<input name="house_no" placeholder="House No.">
<input name="street_name" placeholder="Street Name">
<input name="barangay_last" placeholder="Barangay">
</div>

<div class="grid-3">
<input name="town_city" placeholder="Town/City">
<input name="province_last" placeholder="Province">
<input name="region_last" placeholder="Region">
</div>

<div class="grid-2">
<input name="completion_year" placeholder="Month/Year of Completion">
<input name="school_email" placeholder="School Email">
</div>

<!-- PARENTS -->
<div class="section-title">Parents</div>

<div class="grid-2">
<input name="father_name" placeholder="Father Name">
<input name="mother_name" placeholder="Mother Name">
</div>

<div class="grid-3">
<input name="father_contact" placeholder="Father Contact">
<input name="mother_contact" placeholder="Mother Contact">
<input name="parent_address" placeholder="Parent Address">
</div>

<!-- GUARDIAN -->
<div class="section-title">Guardian</div>

<div class="grid-2">
<input name="guardian_name" placeholder="Guardian Name">
<input name="guardian_contact" placeholder="Guardian Contact">
</div>

<input name="guardian_address" placeholder="Guardian Address">

<!-- EMERGENCY -->
<div class="section-title">Emergency Contact</div>

<div class="grid-2">
<input name="emergency_name" placeholder="Name">
<input name="emergency_contact" placeholder="Contact Number">
</div>

<input name="emergency_address" placeholder="Address">

<!-- PREFERRED -->
<div class="section-title">Preferred Grade Level and Strand</div>

<div class="grid-2">
<select name="grade_level">
<option>Grade 11</option>
<option>Grade 12</option>
</select>

<select name="strand">
<option>ICT</option>
<option>HUMSS</option>
<option>GAS</option>
<option>HE</option>
</select>
</div>

<!-- REQUIREMENTS -->
<div class="section-title">Requirements</div>

<div class="grid-2">
<input type="file" name="psa">
<input type="file" name="form137">
<input type="file" name="form138">
<input type="file" name="good_moral">
</div>

<br>

<div class="actions">
<button type="button" onclick="window.location.href='/enroll'">Back</button>
<button type="submit" class="next">Next</button>
</div>

</form>

</div>

</body>
</html>
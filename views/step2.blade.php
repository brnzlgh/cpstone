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

/* ERROR STYLE */
input.error, select.error {
    border: 2px solid red !important;
    background: #ffecec;
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
<input name="lrn" id="lrn" placeholder="LRN (12 digits)" maxlength="12" inputmode="numeric">
<input name="last_name" placeholder="Last Name">
<input name="first_name" placeholder="First Name">
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
<input name="mobile" id="mobile" placeholder="Mobile" maxlength="11" inputmode="numeric">
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

<!-- CONTACT TYPE -->
<div class="section-title">Contact Preference</div>

<label>
<input type="radio" name="contact_type" value="parents" checked> Parents
</label>

<label>
<input type="radio" name="contact_type" value="guardian"> Guardian
</label>

<!-- PARENTS -->
<div class="section-title">Parents</div>

<div class="grid-2">
<input name="father_name" placeholder="Father Name">
<input name="mother_name" placeholder="Mother Name">
</div>

<div class="grid-3">
<input name="father_contact" id="father_contact" placeholder="Father Contact" maxlength="11" inputmode="numeric">
<input name="mother_contact" id="mother_contact" placeholder="Mother Contact" maxlength="11" inputmode="numeric">
<input name="parent_address" placeholder="Parent Address">
</div>

<!-- GUARDIAN -->
<div class="section-title">Guardian</div>

<div class="grid-2">
<input name="guardian_name" placeholder="Guardian Name">
<input name="guardian_contact" id="guardian_contact" placeholder="Guardian Contact" maxlength="11" inputmode="numeric">
</div>

<input name="guardian_address" placeholder="Guardian Address">

<!-- EMERGENCY -->
<div class="section-title">Emergency Contact</div>

<div class="grid-2">
<input name="emergency_name" placeholder="Name">
<input name="emergency_contact" id="emergency_contact" placeholder="Contact Number" maxlength="11" inputmode="numeric">
</div>

<input name="emergency_address" placeholder="Address">

<!-- PREFERRED -->
<div class="section-title">Preferred Grade Level and Strand</div>

<div class="grid-2">
<select name="grade_level">
<option value="">Select Grade</option>
<option>Grade 11</option>
<option>Grade 12</option>
</select>

<select name="strand">
<option value="">Select Strand</option>
<option>ICT</option>
<option>HUMSS</option>
<option>GAS</option>
<option>HE</option>
</select>
</div>

<!-- FILES -->
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

<script>

// 🔥 LRN VALIDATION
const lrnInput = document.getElementById("lrn");

lrnInput.addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, '').slice(0,12);

    if (this.value.length !== 12) {
        this.classList.add("error");
    } else {
        this.classList.remove("error");
    }
});


// 🔥 PHONE FORMAT
function formatPhone(value) {
    value = value.replace(/\D/g, '').slice(0, 11);

    if (value.length > 7) {
        return value.replace(/(\d{4})(\d{3})(\d{1,4})/, '$1-$2-$3');
    } else if (value.length > 4) {
        return value.replace(/(\d{4})(\d{1,3})/, '$1-$2');
    }

    return value;
}

// 🔥 ONLY NUMBERS + LIMIT WHILE TYPING
const phoneFields = ["mobile","father_contact","mother_contact","guardian_contact","emergency_contact"];

phoneFields.forEach(id => {

    const input = document.getElementById(id);
    if (!input) return;

    // while typing
    input.addEventListener("input", function () {
        let raw = this.value.replace(/\D/g, '').slice(0, 11);
        this.value = raw;

        if (raw.length !== 11) {
            this.classList.add("error");
        } else {
            this.classList.remove("error");
        }
    });

    // 🔥 format only when user clicks outside
    input.addEventListener("blur", function () {
        let raw = this.value.replace(/\D/g, '');

        if (raw.length === 11) {
            this.value = raw.replace(/(\d{4})(\d{3})(\d{4})/, '$1-$2-$3');
        }
    });

    // 🔥 remove dashes when editing again
    input.addEventListener("focus", function () {
        this.value = this.value.replace(/\D/g, '');
    });

});

// 🔥 TOGGLE + CLEAR
const parentFields = ['father_name','mother_name','father_contact','mother_contact','parent_address'];
const guardianFields = ['guardian_name','guardian_contact','guardian_address'];

function toggleFields(type) {

    parentFields.forEach(name => {
        let el = document.querySelector(`[name="${name}"]`);
        if (!el) return;

        if (type === "guardian") {
            el.disabled = true;
            el.value = "";
        } else {
            el.disabled = false;
        }
    });

    guardianFields.forEach(name => {
        let el = document.querySelector(`[name="${name}"]`);
        if (!el) return;

        if (type === "parents") {
            el.disabled = true;
            el.value = "";
        } else {
            el.disabled = false;
        }
    });
}

document.querySelectorAll('input[name="contact_type"]').forEach(radio => {
    radio.addEventListener("change", function() {
        toggleFields(this.value);
    });
});

toggleFields("parents");


// 🔥 FINAL VALIDATION
document.querySelector("form").addEventListener("submit", function(e) {

    let valid = true;

    const excluded = ["middle_name","psa","form137","form138","good_moral"];
    const inputs = document.querySelectorAll("input, select");

    inputs.forEach(input => {
        if (excluded.includes(input.name)) return;
        if (input.disabled) return;

        if (!input.value.trim()) {
            input.classList.add("error");
            valid = false;
        }
    });

    // LRN
    if (lrnInput.value.length !== 12) {
        valid = false;
    }

    // PHONES
    phoneFields.forEach(id => {
        let el = document.getElementById(id);
        if (!el || el.disabled) return;

        let raw = el.value.replace(/\D/g,'');
        if (raw.length !== 11) {
            el.classList.add("error");
            valid = false;
        }
    });

    if (!valid) {
        e.preventDefault();
        alert("Please complete all fields correctly.");
    }
});

</script>

</body>
</html>
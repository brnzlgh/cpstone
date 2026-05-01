<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Step 4 - Finish</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
window.jsPDF = window.jspdf.jsPDF;
</script>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
}

.header {
    background: #0d2c6c;
    color: white;
    padding: 15px;
    text-align: center;
}

.stepper {
    display: flex;
    justify-content: space-between;
    max-width: 600px;
    margin: 30px auto;
}

.step {
    text-align: center;
    flex: 1;
}

.circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: gold;
    line-height: 35px;
    margin: auto;
}

.container {
    max-width: 800px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
}

.success {
    font-size: 22px;
    color: green;
    margin-bottom: 10px;
}

.download-link {
    color: #0d47a1;
    cursor: pointer;
    text-decoration: underline;
    font-weight: bold;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
}
</style>
</head>

<body>

<div class="header">Enrollment Complete</div>

<div class="stepper">
    <div class="step"><div class="circle">✓</div><p>1</p></div>
    <div class="step"><div class="circle">✓</div><p>2</p></div>
    <div class="step"><div class="circle">✓</div><p>3</p></div>
    <div class="step"><div class="circle">✓</div><p>4</p></div>
</div>

<div class="container">
    <div class="success">✅ Enrollment Submitted Successfully!</div>

    <p>Your application has been recorded.</p>

    <p>
        Download your copy here:
        <span class="download-link" onclick="generatePDF()">Download PDF</span>
    </p>

    <!-- ✅ FIXED HOME BUTTON -->
    <button onclick="goHome()">Go to Home</button>
</div>

<script>
function generatePDF() {

    const doc = new window.jspdf.jsPDF();
    const data = JSON.parse(localStorage.getItem("enrollmentData"));

    if (!data) {
        alert("No data found.");
        return;
    }

    let y = 10;

    doc.setFontSize(14);
    doc.text("SAINT JOHN BOSCO I.A.S INC.", 105, y, null, null, "center");
    y += 7;
    doc.text("REGISTRATION FORM", 105, y, null, null, "center");
    y += 10;

    function box(x, y, w, h) {
        doc.rect(x, y, w, h);
    }

    function label(text, x, y) {
        doc.setFontSize(9);
        doc.text(text, x, y);
    }

    function value(text, x, y) {
        doc.setFontSize(10);
        doc.text(String(text || ""), x, y);
    }

    label("LRN Number:", 10, y);
    box(40, y - 5, 80, 8);
    value(data.lrn, 42, y);
    y += 12;

    label("Last Name", 10, y);
    box(10, y + 2, 60, 10);
    value(data.lastName, 12, y + 8);

    label("First Name", 75, y);
    box(75, y + 2, 60, 10);
    value(data.firstName, 77, y + 8);

    label("Middle", 140, y);
    box(140, y + 2, 50, 10);
    value(data.middleName, 142, y + 8);

    y += 18;

    label("Sex:", 10, y);
    value(data.gender, 25, y);

    label("Birthdate:", 80, y);
    value(data.birthdate, 110, y);

    y += 10;

    label("Address:", 10, y);
    box(10, y + 2, 180, 10);
    value(
        (data.street || "") + ", " + (data.barangay || "") + ", " + (data.city || ""),
        12,
        y + 8
    );

    y += 18;

    label("Last School:", 10, y);
    value(data.lastSchool, 40, y);

    y += 10;

    label("Grade Level:", 10, y);
    value(data.gradeLevel, 45, y);

    label("Strand:", 100, y);
    value(data.strand, 125, y);

    y += 12;

    label("Parent / Guardian:", 10, y);

    let parentName = "";
    let contact = "";

    if (data.guardianName) {
        parentName = data.guardianName;
        contact = data.guardianContact;
    } else {
        parentName = (data.father || "") + " / " + (data.mother || "");
        contact = (data.fatherContact || "") + " / " + (data.motherContact || "");
    }

    value(parentName, 60, y);

    y += 10;

    label("Contact:", 10, y);
    value(contact, 40, y);

    y += 20;

    doc.line(10, y, 80, y);
    doc.text("Student Signature", 10, y + 5);

    doc.line(120, y, 190, y);
    doc.text("Registrar", 120, y + 5);

    doc.save("Enrollment_Form.pdf");
}

function goHome() {
    // ✅ FIXED ROUTE
    window.location.href = "/";
}
</script>

</body>
</html>s
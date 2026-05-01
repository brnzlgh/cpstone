<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Archived Students</title>

<style>
body {
    font-family: 'Segoe UI', Arial;
    margin: 0;
    background: #eef2f7;
}

.header {
    background: linear-gradient(90deg, #0d2c6c, #1565c0);
    color: white;
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
}

.container {
    padding: 25px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

th {
    background: #0d2c6c;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.btn {
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    background: #3498db;
    color: white;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
}

.modal-content {
    background: white;
    width: 600px;
    max-width: 95%;
    margin: 40px auto;
    padding: 20px;
    border-radius: 12px;
    max-height: 85vh;
    overflow-y: auto;
}

.section-box {
    background: #f4f7fb;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 12px;
}

.section-title {
    font-weight: bold;
    color: #1565c0;
    margin-bottom: 8px;
}

.preview-img {
    width: 120px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.form-group {
    display: flex;
    flex-direction: column;
}
</style>
</head>

<body>

<div class="header">
    <h2>Archived Students</h2>
    <a href="/students" style="color:white;">Back to Students</a>
</div>

<div class="container">

<!-- ✅ SUCCESS MESSAGE -->
@if(session('success'))
<div style="background:#d4edda; color:#155724; padding:10px; margin-bottom:15px; border-radius:6px;">
    {{ session('success') }}
</div>
@endif

<table>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Grade</th>
    <th>Section</th>
    <th>Action</th>
</tr>

@forelse($students as $s)
<tr>
    <td>{{ $s->id }}</td>
    <td>{{ $s->first_name }} {{ $s->last_name }}</td>
    <td>{{ $s->grade_level }}</td>
    <td>{{ $s->section }}</td>
    <td>
        <button class="btn" onclick='viewStudent(@json($s))'>View</button>

        <!-- ✅ RESTORE BUTTON -->
        <button class="btn" style="background:green;"
                onclick="restoreStudent({{ $s->id }})">
            Restore
        </button>
    </td>
</tr>
@empty
<tr><td colspan="5">No archived students</td></tr>
@endforelse

</table>

</div>

<!-- MODAL -->
<div id="modal" class="modal">
<div class="modal-content">

<span onclick="closeModal()" style="float:right;cursor:pointer;">✖</span>

<h3 id="name"></h3>

<div id="details"></div>

</div>
</div>

<script>

function viewStudent(s){

document.getElementById("modal").style.display="block";
document.getElementById("name").innerText = s.first_name + " " + s.last_name;

let html = `

<div class="section-box">
<div class="section-title">Student Information</div>

<div class="form-grid">

<div class="form-group"><label>LRN</label><input value="${s.lrn ?? ''}" disabled></div>
<div class="form-group"><label>Gender</label><input value="${s.gender ?? ''}" disabled></div>

<div class="form-group"><label>First Name</label><input value="${s.first_name}" disabled></div>
<div class="form-group"><label>Middle Name</label><input value="${s.middle_name ?? ''}" disabled></div>

<div class="form-group"><label>Last Name</label><input value="${s.last_name}" disabled></div>
<div class="form-group"><label>Birthdate</label><input value="${s.birthdate ?? ''}" disabled></div>

<div class="form-group"><label>Street</label><input value="${s.street ?? ''}" disabled></div>
<div class="form-group"><label>Barangay</label><input value="${s.barangay ?? ''}" disabled></div>

<div class="form-group"><label>City</label><input value="${s.city ?? ''}" disabled></div>
<div class="form-group"><label>Province</label><input value="${s.province ?? ''}" disabled></div>

<div class="form-group"><label>Elementary</label><input value="${s.elementary_school ?? ''}" disabled></div>
<div class="form-group"><label>Last School</label><input value="${s.last_school ?? ''}" disabled></div>

<div class="form-group"><label>Father</label><input value="${s.father_name ?? ''}" disabled></div>
<div class="form-group"><label>Mother</label><input value="${s.mother_name ?? ''}" disabled></div>

</div>
</div>

<div class="section-box">
<div class="section-title">Assignment</div>

Grade: ${s.grade_level}<br>
Strand: ${s.strand}<br>
Section: ${s.section}
</div>

<div class="section-box">
<div class="section-title">Requirements</div>

PSA:<br>${filePreview(s.psa)}<br><br>
Form 137:<br>${filePreview(s.form137)}<br><br>
Form 138:<br>${filePreview(s.form138)}<br><br>
Good Moral:<br>${filePreview(s.good_moral)}

</div>
`;

document.getElementById("details").innerHTML = html;
}

function closeModal(){
document.getElementById("modal").style.display="none";
}

function filePreview(file){
if(!file) return "❌ Missing";

let url = "/storage/" + file;
let ext = file.split('.').pop().toLowerCase();

if(['jpg','jpeg','png'].includes(ext)){
return `<img src="${url}" class="preview-img">`;
}

if(ext === 'pdf'){
return `<iframe src="${url}" style="width:100%;height:120px;"></iframe>`;
}

return `<a href="${url}" target="_blank">Download</a>`;
}

// ✅ RESTORE FUNCTION
function restoreStudent(id){
    if(confirm("Restore this student?")){
        window.location.href = "/students/restore/" + id;
    }
}

</script>

</body>
</html>
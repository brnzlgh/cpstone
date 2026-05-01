<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Students</title>

<style>
body {
    font-family: 'Segoe UI', Arial;
    margin: 0;
    background: #eef2f7;
}

/* HEADER */
.header {
    background: linear-gradient(90deg, #0d2c6c, #1565c0);
    color: white;
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* CONTAINER */
.container {
    padding: 25px;
}

/* 🔍 FILTER BAR */
.filter-bar {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-bar input,
.filter-bar select {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.filter-bar button {
    padding: 8px 15px;
    border: none;
    background: #1565c0;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}

/* SECTION TITLE */
.section-header {
    margin: 20px 0 10px;
    font-size: 18px;
    font-weight: bold;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 25px;
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

tr:hover {
    background: #f5f8ff;
}

/* BADGES */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.badge-tbd {
    background: #fff3cd;
    color: #856404;
}

.badge-assigned {
    background: #d4edda;
    color: #155724;
}

/* BUTTONS */
.btn {
    padding: 7px 14px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.view-btn { background: #3498db; color: white; }
.edit-btn { background: #f39c12; color: white; }

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
    width: 500px;
    max-width: 95%;
    margin: 40px auto;
    padding: 25px;
    border-radius: 12px;
    max-height: 85vh;
    overflow-y: auto;
}

.section-box {
    background: #f4f7fb;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.section-title {
    font-weight: bold;
    color: #1565c0;
    margin-bottom: 10px;
}

.preview-img {
    width: 120px;
    height: auto;
    max-height: 120px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 4px;
    color: #333;
}

.form-group input,
.form-group select {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 13px;
    width: 100%;
}
</style>
</head>

<body>

<div class="header">
    <h2>Students</h2>
    <a href="/dashboard" style="color:white;">Dashboard</a>
    <a href="/students/archived" style="color:white; margin-left:15px;">
    Archived Students
</a>
</div>

<div class="container">

<!-- 🔍 SEARCH + FILTER -->
<form method="GET" action="/students" class="filter-bar">

    <input type="text" name="search" placeholder="Search Name / LRN"
           value="{{ request('search') }}">

    <select name="grade">
        <option value="">All Grades</option>
        <option value="Grade 11" {{ request('grade')=='Grade 11'?'selected':'' }}>Grade 11</option>
        <option value="Grade 12" {{ request('grade')=='Grade 12'?'selected':'' }}>Grade 12</option>
    </select>

    <select name="strand">
        <option value="">All Strands</option>
        <option value="ICT" {{ request('strand')=='ICT'?'selected':'' }}>ICT</option>
        <option value="GAS" {{ request('strand')=='GAS'?'selected':'' }}>GAS</option>
    </select>

    <select name="section">
        <option value="">All Sections</option>
        <option value="Section A" {{ request('section')=='Section A'?'selected':'' }}>Section A</option>
        <option value="Section B" {{ request('section')=='Section B'?'selected':'' }}>Section B</option>
        <option value="TBD" {{ request('section')=='TBD'?'selected':'' }}>TBD</option>
    </select>

    <button type="submit" class="btn view-btn" style="display:none;">Save</button>
</form>


<!-- 🟡 UNASSIGNED -->
<div class="section-header">🟡 Unassigned Students</div>

<table>
<tr>
<th>#</th>
<th>Name</th>
<th>Grade</th>
<th>Section</th>
<th>Action</th>
</tr>

@forelse($unassigned as $s)
<tr>
<td>{{ $s->id }}</td>
<td>{{ $s->first_name }} {{ $s->last_name }}</td>
<td>{{ $s->grade_level }}</td>
<td><span class="badge badge-tbd">{{ $s->section ?? 'TBD' }}</span></td>
<td>
    <button class="btn view-btn" onclick='viewStudent(@json($s))'>View</button>
    <button class="btn edit-btn" onclick='editStudent(@json($s))'>Assign</button>
</td>
</tr>
@empty
<tr><td colspan="5">No data</td></tr>
@endforelse
</table>


<!-- 🟢 ASSIGNED -->
<div class="section-header">🟢 Assigned Students</div>

<table>
<tr>
<th>#</th>
<th>Name</th>
<th>Grade</th>
<th>Section</th>
<th>Action</th>
</tr>

@forelse($assigned as $s)
<tr>
<td>{{ $s->id }}</td>
<td>{{ $s->first_name }} {{ $s->last_name }}</td>
<td>{{ $s->grade_level }}</td>
<td><span class="badge badge-assigned">{{ $s->section }}</span></td>
<td>
    <button class="btn view-btn" onclick='viewStudent(@json($s))'>View</button>
    <button class="btn edit-btn" onclick='editStudent(@json($s))'>Edit</button>
</td>
</tr>
@empty
<tr><td colspan="5">No data</td></tr>
@endforelse
</table>

</div>


<div id="studentModal" class="modal">
    <div class="modal-content">

        <span onclick="closeModal()" style="float:right;cursor:pointer;">✖</span>

        <h3 id="studentName"></h3>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" id="student_id">

            <div id="studentDetails"></div>

            <br>

            <!-- ✅ SAVE BUTTON (used in JS) -->
            <button id="saveBtn" type="submit" class="btn view-btn" style="display:none;">
                Save
            </button>
            <button type="button" id="archiveBtn" class="btn edit-btn" style="display:none; background:#e74c3c;">
    Archive
</button>

        </form>

    </div>
</div>

<script>
function viewStudent(s) {
    openModal(s, false);
}

function editStudent(s) {
    openModal(s, true);
}

function openModal(s, isEdit = false) {

document.getElementById("studentModal").style.display = "block";
document.getElementById("studentName").innerText = s.first_name + " " + s.last_name;
document.getElementById("student_id").value = s.id;
document.getElementById("saveBtn").style.display = isEdit ? "inline-block" : "none";
document.getElementById("archiveBtn").style.display = isEdit ? "inline-block" : "none";


let disabled = isEdit ? '' : 'disabled';

let html = `

<div class="section-box">
<div class="section-title">👤 Student Information</div>

<div class="form-grid">

<!-- BASIC -->
<div class="form-group">
<label>LRN</label>
<input name="lrn" value="${s.lrn ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Gender</label>
<input name="gender" value="${s.gender ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>First Name</label>
<input name="first_name" value="${s.first_name ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Middle Name</label>
<input name="middle_name" value="${s.middle_name ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Last Name</label>
<input name="last_name" value="${s.last_name ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Birthdate</label>
<input type="date" name="birthdate" value="${s.birthdate ?? ''}" ${disabled}>
</div>

<!-- ADDRESS -->
<div class="form-group">
<label>Street</label>
<input name="street" value="${s.street ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Barangay</label>
<input name="barangay" value="${s.barangay ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>City</label>
<input name="city" value="${s.city ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Province</label>
<input name="province" value="${s.province ?? ''}" ${disabled}>
</div>

<!-- SCHOOL -->
<div class="form-group">
<label>Elementary School</label>
<input name="elementary_school" value="${s.elementary_school ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Last School Attended</label>
<input name="last_school" value="${s.last_school ?? ''}" ${disabled}>
</div>

<!-- PARENTS -->
<div class="form-group">
<label>Father's Name</label>
<input name="father_name" value="${s.father_name ?? ''}" ${disabled}>
</div>

<div class="form-group">
<label>Mother's Name</label>
<input name="mother_name" value="${s.mother_name ?? ''}" ${disabled}>
</div>

</div>
</div>

<div class="section-box">
<div class="section-title">🎓 Assignment</div>

<select name="grade_level" ${disabled}>
<option ${s.grade_level=='Grade 11'?'selected':''}>Grade 11</option>
<option ${s.grade_level=='Grade 12'?'selected':''}>Grade 12</option>
</select>

<select name="strand" ${disabled}>
<option ${s.strand=='ICT'?'selected':''}>ICT</option>
<option ${s.strand=='GAS'?'selected':''}>GAS</option>
</select>

<select name="section" ${disabled}>
<option ${s.section=='Section A'?'selected':''}>Section A</option>
<option ${s.section=='Section B'?'selected':''}>Section B</option>
<option ${!s.section || s.section=='TBD'?'selected':''}>TBD</option>
</select>
</div>

<div class="section-box">
<div class="section-title">📄 Requirements</div>

PSA:<br>${filePreview(s.psa)}
<input type="file" name="psa" ${disabled}><br><br>

Form 137:<br>${filePreview(s.form137)}
<input type="file" name="form137" ${disabled}><br><br>

Form 138:<br>${filePreview(s.form138)}
<input type="file" name="form138" ${disabled}><br><br>

Good Moral:<br>${filePreview(s.good_moral)}
<input type="file" name="good_moral" ${disabled}>
</div>
`;

document.getElementById("studentDetails").innerHTML = html;
document.getElementById("editForm").action = "/students/update/" + s.id;

// ✅ SHOW/HIDE SAVE BUTTON
document.getElementById("saveBtn").style.display = isEdit ? "inline-block" : "none";
document.getElementById("archiveBtn").onclick = function () {

    let id = document.getElementById("student_id").value;

    if(confirm("Are you sure you want to archive this student?")) {
        window.location.href = "/students/archive/" + id;
    }
};
}

function closeModal(){
document.getElementById("studentModal").style.display = "none";
}

function filePreview(file){
if(!file) return '<span style="color:red;">❌ Missing</span>';

let url = "/storage/" + file;
let ext = file.split('.').pop().toLowerCase();

if(['jpg','png','jpeg'].includes(ext)){
return `
<img src="${url}" class="preview-img"><br>
<a href="${url}" target="_blank">View</a><br>
`;
}

if(ext==='pdf'){
return `
<iframe src="${url}" style="width:100%;height:120px;"></iframe>
<a href="${url}" target="_blank">Open</a><br>
`;
}

return `<a href="${url}" target="_blank">Download</a>`;
}
</script>

</body>
</html>
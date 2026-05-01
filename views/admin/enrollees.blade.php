<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Enrollees</title>

<style>
body {
    font-family: Arial;
    background: #0d2c6c;
    margin: 0;
    color: white;
}

.header {
    background: #081f4a;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-left img {
    height: 40px;
    cursor: pointer;
}

.dashboard-btn {
    background: #1565c0;
    color: white;
    padding: 8px 14px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.container {
    padding: 20px;
}

table {
    width: 100%;
    background: white;
    color: black;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

th {
    background: #0d2c6c;
    color: white;
}

tr:hover {
    background: #f5f7fa;
    cursor: pointer;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
}

.modal-content {
    background: white;
    width: 500px;
    max-width: 95%;
    margin: 40px auto;
    padding: 25px;
    border-radius: 12px;
    color: black;   

    max-height: 85vh;   /* 🔥 IMPORTANT */
    overflow-y: auto;   /* 🔥 ENABLE SCROLL */
}
.modal-content::-webkit-scrollbar {
    width: 6px;
}
.modal-content::-webkit-scrollbar-thumb {
    background: #1565c0;
    border-radius: 10px;
}

.btn {
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
    font-weight: bold;
}

.approve { background: green; color: white; }
.archive { background: orange; color: white; }
.delete { background: red; color: white; }
.close { background: gray; color: white; }
</style>
</head>

<body>

<div class="header">
    <div class="header-left">
        <a href="/dashboard">
            <img src="{{ asset('images/logo.png') }}">
        </a>
        <h2>Enrollees</h2>
    </div>

    <a href="/dashboard" class="dashboard-btn">Dashboard</a>
</div>

<div class="container">

<table>
    <thead>
        <tr>
            <th>LRN</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($enrollees as $e)
        <tr onclick="showDetails({{ $e->id }})">
            <td>{{ $e->lrn ?? 'N/A' }}</td>
            <td>{{ $e->last_name }}</td>
            <td>{{ $e->first_name }}</td>
            <td>{{ $e->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

<!-- MODAL -->
<div id="modal" class="modal">
    <div class="modal-content">

        <h3>Enrollee Details</h3>

        <div id="details"></div>

        <!-- APPROVE -->
        <form id="approveForm" method="POST">
            @csrf
            <button class="btn approve">Approve</button>
        </form>

        <!-- ARCHIVE -->
        <form id="archiveForm" method="POST">
            @csrf
            <button class="btn archive">Archive</button>
        </form>

        <!-- DELETE -->
        <form id="deleteForm" method="POST"
              onsubmit="return confirm('Delete this enrollee permanently?')">
            @csrf
            <button class="btn delete">Delete</button>
        </form>

        <button class="btn close" onclick="closeModal()">Close</button>

    </div>
</div>

<script>
const enrollees = @json($enrollees);
function filePreview(file) {
    if (!file) return '<span style="color:red;">❌ Missing</span>';

    const url = `/storage/${file}`;
    const ext = file.split('.').pop().toLowerCase();

    if (['jpg','jpeg','png'].includes(ext)) {
        return `
            <img src="${url}" style="width:100px;display:block;margin-bottom:5px;">
            <a href="${url}" target="_blank">🔍 View</a>
        `;
    }

    if (ext === 'pdf') {
        return `
            <iframe src="${url}" style="width:100%;height:150px;"></iframe>
            <a href="${url}" target="_blank">🔍 Open PDF</a>
        `;
    }

    return `<a href="${url}" target="_blank">Download</a>`;
}
function showDetails(id) {
    const e = enrollees.find(x => x.id === id);
    if (!e) return;

    document.getElementById('modal').style.display = 'block';

    document.getElementById('details').innerHTML = `
        <b>LRN:</b> ${e.lrn ?? 'N/A'}<br><br>

        <b>Name:</b> ${e.first_name} ${e.last_name}<br>
        <b>Gender:</b> ${e.gender ?? ''}<br>
        <b>Birthdate:</b> ${e.birthdate ?? ''}<br>
        <b>Place of Birth:</b> ${e.place_of_birth ?? ''}<br>
        <b>Nationality:</b> ${e.nationality ?? ''}<br><br>

        <b>Grade Level:</b> ${e.grade_level ?? ''}<br>
        <b>Strand:</b> ${e.strand ?? ''}<br><br>

        <b>Email:</b> ${e.email ?? ''}<br>
        <b>Mobile:</b> ${e.mobile ?? ''}<br><br>

        <b>Address:</b><br>
        ${e.street ?? ''}, ${e.barangay ?? ''}, ${e.city ?? ''}, ${e.province ?? ''}<br><br>

        <b>Parents:</b><br>
        Father: ${e.father_name ?? ''}<br>
        Mother: ${e.mother_name ?? ''}<br><br>

        <b>📄 Requirements:</b><br><br>

PSA:<br> ${filePreview(e.psa)} <br><br>
Form 137:<br> ${filePreview(e.form137)} <br><br>
Form 138:<br> ${filePreview(e.form138)} <br><br>
Good Moral:<br> ${filePreview(e.good_moral)}
    `;

    // actions
    document.getElementById('approveForm').action = `/approve/${id}`;
    document.getElementById('archiveForm').action = `/archive/${id}`;
    document.getElementById('deleteForm').action = `/delete/${id}`;
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

// close when clicking outside
window.onclick = function(e) {
    const modal = document.getElementById('modal');
    if (e.target === modal) modal.style.display = "none";
}
</script>

</body>
</html>
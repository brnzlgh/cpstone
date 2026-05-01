<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollee;
use App\Models\Student;
use App\Models\ArchivedStudent;

class AdminController extends Controller
{
    // 📋 SHOW ENROLLEES
    public function enrollees()
    {
        $enrollees = Enrollee::latest()->get();
        return view('admin.enrollees', compact('enrollees')); 
    }

    // 📋 SHOW STUDENTS
    public function students(Request $request)
    {
        $query = Student::query();

        // FILTERS
        if ($request->grade) {
            $query->where('grade_level', $request->grade);
        }

        if ($request->strand) {
            $query->where('strand', $request->strand);
        }

        if ($request->section) {
            $query->where('section', $request->section);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('lrn', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->get();

        // SPLIT
        $unassigned = $students->filter(fn($s) => !$s->section || $s->section == 'TBD');
        $assigned   = $students->filter(fn($s) => $s->section && $s->section != 'TBD');

        return view('admin.students', compact('students', 'unassigned', 'assigned'));
    }

    // ✅ APPROVE
    public function approve($id)
    {
        $enrollee = Enrollee::findOrFail($id);

        Student::updateOrCreate(
            ['lrn' => $enrollee->lrn],
            [
                'first_name' => $enrollee->first_name,
                'last_name'  => $enrollee->last_name,
                'middle_name'=> $enrollee->middle_name,
                'email'      => $enrollee->email,

                'gender'     => $enrollee->gender,
                'birthdate'  => $enrollee->birthdate,

                'street'     => $enrollee->street,
                'barangay'   => $enrollee->barangay,
                'city'       => $enrollee->city,
                'province'   => $enrollee->province,

                'elementary_school' => $enrollee->elementary_school,
                'last_school'       => $enrollee->last_school,

                'father_name' => $enrollee->father_name,
                'mother_name' => $enrollee->mother_name,

                'grade_level' => $enrollee->grade_level ?? 'Grade 11',
                'strand'      => $enrollee->strand ?? 'ICT',
                'section'     => 'TBD',

                'psa'         => $enrollee->psa,
                'form137'     => $enrollee->form137,
                'form138'     => $enrollee->form138,
                'good_moral'  => $enrollee->good_moral,
            ]
        );

        $enrollee->delete();

        return redirect('/students')->with('success', 'Student approved!');
    }

    // 🎯 ASSIGN
    public function assign(Request $request, $id)
    {
        $request->validate([
            'grade_level' => 'required',
            'strand'      => 'required',
            'section'     => 'required',
        ]);

        $student = Student::findOrFail($id);

        $student->update([
            'grade_level' => $request->grade_level,
            'strand'      => $request->strand,
            'section'     => $request->section,
        ]);

        return back()->with('success', 'Student assigned!');
    }

    // 📦 ARCHIVE
    public function archive($id)
    {
        $student = Student::findOrFail($id);

        ArchivedStudent::create($student->toArray());

        $student->delete();

        return redirect('/students')->with('success', 'Student archived!');
    }

    // ✅ VIEW ARCHIVED
    public function archivedStudents()
    {
        $students = ArchivedStudent::latest()->get();
        return view('admin.archived', compact('students'));
    }

    // 🔥 RESTORE (THIS IS THE MISSING PART)
    public function restore($id)
    {
        $archived = ArchivedStudent::findOrFail($id);

        // move back to students
        Student::updateOrCreate(
            ['lrn' => $archived->lrn],
            [
                'first_name' => $archived->first_name,
                'last_name'  => $archived->last_name,
                'middle_name'=> $archived->middle_name,
                'gender'     => $archived->gender,
                'birthdate'  => $archived->birthdate,

                'street'     => $archived->street,
                'barangay'   => $archived->barangay,
                'city'       => $archived->city,
                'province'   => $archived->province,

                'elementary_school' => $archived->elementary_school,
                'last_school'       => $archived->last_school,

                'father_name' => $archived->father_name,
                'mother_name' => $archived->mother_name,

                'grade_level' => $archived->grade_level,
                'strand'      => $archived->strand,
                'section'     => $archived->section,

                'psa'         => $archived->psa,
                'form137'     => $archived->form137,
                'form138'     => $archived->form138,
                'good_moral'  => $archived->good_moral,
            ]
        );

        $archived->delete();

        return redirect('/students/archived')->with('success', 'Student restored!');
    }

    // ❌ DELETE
    public function delete($id)
    {
        Enrollee::destroy($id);
        return back()->with('success', 'Deleted!');
    }

    // ✏️ UPDATE STUDENT
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        if ($request->hasFile('psa')) {
            $student->psa = $request->file('psa')->store('requirements', 'public');
        }

        if ($request->hasFile('form137')) {
            $student->form137 = $request->file('form137')->store('requirements', 'public');
        }

        if ($request->hasFile('form138')) {
            $student->form138 = $request->file('form138')->store('requirements', 'public');
        }

        if ($request->hasFile('good_moral')) {
            $student->good_moral = $request->file('good_moral')->store('requirements', 'public');
        }

        $student->update($request->except(['psa','form137','form138','good_moral']));

        return back()->with('success', 'Updated!');
    }
}
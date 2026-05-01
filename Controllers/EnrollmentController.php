<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollee;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    /**
     * STEP 2 → SAVE TO SESSION + TEMP FILE UPLOAD
     */
    public function storeStep2(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'lrn' => 'required|digits:12',
        ]);

        // 🔥 TEMP FILE UPLOAD
        $psa = $request->file('psa')?->store('temp', 'public');
        $form137 = $request->file('form137')?->store('temp', 'public');
        $form138 = $request->file('form138')?->store('temp', 'public');
        $good_moral = $request->file('good_moral')?->store('temp', 'public');

        // 🔥 SAVE ALL FORM DATA TO SESSION
        session([
            'enrollment' => array_merge($request->all(), [
                'psa' => $psa,
                'form137' => $form137,
                'form138' => $form138,
                'good_moral' => $good_moral,
            ])
        ]);

        return redirect('/step3');
    }


    /**
     * FINAL SUBMIT → SAVE TO DATABASE
     */
    public function store(Request $request)
    {
        $data = session('enrollment');

        if (!$data) {
            return redirect('/step2')->with('error', 'Session expired. Please fill again.');
        }

        // ✅ FINAL VALIDATION
        $request->validate([
            'lrn' => 'required|digits:12|unique:enrollees,lrn',
        ]);

        // 🔥 SAFE FILE MOVE FUNCTION
        function moveFile($path)
        {
            if (!$path || !Storage::disk('public')->exists($path)) {
                return null;
            }

            $newPath = str_replace('temp/', 'requirements/', $path);

            // create folder if not exists
            Storage::disk('public')->makeDirectory('requirements');

            Storage::disk('public')->move($path, $newPath);

            return $newPath;
        }

        $psa = moveFile($data['psa'] ?? null);
        $form137 = moveFile($data['form137'] ?? null);
        $form138 = moveFile($data['form138'] ?? null);
        $good_moral = moveFile($data['good_moral'] ?? null);

        // ✅ SAVE TO DATABASE (FULL VERSION)
        Enrollee::create([

            // PERSONAL
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'middle_name' => $data['middle_name'] ?? null,
            'lrn' => $data['lrn'] ?? null,

            'gender' => $data['gender'] ?? null,
            'birthdate' => $data['birthdate'] ?? null,
            'place_of_birth' => $data['place_of_birth'] ?? null,
            'nationality' => $data['nationality'] ?? null,

            // CONTACT
            'email' => $data['email'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'telephone' => $data['telephone'] ?? null,

            // ADDRESS
            'street' => $data['street'] ?? null,
            'barangay' => $data['barangay'] ?? null,
            'city' => $data['city'] ?? null,
            'province' => $data['province'] ?? null,

            // 🔥 ELEMENTARY SCHOOL
            'elementary_school' => $data['elementary_school'] ?? null,
            'elem_completion' => $data['elem_completion'] ?? null,
            'elem_address' => $data['elem_address'] ?? null,
            'elem_region' => $data['elem_region'] ?? null,

            // 🔥 LAST SCHOOL
            'last_school' => $data['last_school'] ?? null,
            'house_no' => $data['house_no'] ?? null,
            'street_name' => $data['street_name'] ?? null,
            'barangay_last' => $data['barangay_last'] ?? null,
            'town_city' => $data['town_city'] ?? null,
            'province_last' => $data['province_last'] ?? null,
            'region_last' => $data['region_last'] ?? null,
            'completion_year' => $data['completion_year'] ?? null,
            'school_email' => $data['school_email'] ?? null,

            // PARENTS
            'father_name' => $data['father_name'] ?? null,
            'father_contact' => $data['father_contact'] ?? null,
            'mother_name' => $data['mother_name'] ?? null,
            'mother_contact' => $data['mother_contact'] ?? null,
            'parent_address' => $data['parent_address'] ?? null,

            // GUARDIAN
            'guardian_name' => $data['guardian_name'] ?? null,
            'guardian_address' => $data['guardian_address'] ?? null,
            'guardian_contact' => $data['guardian_contact'] ?? null,

            // 🔥 EMERGENCY
            'emergency_name' => $data['emergency_name'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'emergency_address' => $data['emergency_address'] ?? null,

            // PREFERRED
            'grade_level' => $data['grade_level'] ?? null,
            'strand' => $data['strand'] ?? null,

            // FILES
            'psa' => $psa,
            'form137' => $form137,
            'form138' => $form138,
            'good_moral' => $good_moral,
        ]);

        // 🔥 CLEAR SESSION
        session()->forget('enrollment');

        return redirect('/finish')->with('success', 'Enrollment submitted!');
    }
}
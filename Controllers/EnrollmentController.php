<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollee;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    /**
     * STEP 2 → VALIDATE + SAVE TO SESSION
     */
    public function storeStep2(Request $request)
    {
        // 🔥 CLEAN PHONE NUMBERS (REMOVE DASHES)
        $request->merge([
            'mobile' => preg_replace('/\D/', '', $request->mobile),
            'father_contact' => preg_replace('/\D/', '', $request->father_contact),
            'mother_contact' => preg_replace('/\D/', '', $request->mother_contact),
            'guardian_contact' => preg_replace('/\D/', '', $request->guardian_contact),
            'emergency_contact' => preg_replace('/\D/', '', $request->emergency_contact),
        ]);

        // 🔥 BASE VALIDATION
        $request->validate([

            // PERSONAL
            'lrn' => 'required|digits:12',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'place_of_birth' => 'required',
            'nationality' => 'required',

            // ADDRESS
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',

            // CONTACT
            'email' => 'required|email',
            'mobile' => 'required|digits:11',

            // SCHOOL
            'elementary_school' => 'required',
            'elem_completion' => 'required',
            'elem_region' => 'required',
            'elem_address' => 'required',

            'last_school' => 'required',
            'house_no' => 'required',
            'street_name' => 'required',
            'barangay_last' => 'required',
            'town_city' => 'required',
            'province_last' => 'required',
            'region_last' => 'required',
            'completion_year' => 'required',
            'school_email' => 'required',

            // EMERGENCY
            'emergency_name' => 'required',
            'emergency_contact' => 'required|digits:11',
            'emergency_address' => 'required',

            // PREFERRED
            'grade_level' => 'required',
            'strand' => 'required',
        ]);

        // 🔥 PARENT / GUARDIAN LOGIC
        if ($request->contact_type === "guardian") {
            $request->validate([
                'guardian_name' => 'required',
                'guardian_contact' => 'required|digits:11',
                'guardian_address' => 'required',
            ]);
        } else {
            $request->validate([
                'father_name' => 'required',
                'mother_name' => 'required',
                'father_contact' => 'required|digits:11',
                'mother_contact' => 'required|digits:11',
                'parent_address' => 'required',
            ]);
        }

        // 🔥 TEMP FILE UPLOAD
        $psa = $request->file('psa')?->store('temp', 'public');
        $form137 = $request->file('form137')?->store('temp', 'public');
        $form138 = $request->file('form138')?->store('temp', 'public');
        $good_moral = $request->file('good_moral')?->store('temp', 'public');

        // 🔥 SAVE TO SESSION
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
            return redirect('/step2')->with('error', 'Session expired.');
        }

        // 🔥 CLEAN PHONE AGAIN (SAFETY)
        $data['mobile'] = preg_replace('/\D/', '', $data['mobile'] ?? '');
        $data['father_contact'] = preg_replace('/\D/', '', $data['father_contact'] ?? '');
        $data['mother_contact'] = preg_replace('/\D/', '', $data['mother_contact'] ?? '');
        $data['guardian_contact'] = preg_replace('/\D/', '', $data['guardian_contact'] ?? '');
        $data['emergency_contact'] = preg_replace('/\D/', '', $data['emergency_contact'] ?? '');

        // 🔥 FINAL VALIDATION
        $request->validate([
            'lrn' => 'required|digits:12|unique:enrollees,lrn',
        ]);

        // 🔥 MOVE FILE FUNCTION
        function moveFile($path)
        {
            if (!$path || !Storage::disk('public')->exists($path)) {
                return null;
            }

            $newPath = str_replace('temp/', 'requirements/', $path);
            Storage::disk('public')->makeDirectory('requirements');
            Storage::disk('public')->move($path, $newPath);

            return $newPath;
        }

        $psa = moveFile($data['psa'] ?? null);
        $form137 = moveFile($data['form137'] ?? null);
        $form138 = moveFile($data['form138'] ?? null);
        $good_moral = moveFile($data['good_moral'] ?? null);

        // 🔥 SAVE
        Enrollee::create([

            // PERSONAL
            'lrn' => $data['lrn'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'place_of_birth' => $data['place_of_birth'],
            'nationality' => $data['nationality'],

            // CONTACT
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'telephone' => $data['telephone'] ?? null,

            // ADDRESS
            'street' => $data['street'],
            'barangay' => $data['barangay'],
            'city' => $data['city'],
            'province' => $data['province'],

            // ELEMENTARY
            'elementary_school' => $data['elementary_school'],
            'elem_completion' => $data['elem_completion'],
            'elem_address' => $data['elem_address'],
            'elem_region' => $data['elem_region'],

            // LAST SCHOOL
            'last_school' => $data['last_school'],
            'house_no' => $data['house_no'],
            'street_name' => $data['street_name'],
            'barangay_last' => $data['barangay_last'],
            'town_city' => $data['town_city'],
            'province_last' => $data['province_last'],
            'region_last' => $data['region_last'],
            'completion_year' => $data['completion_year'],
            'school_email' => $data['school_email'],

            // PARENTS OR GUARDIAN
            'father_name' => $data['contact_type'] === 'parents' ? $data['father_name'] : null,
            'mother_name' => $data['contact_type'] === 'parents' ? $data['mother_name'] : null,
            'father_contact' => $data['contact_type'] === 'parents' ? $data['father_contact'] : null,
            'mother_contact' => $data['contact_type'] === 'parents' ? $data['mother_contact'] : null,
            'parent_address' => $data['contact_type'] === 'parents' ? $data['parent_address'] : null,

            'guardian_name' => $data['contact_type'] === 'guardian' ? $data['guardian_name'] : null,
            'guardian_contact' => $data['contact_type'] === 'guardian' ? $data['guardian_contact'] : null,
            'guardian_address' => $data['contact_type'] === 'guardian' ? $data['guardian_address'] : null,

            // EMERGENCY
            'emergency_name' => $data['emergency_name'],
            'emergency_contact' => $data['emergency_contact'],
            'emergency_address' => $data['emergency_address'],

            // PREFERRED
            'grade_level' => $data['grade_level'],
            'strand' => $data['strand'],

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
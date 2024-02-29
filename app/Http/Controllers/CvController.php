<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Jobs\GeneratePdf;
use Inertia\Inertia;
use App\Models\Resume;
use App\Models\Experience;
use App\Models\Formation;
use App\Models\Skill;

class CvController extends Controller
{
    //

    public function updatePersonalData(Request $request) {

        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
        ]);

        $newData = $request->all();
        $nameImage = '';

        if($request->hasFile('photo')) {
            //$path = $request->file('photo')->store('public/files');

            $image = $request->file('photo');
            $nameImage = time().'.'.$image->getClientOriginalName();
            $image->move(app()->basePath('storage/app/public'), $nameImage);

        }

        $newData['photo'] = $nameImage;

        auth()->user()->fill($newData);

        $request->user()->save();

        return Redirect::route('dashboard');
    }


    public function createPdfCv() {

        $user = auth()->user();
/*
        GeneratePdf::dispatch($user);

        return Redirect::route('dashboard');

*/


        setlocale(LC_TIME, 'es_ES.UTF-8','esp');

        $cv = Resume::find(1);

        $experiences = $cv->experiences()->get()->all();

        foreach($experiences as $exp) {
            //$formattedStart = date("F Y", strtotime($exp->date_start));

            $formattedStart = strftime("%B %G", strtotime($exp->date_start));

            //$formattedFinish = date("F Y", strtotime($exp->date_finish));

            $formattedFinish = strftime("%B %G", strtotime($exp->date_finish));

            $exp->date_start = $formattedStart;
            $exp->date_finish = $formattedFinish;
        }

        $formations = $cv->formations()->where('type', 'académica')->get()->all();

        foreach($formations as $for) {
            $formattedFinish = strftime("%G", strtotime($for->date_finish));
            $for->date_finish = $formattedFinish;
        }

        $complementary_formations = $cv->formations()->where('type', 'complementaria')->get()->all();

        $skills = $cv->skills()->get()->all();

        $pdf = Pdf::loadView('cv.cv1', compact('user', 'experiences', 'formations', 'complementary_formations', 'skills'));

        return $pdf->stream('cv1.pdf');   



/*
        $content = $pdf->download()->getOriginalContent();
        Storage::put('public/pdfs/'.$user->name.'.pdf', $content);

        return Redirect::route('dashboard');
*/
    }    


    public function viewCvs() {

        $cvs = auth()->user()->resumes()->get();

        return Inertia::render('ViewCVs', ['cvs' => $cvs->all()]);

    }

    public function createNewCv() {
        
        return Inertia::render('CVForm');
    }

    public function saveNewCv(Request $request) {
        $request->validate([
            'title' => 'required',
        ]);

        $cv = new Resume;

        $cv->title = $request->title;
        $cv->user_id = auth()->user()->id;
        $cv->save();

        return Redirect::route('miscvs');
    }

    public function editCv($id) {
        $cv = Resume::find($id);

        $experiences = $cv->experiences()->get()->all();

        if(!$experiences) {

            $var = new \stdClass();
            $var->id = 0;
            $var->resume_id = $id;
            $var->title = '';
            $var->company_name = '';
            $var->company_city = '';
            $var->date_start = '';
            $var->date_finish = '';
            $var->job_description = '';

            $experiences = [$var];
        }

        $formations = $cv->formations()->where('type', 'académica')->get()->all();

        if(!$formations) {

            $var = new \stdClass();
            $var->id = 0;
            $var->resume_id = $id;
            $var->title = '';
            $var->institution = '';
            $var->institution_city = '';
            $var->date_start = '';
            $var->date_finish = '';

            $formations = [$var];
        }

        $complementary_formations = $cv->formations()->where('type', 'complementaria')->get()->all();

        if(!$complementary_formations) {

            $var = new \stdClass();
            $var->id = 0;
            $var->resume_id = $id;
            $var->type = 'complementaria';
            $var->title = '';
            $var->institution = '';
            $var->institution_city = '';
            $var->year = 0;
            $var->hours = 0;

            $complementary_formations = [$var];
        }

        $skills = $cv->skills()->get()->all();

        if(!$skills) {
            $var = new \stdClass();
            $var->id = 0;
            $var->resume_id = $id;
            $var->name = '';
            $var->level = 0;

            $skills = [$var];
        }

        return Inertia::render('CVFormEdit', [
            'cv' => $cv, 
            'experiences' => $experiences, 
            'formations' => $formations,
            'complementary_formations' => $complementary_formations,
            'skills' => $skills,
        ]);

    }

    public function updateCv(Request $request) {
        $cv = Resume::findOrFail($request->cv_id);

        $cv->title = $request->title;
        $cv->save();
/*
        echo "<pre>";
        print_r($cv);
        echo "<pre>";
        die();
*/
        //return Inertia::render('CVFormEdit', ['cv' => $cv]);

        return Redirect::route('editcv', ['id' => $cv->id]);
    }

    public function addExperience(Request $request) {
        $request->validate([
            'title' => 'required',
            'company_name' => 'required',
            'company_city' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
            'job_description' => 'required'
        ], );

        $exp = new Experience;
        $exp->title = $request->title;
        $exp->company_name = $request->company_name;
        $exp->company_city = $request->company_city;
        $exp->date_start = $request->date_start;
        $exp->date_finish = $request->date_finish;
        $exp->job_description = $request->job_description;
        $exp->resume_id = $request->resume_id;

        $exp->save();

        //return Redirect::route('editcv', ['id' => $exp->resume_id]);

       //return redirect()->route('editcv', ['id' => $exp->resume_id]);

        return $exp;

    }

    public function updateExperience(Request $request) {
/*        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'company_name' => 'required',
            'company_city' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
            'job_description' => 'required'
        ]);
*/
        $exp = Experience::findOrFail($request->id);
        $exp->title = $request->title;
        $exp->company_name = $request->company_name;
        $exp->company_city = $request->company_city;
        $exp->date_start = $request->date_start;
        $exp->date_finish = $request->date_finish;
        $exp->job_description = $request->job_description;
        $exp->resume_id = $request->resume_id;

        $exp->save();

        //return Redirect::route('editcv', ['id' => $exp->resume_id]);

        return $exp;
    }

    public function deleteExperience($id) {
        Experience::destroy($id);

        return $id;
    }

    public function addFormation(Request $request) {

        $formation = new Formation;

        $formation->title = $request->title;
        $formation->institution = $request->institution;
        $formation->institution_city = $request->institution_city;
        $formation->date_start = $request->date_start;
        $formation->date_finish = $request->date_finish;
        $formation->resume_id = $request->resume_id;
        if($request->has('type')) $formation->type = $request->type;
        if($request->has('hours')) $formation->hours = $request->hours;
        if($request->has('year')) $formation->year = $request->year;

        $formation->save();

        return $formation;
    }

    public function updateFormation(Request $request) {

        $formation = Formation::findOrFail($request->id);

        $formation->title = $request->title;
        $formation->institution = $request->institution;
        $formation->institution_city = $request->institution_city;
        $formation->date_start = $request->date_start;
        $formation->date_finish = $request->date_finish;
        $formation->resume_id = $request->resume_id;
        if($request->has('type')) $formation->type = $request->type;
        if($request->has('hours')) $formation->hours = $request->hours;
        if($request->has('year')) $formation->year = $request->year;
 
        $formation->save();

        return $formation;
    }

    public function deleteFormation($id) {
        Formation::destroy($id);

        return $id;
    }

    public function addSkill(Request $request) {
        $skill = new Skill;

        $skill->name = $request->name;
        $skill->level = $request->level;
        $skill->resume_id = $request->resume_id;

        $skill->save();

        return $skill;
    }

    public function updateSkill(Request $request) {
        
        $skill = Skill::findOrFail($request->id);

        $skill->name = $request->name;
        $skill->level = $request->level;
        $skill->resume_id = $request->resume_id;

        $skill->save();

        return $skill;

    }

    public function deleteSkill($id) {
        Skill::destroy($id);

        return $id;
    }

}

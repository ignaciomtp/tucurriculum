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

/**/

        $cv = Resume::find(1);

        $experiences = $cv->experiences()->get()->all();

        $pdf = Pdf::loadView('cv.cv1', compact('user', 'experiences'));

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

        return Inertia::render('CVFormEdit', ['cv' => $cv, 'experiences' => $experiences]);

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
/*        $request->validate([
            'title' => 'required',
            'company_name' => 'required',
            'company_city' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
            'job_description' => 'required'
        ]);
*/
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


}

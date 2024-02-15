<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Jobs\GeneratePdf;
use Inertia\Inertia;
use App\Models\Resume;

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
        $pdf = Pdf::loadView('cv.cv1', compact('user'));

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

        return Inertia::render('CVFormEdit', ['cv' => $cv]);

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
        return Inertia::render('CVFormEdit', ['cv' => $cv]);
    }


}

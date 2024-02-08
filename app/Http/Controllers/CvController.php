<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;

class CvController extends Controller
{
    //

    public function updatePersonalData(Request $request) {
        auth()->user()->fill($request->all());

        $request->user()->save();

        return Redirect::route('dashboard');
    }


    public function createCv() {

        $user = auth()->user();

        //return view('posts.cv1', compact('posts'));


        $pdf = Pdf::loadView('cv.cv1', compact('user'));

        return $pdf->stream('cv1.pdf');   

    }    
}

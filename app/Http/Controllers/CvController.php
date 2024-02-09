<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;

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


    public function createCv() {

        $user = auth()->user();
/*
        return view('cv.cv1', compact('user'));
*/

        $pdf = Pdf::loadView('cv.cv1', compact('user'));

        return $pdf->stream('cv1.pdf');   

    }    
}

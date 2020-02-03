<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MajorSystem\MajorSystem;

class MajorController extends Controller
{
    /**
     * Simply looks up matches for the POSTed number and returns them as JSON.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\MajorSystem\MajorSystem $major
     * @return string
     */
    public function __invoke(Request $request, MajorSystem $major)
    {
        $number = $request->input('number');
        return json_encode($major->getMatches($number));
    }
}

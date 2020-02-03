<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MajorSystem\MajorSystem;

class MajorController extends Controller
{
    public function __invoke(MajorSystem $maj)
    {
        return json_encode($maj->foo());
    }
}

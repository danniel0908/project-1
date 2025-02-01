<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violator;


class TmuController extends Controller
{
    public function index(){
        $violators = Violator::all();
        return view('tmu.dashboard', compact('violators'));
    }

  public function viewViolator(): View
  {
      $violators = Violator::all();

      return view('violators.index', compact('violators'));
  }
}

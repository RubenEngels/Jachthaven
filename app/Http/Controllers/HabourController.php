<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Boats;
use App\Box;

class HabourController extends Controller
{
  public function getHabourOverview()
  {
    return view('admin.habour.overview')
      ->with('boats', Boats::where('box_id', null)->get())
      ->with('boxes', Box::where('isWalplaats', false)->paginate(10))
      ->witH('walplaatsen', Box::where('isWalplaats', true)->paginate(10, ['*'], 'walplaatsen'));
  }

  public function postAssignBox(Request $request)
  {
    $boat = Boats::find($request->boat_id);

    $boat->box_id = $request->box_id;
    $boat->save();

    return redirect()->back()->with('status', 'De box is succesvol toegewezen aan de boot <b><i>' . $boat->name . '</i></b>');
  }

  public function postAssignWalplaats(Request $request)
  {
    $boat = Boats::find($request->boat_id);

    $boat->box_id = $request->box_id;
    $boat->save();

    return redirect()->back()->with('status', 'De walplaats is succesvol toegewezen aan de boot <b><i>' . $boat->name . '</i></b>');
  }
}

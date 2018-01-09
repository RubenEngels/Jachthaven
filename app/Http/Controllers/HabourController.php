<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Boats;
use App\Box;
use App\RentedBox;
use App\User;

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

    $boat->box_id = $request->wp_id;
    $boat->save();

    return redirect()->back()->with('status', 'De walplaats is succesvol toegewezen aan de boot <b><i>' . $boat->name . '</i></b>');
  }

  public function getClearForTransfer($id)
  {
    $boat = Boats::find($id);

    $boat->box_id = null;
    $boat->save();

    return redirect()->back()->with('status', 'De boot is succesvol vrijgegeven voor overplaatsing!');
  }

  public function postRentBox(Request $request)
  {
    $user = User::find($request->rentTo);

    RentedBox::create([
      'user_id' => $user->id,
      'box_id' => $request->box_id,
    ]);

    return redirect()->back()->with('status', 'De box is succesvol verhuurd aan <b><i>' . $user->name . '</i></b>');
  }

  public function getReleaseRent($id)
  {
    RentedBox::destroy($id);

    return redirect()->back()->with('status', 'De box is succesvol vrij gegeven');
  }
}

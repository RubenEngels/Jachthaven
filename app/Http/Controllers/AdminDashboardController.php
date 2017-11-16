<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserNotifications;

class AdminDashboardController extends Controller
{
  public function getDashboard()
  {
    $active = UserNotifications::where('show', true)->paginate(2);

    return view('admin.dashboard.index')
    ->with('active', $active);
  }

  public function postNotifications(Request $request)
  {
    if (isset($request->id)) {
      $notification = UserNotifications::findOrFail($request->id);
      $save = 'Uw wijzigingen zijn succesvol opgeslagen!';
    } else {
      $notification = new UserNotifications;
      $save = 'De melding is succesvol aangemaakt!';
    }

    $notification->message = $request->message;

    $notification->save();

    return redirect()
      ->back()
      ->with('status', $save);
  }

  public function getDeleteNotifications($id)
  {
    $notification = UserNotifications::findOrFail($id);

    $notification->show = false;
    $notification->save();

    return redirect()
      ->back()
      ->with('status', 'De melding is succesvol verwijderd!');
  }
}

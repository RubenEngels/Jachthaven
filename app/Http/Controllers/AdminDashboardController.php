<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserNotifications;
use App\MailingList;
use App\Newsletters;
use App\Mail\Newsletter;

class AdminDashboardController extends Controller
{
  public function getDashboard()
  {
    $active = UserNotifications::where('show', true)->paginate(2);
    $mailing_list = MailingList::paginate(5);
    $newsletters = Newsletters::paginate(5);

    return view('admin.dashboard.index')
    ->with('active', $active)
    ->with('mailing_list', $mailing_list)
    ->with('newsletters', $newsletters);
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

  public function getMailDelete($id)
  {
    $recipient = MailingList::findOrFail($id);

    $recipient->delete();

    return redirect()
      ->back()
      ->with('status', 'De onvanger is succesvol verwijderd!');
  }

  public function postNewsletter(Request $request)
  {
    if (isset($request->id)) {
      $newsletter = Newsletters::findOrFail($request->id);
      $message = 'Uw wijzingen zijn succesvol opgeslagen!';
    } else {
      $newsletter = new Newsletters;
      $message = 'Uw nieuwsbrief is succesvol aangemaakt!';
    }

    $newsletter->name = $request->name;
    $newsletter->content = $request->content;

    $newsletter->save();

    return redirect()
      ->back()
      ->with('status', $message);
  }

  public function getDeleteNewsletter($id)
  {
    $recipient = Newsletters::findOrFail($id);

    $recipient->delete();

    return redirect()
      ->back()
      ->with('status', 'De nieuwsbrief is succesvol verwijderd!');
  }

  public function sendMail(Request $request)
  {

    if ($request->to == 'everyone') {
      $mailing_list = MailingList::all();

      foreach ($mailing_list as $user) {
        \Mail::to($user->email)->send(new Newsletter($request->newsletter));
      }
    } else {
      \Mail::to($request->to)->send(new Newsletter($request->newsletter));
    }

    return redirect()
      ->back()
      ->with('status', 'De nieuwsbrief is succesvol verstuurd!');
  }
}

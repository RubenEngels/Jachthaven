<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactForm;
use App\MailingList;
use App\Events;
use App\Documents;
use App\UserNotifications;

class GuestController extends Controller
{
  public function getIndex()
  {
    $active = UserNotifications::where('show', true);
    if (null !== $active->first()) {
      return redirect('/start')
        ->with('notifications', count($active));
    }
    return redirect('/start');
  }

  public function getHome()
  {
    return view('index');
  }

  public function postNewsLetter(Request $request)
  {
    MailingList::create([
      'email' => $request->email
    ]);

    return redirect()
      ->back()
      ->with('status', 'U bent succesvol ingeschreven voor de wekelijkse nieuwsbrief');
  }

  public function getContact()
  {
    return view('contact');
  }

  public function postContact(Request $request)
  {
    ContactForm::create([
      'name' => $request->name,
      'email' => $request->email,
      'message' => $request->message,
    ]);

    return redirect()
      ->back()
      ->with('status', 'Uw bericht is succesvol verstuur! We nemen zo spoedig mogelijk contact met u op.');
  }

  public function getAgenda()
  {
    $events = Events::orderBy('date', 'asc')->paginate(5);

    return view('agenda')
      ->with('events', $events);
  }

  public function getPublicDocuments()
  {
    if (\Auth::guard()->check()) {
      $documents = Documents::paginate(3);
    } else {
      $documents = Documents::where('public', true)->paginate(3);
    }

    return view('documents')
      ->with('documents', $documents);
  }

  public function getDownloadDocuments($id)
  {
    $document = Documents::findOrFail($id);

    return response()->download(public_path($document->link));
  }
}

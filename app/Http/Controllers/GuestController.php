<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactForm;
use App\MailingList;

class GuestController extends Controller
{
  public function getIndex()
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
}

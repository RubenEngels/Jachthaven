<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function getProfile()
    {
      return view('user.profile')
        ->with('user', Auth::user());
    }

    public function postPhoto(Request $request)
    {
      // TODO: update using intervention
      request()->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      $imageName = time().'.'.request()->photo->getClientOriginalExtension();
      request()->photo->move(public_path('uploads/avatars'), $imageName);

      Auth::user()->image = strtolower($imageName);
      Auth::user()->save();

      return redirect()->back()->with('status', 'Uw wijzigingen zijn sucessvol opgeslagen!');
    }

    public function postProfile(Request $request)
    {
      $user = Auth::user();

      $user->name = $request->name;
      $user->email = $request->email;
      $user->city = $request->city;
      $user->street = $request->street;
      $user->zip = $request->zip;
      $user->tel = $request->tel;

      $user->save();

      return redirect()
        ->back()
        ->with('status', 'Uw wijzigingen zijn succesvol opgeslagen!');
    }
}

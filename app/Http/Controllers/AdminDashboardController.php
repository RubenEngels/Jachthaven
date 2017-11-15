<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserNotifications;

class AdminDashboardController extends Controller
{
  public function getDashboard()
  {
    return view('admin.dashboard.index');
  }

  public function getNotifications()
  {
    $activeNotifications = UserNotifications::where('active', true)->paginate(3);
    $notifications = UserNotifications::where('active', false)->paginate(5);

    // return view('admin.dashboard.notifications');
  }
}

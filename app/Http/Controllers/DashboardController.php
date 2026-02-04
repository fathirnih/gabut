<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // members see polls without vote counts
        $polls = Poll::latest()->paginate(10);
        return view('dashboard', compact('polls'));
    }
}

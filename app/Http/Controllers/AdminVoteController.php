<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class AdminVoteController extends Controller
{
    public function index()
    {
        $votes = Vote::with(['poll', 'option', 'user'])->latest()->paginate(50);
        return view('admin.votes.index', compact('votes'));
    }

    public function destroy(Vote $vote)
    {
        // decrement option votes_count safely
        $option = $vote->option;
        if ($option) {
            $option->decrement('votes_count');
        }
        $vote->delete();
        return redirect()->route('admin.votes.index')->with('success', 'Vote removed.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // members see polls (no counts). eager load options and compute which polls the user/ip already voted on
        $polls = Poll::with('options')->latest()->paginate(10);

        $votedPollIds = [];
        if (auth()->check()) {
            $votedPollIds = \App\Models\Vote::where('user_id', auth()->id())
                ->whereIn('poll_id', $polls->pluck('id'))
                ->pluck('poll_id')
                ->toArray();
        } else {
            $votedPollIds = \App\Models\Vote::where('ip', $request->ip())
                ->whereIn('poll_id', $polls->pluck('id'))
                ->pluck('poll_id')
                ->toArray();
        }

        return view('dashboard', compact('polls', 'votedPollIds'));
    }
}

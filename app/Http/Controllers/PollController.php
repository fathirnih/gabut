<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Option;
use App\Models\Vote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index(Request $request)
    {
        // show polls with options and compute voted polls for current user/ip
        $polls = Poll::with('options')->latest()->paginate(10);

        $votedPollIds = [];
        if (auth()->check()) {
            $votedPollIds = Vote::where('user_id', auth()->id())
                ->whereIn('poll_id', $polls->pluck('id'))
                ->pluck('poll_id')
                ->toArray();
        } else {
            $votedPollIds = Vote::where('ip', $request->ip())
                ->whereIn('poll_id', $polls->pluck('id'))
                ->pluck('poll_id')
                ->toArray();
        }

        return view('polls.index', compact('polls', 'votedPollIds'));
    }

    public function show(Poll $poll)
    {
        $poll->load('options');
        return view('polls.show', compact('poll'));
    }

    public function vote(Request $request, Poll $poll)
    {
        $data = $request->validate([
            'option_id' => 'required|exists:options,id',
        ]);

        $option = Option::where('id', $data['option_id'])->where('poll_id', $poll->id)->firstOrFail();

        // check expiration
        if ($poll->expires_at && now()->greaterThan($poll->expires_at)) {
            return back()->withErrors(['poll' => 'This poll has expired.']);
        }

        // prevent double vote for authenticated users
        if (auth()->check()) {
            $exists = Vote::where('poll_id', $poll->id)->where('user_id', auth()->id())->exists();
            if ($exists) {
                return back()->withErrors(['vote' => 'You already voted on this poll.']);
            }
        } else {
            // fallback: prevent duplicate by IP
            $exists = Vote::where('poll_id', $poll->id)->where('ip', $request->ip())->exists();
            if ($exists) {
                return back()->withErrors(['vote' => 'You already voted on this poll.']);
            }
        }

        $vote = Vote::create([
            'poll_id' => $poll->id,
            'option_id' => $option->id,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
        ]);

        $option->increment('votes_count');

        return redirect()->route('polls.show', $poll)->with('success', 'Thank you for voting.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminPollController extends Controller
{
    public function index()
    {
        $polls = Poll::latest()->paginate(20);
        return view('admin.polls.index', compact('polls'));
    }

    public function create()
    {
        return view('admin.polls.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);

        $poll = Poll::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        foreach ($data['options'] as $opt) {
            $poll->options()->create(['text' => $opt]);
        }

        return redirect()->route('admin.polls.index')->with('success', 'Poll created.');
    }

    public function edit(Poll $poll)
    {
        $poll->load('options');
        return view('admin.polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);

        $poll->update(["title" => $data['title'], 'description' => $data['description'] ?? null, 'expires_at' => $data['expires_at'] ?? null]);

        // sync options: simple approach: delete & recreate
        $poll->options()->delete();
        foreach ($data['options'] as $opt) {
            $poll->options()->create(['text' => $opt]);
        }

        return redirect()->route('admin.polls.index')->with('success', 'Poll updated.');
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('admin.polls.index')->with('success', 'Poll deleted.');
    }

    public function results(Poll $poll)
    {
        $poll->load('options');
        return view('admin.polls.results', compact('poll'));
    }
}

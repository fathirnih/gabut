<?php

namespace Tests\Feature;

use App\Models\Poll;
use App\Models\Option;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PollTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_vote()
    {
        $poll = Poll::create(['title' => 'Favorite color?']);
        $option = Option::create(['poll_id' => $poll->id, 'text' => 'Blue']);

        $response = $this->post(route('polls.vote', $poll), ['option_id' => $option->id]);

        $response->assertRedirect(route('polls.show', $poll));
        $this->assertDatabaseHas('votes', ['poll_id' => $poll->id, 'option_id' => $option->id]);
        $this->assertDatabaseHas('options', ['id' => $option->id, 'votes_count' => 1]);
    }

    public function test_prevents_double_vote_for_user()
    {
        $user = User::factory()->create();
        $poll = Poll::create(['title' => 'Test poll']);
        $option = Option::create(['poll_id' => $poll->id, 'text' => 'A']);

        $this->actingAs($user)->post(route('polls.vote', $poll), ['option_id' => $option->id]);
        $response = $this->actingAs($user)->post(route('polls.vote', $poll), ['option_id' => $option->id]);

        $response->assertSessionHasErrors('vote');
    }
}

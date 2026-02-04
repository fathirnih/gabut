<?php

namespace Tests\Feature;

use App\Models\Poll;
use App\Models\Option;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_routes_and_see_results()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $poll = Poll::create(['title' => 'Who?']);
        $option = Option::create(['poll_id' => $poll->id, 'text' => 'A', 'votes_count' => 3]);

        $response = $this->actingAs($admin)->get(route('admin.polls.results', $poll));
        $response->assertStatus(200);
        $response->assertSee('Results');
        $response->assertSee('3 votes');
    }

    public function test_member_cannot_access_admin_routes_and_cannot_see_counts()
    {
        $user = User::factory()->create(['role' => 'member']);
        $poll = Poll::create(['title' => 'Test Poll']);
        $option = Option::create(['poll_id' => $poll->id, 'text' => 'A', 'votes_count' => 5]);

        $response = $this->actingAs($user)->get(route('admin.polls.index'));
        $response->assertStatus(403);

        // member viewing poll show should not see vote counts
        $response2 = $this->actingAs($user)->get(route('polls.show', $poll));
        $response2->assertStatus(200);
        $response2->assertDontSee('votes');
    }
}

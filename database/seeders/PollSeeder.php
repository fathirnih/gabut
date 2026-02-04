<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;
use App\Models\Option;
use App\Models\Vote;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        // create 5 polls
        Poll::factory(5)->create()->each(function (Poll $poll) {
            // create 3-5 options per poll
            $options = Option::factory(rand(3, 5))->make();
            $poll->options()->saveMany($options);

            // create some votes (randomly) and increment votes_count
            foreach ($options as $option) {
                $votes = rand(0, 10);
                for ($i = 0; $i < $votes; $i++) {
                    $vote = Vote::factory()->make();
                    $vote->poll_id = $poll->id;
                    $vote->option_id = $option->id;
                    $vote->save();
                }
                $option->update(['votes_count' => $votes]);
            }
        });
    }
}

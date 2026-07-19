<?php

use App\Models\Idea;
use App\Models\User;
use Ramsey\Collection\Collection;

test('idea belongs to a user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});


test('idea can have steps', function () {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'first progress',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});

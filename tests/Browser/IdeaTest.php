<?php

use App\Models\User;
use App\Models\Idea;

it('creates a new idea', function () {
    $this->actingAs($user = User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'some example title')
        ->click('@status-completed-button')
        ->fill('description', 'some example description')
        ->fill('@new-link', "https://example.com")
        ->click('@submit-new-link')
        ->debug()
        ->click('Create')
        ->assertPathIs('/ideas');

    expect(Idea::count())->toBe(1);

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'some example title',
        'description' => 'some example description',
        'status' => 'completed',
    ]);
});

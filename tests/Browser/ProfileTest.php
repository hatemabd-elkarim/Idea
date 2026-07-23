<?php

use App\Notifications\EmailChanged;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

it('notifies the user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Notification::fake();

    visit('/profile')
        ->assertValue('name', $user->name)
        ->fill('email', 'new@example.com')
        ->fill('password', 'password123')
        ->debug()
        ->click('Update Account')
        ->assertSee('profile updated successfully');

    Notification::assertSentOnDemand(EmailChanged::class);
});

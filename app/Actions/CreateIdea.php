<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;

class CreateIdea
{

    public function __construct(#[CurrentUser] protected User $user) {}

    public function handle(array $attributes)
    {
        $data = collect($attributes)->only([
            'title',
            'description',
            'status',
            'links'
        ])->toArray();

        if (!empty($attributes['image'])) {
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        $steps = collect($attributes['steps'] ?? []);

        DB::transaction(function () use ($data, $steps) {
            $idea = $this->user->ideas()->create($data);
            $idea->steps()->createMany($steps);
        });
    }
}

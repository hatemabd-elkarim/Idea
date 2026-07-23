<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Idea;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;

class UpdateIdea
{

    public function handle(array $attributes, Idea $idea)
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

        DB::transaction(function () use ($data, $steps, $idea) {
            $idea->update($data);
            $idea->steps()->delete();
            $idea->steps()->createMany($steps);
        });
    }
}

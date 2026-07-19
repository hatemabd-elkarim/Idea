<?php

namespace App\Models;

use App\IdeaStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    protected $casts = [
        // $casts tells Eloquent how to convert attributes when reading them from the database and writing them back.
        'links' => AsArrayObject::class,
        'status' => IdeaStatus::class,
    ];

    protected $attributes = [ // sets a default value for the model attribute even before saving to the database
        'status' => IdeaStatus::PENDING,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public static function statusCounts(User $user)
    {
        $counts = $user->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBY('status')
            ->pluck('count', 'status'); // pluck(as value, as key)

        $statusCount = collect(IdeaStatus::cases())
            ->mapWithKeys(fn($status) => [
                $status->value => $counts->get($status->value, 0),
            ])
            ->put('all', $user->ideas()->count());

        return $statusCount;
    }
}

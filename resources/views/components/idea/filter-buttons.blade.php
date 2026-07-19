<div>
    <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">All</a>

    @foreach (App\IdeaStatus::cases() as $status)
        <a 
            href="/ideas?status={{ $status->value }}"
            class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}"
        >
            {{ $status->label() }} <span class="text-xs pl-3">{{ $statusCounts->get($status->value) }}</span>
        </a>
    @endforeach
</div>
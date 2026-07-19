@props([
    'status' => ""
])

@php
    use App\IdeaStatus;

    $classes = 'inline-block rounded-full border px-2 py-1 text-xs font-medium';

    $classes .= match($status) {
            IdeaStatus::PENDING => ' bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
            IdeaStatus::IN_PROGRESS => ' bg-blue-500/10 text-blue-500 border-blue-500/20',
            IdeaStatus::COMPLETED => ' bg-green-500/10 text-green-500 border-green-500/20',
            default => ' bg-red-500/10 text-red-500 border-red-500/20'
    };


@endphp

<span {{ $attributes(['class' => $classes]) }}>
        {{ $status->label() }}    
</span>
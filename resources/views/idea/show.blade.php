<x-layout.layout :title="$idea->title">
    <div class="font-bold max-w-4xl mx-auto mt-6">
        <div class="flex justify-between items-center mb-4">
            <a href="{{route('ideas.index')}}" class="flex items-center gap-2 text-sm font-medium">
                <x-icons.arrow-back/>
                Back to Ideas
            </a>
            <div class="gap-x-3 flex items-center">
                <button 
                class="btn btn-outlined"
                x-data
                data-test="edit-idea-button"
                @click="$dispatch('open-modal', 'edit-idea')"
                >
                    <x-icons.external />
                    Edit
                </button>
                <form action="{{route('idea.destroy', $idea->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outlined hover:text-red-500">Delete</button>
                </form>
            </div>

        </div>

        @if($idea->image_path)
            <div class="rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class="w-full" h-auto object-cover>
            </div>
        @endif
        <h3 class="text-foreground text-3xl mb-1.5 mt-3 text-transform: capitalize">{{$idea->title}}</h3>

        <div @class(['border border-border rounded-lg bg-card p-4 md:text-sm']) >

            <div class="flex items-center gap-2">
                <x-idea.status-label :status="$idea->status"/>
                <p class="text-xs text-muted-foreground">{{ $idea->created_at->diffForHumans() }}</p>
            </div>

            <div class="mt-5 prose prose-invert">{!! $idea->formattedDescription !!}</div>
        </div>

            <div class="mt-4 space-y-1">
                <h4 class="text-xl mb-1.5">Actionable Steps</h4>
                    @forelse($idea->steps as $step)
                    <x-card is="div">
                        <form method="POST" action="{{ route('step.update', $step) }}">
                            @csrf
                            @method('PATCH')
                            <div class="flex item-center gap-x-3">
                                <button type="submit" role="checkbox" class="size-5 flex items-center justify-center rounded-lg text-primary-foreground {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">&check;</button>
                                <span class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}"> {{ $step->description }} </span>
                            </div>
                        </form>
                    </x-card>
                    @empty
                        <x-card is="h3">No steps at time </x-card>
                    @endforelse
            </div>
            
            <div class="mt-4 space-y-1">
                <h4 class="text-xl mb-1.5">Links</h4>
                    @forelse($idea->links as $link)
                    <x-card href="{{ $link }}" class="text-primary font-medium flex gap-x-3 items-center hover:text-green-500/60">
                        <div class="flex item-center gap-x-3">
                            <x-icons.external />
                            <span> {{ $link }} </span>
                        </div>
                    </x-card>
                    @empty
                        <x-card is="h3">No links at time </x-card>
                    @endforelse
            </div>
            
            <x-idea.modal :idea="$idea" />
    </div>
</x-layout.layout>

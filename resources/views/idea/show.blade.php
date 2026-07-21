<x-layout.layout :title="$idea->title">
    <div class="font-bold max-w-4xl mx-auto mt-6">
        <div class="flex justify-between items-center mb-4">
            <a href="{{route('ideas.index')}}" class="flex items-center gap-2 text-sm font-medium">
                <x-icons.arrow-back/>
                Back to Ideas
            </a>
            <div class="gap-x-3 flex items-center">
                <button class="btn btn-outlined">
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
        <h3 class="text-foreground text-lg mb-3">{{$idea->title}}</h3>

        <div @class(['border border-border rounded-lg bg-card p-4 md:text-sm']) >

            <div class="flex items-center gap-2">
                <x-idea.status-label :status="$idea->status"/>
                <p class="text-xs text-muted-foreground">{{ $idea->created_at->diffForHumans() }}</p>
            </div>

            <div class="mt-5 ">{{ $idea->description }}</div>
        </div>
            <div class="mt-4 space-y-1">
                <h4 class="text-xl mb-1.5">Links</h4>
                    @forelse($idea->links as $link)
                    <div class="border border-border rounded-lg bg-card p-4 md:text-sm">
                        <a href="{{$link}}"
                           target="_blank"
                           class="text-sm text-green-500/60 flex gap-2 hover:text-primary max-w-fit">
                            <x-icons.external />
                            {{ $link }}
                        </a>
                    </div>
                    @empty
                        <x-card is="h3">No links at time </x-card>
                    @endforelse
            </div>
    </div>
</x-layout.layout>

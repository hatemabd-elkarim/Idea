<x-layout>
    <div class="text-muted-foreground">
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2"> Capture yor thoughts. Make a plan.</p>

            <x-card
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                is="button"
                class="mt-10 cursor-pointer h-32 w-full text-left"
            >
            <p>What is the idea...</p>
            </x-card>
        </header>

        <x-idea.filter-buttons :statusCounts="$statusCounts"/>
        
        <div class="mt-10">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)
                <x-card href="{{route('idea.show', $idea->id)}}"> 
                    <h3 class="text-foreground text-lg">{{$idea->title}}</h3>
                    <x-idea.status-label :status="$idea->status" />
                    <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                    <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
                @empty
                    <h2 class="text-4xl font-bold text-purple-600 ">No ideas at this time</h2>
                @endforelse
            </div>
        </div>

        <x-modal name="create-idea" title="New Idea" />
    </div>
</x-layout>

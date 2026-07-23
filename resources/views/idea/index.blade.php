<x-layout>
    <div class="text-muted-foreground">
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2"> Capture yor thoughts. Make a plan.</p>

            <x-card
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                data-test="create-idea-button"
                is="button"
                class="mt-10 cursor-pointer h-32 w-full text-left"
            >
            <p>What is the idea...</p>
            </x-card>
        </header>

        <x-idea.filter-buttons :statusCounts="$statusCounts"/>
        
        <div class="mt-10">
            <div class="grid md:grid-cols-2 gap-6">
                {{--  image thumbnail --}}
                @forelse($ideas as $idea)
                <x-card href="{{route('idea.show', $idea->id)}}"> 
                    @if($idea->image_path)
                        <div class="mb-4 -mx-4 -mt-4 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class="w-full h-48 object-cover" >
                        </div>
                    @endif
                    <h3 class="text-foreground text-lg">{{$idea->title}}</h3>
                    <x-idea.status-label :status="$idea->status" />
                    <div class="mt-5 line-clamp-3 prose prose-invert">{!! $idea->formattedDescription !!}</div>
                    <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
                @empty
                    <x-card>No ideas at this time</x-card>
                @endforelse
            </div>
        </div>

        <x-idea.modal />
    </div>
</x-layout>

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
                @forelse($ideas as $idea)
                <x-card href="{{route('idea.show', $idea->id)}}"> 
                    <h3 class="text-foreground text-lg">{{$idea->title}}</h3>
                    <x-idea.status-label :status="$idea->status" />
                    <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                    <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
                @empty
                    <x-card>No ideas at this time</x-card>
                @endforelse
            </div>
        </div>

        <x-modal name="create-idea" title="New Idea"> 
                <form
                x-data="{
                status:'pending',
                newLink: '',
                links: [],
                }"
                method="POST" action="{{ route('ideas.store') }}">
                @csrf

                <div class="space-y-6">
                    <x-form.field
                        label="Title"
                        name="title"
                        type="text"
                        placeholder="Enter a title for your idea"
                        required
                        autofocus
                    />
                    <x-form.error name="title"/>

                    <div class="space-y-4">
                        <label for="status" class="lablel">Status</label>
                        <div class="flex gap-x-4 mt-2">
                            @foreach(App\IdeaStatus::cases() as $status)
                                <button
                                    type="button"
                                    @click="status = @js($status->value)"
                                    data-test="status-{{ $status->value }}-button"
                                    class="btn flex-1 h-10"
                                    :class="{'btn-outlined': status !== @js($status->value)}"
                                >
                                    {{ $status->label() }}
                                </button>
                            @endforeach
                                <input type="hidden" name="status" id="status" :value="status" />
                        </div>
                    </div>
                        <x-form.field
                                label="Description"
                                name="description"
                                type="textarea"
                                placeholder="Describe here your idea ...." 
                        />

                        <div>
                            <fieldset class="space-y-3">
                                <legend class="label">Links</legend>

                                <template x-for="(link, index) in links" :key="index">                                    <div class="flex gap-x-2 items-center">
                                        <input
                                            x-model="links[index]"
                                            name="links[]"
                                            class="input flex-1"
                                        >

                                        <button 
                                            type="button" 
                                            aria-label="Remove link"
                                            @click="links.splice(index, 1)"
                                            class="form-muted-icon"
                                            >
                                            <x-icons.close />
                                        </button>
                                    </div>
                                </template>

                                <div class="flex gap-x-2 items-center">
                                    <input 
                                        x-model="newLink"
                                        type="url"
                                        id="new-link"
                                        placeholder="https://example.com"
                                        autocomplete="url"
                                        class="input flex-1"
                                        spellcheck="false"
                                    >

                                    <button 
                                        type="button" 
                                        @click="links.push(newLink.trim()); newLink = '';"
                                        :disabled="newLink.trim().length === 0"
                                        aria-label="Add a new link"
                                        class="form-muted-icon"
                                        >
                                        <x-icons.close class="rotate-45" />
                                    </button>
                                </div>
                            </fieldset>
                        </div>
                </div>
                <div class="flex justify-end gap-x-5 mt-4 pr-4">
                    <button type="button"  @click="$dispatch('close-modal')"
                            class="btn btn-outlined font-bold hover:text-red-500/70 hover:font-extrabold">
                        Cancel
                    </button>
                    <button type="submit" class="btn">Create</button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layout>

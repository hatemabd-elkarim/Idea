@props(['idea' => new \App\Models\Idea()])

<x-modal :name="$idea->exists ? 'edit-idea' : 'create-idea'" :title="$idea->exists ? 'Edit Idea' : 'New Idea'">

    <form
        x-data="{
            status: @js(old('status', $idea->status->value)),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed']))),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            }"
            method="POST" 
            action="{{ $idea->exists ? route('idea.update', $idea) : route('ideas.store') }}"
            enctype="multipart/form-data"
        >

        @csrf

        @if($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-form.field
                label="Title"
                name="title"
                type="text"
                placeholder="Enter a title for your idea"
                required
                autofocus
                :value="$idea->title"
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
                        :value="$idea->description"      
                />

                <div class="space-y-2">
                    <label for="image" class="label">Featured Image</label>

                    @if($idea->image_path)
                        <div>
                            <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class="w-full h-48 object-cover rounded-lg" >
                            <button type="submit" class="btn btn-outlined h-10 mt-1 w-full" form="delete-image-form">Remove Image</button>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*">
                    <x-form.error name="image"/>
                </div>

                {{--  Steps --}}

                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Actionable Steps</legend>

                        <template x-for="(step, index) in steps">                                    
                            <div class="flex gap-x-2 items-center">
                                <input
                                    x-model="step.description"
                                    :name="`steps[${index}][description]`"
                                    class="input flex-1"
                                >

                                <input
                                    type="hidden"
                                    :value="step.completed ? '1' : '0' "
                                    :name="`steps[${index}][completed]`"
                                    class="input flex-1"
                                >

                                <button 
                                    type="button" 
                                    aria-label="Remove Step"
                                    @click="steps.splice(index, 1)"
                                    class="form-muted-icon"
                                    >
                                    <x-icons.close />
                                </button>
                            </div>
                        </template>

                        <div class="flex gap-x-2 items-center">
                            <input 
                                x-model="newStep"
                                type="text"
                                id="new-step"
                                placeholder="my next step is ..."
                                data-test="new-step"
                                class="input flex-1"
                                spellcheck="false"
                            >

                            <button 
                                type="button" 
                                @click="steps.push({ description: newStep.trim(), completed: false}); newStep = '';"
                                :disabled="newStep.trim().length === 0"
                                aria-label="Add a new step"
                                class="form-muted-icon"
                                data-test="submit-new-step"                                        
                                >
                                <x-icons.close class="rotate-45" />
                            </button>
                        </div>
                    </fieldset>
                </div>


                {{-- Links --}}
                <div>
                    <fieldset class="space-y-3">
                        <legend class="label">Links</legend>

                        <template x-for="(link, index) in links">                                    
                            <div class="flex gap-x-2 items-center">
                                <input
                                    type="url"
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
                                data-test="new-link"
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
                                data-test="submit-new-link"                                        
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
            <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
        </div>
    </form>

    @if($idea->exists)
        <form action="{{ route('idea.destroyImage', $idea) }}" id="delete-image-form" method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
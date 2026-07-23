@props(['name', 'title'])

<div
    x-data="{
    show: @js(session('open-modal') === $name || $errors->any()),
    name: @js($name)
    }"
    x-show="show"
    @open-modal.window="if($event.detail === name) show = true"
    @close-modal="show = false"
    @keydown.escape.window="show = false"
    x-transition:enter="ease-out duration-250"
    x-transition:enter-start="opacity-0 -translate-y-24 -translate-x-24"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-250"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 -translate-y-4"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs"
    style="display:none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-{{ $name }}-title"
    :aria-hidden="!show"
    tabindex="-1"
    :inert="!show"
>
    <x-card is="div" @click.away="show = false" class="shadow-xl max-w-2xl w-full max-h-[80dvh] overflow-auto">
        <div class="flex justify-between items-center">
            <h2 id="modal-{{ $name }}-title" class="text-xl font-bold mb-4">{{ $title }}</h2>
            <button class="border border-border rounded-full p-1 group hover:border-red-500/30 hover:bg-red-300/20">
                <x-icons.close
                    @click="show=false"
                    class="w-6 cursor-pointer group-hover:fill-red-500/80" />
            </button>
        </div>

        <div class="mt-4">
            {{ $slot }}
        </div>
    </x-card>
</div>

<div>
    <x-danger-button wire:click="$set('open', true)">
        Crear nuevo post&numsp;<i class="fas fa-plus"></i>
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear nuevo post
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label for="title" value="Título" />
                <x-input wire:model.defer="title" id="title" class="block mt-1 w-full" type="text" />
                @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <div wire:ignore>
                    <x-label for="content" value="Contenido" />
                    <textarea id="editor" wire:model.defer="content" rows="6"
                        class="block mt-1 w-full border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                </div>
                @error('content')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <input type="file" wire:model.defer="image" id="{{ $identificador }}">
                <div wire:loading wire:target="image" class="w-full mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">¡Imagen Cargando!</strong>
                        <span class="block sm:inline">Espere un momento hasta que la imagen se haya procesado.</span>
                    </div>
                </div>
                @if ($image)
                    <img src="{{ $image ? $image->temporaryUrl() : '' }}" class="object-cover h-64 w-full mt-4">
                @endif
                @error('image')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-secondary-button>
            &numsp;
            <x-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image"
                class="disabled:opacity-25">
                Crear post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(function(editor) {
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData());
                    });

                    Livewire.on('resetCKEditor', () => {
                        editor.setData('');
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</div>

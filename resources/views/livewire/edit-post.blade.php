<div>
    <a class="cursor-pointer bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
        wire:click="$set('open', true)">
        <i class="fas fa-edit"></i>
    </a>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Edit Post
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label for="title" value="Título" />
                <x-input wire:model.defer="post.title" id="title" class="block mt-1 w-full" type="text" />
                @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="content" value="Contenido" />
                <textarea wire:model.defer="post.content" id="content" rows="6"
                    class="form-control block mt-1 w-full border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
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
                    <img src="{{ $image->temporaryUrl() }}" class="object-cover h-64 w-full mt-4">
                @else
                    <img src="{{ Storage::url($post->image) }}" class="object-cover h-64 w-full mt-4">
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
            <x-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                class="disabled:opacity-25">
                Actualizar post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>

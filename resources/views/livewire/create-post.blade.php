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
                <x-label for="content" value="Contenido" />
                <textarea wire:model.defer="content" id="content" rows="6"
                    class="form-control block mt-1 w-full border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                @error('content')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- <div class="mb-4">
                <input type="file" wire:model.defer="image" id="{{ $identificador }}">
                <div wire:loading wire:target="image">
                    Cargando...
                </div>
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="object-cover h-64 w-full">
                @endif
                @error('image')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div> --}}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-secondary-button>
            &numsp;
            <x-danger-button wire:click="save">
                Crear post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>

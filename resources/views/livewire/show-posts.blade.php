<div wire:init="loadPosts">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <x-table>
            <div class="px-6 py-4 flex items-center">
                <div class="flex items-center">
                    <span>Mostrar</span>

                    <select wire:model="cant"
                        class="mx-2 block w-full border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    <span>entradas</span>
                </div>

                <x-input class="flex-1 mx-4" placeholder="Escriba que quiere buscar" type="text"
                    wire:model="search" />

                @livewire('create-post')
            </div>

            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="w-24 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('id')">
                            ID
                            {{-- Sort --}}
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                        </th>
                        <th scope="col"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('title')">
                            Title
                            {{-- Sort --}}
                            @if ($sort == 'title')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                        </th>
                        <th scope="col"
                            class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            wire:click="order('content')">
                            Content
                            {{-- Sort --}}
                            @if ($sort == 'content')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fas fa-sort float-right mt-1"></i>
                            @endif
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">
                                Actions
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($posts as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $item->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $item->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {!! $item->content !!}
                                </div>
                            </td>
                            <td class="px-6 py-4 ext-sm font-medium flex">
                                {{-- @livewire('edit-post', ['post' => $post], key($post->id)) --}}

                                <a class="cursor-pointer bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
                                    wire:click="edit({{ $item }})">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a class="cursor-pointer bg-red-700 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-2"
                                    wire:click="$emit('deletePost', {{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        @if (!$readyToLoad)
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-2xl">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-sm text-gray-500">
                                    No posts found!
                                </td>
                            </tr>
                        @endif
                    @endforelse
                </tbody>
            </table>

            @if (count($posts))
                @if ($posts->hasPages())
                    <div class="px-6 py-3">
                        {{ $posts->links() }}
                    </div>
                @endif
            @endif
        </x-table>
    </div>

    <x-dialog-modal wire:model="open_edit">
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
                    <img src="{{ $image ? $image->temporaryUrl() : '' }}" class="object-cover h-64 w-full mt-4">
                @else
                    <img src="{{ $post->image ? Storage::url($post->image) : '' }}"
                        class="object-cover h-64 w-full mt-4">
                @endif
                @error('image')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open_edit', false)">
                Cancelar
            </x-secondary-button>
            &numsp;
            <x-danger-button wire:click="update" wire:loading.attr="disabled" wire:target="update"
                class="disabled:opacity-25">
                Actualizar post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    @push('js')
        <script>
            Livewire.on('deletePost', postId => {
                Swal.fire({
                    title: '¿Está seguro/a?',
                    text: "¡No podrá revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('show-posts', 'delete', postId);
                    }
                })
            });
        </script>
    @endpush
</div>

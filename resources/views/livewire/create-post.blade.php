<div>
    <button wire:click="$set('isOpen', true)" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
        <i class="fas fa-plus"></i> Post
    </button>
    <x-jet-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            Nuevo Post
        </x-slot>
        <x-slot name="content">
            <x-jet-label value="Título del Post" />
            <x-jet-input type="text" placeholder="Título" class="mt-2 w-full" wire:model.defer="titulo" />
            <x-jet-input-error for="titulo" />
            <x-jet-label value="Contenido del Post" class="mt-4" />
            <textarea wire:model.defer="contenido"
                class='w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm'
                placeholder='Contenido del Post'></textarea>
                <x-jet-input-error for="contenido" />
            <!-- Para la Imagen -->
            <div class="grid mt-2 grid-cols-2 gap-4">
                <div>
                    <div class="flex justify-center">
                        <div>
                            <x-jet-label value="Imagen del Post" />
                            <input
                                class="form-control block w-full px-3
                                py-1.5
                                text-base
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded transition ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                type="file" wire:model="image" accept="image/*">
                                <x-jet-input-error for="image" />
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Pintaremosla imagen por defecto o la imagen elegida-->
                    @if($image)
                    <img src="{{$image->temporaryUrl()}}" class="object-cover object-center w-80">
                    @else
                    <img src="{{Storage::url('logos/noimage.jpg')}}" class="object-cover object-center w-80">
                    @endif    
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button wire:loading.attr="disabled" class="mt-2 mb-4 bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded" wire:click="guardar">
                <i class="fas fa-save"></i> Enviar
            </button>
        </x-slot>

    </x-jet-dialog-modal>
</div>

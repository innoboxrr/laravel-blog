<div>
    <h2 class="text-lg font-semibold text-gray-800">{{ $message }}</h2>
    <button wire:click="$set('message', 'Mensaje Actualizado')" class="bg-blue-500 text-white px-4 py-2 rounded">
        Actualizar Mensaje
    </button>
</div>

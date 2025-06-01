<div class="max-w-3xl mx-auto mt-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white bg-gray-800 shadow rounded-xl p-6 md:p-10">

        <div class="text-center mb-6">
            <div class="inline-block bg-indigo-100 p-4 rounded-full mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16l-4-4H4a1 1 0 01-1-1V4z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Contáctanos</h2>
            <p class="text-sm text-gray-500 text-gray-400">
                ¿Tienes dudas o necesitas ayuda? Escríbenos y te responderemos lo antes posible.
            </p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Nombre</label>
                <input type="text" wire:model.defer="name"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-700" />
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Correo electrónico</label>
                <input type="email" wire:model.defer="email"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-700" />
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Teléfono (opcional)</label>
                <input type="text" wire:model.defer="phone"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-700" />
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Mensaje</label>
                <textarea rows="5" wire:model.defer="message"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-700"></textarea>
                @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 font-semibold py-2 px-4 rounded-md shadow text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Enviar mensaje
                </button>
            </div>
        </form>
    </div>
</div>

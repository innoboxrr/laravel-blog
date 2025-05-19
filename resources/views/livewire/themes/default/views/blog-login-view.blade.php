<div class="container mx-auto my-12 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 bg-white rounded-lg shadow-lg overflow-hidden">

        {{-- Panel de inicio de sesión --}}
        <div class="p-8 bg-gray-50">
            <h2 class="text-2xl font-bold mb-6 text-center">Inicia sesión</h2>

            <form wire:submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Correo electrónico</label>
                    <input type="email" wire:model.defer="login_email" class="w-full border px-4 py-2 rounded" />
                    @error('login_email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Contraseña</label>
                    <input type="password" wire:model.defer="login_password" class="w-full border px-4 py-2 rounded" />
                    @error('login_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Entrar
                </button>
            </form>
        </div>

        {{-- Panel de registro --}}
        <div class="p-8 bg-white border-l border-gray-200">
            <h2 class="text-2xl font-bold mb-6 text-center">Crea tu cuenta</h2>

            <form wire:submit.prevent="register" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nombre completo</label>
                    <input type="text" wire:model.defer="register_name" class="w-full border px-4 py-2 rounded" />
                    @error('register_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Correo electrónico</label>
                    <input type="email" wire:model.defer="register_email" class="w-full border px-4 py-2 rounded" />
                    @error('register_email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Contraseña</label>
                    <input type="password" wire:model.defer="register_password" class="w-full border px-4 py-2 rounded" />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                    <input type="password" wire:model.defer="register_password_confirmation" class="w-full border px-4 py-2 rounded" />
                    @error('register_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <input type="hidden" wire:model.defer="redirect" value="{{ request()->input('redirect') }}" />

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                    Registrarse
                </button>
            </form>
        </div>
    </div>
</div>
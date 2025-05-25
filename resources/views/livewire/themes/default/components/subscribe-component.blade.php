<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300"
            x-data
            @click.self="$wire.set('showModal', false)">
            <div class="relative bg-gradient-to-br from-purple-600 to-indigo-500 p-1 rounded-2xl shadow-2xl max-w-lg w-full animate-fadeInUp">
                <div class="bg-white rounded-2xl p-6 md:p-8 text-center">
                    {{-- Icono Superior --}}
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <div class="bg-indigo-100 p-4 rounded-full">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16l-4-4H4a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                            <span class="absolute -top-1 -right-1 bg-yellow-400 w-4 h-4 rounded-full border-2 border-white"></span>
                        </div>
                    </div>

                    {{-- Contenido principal --}}
                    @if (!$subscribed)
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Suscríbete y recibe contenido exclusivo</h2>
                        <p class="text-sm text-gray-500 mb-6">
                            Sé el primero en enterarte de nuestras novedades, promociones y artículos destacados.
                        </p>

                        <form wire:submit.prevent="subscribe" class="space-y-4 text-left">
                            @if ($showName)
                                <div>
                                    <label class="text-sm text-gray-700 block mb-1">Nombre</label>
                                    <input type="text" wire:model.defer="name" placeholder="Tu nombre"
                                           class="w-full border border-gray-300 px-4 py-2 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>
                            @endif

                            <div>
                                <label class="text-sm text-gray-700 block mb-1">Correo electrónico</label>
                                <input type="email" wire:model.defer="email" placeholder="Tu correo"
                                       class="w-full border border-gray-300 px-4 py-2 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            @if ($showPhone)
                                <div>
                                    <label class="text-sm text-gray-700 block mb-1">Teléfono</label>
                                    <x-tel-input
                                        wire:model.live="phone"
                                        id="phone"
                                        name="phone"
                                        class="w-full border border-gray-300 px-4 py-2 rounded-md text-sm focus:ring-2 focus:ring-indigo-500"
                                    />
                                    <input type="hidden" wire:model.live="country_code" id="country_code" name="country_code">
                                </div>
                            @endif

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-orange-500 to-yellow-400 text-white font-semibold px-6 py-2 rounded-md shadow hover:brightness-110 transition">
                                Suscribirme
                            </button>
                        </form>
                    @else
                        {{-- Mensaje post-suscripción --}}
                        <div class="text-center space-y-3">
                            <h3 class="text-xl font-semibold text-green-600">¡Gracias por suscribirte! 🎉</h3>
                            <p class="text-sm text-gray-600">
                                📩 Hemos enviado un correo a <strong>{{ $emailToConfirm }}</strong>. 
                                Revisa tu bandeja de entrada o spam para confirmar tu suscripción.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Botón de cierre --}}
                <button wire:click="$set('showModal', false)" x-on:click="setCookie()"
                        class="absolute top-3 right-4 text-white text-2xl font-bold hover:scale-110 transition-all">
                    &times;
                </button>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        function setCookie() {
            const expires = new Date(Date.now() + 2 * 60 * 60 * 1000).toUTCString();
            document.cookie = `subscribe_modal=true; expires=${expires}; path=/`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const alwaysShow = @json($alwaysShow);
            if (!document.cookie.includes('subscribe_modal=') || alwaysShow) {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('openSubscribeModal'));
                }, 10000);
            }
        });

        window.addEventListener('set-subscribe-cookie', function () {
            setCookie();
        });
    </script>
@endpush

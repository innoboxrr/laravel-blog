<div>
    <input wire:model="email" type="email" placeholder="Tu correo">
    <button wire:click="subscribe">Suscribirme</button>
    @if (session()->has('message'))
        <p>{{ session('message') }}</p>
    @endif
</div>

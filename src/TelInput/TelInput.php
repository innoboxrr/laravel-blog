<?php

namespace Innoboxrr\LaravelBlog\TelInput;

use Illuminate\View\Component;

/**
 * Campo de telefono internacional para los formularios Livewire del tema.
 *
 * Viene de victorybiz/laravel-tel-input (MIT, main en a3ae8a8, marzo de 2025;
 * la licencia esta en resources/tel-input/LICENSE.md). Se trae al paquete porque
 * el original no tiene ninguna version compatible con Laravel 13 y el blog lo
 * usa en los formularios de contacto y de suscripcion.
 *
 * Se conservan el nombre del componente, las directivas, los nombres de vista y
 * la clave de configuracion: una aplicacion que hubiera publicado o sobrescrito
 * cualquiera de ellos sigue funcionando igual.
 *
 * El unico cambio respecto al original es declarar explicito el parametro
 * nullable, que PHP 8.4 depreca cuando es implicito.
 */
class TelInput extends Component
{
    public $id;

    public $name;

    public function __construct(?string $id = null, string $name = 'phone')
    {
        $this->id = $id;
        $this->name = $name;

        if (! $this->name) {
            $this->name = 'phone-' . uniqid();
        }

        if (! $this->id) {
            $this->id = $this->name;
        }
    }

    public function render()
    {
        return view('laravel-tel-input::components.laravel-tel-input');
    }
}

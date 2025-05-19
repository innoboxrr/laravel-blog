<?php

namespace Innoboxrr\LaravelBlog\Http\Livewire;

use Innoboxrr\LaravelBlog\Http\Livewire\BaseLivewireComponent as Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BlogLogin extends Component
{
    public string $mode = 'login';

    // Separar inputs para login y registro
    public string $login_email = '';
    public string $login_password = '';

    public string $register_name = '';
    public string $register_email = '';
    public string $register_password = '';
    public string $register_password_confirmation = '';

    public string $redirect = '';

    public function mount()
    {
        $this->redirect = request()->query('redirect', '/');

        if (Auth::check()) {
            redirect()->to($this->redirect);
        }
    }

    protected function rules()
    {
        if ($this->mode === 'register') {
            return [
                'register_name' => 'required|string|max:255',
                'register_email' => 'required|email|unique:users,email',
                'register_password' => 'required|min:6|confirmed',
            ];
        }

        return [
            'login_email' => 'required|email',
            'login_password' => 'required',
        ];
    }

    public function login()
    {
        $this->mode = 'login';
        $this->validate();

        if (Auth::attempt(['email' => $this->login_email, 'password' => $this->login_password])) {
            session()->regenerate();
            return redirect()->to($this->redirect);
        } else {
            $this->addError('login_email', 'Credenciales incorrectas');
        }
    }

    public function register()
    {
        $this->mode = 'register';
        $this->validate();

        $user = User::create([
            'name' => $this->register_name,
            'email' => $this->register_email,
            'password' => Hash::make($this->register_password),
        ]);

        Auth::login($user);
        session()->regenerate();
        return redirect()->to($this->redirect);
    }

    public function render()
    {
        return $this->renderView('login');
    }
}
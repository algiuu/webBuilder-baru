<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login Admin | Innova.Web</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="login-page">
        <main class="login-card">
            <div class="login-mark">I</div>
            <p class="eyebrow">Innova.Web Control Room</p>
            <h1>Masuk sebagai admin</h1>
            <p class="login-copy">Kelola website, template, dan aktivitas platform dari satu tempat.</p>
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <label for="email">Email admin</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus />
                @error('email')<small class="form-error">{{ $message }}</small>@enderror
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required />
                <label class="remember-field"><input type="checkbox" name="remember" value="1" /> Ingat saya</label>
                <button class="button button-primary" type="submit">Masuk ke dashboard <span>→</span></button>
            </form>
        </main>
    </body>
</html>

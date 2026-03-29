<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login | LMC Fencing & Gates</title>
        <meta name="description" content="LMC Fencing & Gates admin login.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Barlow+Condensed:wght@300;400;500;600;700;900&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-forge font-sans text-white antialiased">
        <div class="forge-noise flex min-h-screen items-center justify-center px-6 py-10">
            <div class="steel-card w-full max-w-md p-8">
                <div class="mb-8 text-center">
                    <img src="{{ asset('storage/lmc.svg') }}" alt="LMC Fencing & Gates" class="mx-auto h-20 w-auto">
                    <p class="section-tag mt-6 justify-center after:hidden before:block before:h-px before:w-9 before:bg-rust">Admin</p>
                    <h1 class="mt-4 font-display text-4xl font-bold uppercase tracking-[0.02em] text-white">Sign In</h1>
                </div>

                @if ($errors->any())
                    <div class="mb-6 border border-rust/40 bg-rust/10 px-4 py-3 text-sm text-silver">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition placeholder:text-ash focus:border-rust">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Password</label>
                        <input id="password" name="password" type="password" required class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition placeholder:text-ash focus:border-rust">
                    </div>

                    <label class="flex items-center gap-3 text-sm text-silver">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 border-white/20 bg-chain text-rust focus:ring-rust">
                        <span>Keep me signed in</span>
                    </label>

                    <button type="submit" class="clip-rust-sm inline-flex w-full items-center justify-center bg-rust px-6 py-4 font-display text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-rust-hot">
                        Log In
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-ash">
                    <a href="{{ route('home') }}" class="transition hover:text-white">Back to site</a>
                </div>
            </div>
        </div>
    </body>
</html>

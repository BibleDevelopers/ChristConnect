@props([
    'title',
    'action',
    'buttonText',
    'switchText',
    'switchLink',
    'switchLinkText'
])

<x-auth-layout :title="$title">
    <div class="auth-container">
        <div class="auth-form">
            <h2>{{ $title }}</h2>
            <form method="POST" action="{{ $action }}">
                @csrf
                
                {{ $slot }}

                <button type="submit" class="btn-submit">{{ $buttonText }}</button>

                <div class="switch-auth">
                    <p>{{ $switchText }} <a href="{{ $switchLink }}">{{ $switchLinkText }}</a></p>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>
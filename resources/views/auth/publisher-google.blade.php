<x-filament::button
    :href="route('socialite.redirect',['provider' => 'google', 'role' => 'publisher'])"
    tag="a"
    color="info"
>
    Sign in with Google
</x-filament::button>
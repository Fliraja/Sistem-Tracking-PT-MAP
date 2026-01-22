@auth
    @if (auth()->user()->role === 'admin')
        @include('layouts.navigation.admin')
    @elseif (auth()->user()->role === 'supir')
        @include('layouts.navigation.supir')
    @endif
@endauth

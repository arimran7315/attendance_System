@props([
    'action',
    'method' => 'POST'
])

<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" style="display:inline;">
    @csrf
    @unless (in_array($method, ['GET', 'POST']))
        @method($method)
    @endunless

    {{ $slot }}
</form>

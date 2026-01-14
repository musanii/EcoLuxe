@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'EcoLuxe Cleaning')
                <img src="{{ asset('images/logo.png') }}" class="logo" alt="EcoLuxe Logo" style="width: 150px;">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>

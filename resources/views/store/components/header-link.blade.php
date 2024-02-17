<a href="{{ route($route,request()->route('store')) }}">
    <li
        class="hover:bg-gray-700 transition-all py-1 border-b-2 px-2 @if (request()->routeIs($route)) border-b-green-500 @else border-b-transparent @endIf">
        {{ $slot }}
    </li>
</a>

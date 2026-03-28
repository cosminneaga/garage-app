<x-layout>
    Hello, {{ Auth::user() ? Auth::user()->name : 'Guest' }}!
</x-layout>

<x-app-layout>
    <x-slot name='header'>
        First Page
    </x-slot>
    <div class='py-12 container'>
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('test')
            </div>
        </div>
    </div>
    
</x-app-layout>
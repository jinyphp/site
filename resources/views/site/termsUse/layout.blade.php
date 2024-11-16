<x-www-app>
    <x-www-layout>
        <x-www-main>

            {{-- 약관 --}}
            @livewire('site-terms-use',[
                'slug' => $slug
            ])

        </x-www-main>
    </x-www-layout>
</x-www-app>

<x-www-layout>
    Hello

    <section class="py-5">
        <div class="container px-5">
            @livewire('WidgetCode-Html', [
                'filename' => "code_html1"
            ])
        </div>
    </section>

    <section class="py-5">
        <div class="container px-5">
            @livewire('WidgetCode-Preview', [
                'filename' => "component_alert_code2"
            ])
        </div>
    </section>




</x-www-layout>

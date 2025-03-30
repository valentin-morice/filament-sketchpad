<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry"
>
    @php $uniqid = uniqid() @endphp
    <div id="sketchpad_container" wire:key="{{ rand() }}" x-data="{
            id: {{ \Illuminate\Support\Js::from($uniqid) }},
            penSize: 10,
            color: '#000000',
            state: {{ \Illuminate\Support\Js::from($getState()) }},
            height: {{ \Illuminate\Support\Js::from($getHeight()) }},
            sketchpad: null
        }"
         x-init="
            $watch('penSize', value => sketchpad.penSize = value);
            $watch('color', value => sketchpad.color = value);
            $watch('sketchpad', value => state = value.toJSON());
            const element = `#sketchpad_${id}`;
            if (state) {
                try {
                    parsed = JSON.parse(state)
                    penSize = parsed.strokes.at(-1).size
                    color = parsed.strokes.at(-1).color
                    state = parsed
                    state.height = height
                    state.element = element;
                    state.width = document.getElementById('sketchpad_container').clientWidth
                    sketchpad = new FilamentSketchpad(state)
                } catch {
                    sketchpad = null
                }
            }
        " style="box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); border-radius: 0.5rem; overflow: hidden" class="master">
        <canvas disabled x-show="state" style="cursor: not-allowed; pointer-events: none; width: 100%" id="sketchpad_{{ $uniqid }}">
        </canvas>
        <x-filament::icon-button style="margin: 0 auto; pointer-events: none" icon="heroicon-m-eye-slash" x-show="!state" color="gray"/>
    </div>
</x-dynamic-component>

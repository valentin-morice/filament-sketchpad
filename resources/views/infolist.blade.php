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
            const element = `#sketchpad_${id}`;
            if (state) {
                try {
                    const parsed = typeof state === 'string' ? JSON.parse(state) : state;
                    const last = parsed.strokes?.at(-1);
                    if (last) {
                        penSize = last.size;
                        color = last.color;
                    }
                    parsed.height = height;
                    parsed.element = element;
                    parsed.width = document.getElementById('sketchpad_container').clientWidth;
                    parsed.readOnly = true;
                    sketchpad = new FilamentSketchpad(parsed);
                    state = parsed;
                } catch {
                    sketchpad = null;
                    state = null;
                }
            }
        " style="box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); border-radius: 0.5rem; overflow: hidden" class="master">
        <canvas disabled x-show="state" style="cursor: not-allowed; pointer-events: none; width: 100%" id="sketchpad_{{ $uniqid }}">
        </canvas>
        <div x-show="!state" style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem 0;">
            <x-filament::icon-button style="margin: 0 auto; pointer-events: none" icon="heroicon-m-eye-slash" color="gray"/>
            <span style="font-size: 0.875rem; color: rgb(107 114 128);">{{ __('filament-sketchpad::sketchpad.empty') }}</span>
        </div>
    </div>
</x-dynamic-component>

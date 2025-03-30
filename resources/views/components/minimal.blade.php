<div id="sketchpad_container" wire:key="{{ rand() }}" x-data="{
        id: {{ \Illuminate\Support\Js::from($uniqid) }},
        penSize: 10,
        color: '#000000',
        state: $wire.entangle({{ \Illuminate\Support\Js::from($getStatePath()) }}),
        height: {{ \Illuminate\Support\Js::from($getHeight()) }},
        sketchpad: null,
        updateState() {
            if (this.sketchpad) {
                this.state = this.sketchpad.toJSON();
            }
        }
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
                sketchpad = new FilamentSketchpad({
                            element,
                            width: document.getElementById('sketchpad_container').clientWidth,
                            height
                        })
            }
        } else {
            sketchpad = new FilamentSketchpad({
                            element,
                            width: document.getElementById('sketchpad_container').clientWidth,
                            height
                        })
        }

        sketchpad.on('mouseup', () => updateState());
        updateState();
    " style="box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); border-radius: 0.5rem; overflow: hidden" class="master">
    <div class="bottom" style="display: flex; align-items: center; padding: 8px; justify-content: space-between;">
        <div style="display: flex; gap: 0.75rem; align-items: center; margin: 0.25rem 0.5rem">
            @foreach($getHistory() as $key => $button)
                <x-filament::icon-button
                                    tooltip="{{ $button['label'] }}"
                                    x-on:click="sketchpad.{{ $key }}()"
                                    color="{{ $button['color'] }}" icon="{{ $button['icon'] }}">
                    {{ $button['label'] }}
                </x-filament::icon-button>
            @endforeach
            @php $controls = $getControls() @endphp
                <x-filament::icon-button x-on:click="sketchpad.clear()"
                                         icon="{{ $controls['clear']['icon'] }}"
                                         color="{{ $controls['clear']['color'] }}"
                                         tooltip="{{ $controls['clear']['label'] }}" />
                <x-filament::icon-button
                    icon="{{ $controls['reset']['icon'] }}"
                    color="{{ $controls['reset']['color'] }}"
                    tooltip="{{ $controls['reset']['label'] }}"
                    x-on:click="
                       if (sketchpad) {
                           sketchpad.strokes = [];
                           sketchpad.undoHistory = [];
                           if (sketchpad.context && sketchpad.canvas) {
                               sketchpad.context.clearRect(0, 0, sketchpad.canvas.width, sketchpad.canvas.height);
                           } else {
                               console.error('Sketchpad context or canvas not available for hard reset clear.');
                           }
                           state = sketchpad.toJSON();
                       } else {
                            console.error('Sketchpad not initialized, cannot reset.');
                       }
                    "
                />
        </div>
        @php $download = $getDownload() @endphp
        <x-filament::icon-button
            style="margin-right: 0rem"
            tooltip="{{ $download['label'] }}"
            color="{{ $download['color'] }}" icon="{{ $download['icon'] }}"
            x-on:click="
                    if (!sketchpad || !sketchpad.canvas) {
                        return;
                    }
                    const dataUrl = sketchpad.canvas.toDataURL('image/png');
                    const link = document.createElement('a');
                    link.style.display = 'none';

                    link.href = dataUrl;
                    link.download = id;
                    document.body.appendChild(link);
                    link.click();

                    document.body.removeChild(link);
            "/>
    </div>
    <canvas style="cursor: crosshair;" id="sketchpad_{{ $uniqid }}">
    </canvas>
    <div class="top" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px 8px 8px">
        <input type="color" x-model="color">
        <input type="range" min="1" max="50" class="slider" x-model="penSize">
    </div>
</div>

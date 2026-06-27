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
                sketchpad = new FilamentSketchpad(parsed);
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
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            @foreach($getHistory() as $key => $button)
                <x-filament::button icon-position="{{ $key !== 'redo' ? 'before' : 'after' }}"
                                    x-on:click="sketchpad.{{ $key }}()"
                                    color="{{ $button['color'] }}" icon="{{ $button['icon'] }}">
                    {{ $button['label'] }}
                </x-filament::button>
            @endforeach
            <x-filament::dropdown placement="top-start" style="padding: 0 0.5rem">
                <x-slot name="trigger">
                    <x-filament::icon-button icon="heroicon-m-bars-3" color="gray"/>
                </x-slot>

                @php $controls = $getControls() @endphp
                <x-filament::dropdown.list>
                    <x-filament::dropdown.list.item
                        icon="{{ $controls['clear']['icon'] }}"
                        color="{{ $controls['clear']['color'] }}"
                        x-on:click="sketchpad.clear()"
                    >
                        {{ $controls['clear']['label'] }}
                    </x-filament::dropdown.list.item>
                    <x-filament::dropdown.list.item
                        icon="{{ $controls['reset']['icon'] }}"
                        color="{{ $controls['reset']['color'] }}"
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
                                ">
                        {{ $controls['reset']['label'] }}
                    </x-filament::dropdown.list.item>
                </x-filament::dropdown.list>
            </x-filament::dropdown>

        </div>
        @php $download = $getDownload() @endphp
        <x-filament::button
            color="{{ $download['color'] }}" icon="{{ $download['icon'] }}"
            x-on:click="
                    if (!sketchpad || !sketchpad.canvas) {
                        return;
                    }
                    const dataUrl = sketchpad.canvas.toDataURL('image/png');
                    const link = document.createElement('a');
                    link.style.display = 'none';

                    link.href = dataUrl;
                    link.download = {{ \Illuminate\Support\Js::from(($download['filename'] ?? 'sketchpad').'.png') }};
                    document.body.appendChild(link);
                    link.click();

                    document.body.removeChild(link);
            ">{{ $download['label'] }}</x-filament::button>
    </div>
    <canvas style="cursor: crosshair;" id="sketchpad_{{ $uniqid }}">
    </canvas>
    <div class="top" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px 8px 8px">
        <input type="color" x-model="color">
        <input type="range" min="1" max="50" class="slider" x-model="penSize">
    </div>
</div>

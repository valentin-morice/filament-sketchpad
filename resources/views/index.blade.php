<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div id="sketchpad_container" wire:key="{{ rand() }}" x-data="{
        penSize: 10,
        color: '#000',
        state: $wire.entangle('{{ $getStatePath() }}'),
        sketchpad: null,
    }" x-init="
        $watch('penSize', value => sketchpad.penSize = value);
        $watch('color', value => sketchpad.color = value);
        $watch('sketchpad', value => state = value.toJSON());
        if (state) {
            try {
                penSize = JSON.parse(state).strokes.at(-1).size
                color = JSON.parse(state).strokes.at(-1).color
                state = JSON.parse(state)
                state.height = {{ $getHeight() }}
                state.element = '#sketchpad';
                state.width = document.getElementById('sketchpad_container').clientWidth
                sketchpad = new Sketchpad(state)
            } catch {
                sketchpad = new Sketchpad({
                            element: '#sketchpad',
                            width: document.getElementById('sketchpad_container').clientWidth,
                            height: {{ $getHeight() }}
                        })
            }
        } else {
            sketchpad = new Sketchpad({
                            element: '#sketchpad',
                            width: document.getElementById('sketchpad_container').clientWidth,
                            height: {{ $getHeight() }}
                        })
        }
    " style="box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); border-radius: 0.5rem;" class="master">
        <div class="bottom" style="display: flex; align-items: center; padding: 8px; justify-content: space-between">
            <div style="display: flex; gap: 0.5rem;">
                <x-filament::button x-on:click="sketchpad.undo()" color="gray">Undo</x-filament::button>
                <x-filament::button x-on:click="sketchpad.redo()" color="gray">Redo</x-filament::button>
            </div>
            <x-filament::button x-on:click="
                const url = document.getElementById('sketchpad').toDataURL();
                window.open(url, '_blank')
            ">Download</x-filament::button>
        </div>
        <canvas style="cursor: crosshair;" id="sketchpad">
        </canvas>
        <div class="top" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px 8px 8px">
            <input type="color" x-model="color">
            <input type="range" min="1" max="50" class="slider" x-model="penSize">
        </div>
    </div>

    <style>
        .master {
            border: #e5e7eb solid 1px;
        }

        .top {
            border-top: #e5e7eb solid 1px;
        }

        .bottom {
            border-bottom: #e5e7eb solid 1px;
        }

        :is(.dark) .top {
            border-top: hsla(0,0%,100%,.2) solid 1px !important;
        }

        :is(.dark) .bottom {
            border-bottom: hsla(0,0%,100%,.2) solid 1px !important;
        }

        :is(.dark) .master {
            border: hsla(0,0%,100%,.2) solid 1px !important;
        }

        :is(.dark) canvas {
            background-color: white;
        }

        canvas {
            background-color: white;
        }
    </style>
</x-dynamic-component>

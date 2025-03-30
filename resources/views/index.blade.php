<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php $uniqid = uniqid() @endphp
    @if($getMinimal())
        @include('filament-sketchpad::components.minimal', ['uniqid' => $uniqid])
    @else
        @include('filament-sketchpad::components.default', ['uniqid' => $uniqid])
    @endif
</x-dynamic-component>

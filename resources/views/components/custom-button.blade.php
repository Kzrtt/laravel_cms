<button class="p-2 rounded-lg bg-{{ $color }}-200/55 hover:cursor-pointer text-{{ $color }}-600 hover:text-white hover:bg-{{ $color }}-500 hover:shadow-sm"
    @if ($clickType == 'wire')
        :wire:click=" {{ $click }} "
    @else
        @click="{{ $click }}"
    @endif
>
    <i class="{{ $icon }} p-1"></i>
    &nbsp;<span class="font-semibold">{{ $text }}</span>&nbsp;
</button>
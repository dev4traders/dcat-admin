<span class="cp-table-cell {{ $class }}">
    @if( !is_null($icon) && $prepend )
        <span class="{{ $icon }} cp-table-cell__icon cp-table-cell__icon"></span>
    @endif
    <span class="cp-table-cell__text">
        {{ $label }}
    </span>
    @if( !is_null($icon) && !$prepend )
        <span class="{{ $icon }} cp-table-cell__icon cp-table-cell__icon_post"></span>
    @endif
</span>

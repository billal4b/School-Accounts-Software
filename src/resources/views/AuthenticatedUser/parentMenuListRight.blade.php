@if(Auth::check())
<div class="list-group">
    @if(session()->has('parentMenuList'))

    <?php
    $parentMenuListRight = session('parentMenuList');
    ?>

    @for ($i = 0; $i < count($parentMenuListRight); $i++)

    @if($parentMenuListRight[$i]->position_right == 1 && $parentMenuListRight[$i]->position_left == 0)
    <a href="{{ url('AuthenticatedUser') . '/' . $parentMenuListRight[$i]->url }}" class="list-group-item"><i class="fa fa-{{ $parentMenuListRight[$i]->icon }}"></i>&nbsp;{{ $parentMenuListRight[$i]->menu_name }}&nbsp;{!! $parentMenuListRight[$i]->has_child > 0 ? '&nbsp;<i class="fa fa-chevron-left"></i>' : '' !!}</a>
    @endif
    @endfor

    @endif
</div>
@endif
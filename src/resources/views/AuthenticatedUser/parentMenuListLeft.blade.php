@if(Auth::check())
<div class="list-group">
    @if(session()->has('parentMenuList'))

    <?php
    $parentMenuListLeft = session('parentMenuList');
    ?>

    @for ($i = 0; $i < count($parentMenuListLeft); $i++)

    @if($parentMenuListLeft[$i]->position_left == 1 && $parentMenuListLeft[$i]->position_right == 0)
    <a href="{{ url('AuthenticatedUser') . '/' . $parentMenuListLeft[$i]->url }}" class="list-group-item"><i class="fa fa-{{ $parentMenuListLeft[$i]->icon }}"></i>&nbsp;{{ $parentMenuListLeft[$i]->menu_name }}&nbsp;{!! $parentMenuListLeft[$i]->has_child > 0 ? '&nbsp;<i class="fa fa-chevron-right"></i>' : '' !!}</a>
    @endif
    @endfor

    @endif
</div>
@endif
<?php
//echo '<pre>';print_r($data);echo '</pre>';exit();
?>

@extends('layouts.app')

@section('main_content')

<div class="row">

    @if(isset($data['childMenuList']))

    <?php $totalRow = count($data['childMenuList']) ?>

    @for($i = 1; $i <= $totalRow; $i++)


    @if($i << 1)
    <div class="col-sm-6">
        <a class="btn btn-default btn-sm btn-block" href="{{ $data['childMenuList'][$i - 1]->url }}"><i class="fa fa-{{ $data['childMenuList'][$i - 1]->icon }}"></i>&nbsp;{{ $data['childMenuList'][$i - 1]->menu_name }}</a>
    </div>
    @endif



    @if(!($i << 1))
    <div class="col-sm-6">
        <a class="btn btn-default btn-sm btn-block" href="{{ $data['childMenuList'][$i - 1]->url }}"><i class="fa fa-{{ $data['childMenuList'][$i - 1]->icon }}"></i>&nbsp;{{ $data['childMenuList'][$i - 1]->menu_name }}</a>
    </div>
    @endif


    @endfor

    @endif
</div>
@endsection

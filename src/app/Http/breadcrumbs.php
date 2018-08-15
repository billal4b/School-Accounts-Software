<?php

Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('<i class="glyphicon glyphicon-home"></i>', route('home::onlineInfo'));
});

Breadcrumbs::register('custom', function($breadcrumbs, $brdcrmb) {
    $breadcrumbs->parent('home');

    foreach ($brdcrmb as $b) {
        $breadcrumbs->push($b[0]['title'], $b[0]['url']);
    }
});
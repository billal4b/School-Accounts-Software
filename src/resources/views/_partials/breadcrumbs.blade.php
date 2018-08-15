@if ($breadcrumbs)
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <div class="btn-group btn-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
            <a href="{{ $breadcrumb->url }}" class="btn btn-default">{!! $breadcrumb->title !!}</a>
            @endforeach
        </div>
    </div>
</div>
@endif
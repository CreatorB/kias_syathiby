@props(['title', 'parent' => null, 'parentLink' => '#', 'current' => null])

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">{{ $title }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        @if($parent)
                            <li class="breadcrumb-item">
                                <a href="{{ $parentLink }}">{{ $parent }}</a>
                            </li>
                        @endif
                        @if($current)
                            <li class="breadcrumb-item active">{{ $current }}</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

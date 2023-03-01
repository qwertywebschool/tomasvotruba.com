@php
    use TomasVotruba\Website\Enum\RouteName;

    /** type declarations */
    /** @var $post \TomasVotruba\Website\Entity\Post */
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title }} | Tomas Votruba</title>
    <meta charset="utf-8">
    <meta name="robots" content="index, follow">

    {{-- mobile --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    {{--  social tags based on https://www.phpied.com/minimum-viable-sharing-meta-tags/ --}}
    <meta name="description" property="og:description" content="{{ $post->getPerex() }}"/>

    <meta property="og:title" content="{{ $post->getClearTitle() }}"/>
    <meta property="og:description" content="{{ $post->getPerex() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{{ route(RouteName::POST_IMAGE, ['title' => $post->getClearTitle()]) }}"/>

    <meta
        property="og:url"
        content="{{ route(RouteName::POST_DETAIL, ['slug' => $post->getSlug()]) }}"
    />

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="votrubaT"/>
    <meta name="twitter:creator" content="votrubaT"/>
    <meta name="twitter:title" content="{{ $post->getClearTitle() }}"/>
    <meta name="twitter:image" content="{{ route(RouteName::POST_IMAGE, ['title' => $post->getClearTitle()]) }}"/>
    <meta name="twitter:description" content="{{ $post->getPerex() }}"/>

    <link rel="alternate" type="application/rss+xml" title="Tomas Votruba Blog RSS"  href="{{ route(RouteName::RSS) }}">

    {{-- next attempts https://stackoverflow.com/a/64439406/1348344 --}}
    <link rel="stylesheet" rel="preload" as="style"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700&amp;display=swap"/>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body>
<!-- post_id: {{ $post->getId() }} -->
@include('_snippets.menu')

<div class="container-fluid post" id="content">
    <h1>{!! $post->getTitle() !!}</h1>

    <time datetime="{{ $post->getDateTime()->format('Y-m-D') }}" class="text-muted">
        {{ $post->getDateTime()->format('Y-m-d') }}
    </time>

    @if ($post->getUpdatedAt())
        <div class="card border-success mt-4">
            <div class="card-header text-white bg-success">
                This post was updated at {{ $post->getUpdatedAt()->format("F Y") }} with fresh know-how.
                <br>
                <strong>What is new?</strong>
            </div>
            @if ($post->getUpdatedMessage())
                <div class="card-body pb-2">
                    <x-markdown>
                        {{ $post->getUpdatedMessage() }}
                    </x-markdown>
                </div>
            @endif
        </div>

        <br>
    @endif

    <div class="card card-bigger mb-5">
        <div class="card-body pb-2">
            <x-markdown>
                {{ $post->getPerex() }}
            </x-markdown>
        </div>
    </div>

    {!! $post->getHtmlContent() !!}

    <br>

    <br>
    <br>

    <a name="comments"></a>

    @include('_snippets.disqus_comments')
</div>

<script id="dsq-count-scr" src="https://itsworthsharing/disqus.com/count.js" async defer></script>

<link href="{{ asset('assets/prism/prism.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/prism/prism.js') }}"></script>

@include('_snippets.google_analytics')
</body>
</html>

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

        {{-- socials --}}
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:creator" content="@votrubaT"/>

        <meta property="og:image" content="{{ asset('assets/images/tomas_votruba.jpg') }}"/>
        <meta name="twitter:image" content="{{ asset('assets/images/tomas_votruba.jpg') }}"/>

        <link rel="alternate" type="application/rss+xml" title="Tomas Votruba Blog RSS" href="{{ route(\TomasVotruba\Website\Enum\RouteName::RSS) }}">

        {{-- !!! Twitter Bootstrap - keep the local copy css classes autocomplete --}}
        {{-- to speed-up delivery https://stackoverflow.com/a/46142270/1348344 --}}

        {{-- next attempts https://stackoverflow.com/a/64439406/1348344 --}}
        <link rel="stylesheet" rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700&amp;display=swap" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" media="print" onload="this.media='all'">

        {{-- this is the last, so prism can be overriden here --}}
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        @include('_snippets/menu')

        <div class="container-fluid">
            <div id="content">
                @yield('content')
            </div>
        </div>

        @section('custom_footer')
        @endsection

        @include('_snippets/google_analytics')
    </body>
</html>

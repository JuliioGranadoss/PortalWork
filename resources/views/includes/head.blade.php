<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Gestin de informes de Tamisur Clima">
<meta name="author" content="Logic Sistemas">
<meta name="robots" content="noindex">
<meta name="csrf-token" content="{{ csrf_token() }}" />
            @php
                $logo = App\Models\Config::where('key','company_favicon')->first()->value ?? null;
                $url = App\Models\File::where('id', $logo)->first()->source ?? null;
            @endphp
            @if ($url)
                <link rel="icon" href="{{$url}}">
            @endif

<title>
    @section('title')
    | {{ config('app.name', 'Laravel') }}
    @show
</title>

<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- Custom styles for this template -->
<link rel="stylesheet" href="{{ url('/dynamic-styles') }}">

@section('head_css')@show

@vite([
    'resources/icons/fontawesome-free/css/all.min.css',
    'resources/sass/app.scss',
    'resources/css/app.css',
    'resources/css/custom-theme.css'
])

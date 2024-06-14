@php
    use App\Models\Config;
@endphp

<div class="container my-auto">
    <div class="copyright text-center my-auto">
        <span>
            Copyright &copy; {{date('Y')}} {{Config::where('key', 'company_name')->first()->value ?? null}}, 
            CIF: {{Config::where('key', 'company_cif')->first()->value ?? null}}
            {{Config::where('key', 'company_app')->first() ? (' | APP: ' . Config::where('key', 'company_app')->first()->value) : null}}

        </span>
    </div>
</div>


<!-- Javascript -->
@vite([
    'resources/js/app.js'
])
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

@section('scripts')@show
@livewireScripts
@stack('scripts_calendar')

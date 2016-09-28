@if (session('success'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-success {{-- alert-dismissible --}}">
            {{-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> --}}
            {{ session('success') }}
            @if (session()->has('link'))
                <a href="{{ session()->get('link') }}" target="__blank" class="alert-link">Imprimir</a>
            @endif
        </div>
    </div>
</div>
@endif

@if (session('info'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-info {{-- alert-dismissible --}}">
            {{-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> --}}
            {{ session('info') }}
            @if (session()->has('link'))
                <a href="{{ session()->get('link') }}" target="__blank" class="alert-link">Imprimir</a>
            @endif
        </div>
    </div>
</div>
@endif

@if (session('warning'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-warning {{-- alert-dismissible --}}">
            {{-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> --}}
            {{ session('warning') }}
            @if (session()->has('link'))
                <a href="{{ session()->get('link') }}" target="__blank" class="alert-link">Imprimir</a>
            @endif
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger {{-- alert-dismissible --}}">
            {{-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> --}}
            {{ session('error') }}
            @if (session()->has('link'))
                <a href="{{ session()->get('link') }}" target="__blank" class="alert-link">Imprimir</a>
            @endif
        </div>
    </div>
</div>
@endif

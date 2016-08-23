@if (session('success'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if (session('info'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('info') }}
        </div>
    </div>
</div>
@endif

@if (session('warning'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('warning') }}
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

@if (Session::has('success'))

    <div class="pt-3">
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    </div>
    
@endif

@if ($errors->has('message'))

    <div class="pt-3">
        <div class="alert alert-danger">
            {{ $errors->first('message') }}
        </div>
    </div>
    
@endif
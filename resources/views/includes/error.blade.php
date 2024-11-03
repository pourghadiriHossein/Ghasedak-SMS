@if ($errors->all())
    <div class="page-header">
        <div class="col-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show text-right mb-1" role="alert">
                    <span class="alert-inner--text">{{ $error }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('activities.index') }}">
            <i class="fa fa-boxes fa-fw"></i> {{ env('APP_NAME', 'CPanels') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form method="POST" action="{{ route('search.post') }}" class="d-flex w-100">
                @csrf
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search <i class="fas fa-search fa-fw"></i></button>
            </form>
        </div>
    </div>
</nav>

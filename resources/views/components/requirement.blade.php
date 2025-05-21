<div>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $pageName }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                @php
                    $user = Auth::user();
                @endphp
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <h7>{{ $user->name }}</h7>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                {{ $slot }}
            </div>
        </div>
    </section>
</div>

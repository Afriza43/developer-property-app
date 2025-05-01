<x-body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">Rumah</a></li>
                </ul>

                <div class="text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32"
                            class="rounded-circle">
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Daftar Perumahan {{ $project->project_name }}</h1>
                    <h2 class="fw-light">PT. AJISAKA</h2>
                </div>
            </div>
        </section>
        <section>
            <div class="container mx-3 mb-3">
                <a href="{{ route('houses.create', ['project_id' => $project->project_id]) }}"><button type="button"
                        class="btn btn-primary col-md-2">Tambah
                        Rumah</button></a>
                <a href="{{ route('projects.index') }}"><button type="button"
                        class="btn btn-danger col-md-2">Kembali</button></a>
            </div>
            <div class="card p-3 mx-4">
                <h5>Tampilkan Berdasarkan :</h5>
                <div class="row">
                    <div class="col-md-8">
                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                            <label for="search" class="mx-1 mb-2">Nama Rumah : </label>
                            <input type="search" class="form-control" placeholder="Cari Rumah" aria-label="Search">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="mx-1 mb-2">Blok : </label>
                        <select class="form-select" placeholder="Cari Blok">
                            <option selected>Pilih Blok</option>
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">C</option>
                        </select>
                    </div>
                </div>
        </section>
        <section>
            <div class="album py-5 bg-body-tertiary">
                <div class="container mx-3 mb-3">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        @foreach ($houses as $house)
                            <div class="col">
                                <div class="card shadow-sm">
                                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                                        xmlns="http://www.w3.org/2000/svg" role="img"
                                        aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                                        focusable="false">
                                        <title>Placeholder</title>
                                        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%"
                                            fill="#eceeef" dy=".3em">Thumbnail</text>
                                    </svg>
                                    <div class="card-body">
                                        <h4 class="text-center">{{ $house->name }}</h4>
                                        <p class="card-text">Tipe : {{ $house->type }}</p>
                                        <p class="card-text">Blok : {{ $house->block_number }}</p>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="btn-group">
                                                {{-- <a href="{{ route('expense-list', ['house_id' => $house->house_id]) }}"> --}}
                                                <a href="{{ route('rab.index', ['house_id' => $house->house_id]) }}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary btn-primary text-light">RAB
                                                    </button>
                                                </a>
                                                <a
                                                    href="{{ route('expenses.index', ['house_id' => $house->house_id]) }}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary btn-primary text-light">Lihat
                                                    </button>
                                                </a>
                                                <a href="{{ route('houses.edit', $house->house_id) }}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary btn-success text-light">Edit
                                                    </button></a>
                                                <form action="{{ route('houses.destroy', $house->house_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" name="submit"
                                                        class="btn btn-sm btn-outline-secondary text-light btn-danger">Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        </section>
    </main>
</x-body>

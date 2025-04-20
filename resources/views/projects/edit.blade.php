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
                    <li><a href="#" class="nav-link px-2 link-secondary">Proyek</a></li>
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
                    <h1 class="fw-light">Pengadaan Proyek</h1>
                    <h2 class="fw-light">PT. AJISAKA</h2>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="card p-3">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="container">
                                <h3>Halo</h3>
                            </div>
                        </div>
                        <div class="col col-md-8">
                            <div class="container">
                                <form action="{{ route('projects.update', $project->project_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="project_name" class="form-label">Nama Proyek</label>
                                        <input type="text" class="form-control" id="project_name"
                                            placeholder="Nama Proyek" name="project_name"
                                            value="{{ $project->project_name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" id="location" name="location"
                                            placeholder="Lokasi" value="{{ $project->location }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="year" name="year"
                                            placeholder="Tahun" value="{{ $project->year }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="description" value="{{ $project->description }}" name="description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        {{-- <label for="image">Upload Gambar</label> --}}
                                        <input value="{{ $project->image }}" type="hidden" name="image"
                                            class="form-control" id="image" @error('image')is-invalid @enderror>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <input type="hidden" class="form-control" id="total_cost" value=""
                                        name="total_cost">
                                    <button type="submit" name="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </main>
</x-body>

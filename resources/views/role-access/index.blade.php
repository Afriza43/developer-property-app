<x-layout-house title="Pengelola Perumahan">
    <div class="page-heading">
        <h2>Perumahan </h2>
        <h6 class="text-muted"></h6>
    </div>
    <div class="page-content">
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Buat Akun Pengelola</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical"action="{{ route('role-access.store') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <input type="hidden" name="project_id" value="{{ request('project_id') }}">
                                            <div class="form-group has-icon-left">
                                                <label for="name">Nama</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Nama.."
                                                        id="name" name="name" value="{{ old('name') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                                @error('name')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="username">Username</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Username.."
                                                        name="username" id="username" value="{{ old('username') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                                @error('username')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="password">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" placeholder="Password.."
                                                        id="password" name="password" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success me-1 mb-1">
                                                Buat
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <h3 class="card-title col">
                            Pengelola Perumahan
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($roleAccess as $user)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->username }}</td>
                                        <td class="text-center">
                                            @foreach ($user->roles as $role)
                                                {{ $role->name }}
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('role-access.destroy', $user->user_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onsubmit="return confirm('Apakah anda yakin menghapus data ini?')"
                                                    class="btn btn-danger">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <a href="{{ route('projects.index') }}">
                            <button type="submit" class="btn btn-secondary">Kembali</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

</x-layout-house>

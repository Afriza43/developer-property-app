<x-layout-2 title="Laporan Pengeluaran Pembangunan">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Pengeluaran Pembangunan Rumah</h3>
                    <p class="text-subtitle text-muted">{{ $house->name }}</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="text-center bg-primary rounded px-3 py-2 border border-primary">
                                <span class="text-white">Total Pengeluaran</span>
                                <br>
                                <span class="fw-bold fs-5 text-white">Rp
                                    {{ number_format($totalExpenses, 0, ',', '.') }}</span>
                            </div>
                            <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                data-bs-target="#addExpenseModal">
                                <i class="bi bi-plus-lg"></i> Tambah Laporan
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- table bordered -->
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 text-center" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Keterangan Pengeluaran</th>
                                            <th class="text-center">Pengeluaran</th>
                                            <th class="text-center">Tanggal Pembelian</th>
                                            <th class="text-center">Lihat Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td class="text-bold-500">{{ $expense->description }}</td>
                                                <td>Rp {{ number_format($expense->total_expense, 0, ',', '.') }}</td>
                                                <td>{{ $expense->purchase_date }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#previewImage-{{ $expense->expense_id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- Modal Preview Gambar --}}
                                            <div class="modal fade" id="previewImage-{{ $expense->expense_id }}"
                                                tabindex="-1"
                                                aria-labelledby="previewImage-{{ $expense->expense_id }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="previewImage-{{ $expense->expense_id }}Label">
                                                                Bukti Pengeluaran</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $expense->evidence) }}"
                                                                class="img-fluid" alt="Pratinjau Gambar">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-2 mb-3">
                                <a href="{{ route('houses.index', ['project_id' => $house->project->project_id]) }}"
                                    class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Form Tambah Pengeluaran -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Laporan Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="house_id" value="{{ $house->house_id }}">
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" name="description" required maxlength="50"
                                placeholder="Keterangan..">
                        </div>
                        <div class="mb-3">
                            <label for="total_expense" class="form-label">Pengeluaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="uang-format" step="0.01" required
                                    placeholder="0">
                                <input type="hidden" name="total_expense" id="uang-asli">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Pembelian</label>
                            <input type="date" placeholder="Tanggal.." class="form-control" name="purchase_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label>Upload Bukti</label>
                            <input type="file" id="evidence"
                                class="form-control @error('evidence') is-invalid @enderror" name="evidence"
                                accept=".jpg,.jpeg,.png" required>
                            @error('evidence')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            onsubmit="return confirm('Data tersimpan permanen, apakah anda yakin?')"
                            class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                theme: 'auto',
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                theme: 'auto'
            });
        </script>
    @endif

    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/jquery/jquery.mask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#uang-format').mask('000.000.000', {
                reverse: true
            });

            $('form').on('submit', function() {
                let uangFormatted = $('#uang-format').val();
                let uangAsli = uangFormatted.replace(/\./g, '');
                $('#uang-asli').val(uangAsli);
            });
        });
    </script>

</x-layout-2>

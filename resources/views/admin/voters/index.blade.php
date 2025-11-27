@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Data Pemilih (DPT)</h3>
            <p class="text-muted small mb-0">Total: {{ $voters->total() }} Mahasiswa Terdaftar</p>
        </div>

        <button type="button" class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-file-excel me-2"></i> Import Excel
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Nama Lengkap</th>
                            <th>Email / NIM</th>
                            <th>Status Voting</th>
                            <th>Bergabung</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($voters as $voter)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $voter->name }}</td>
                            <td class="text-primary">{{ $voter->email }}</td>
                            <td>
                                @if($voter->is_voted)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Sudah Memilih</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Belum Memilih</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $voter->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('voters.destroy', $voter->id) }}" method="POST" onsubmit="return confirm('Hapus pemilih ini?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm text-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data pemilih. Silakan Import Excel.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $voters->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Import Data Pemilih</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('voters.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i> <strong>Format Excel Wajib:</strong>
                        <br>Kolom A (Header): <code>name</code>
                        <br>Kolom B (Header): <code>email</code>
                        <br>Password default user baru: <strong>12345678</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File Excel (.xlsx)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary fw-bold w-100">Upload & Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

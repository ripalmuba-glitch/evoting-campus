@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Data Pemilihan</h3>
        <a href="{{ route('elections.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i> Buat Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Nama Event</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Kandidat</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($elections as $election)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $election->title }}</div>
                                <div class="small text-muted">{{ Str::limit($election->description, 50) }}</div>
                            </td>
                            <td>
                                <div class="small">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i>
                                    {{ \Carbon\Carbon::parse($election->start_date)->format('d M Y') }}
                                </div>
                                <div class="small text-muted">s/d {{ \Carbon\Carbon::parse($election->end_date)->format('d M Y') }}</div>
                            </td>
                            <td>
                                @if($election->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Aktif</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 rounded-pill">Tutup</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('elections.candidates.index', $election->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold">
                                <i class="fas fa-users me-1"></i> {{ $election->candidates->count() }} Kandidat
                                </a>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('elections.edit', $election->id) }}" class="btn btn-sm btn-light text-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('elections.destroy', $election->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pemilihan ini? Data suara juga akan terhapus!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/no-data-found-8867280-7265556.png" width="200" alt="Kosong">
                                <p class="text-muted mt-3">Belum ada acara pemilihan dibuat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $elections->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

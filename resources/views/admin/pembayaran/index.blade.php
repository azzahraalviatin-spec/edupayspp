    @extends('layouts.admin')
    @section('title', 'Metode Pembayaran')
    @section('content')

    <div class="container-fluid px-4">
        {{-- Notifikasi Sukses / Gagal --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2.5 px-3 small d-flex align-items-center mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto shadow-none small" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px;"></button>
        </div>
        @endif

        {{-- Header Tabel & Tombol Tambah --}}
        <div class="card border-0 shadow-sm mb-4" style="background: #1e293b; border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="fw-bold text-white m-0 d-flex align-items-center" style="font-size: 16px;">
                    <span class="p-2 bg-info bg-opacity-10 rounded-3 me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="bi bi-wallet2 text-info"></i>
                    </span>
                    Pengaturan Metode Pembayaran
                </h5>
                <a href="{{ route('admin.pembayaran.create') }}" class="btn btn-primary btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center shadow-sm" style="border-radius: 8px;">
                    <i class="bi bi-plus-lg me-1.5"></i> Tambah Metode
                </a>
            </div>

            {{-- Tabel List Data Metode Pembayaran --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0" style="font-size: 13px; background: #1e293b;">
                        <thead>
                            <tr style="border-bottom: 2px solid #334155; background: #0f172a;">
                                <th class="text-center py-3 px-4" style="color: #94a3b8; font-weight: 600; width: 70px;">No</th>
                                <th class="py-3 px-4" style="color: #94a3b8; font-weight: 600;">Nama Metode Pembayaran</th>
                                <th class="py-3 px-4" style="color: #94a3b8; font-weight: 600;">Keterangan / No. Rekening</th>
                                <th class="text-center py-3 px-4" style="color: #94a3b8; font-weight: 600; width: 120px;">Status</th>
                                <th class="text-center py-3 px-4" style="color: #94a3b8; font-weight: 600; width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($metode as $m)
                            <tr style="border-bottom: 1px solid #334155;">
                           <td class="text-center text-white py-3 px-4 fw-bold">
    {{ $loop->iteration }}
</td>
                                <td class="text-white py-3 px-4 fw-bold">{{ $m->nama }}</td>
                                <td class="py-3 px-4">
                                    @if(empty($m->no_rekening))
                                    <span class="text-muted small">Transaksi tunai langsung / tanpa rekening</span>
                                    @else
                                    <div class="fw-semibold text-white" style="letter-spacing: 0.5px;">{{ $m->no_rekening }}</div>
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4">
                                    @if($m->is_aktif)
                                    <span class="badge rounded-pill px-2.5 py-1 text-success bg-transparent border border-success border-opacity-50" style="font-size: 10px;">Active</span>
                                    @else
                                    <span class="badge rounded-pill px-2.5 py-1 text-danger bg-transparent border border-danger border-opacity-50" style="font-size: 10px;">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Detail (Pindah ke Halaman Show) --}}
                                        <a href="{{ route('admin.pembayaran.show', $m->id) }}" class="btn btn-sm btn-info d-inline-flex align-items-center justify-content-center text-white" 
                                            style="border-radius: 6px; width: 30px; height: 30px;" title="Lihat Detail">
                                            <i class="bi bi-eye-fill" style="font-size: 13px;"></i>
                                        </a>

                                        {{-- Tombol Edit (Pindah ke Halaman Edit, Bukan Pop-up) --}}
                                        <a href="{{ route('admin.pembayaran.edit', $m->id) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center text-dark" 
                                            style="border-radius: 6px; width: 30px; height: 30px;" title="Edit Data">
                                            <i class="bi bi-pencil-square" style="font-size: 13px;"></i>
                                        </a>

                                        {{-- Tombol Hapus dengan Pop-up Peringatan Tegas --}}
                                      {{-- Tombol Hapus --}}
<button 
    type="button"
    class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center border-0"
    style="border-radius: 6px; width: 30px; height: 30px;"
    data-bs-toggle="modal"
    data-bs-target="#hapusModal{{ $m->id }}"
    title="Hapus">

    <i class="bi bi-trash3-fill" style="font-size: 13px;"></i>
</button>

{{-- Modal Hapus --}}
<div class="modal fade" id="hapusModal{{ $m->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg"
            style="background: #172036; border-radius: 18px; overflow: hidden;">

            <div class="modal-body text-center px-4 py-5">

                {{-- Icon --}}
                <div class="mx-auto mb-4 d-flex align-items-center justify-content-center"
                    style="
                        width: 90px;
                        height: 90px;
                        border-radius: 50%;
                        border: 5px solid #facc15;
                        color: #facc15;
                        font-size: 45px;
                    ">
                    !
                </div>

                {{-- Judul --}}
                <h2 class="fw-bold text-white mb-3">
                    Hapus metode pembayaran?
                </h2>

                {{-- Deskripsi --}}
                <p class="text-light mb-4" style="font-size: 16px; line-height: 1.6;">
                    Anda akan menghapus
                    <strong>"{{ $m->nama }}"</strong>.
                    Data metode pembayaran akan terhapus permanen.
                </p>

                {{-- Tombol --}}
                <div class="d-flex justify-content-center gap-3">

                    {{-- Form Hapus --}}
                    <form action="{{ route('admin.pembayaran.destroy', $m->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn fw-bold px-4 py-2 text-white border-0"
                            style="
                                background: #ef4444;
                                border-radius: 10px;
                            ">
                            Ya, Hapus!
                        </button>
                    </form>

                    {{-- Tombol Batal --}}
                    <button type="button"
                        class="btn fw-semibold px-4 py-2 text-white border-0"
                        data-bs-dismiss="modal"
                        style="
                            background: #64748b;
                            border-radius: 10px;
                        ">
                        Batal
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5" style="color: #64748b;">
                                    <div class="p-3 rounded-circle bg-opacity-10 bg-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-credit-card text-muted fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold m-0" style="color: #94a3b8;">Belum ada data metode pembayaran wee.</h6>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endsection
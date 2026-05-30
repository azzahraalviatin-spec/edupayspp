@extends('layouts.petugas')

@section('title', 'Detail Tunggakan')

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="text-white fw-bold mb-0">
            Detail Tunggakan
        </h3>

        <a href="{{ route('petugas.tunggakan') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-lg"
         style="background: #18243b; border-radius: 18px;">

        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Nama Siswa --}}
                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-1">
                            Nama Siswa
                        </small>

                        <h5 class="text-white mb-0">
                            {{ $tagihan->siswa->nama }}
                        </h5>

                    </div>
                </div>

                {{-- Kelas --}}
                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-1">
                            Kelas
                        </small>

                        <h5 class="text-white mb-0">
                            {{ $tagihan->siswa->kelas->tingkat ?? '-' }}
                            {{ strtoupper($tagihan->siswa->kelas->jurusan ?? '') }}
                            {{ $tagihan->siswa->kelas->nomor_kelas ?? '' }}
                        </h5>

                    </div>
                </div>

                {{-- Bulan --}}
                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-1">
                            Bulan Tagihan
                        </small>

                        <h5 class="text-white mb-0">
                            {{ $bulanList[$tagihan->bulan] }}
                        </h5>

                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-1">
                            Status Pembayaran
                        </small>

                        @if($tagihan->status == 'lunas')

                            <span class="badge bg-success px-3 py-2">
                                Lunas
                            </span>

                        @else

                            <span class="badge bg-danger px-3 py-2">
                                Belum Bayar
                            </span>

                        @endif

                    </div>
                </div>

                {{-- Nominal Awal --}}
                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-1">
                            Nominal Awal
                        </small>

                        <h5 class="text-white mb-0">
                            Rp {{ number_format($tagihan->nominal_awal,0,',','.') }}
                        </h5>

                    </div>
                </div>

                {{-- Potongan SPP --}}
                @if($tagihan->total_potongan > 0)

                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-2">
                            Potongan SPP
                        </small>

                        @foreach($tagihan->siswa->potonganSpps as $potongan)

                            <div class="mb-2">

                                <div class="text-warning fw-semibold">
                                    {{ $potongan->nama_potongan }}
                                </div>

                                <small class="text-light">
                                    Potongan:
                                    Rp {{ number_format($potongan->nominal_potongan,0,',','.') }}
                                </small>

                            </div>

                        @endforeach

                    </div>
                </div>

                @endif

                {{-- Total Bayar --}}
                <div class="col-md-6">
                    <div class="p-3 rounded"
                         style="background: #22304d;">

                        <small class="text-secondary d-block mb-1">
                            Total Bayar
                        </small>

                        <h4 class="text-info fw-bold mb-0">
                            Rp {{ number_format($tagihan->nominal_bayar,0,',','.') }}
                        </h4>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
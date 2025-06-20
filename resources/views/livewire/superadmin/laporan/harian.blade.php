<div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-chart-line mr-1"></i> {{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home mr-1"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-chart-line mr-1"></i> {{ $title }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Laporan Harian: {{ $currentDate }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="selectedDate" class="col-sm-2 col-form-label">Pilih Tanggal:</label>
                        <div class="col-sm-4">
                            <input wire:model.live="selectedDate" type="date" class="form-control" id="selectedDate">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Nilai Penjualan Harian</span>
                                    <span class="info-box-number">Rp {{ number_format($totalNilaiPenjualan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- Anda bisa tambahkan info box lain di sini jika ada total stok, dll --}}
                            {{-- Contoh: Total Produk Aktif --}}
                             <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jumlah Produk</span>
                                    <span class="info-box-number">{{ $stokProduk->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Stok Tersisa per Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Stok Tersisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stokProduk as $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td>
                                            <span class="badge badge-{{ $produk->stok <= 5 ? 'danger' : ($produk->stok <= 20 ? 'warning' : 'success') }}">
                                                {{ $produk->stok }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
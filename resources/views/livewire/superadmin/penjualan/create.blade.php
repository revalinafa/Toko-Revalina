<div wire:ignore.self class="modal fade" id="createPenjualanModal" tabindex="-1" role="dialog" aria-labelledby="createPenjualanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPenjualanModalLabel">
                   <i class="fas fa-plus mr-1"></i>
                   Tambah Penjualan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store">
                    <div class="form-group">
                        <label for="produk_id">Produk <span class="text-danger">*</span></label>
                        <select wire:model="produk_id" class="form-control @error('produk_id') is-invalid @enderror">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                            @endforeach
                        </select>
                        @error('produk_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input wire:model="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" placeholder="Masukkan jumlah penjualan">
                        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                        <input wire:model="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror">
                        @error('tanggal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
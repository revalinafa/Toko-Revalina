<div wire:ignore.self class="modal fade" id="editStokLogModal" tabindex="-1" role="dialog" aria-labelledby="editStokLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStokLogModalLabel">
                   <i class="fas fa-edit mr-1"></i>
                   Edit Stok Log
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update">
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
                        <label for="jenis">Jenis Stok <span class="text-danger">*</span></label>
                        <select wire:model="jenis" class="form-control @error('jenis') is-invalid @enderror">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach ($jenisOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('jenis') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input wire:model="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" placeholder="Masukkan jumlah stok">
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
                        <button type="submit" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
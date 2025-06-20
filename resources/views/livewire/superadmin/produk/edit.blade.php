<div wire:ignore.self class="modal fade" id="editProdukModal" tabindex="-1" role="dialog" aria-labelledby="editProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdukModalLabel">
                   <i class="fas fa-edit mr-1"></i>
                   Edit Produk
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update({{ $produk_id }})"> {{-- Menggunakan wire:submit.prevent --}}
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk <span class="text-danger">*</span></label>
                        <input wire:model="nama_produk" type="text" class="form-control @error('nama_produk') is-invalid @enderror" placeholder="Masukkan nama produk">
                        @error('nama_produk') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga">Harga <span class="text-danger">*</span></label>
                        <input wire:model="harga" type="number" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan harga">
                        @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="stok">Stok <span class="text-danger">*</span></label>
                        <input wire:model="stok" type="number" class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan stok">
                        @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="kategori_id">Kategori <span class="text-danger">*</span></label>
                        <select wire:model="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                        <select wire:model="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <small class="text-danger">{{ $message }}</small> @enderror
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
<div wire:ignore.self class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">
                   <i class="fas fa-edit mr-1"></i>
                   Edit Supplier
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update"> {{-- ID sudah ada di $this->supplier_id --}}
                    <div class="form-group">
                        <label for="nama_supplier">Nama Supplier <span class="text-danger">*</span></label>
                        <input wire:model="nama_supplier" type="text" class="form-control @error('nama_supplier') is-invalid @enderror" placeholder="Masukkan nama supplier">
                        @error('nama_supplier') <small class="text-danger">{{ $message }}</small> @enderror
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
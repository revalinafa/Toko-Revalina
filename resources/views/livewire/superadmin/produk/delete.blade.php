<div wire:ignore.self class="modal fade" id="deleteProdukModal" tabindex="-1" role="dialog" aria-labelledby="deleteProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProdukModalLabel">
                    <i class="fas fa-trash-alt mr-1"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                {{-- Tombol konfirmasi hapus akan memanggil metode destroy() di Livewire component --}}
                <button type="button" wire:click="destroy" class="btn btn-danger">Ya, Hapus!</button>
            </div>
        </div>
    </div>
</div>
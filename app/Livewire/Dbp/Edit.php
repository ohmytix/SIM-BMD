<?php

namespace App\Livewire\Dbp;

use Livewire\Component;
use App\Models\AsetUtama;
use App\Models\KodeBarang;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Edit extends Component
{
    public $id_data; // Untuk menyimpan ID aset yang sedang diedit

    // Properti Form
    public $kode_barang; // String kode (misal: 1.1.1...)
    public $sub_sub_rincan_objek;
    public $spesifikasi;
    public $spesifikasi_lainnya;
    public $dokumen;
    public $cara_perolehan;
    public $tanggal_perolehan;
    public $ukuran_barang;
    public $satuan_barang;
    public $kondisi_barang;

    public function mount($id)
    {
        // 1. Ambil Data berdasarkan ID
        $aset = AsetUtama::with('kodeBarang')->findOrFail($id);

        // 2. Isi Properti Form dengan Data Lama
        $this->id_data = $aset->id;
        $this->kode_barang = $aset->kodeBarang->kode ?? ''; // Ambil kode string dari relasi
        $this->sub_sub_rincan_objek = $aset->sub_sub_rincan_objek;
        $this->spesifikasi = $aset->spesifikasi;
        $this->spesifikasi_lainnya = $aset->spesifikasi_lainnya;
        $this->dokumen = $aset->dokumen;
        $this->cara_perolehan = $aset->cara_perolehan;
        $this->tanggal_perolehan = $aset->tanggal_perolehan;
        $this->ukuran_barang = $aset->ukuran_barang;
        $this->satuan_barang = $aset->satuan_barang;
        $this->kondisi_barang = $aset->kondisi_barang;
    }

    public function update()
    {
        if (! session()->has('active_skpd_id')) {
        $this->dispatch('swal:modal', [
            'type' => 'warning', 
            'title' => 'SKPD Belum Dipilih!',
            'text'  => 'Sesi SKPD Anda telah berakhir. Silakan pilih SKPD ulang.',
        ]);
        return;
    }
        // 1. Validasi
        $this->validate([
            'kode_barang' => 'required|exists:kode_barangs,kode',
            'sub_sub_rincan_objek' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'tanggal_perolehan' => 'nullable|date',
            // ... tambahkan validasi lain sesuai kebutuhan ...
        ]);

        // 2. Cari ID Kode Barang Baru (jika user mengubah kode)
        $refKodeBarang = KodeBarang::where('kode', $this->kode_barang)->first();

        // 3. Update Data
        $aset = AsetUtama::find($this->id_data);
        
        $aset->update([
            'kode_barang_id' => $refKodeBarang->id,
            'sub_sub_rincan_objek' => $this->sub_sub_rincan_objek,
            'spesifikasi' => $this->spesifikasi,
            'spesifikasi_lainnya' => $this->spesifikasi_lainnya,
            'dokumen' => $this->dokumen,
            'cara_perolehan' => $this->cara_perolehan,
            'tanggal_perolehan' => $this->tanggal_perolehan,
            'ukuran_barang' => $this->ukuran_barang,
            'satuan_barang' => $this->satuan_barang,
            'kondisi_barang' => $this->kondisi_barang,
        ]);

        // 4. Redirect
        session()->flash('success', 'Data Aset berhasil diperbarui.');
        return $this->redirect(route('AsetUtama.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.dbp.edit', [
            'kodeBarangs' => KodeBarang::all()
        ]);
    }
}
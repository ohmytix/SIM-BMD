<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Livewire\MutasiPersediaan\Index as MutasiIndex;
use App\Livewire\MutasiPersediaan\Create as MutasiCreate;
use App\Livewire\MutasiPersediaan\Edit as MutasiEdit; 
use App\Livewire\Dbp\Index as DbpIndex;
use App\Livewire\Dbp\Detail as DbpDetail;
use App\Livewire\Dbp\Create as DbpCreate;
use App\Livewire\Dbp\Edit as DbpEdit;
use App\Livewire\Dbp\Penyusutan\PenambahanCreate as PenyusutanPenambahanCreate;
use App\Livewire\Dbp\Penyusutan\PenambahanEdit as PenyusutanPenambahanEdit;
use App\Livewire\Dbp\Penyusutan\PenguranganCreate as PenyusutanPenguranganCreate;
use App\Livewire\Dbp\Penyusutan\PenguranganEdit as PenyusutanPenguranganEdit;
use App\Livewire\Dbp\Perolehan\PenambahanCreate as PerolehanPenambahanCreate;
use App\Livewire\Dbp\Perolehan\PenambahanEdit as PerolehanPenambahanEdit;
use App\Livewire\Dbp\Perolehan\PenguranganCreate as PerolehanPenguranganCreate;
use App\Livewire\Dbp\Perolehan\PenguranganEdit as PerolehanPenguranganEdit; 
use App\Livewire\KodeBarang\Index as KodeBarangIndex;
use App\Livewire\KodeBarang\Create as KodeBarangCreate;
use App\Livewire\KodeBarang\Edit as KodeBarangEdit;
use App\Livewire\PbBmd\BeritaAcara;
use App\Livewire\PbPbp\BeritaRekonsiliasi;
use App\Livewire\Aset\AsetRekonsiliasi;
use App\Livewire\Rekap\Index as RekapIndex;
use App\Livewire\MutasiAset\Index as MutasiAsetIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\User\Index as UserIndex;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Hash;

Route::get('/dashboard', Dashboard::class)->name('Dashboard.index');

Route::get('/bmd', function () {
    return view('pb_bmd.index');
});
Route::get('/pbp', function () {
    return view('pb_pbp.index');
});
Route::get('home', function () {
    return view("layout.index");
});
Route::get('/mutasi-persediaan', MutasiIndex::class)->name('MutasiPersediaan.index');
Route::get('/mutasi-persediaan/create', MutasiCreate::class)->name('MutasiPersediaan.create');
Route::get('/mutasi-persediaan/{id}/edit', MutasiEdit::class)->name('MutasiPersediaan.edit');
Route::get('dbp', DbpIndex::class)->name('AsetUtama.index');
Route::get('/dbp/detail', DbpDetail::class)->name('AsetUtama.detail');
Route::get('/dbp/create', DbpCreate::class)->name('AsetUtama.create');
Route::get('/dbp/{id}/edit', DbpEdit::class)->name('AsetUtama.edit');
Route::get('/dbp/penyusutan-penambahan/create/{aset_utama_id}', PenyusutanPenambahanCreate::class)
    ->name('PenyusutanPenambahan.create');
Route::get('/dbp/penyusutan-penambahan/{id}/edit', PenyusutanPenambahanEdit::class)
    ->name('PenyusutanPenambahan.edit');
Route::get('/dbp/penyusutan-pengurangan/create/{aset_utama_id}', PenyusutanPenguranganCreate::class)
    ->name('PenyusutanPengurangan.create');
Route::get('/dbp/penyusutan-pengurangan/{id}/edit', PenyusutanPenguranganEdit::class)
    ->name('PenyusutanPengurangan.edit');
Route::get('/dbp/perolehan-penambahan/create/{aset_utama_id}', PerolehanPenambahanCreate::class)
    ->name('PerolehanPenambahan.create');
Route::get('/dbp/perolehan-penambahan/{id}/edit', PerolehanPenambahanEdit::class)
    ->name('PerolehanPenambahan.edit');
Route::get('/dbp/perolehan-pengurangan/create/{aset_utama_id}', PerolehanPenguranganCreate::class)
    ->name('PerolehanPengurangan.create');
Route::get('/dbp/perolehan-pengurangan/{id}/edit', PerolehanPenguranganEdit::class)
    ->name('PerolehanPengurangan.edit');
Route::get('/kode-barang', KodeBarangIndex::class)->name('KodeBarang.index');
Route::get('/kode-barang/create', KodeBarangCreate::class)->name('KodeBarang.create');
Route::get('/kode-barang/{id}/edit', KodeBarangEdit::class)->name('KodeBarang.edit');
Route::post('/ganti-skpd', function (Request $request) {

    $user = auth()->user();

    // Operator tidak boleh ganti SKPD
    if ($user->role === 'operator_skpd') {

        session([
            'active_skpd_id' => $user->skpd_id
        ]);

        return back()->with(
            'error',
            'Operator tidak dapat mengganti SKPD'
        );
    }

    session([
        'active_skpd_id' => $request->skpd_id
    ]);

    return back();

})->name('ganti.skpd');

Route::get('/aset', AsetRekonsiliasi::class)->name('aset.index');
Route::get('/pb-bmd', BeritaAcara::class)->name('pb_bmd.index');
Route::get('/pb-pbp', BeritaRekonsiliasi::class)->name('pb_pbp.index');
Route::get('/rekap', RekapIndex::class)->name('Rekap.Index');
Route::get('/mutasi-aset', MutasiAsetIndex::class)->name('mutasi.Index');
Route::get('/', Login::class)->name('login');
Route::get('/profile', function () {
    return view('profile.index');
})->middleware('auth')->name('profile');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', UserIndex::class)->name('admin.users.index');
});
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');
Route::post('/profile/password', function (Request $request) {

    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'min:6', 'confirmed'],
    ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Password lama tidak sesuai.'
        ]);
    }

    $user->update([
        'password' => Hash::make($request->password)
    ]);

    return back()->with('success', 'Password berhasil diubah.');

})->middleware('auth')->name('profile.password.update');

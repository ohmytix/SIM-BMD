    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard PMD (Bootstrap)</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />

        <style>
            /* PENTING: Pastikan body dan html tidak overflow horizontal */
            html,
            body {
                overflow-x: hidden;
                width: 100%;
                max-width: 100vw;
            }

            /* CSS minimal HANYA untuk background gradient yang tidak ada di Bootstrap */
            .bg-card-1 {
                background: linear-gradient(135deg, #00BFFF, #1E90FF);
            }

            .bg-card-2 {
                background: linear-gradient(135deg, #25c6ff, #0f83c9);
            }

            .bg-card-3 {
                background: linear-gradient(135deg, #FFD700, #FFA500);
            }

            .bg-card-4 {
                background: linear-gradient(135deg, #32CD32, #2E8B57);
            }

            .bg-card-5 {
                background: #fab9b9;
                background: linear-gradient(90deg, rgba(250, 185, 185, 1) 0%, rgba(250, 191, 143, 1) 50%, rgba(250, 185, 185, 1) 100%);
            }

            /* Mengatur agar sidebar tidak menimpa konten di layar kecil */
            @media (max-width: 992px) {
                .main-content {
                    margin-left: 0 !important;
                }

                .sidebar {
                    display: none;
                }
            }

            div.dt-container {
                width: 800px;
                margin: 0 auto;
                margin-left: 0%;
            }

            /* KELAS BARU UNTUK SIDEBAR AKTIF */
            .sidebar-active {
                background-color: #e8e8e8;
                border-left: 3px solid #00bcd4;
            }

            .sidebar-active a span {
                font-weight: 600;
            }

            /* PERBAIKAN: Pastikan container utama tidak overflow */
            .main-container {
                width: 100vw;
                max-width: 100vw;
                overflow-x: hidden;
                box-sizing: border-box;
            }

            /* Pastikan flex container tidak melebihi viewport */
            .d-flex-main {
                max-width: 100vw;
                overflow-x: hidden;
            }
        </style>
    </head>

    <body class="bg-body-tertiary">
        @if (session('success'))
            <input type="hidden" id="flash-success" value="{{ session('success') }}">
        @endif
        @if (session('error'))
            <input type="hidden" id="flash-error" value="{{ session('error') }}">
        @endif
        @inject('skpdService', 'App\Models\Skpd')

        @inject('skpdService', 'App\Models\Skpd')

        {{-- <div class="bg-dark text-white p-2 mb-3">
            <div class="container d-flex justify-content-between align-items-center">
                <span>Sistem Aset Daerah</span>
            </div>
        </div> --}}

        <!-- PERBAIKAN: Tambahkan class d-flex-main dan batasi width -->
        <div class="d-flex d-flex-main" style="min-height: 100vh; width: 100%; max-width: 100vw; overflow-x: hidden;">
            <!-- Sidebar -->
            <div  class="bg-white border-end" style="width: 200px; flex-shrink: 0;">
                <div class="p-3 border-bottom">
                    <a href="{{route('Dashboard.index')}}" >
                        <h5 class="mb-0 fw-bold">SIM-BMD</h5>
                    </a>
                    
                </div>

                <ul class="list-unstyled">
                    <li class="{{ request()->routeIs('MutasiPersediaan.index') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('MutasiPersediaan.index') }}" wire:navigate
                            class="d-flex align-items-center text-decoration-none text-dark px-3 py-2">
                            <i class="bi bi-box-seam me-2" style="font-size: 16px;"></i>
                            <span style="font-size: 13px;">Mutasi Persediaan</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('mutasi.Index')}}" class="d-flex align-items-center text-decoration-none text-dark px-3 py-2">
                            <i class="bi bi-gem me-2" style="font-size: 16px;"></i>
                            <span style="font-size: 13px; font-weight: 600;">Mutasi Aset</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('AsetUtama.index') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('AsetUtama.index') }}" wire:navigate
                            class="d-flex align-items-center text-decoration-none text-dark px-3 py-2">
                            <i class="bi bi-file-earmark-text me-2" style="font-size: 16px;"></i>
                            <span style="font-size: 13px;">DPB</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Rekap.Index')}}" class="d-flex align-items-center text-decoration-none text-dark px-3 py-2">
                            <i class="bi bi-arrow-repeat me-2" style="font-size: 16px;"></i>
                            <span style="font-size: 13px;">Rekap</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('KodeBarang.index') ? 'sidebar-active' : '' }}">
                        <a href="{{ route('KodeBarang.index') }}" wire:navigate
                            class="d-flex align-items-center text-decoration-none text-dark px-3 py-2">
                            <i class="bi bi-circle-fill me-2" style="font-size: 6px;"></i>
                            <span style="font-size: 13px;">Kode Barang</span>
                        </a>
                    </li>
                    @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.users.index') }}"
                    class="d-flex align-items-center text-decoration-none text-dark px-3 py-2">
                        <i class="bi bi-people me-2"></i>
                        <span style="font-size: 13px;">Manajemen User</span>
                    </a>
                </li>
                @endif

                </ul> 
            </div>
            

            <!-- Main Content - PERBAIKAN: Pastikan tidak overflow -->
            <div class="flex-grow-1 d-flex flex-column" style="max-width: calc(100vw - 200px); overflow-x: hidden;">
                <!-- Top Header -->
                <div class="d-flex justify-content-between align-items-center px-3 py-2"
                    style="background-color: white; min-height: 70px; width: 100%; box-sizing: border-box;">
                    <div style="font-size: 12px; color: #333;">
                        <form action="{{ route('ganti.skpd') }}" method="POST" class="d-flex align-items-center">
                            @csrf

                            <label class="me-2 small">Pilih SKPD:</label>

                            @if(auth()->user()->role === 'operator_skpd')

                                <select class="form-select form-select-sm"
                                        style="width: 200px;"
                                        disabled>
                                    <option selected>
                                        {{ auth()->user()->skpd?->nama ?? 'SKPD Tidak Ditemukan' }}
                                    </option>
                                </select>

                            @else

                                <select name="skpd_id"
                                        class="form-select form-select-sm"
                                        onchange="this.form.submit()"
                                        style="width: 200px;">

                                    @foreach ($skpdService->all() as $s)

                                        <option value="{{ $s->id }}"
                                            {{ session('active_skpd_id', 1) == $s->id ? 'selected' : '' }}>

                                            {{ $s->nama }}

                                        </option>

                                    @endforeach

                                </select>

                            @endif

                        </form>
                    </div>               
                        <div class="dropdown">
    <button
        class="btn p-0 border-0 bg-transparent d-flex align-items-center dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false">

        <div class="text-end me-2">
            <div style="font-size: 12px; font-weight: 500; color: #333;">
                {{ ucfirst(auth()->user()->role) }}
            </div>
            <div style="font-size: 11px; color: #666;">
                {{ auth()->user()->name }}
            </div>
        </div>

        <img
            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=888&color=fff&size=36"
            alt="{{ auth()->user()->name }}"
            class="rounded-circle"
            width="36"
            height="36">
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow">
        <li class="px-3 py-2">
            <div class="fw-semibold" style="font-size: 13px;">
                {{ auth()->user()->name }}
            </div>
            <div class="text-muted" style="font-size: 11px;">
                {{ auth()->user()->email }}
            </div>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
            <a href="{{ route('profile') }}" class="dropdown-item">
                <i class="bi bi-person me-2"></i>
                Profile
            </a>
        </li>

        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
        </div>


                <!-- Main Content Area - PERBAIKAN: Tambahkan width control -->
                <main style="width: 100%; max-width: 100%; overflow-x: hidden; box-sizing: border-box;">
                    @yield('card')

                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @stack('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // 1. Setup Toast (Opsional, jika Anda pakai Toast di tempat lain)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // 2. Fungsi Cek Flash Message (DIPERBAIKI)
            function checkFlashMessage() {
                // Ambil elemen input
                const successEl = document.getElementById('flash-success');
                const errorEl = document.getElementById('flash-error');

                // Ambil value-nya
                const successMsg = successEl?.value;
                const errorMsg = errorEl?.value;

                // JIKA SUKSES
                if (successMsg) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: successMsg,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // PENTING: Kosongkan value agar tidak muncul lagi saat tombol Back ditekan
                    if (successEl) successEl.value = '';
                }

                // JIKA ERROR
                if (errorMsg) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMsg,
                        position: 'center',
                        showConfirmButton: true
                    });
                    // Kosongkan value juga
                    if (errorEl) errorEl.value = '';
                }
            }

            // 3. Jalankan Listener
            // Saat load pertama (Refresh)
            document.addEventListener('DOMContentLoaded', () => checkFlashMessage());

            // Saat navigasi Livewire (SPA)
            document.addEventListener('livewire:navigated', () => checkFlashMessage());

            // 4. Listener untuk Delete (Event dari PHP)
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('confirm-delete', (event) => {
                    Swal.fire({
                        title: 'Yakin hapus data?',
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteConfirmed', {
                                id: event.id
                            });
                        }
                    });
                });

                Livewire.on('alert', (data) => {
                    Swal.fire({
                        icon: data[0].type,
                        title: 'Berhasil!',
                        text: data[0].message,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });

            document.addEventListener('livewire:initialized', () => {
            
            // Listener untuk SweetAlert tipe Modal (Warning/Error)
            Livewire.on('swal:modal', (data) => {
                Swal.fire({
                    icon: data[0].type,      // 'warning'
                    title: data[0].title,    // 'SKPD Belum Dipilih!'
                    text: data[0].text,      // Pesan error
                    confirmButtonText: 'Oke, Saya Pilih',
                    confirmButtonColor: '#3085d6',
                });
            });

        });
        </script>
    </body>

    </html>

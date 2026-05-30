    <style>
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

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0 !important;
            }

            .sidebar {
                display: none;
            }
        }

        .sidebar-active {
            background-color: #e8e8e8;
            border-left: 3px solid #00bcd4;
        }

        .sidebar-active a span {
            font-weight: 600;
        }
    </style>
<div class="main-content flex-grow-1 p-3"
     style="background: linear-gradient(180deg, #00bcd4 0%, #00acc1 100%);">

    <!-- CARD STAT -->
    <div class="row g-4 mb-5">

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 p-3 rounded-3 d-flex align-items-center justify-content-center"
                         style="background-color: #e0f2fe; width: 60px; height: 60px;">
                        <i class="bi bi-box-seam-fill text-primary" style="font-size: 2.2rem;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold fs-3 mb-0">{{ number_format($summary['jumlah']) }}</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Aset Tetap</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 p-3 rounded-3 d-flex align-items-center justify-content-center"
                         style="background-color: #ede9fe; width: 60px; height: 60px;">
                        <i class="bi bi-archive-fill" style="font-size: 2.2rem; color: #7c3aed;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold fs-3 mb-0">{{ number_format($summary['jumlah_lainnya']) }}</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Aset Lainnya</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 p-3 rounded-3 d-flex align-items-center justify-content-center"
                         style="background-color: #fef9c3; width: 60px; height: 60px;">
                        <i class="bi bi-wallet-fill" style="font-size: 2.2rem; color: #a16207;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold fs-3 mb-0">{{ number_format($summary['saldo_awal']) }}</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Saldo Awal</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-3 p-3 rounded-3 d-flex align-items-center justify-content-center"
                         style="background-color: #e5e7eb; width: 60px; height: 60px;">
                        <i class="bi bi-credit-card-2-back-fill" style="font-size: 2.2rem; color: #374151;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold fs-3 mb-0">{{ number_format($summary['saldo_akhir']) }}</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Saldo Akhir</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- CHART 1 -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Perbandingan Saldo Awal dan Saldo Akhir</h6>
        </div>
        <div class="card-body">
            <canvas id="saldoChart" height="100"></canvas>
        </div>
    </div>

    <!-- CHART 2 -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Kenaikan Aset Pertahun</h6>
        </div>
        <div class="card-body">
            <canvas id="asetChart" height="100"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const saldoCtx = document.getElementById('saldoChart');

new Chart(saldoCtx, {
    type: 'bar',
    data: {
        labels: ['Saldo Awal', 'Saldo Akhir'],
        datasets: [{
            label: 'Jumlah Saldo',
            data: [12000, 9000],
            backgroundColor: ['#ff9f40', '#4bc0c0'],
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

const asetCtx = document.getElementById('asetChart');

new Chart(asetCtx, {
    type: 'line',
    data: {
        labels: ['2021', '2022', '2023', '2024', '2025'],
        datasets: [{
            label: 'Total Aset',
            data: [150, 165, 190, 210, 235],
            borderColor: '#36a2eb',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sesi Berakhir</title>
    <link rel="stylesheet" href="{{ URL::asset('build/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/icons.min.css') }}" type="text/css" />
</head>
<body class="bg-light">
    <div class="container" style="max-width: 640px;">
        <div class="card border-0 shadow-sm my-5">
            <div class="card-body p-4">
                <h4 class="mb-3"><i class="ri-time-line text-warning me-2"></i>Sesi Anda Berakhir</h4>

                <p>
                    Halaman ini terlalu lama dibuka sehingga sesi login Anda kedaluwarsa,
                    dan data yang barusan dikirim <strong>belum tersimpan</strong>.
                </p>

                <div class="alert alert-warning small">
                    <strong>Isian Anda kemungkinan besar masih ada.</strong>
                    Tekan tombol <strong>Back</strong> di browser (atau <kbd>Alt</kbd>+<kbd>&larr;</kbd>)
                    untuk kembali ke formulir, salin isian penting ke dokumen terpisah sebagai cadangan,
                    lalu login ulang di tab baru dan simpan kembali.
                </div>

                <p class="small text-muted mb-4">
                    Agar tidak terulang: klik <em>Simpan Draft</em> secara berkala selama mengisi.
                    Draft yang tersimpan tidak akan hilang meskipun sesi berakhir.
                </p>

                <a href="{{ url('/login') }}" class="btn btn-primary">
                    <i class="ri-login-box-line me-1"></i> Login Ulang
                </a>
            </div>
        </div>
    </div>
</body>
</html>

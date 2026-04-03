<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth routes
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Protected routes
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    
    // Absensi Relawan (Aslap only)
    $routes->group('relawan', ['filter' => 'role:aslap,admin'], function($routes) {
        $routes->get('/', 'RelawanController::index');
        $routes->get('create', 'RelawanController::create');
        $routes->post('store', 'RelawanController::store');
        $routes->get('edit/(:num)', 'RelawanController::edit/$1');
        $routes->post('update/(:num)', 'RelawanController::update/$1');
        $routes->post('delete/(:num)', 'RelawanController::delete/$1', ['filter' => 'role:admin']);
    });

    $routes->group('absensi', ['filter' => 'role:aslap,admin'], function($routes) {
        $routes->get('/', 'AbsensiController::index');
        $routes->get('create', 'AbsensiController::create');
        $routes->post('store', 'AbsensiController::store');
        $routes->get('edit/(:num)', 'AbsensiController::edit/$1');
        $routes->post('update/(:num)', 'AbsensiController::update/$1');
        $routes->post('delete/(:num)', 'AbsensiController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('show/(:num)', 'AbsensiController::show/$1');
        $routes->get('export-pdf/(:num)', 'AbsensiController::exportPdf/$1');
        $routes->get('rekap', 'AbsensiController::rekap');
        $routes->get('rekap-pdf', 'AbsensiController::rekapPdf');
    });

    // Admin routes
    $routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('reports', 'AdminController::reports');
        $routes->get('reports/(:num)', 'AdminController::reportDetail/$1');
        $routes->post('reports/(:num)/status', 'AdminController::updateStatus/$1');
        $routes->get('reports/(:num)/download', 'AdminController::download/$1');
        $routes->get('users', 'AdminController::users');
        $routes->get('users/edit/(:num)', 'AdminController::editUser/$1');
        $routes->post('users/update/(:num)', 'AdminController::updateUser/$1');
        $routes->get('switch-sppg/(:num)', 'DashboardController::switchSppg/$1');
    });

    // Profile routes
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');

    // PIC routes
    $routes->group('pic', ['filter' => 'role:pic'], function ($routes) {
        $routes->get('po', 'PicController::orders');
        $routes->get('settings', 'PicController::settings');
        $routes->post('settings/update', 'PicController::updateSettings');
    });

    // Aslap routes
    $routes->group('aslap', ['filter' => 'role:aslap,admin'], function ($routes) {
        $routes->get('upload/(:segment)', 'AslapController::uploadForm/$1');
        $routes->post('upload', 'AslapController::upload');
        $routes->get('history', 'AslapController::history');
    });

    // Akuntan routes
    $routes->group('akuntan', ['filter' => 'role:akuntan,admin'], function ($routes) {
        $routes->get('upload/(:segment)', 'AkuntanController::uploadForm/$1');
        $routes->post('upload', 'AkuntanController::upload');
        $routes->get('po', 'AkuntanController::orders');
        $routes->get('po/create', 'AkuntanController::createPO');
        $routes->post('po/store', 'AkuntanController::storePO');
    });

    // Purchase Order Routes
    $routes->group('po', function ($routes) {
        $routes->get('', 'PoController::index');
        $routes->get('create', 'PoController::create');
        $routes->post('store', 'PoController::store');
        $routes->get('show/(:num)', 'PoController::show/$1');
        $routes->get('edit/(:num)', 'PoController::edit/$1');
        $routes->post('update/(:num)', 'PoController::update/$1');
        $routes->get('edit-price/(:num)', 'PoController::editPrice/$1');
        $routes->post('update-price/(:num)', 'PoController::updatePrice/$1');
        $routes->get('review/(:num)', 'PoController::review/$1');
        $routes->post('do-review/(:num)', 'PoController::doReview/$1');
        $routes->get('approve/(:num)', 'PoController::approve/$1');
        $routes->post('do-approve/(:num)', 'PoController::doApprove/$1');
        $routes->post('delete/(:num)', 'PoController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('print/(:num)', 'PoController::print/$1');
        $routes->get('export-excel', 'PoController::exportExcel');
        $routes->get('export-pdf', 'PoController::exportPdf');
        $routes->get('get-akg-details/(:num)', 'PoController::getAkgDetails/$1');
    });

    // Beneficiary Data Routes
    $routes->group('penerima-manfaat', function ($routes) {
        $routes->get('', 'BeneficiaryController::index');
        $routes->get('create', 'BeneficiaryController::create');
        $routes->post('store', 'BeneficiaryController::store');
        $routes->get('edit/(:num)', 'BeneficiaryController::edit/$1', ['filter' => 'role:aslap']);
        $routes->post('update/(:num)', 'BeneficiaryController::update/$1', ['filter' => 'role:aslap']);
        $routes->get('show/(:num)', 'BeneficiaryController::show/$1');
        $routes->post('approve/(:num)', 'BeneficiaryController::approve/$1');
        $routes->post('reject/(:num)', 'BeneficiaryController::reject/$1');
        $routes->post('delete/(:num)', 'BeneficiaryController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('export-pdf/(:num)', 'BeneficiaryController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'BeneficiaryController::exportExcel/$1');
    });

    // Delivery Routes
    $routes->group('routes', function ($routes) {
        $routes->get('', 'RouteController::index');
        $routes->get('create', 'RouteController::create');
        $routes->post('store', 'RouteController::store');
        $routes->get('edit/(:num)', 'RouteController::edit/$1');
        $routes->post('update/(:num)', 'RouteController::update/$1');
        $routes->post('delete/(:num)', 'RouteController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('show/(:num)', 'RouteController::show/$1');
        $routes->post('approve/(:num)', 'RouteController::approve/$1');
        $routes->post('reject/(:num)', 'RouteController::reject/$1');
        $routes->get('surat-jalan/(:num)', 'RouteController::suratJalanPdf/$1');
        $routes->get('export-pdf/(:num)', 'RouteController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'RouteController::exportExcel/$1');
    });

    // Barang Datang Routes
    $routes->group('barang-datang', function ($routes) {
        $routes->get('', 'BarangDatangController::index');
        $routes->get('create', 'BarangDatangController::create', ['filter' => 'role:aslap,admin']);
        $routes->post('store', 'BarangDatangController::store', ['filter' => 'role:aslap,admin']);
        $routes->get('edit/(:num)', 'BarangDatangController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'BarangDatangController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'BarangDatangController::show/$1');
        $routes->get('export-pdf/(:num)', 'BarangDatangController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'BarangDatangController::exportExcel/$1');
        $routes->post('delete/(:num)', 'BarangDatangController::delete/$1', ['filter' => 'role:admin']);
    });

    // Cek Bahan Baku Routes
    $routes->group('cek-bahan-baku', function ($routes) {
        $routes->get('', 'CekBahanBakuController::index');
        $routes->get('create', 'CekBahanBakuController::create', ['filter' => 'role:aslap,admin']);
        $routes->post('store', 'CekBahanBakuController::store', ['filter' => 'role:aslap,admin']);
        $routes->get('edit/(:num)', 'CekBahanBakuController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'CekBahanBakuController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'CekBahanBakuController::show/$1');
        $routes->get('export-pdf/(:num)', 'CekBahanBakuController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'CekBahanBakuController::exportExcel/$1');
        $routes->post('delete/(:num)', 'CekBahanBakuController::delete/$1', ['filter' => 'role:admin']);
    });

    // Uji Organoleptik Routes
    $routes->group('uji-organoleptik', function ($routes) {
        $routes->get('', 'UjiOrganoleptikController::index');
        $routes->get('create', 'UjiOrganoleptikController::create', ['filter' => 'role:aslap,admin']);
        $routes->post('store', 'UjiOrganoleptikController::store', ['filter' => 'role:aslap,admin']);
        $routes->get('edit/(:num)', 'UjiOrganoleptikController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'UjiOrganoleptikController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'UjiOrganoleptikController::show/$1');
        $routes->get('export-pdf/(:num)', 'UjiOrganoleptikController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'UjiOrganoleptikController::exportExcel/$1');
        $routes->post('delete/(:num)', 'UjiOrganoleptikController::delete/$1', ['filter' => 'role:admin']);
    });

    // BA Kehilangan Ompreng Routes
    $routes->group('ba-kehilangan', function ($routes) {
        $routes->get('', 'BaKehilanganController::index');
        $routes->get('create', 'BaKehilanganController::create', ['filter' => 'role:aslap']);
        $routes->post('store', 'BaKehilanganController::store', ['filter' => 'role:aslap']);
        $routes->get('edit/(:num)', 'BaKehilanganController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'BaKehilanganController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'BaKehilanganController::show/$1');
        $routes->get('export-pdf/(:num)', 'BaKehilanganController::exportPdf/$1');
        $routes->post('delete/(:num)', 'BaKehilanganController::delete/$1', ['filter' => 'role:admin']);
    });

    // Pemberitahuan Kerja Routes
    $routes->group('pemberitahuan-kerja', function ($routes) {
        $routes->get('', 'PemberitahuanKerjaController::index');
        $routes->get('create', 'PemberitahuanKerjaController::create', ['filter' => 'role:aslap']);
        $routes->post('store', 'PemberitahuanKerjaController::store', ['filter' => 'role:aslap']);
        $routes->get('edit/(:num)', 'PemberitahuanKerjaController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'PemberitahuanKerjaController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'PemberitahuanKerjaController::show/$1');
        $routes->get('export-pdf/(:num)', 'PemberitahuanKerjaController::exportPdf/$1');
        $routes->post('delete/(:num)', 'PemberitahuanKerjaController::delete/$1', ['filter' => 'role:admin']);
    });

    // Stok Gudang Routes
    $routes->group('stok-gudang', function ($routes) {
        $routes->get('', 'StokGudangController::index');
        $routes->get('create', 'StokGudangController::create', ['filter' => 'role:aslap']);
        $routes->post('store', 'StokGudangController::store', ['filter' => 'role:aslap']);
        $routes->get('edit/(:num)', 'StokGudangController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'StokGudangController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'StokGudangController::show/$1');
        $routes->get('export-pdf/(:num)', 'StokGudangController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'StokGudangController::exportExcel/$1');
        $routes->post('delete/(:num)', 'StokGudangController::delete/$1', ['filter' => 'role:admin']);
    });

    // Stok Opname Routes
    $routes->group('stok-opname', function ($routes) {
        $routes->get('', 'StokOpnameController::index');
        $routes->get('create', 'StokOpnameController::create', ['filter' => 'role:aslap']);
        $routes->post('store', 'StokOpnameController::store', ['filter' => 'role:aslap']);
        $routes->get('edit/(:num)', 'StokOpnameController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'StokOpnameController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'StokOpnameController::show/$1');
        $routes->get('export-pdf/(:num)', 'StokOpnameController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'StokOpnameController::exportExcel/$1');
        $routes->post('delete/(:num)', 'StokOpnameController::delete/$1', ['filter' => 'role:admin']);
    });

    // Rekap Porsi Routes
    $routes->group('rekap-porsi', function ($routes) {
        $routes->get('', 'RekapPorsiController::index');
        $routes->get('create', 'RekapPorsiController::create', ['filter' => 'role:aslap']);
        $routes->post('store', 'RekapPorsiController::store', ['filter' => 'role:aslap']);
        $routes->get('edit/(:num)', 'RekapPorsiController::edit/$1', ['filter' => 'role:aslap,admin']);
        $routes->post('update/(:num)', 'RekapPorsiController::update/$1', ['filter' => 'role:aslap,admin']);
        $routes->get('show/(:num)', 'RekapPorsiController::show/$1');
        $routes->get('export-pdf/(:num)', 'RekapPorsiController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'RekapPorsiController::exportExcel/$1');
        $routes->post('delete/(:num)', 'RekapPorsiController::delete/$1', ['filter' => 'role:admin']);
    });

    // Signatures Route
    $routes->group('signatures', ['filter' => 'auth'], function ($routes) {
        $routes->get('', 'SignatureController::index');
        $routes->post('store', 'SignatureController::store');
    });

    // Ahli Gizi routes
    $routes->group('ahli-gizi', ['filter' => 'role:ahli_gizi,admin'], function ($routes) {
        $routes->get('upload', 'AhliGiziController::uploadForm');
        $routes->post('upload', 'AhliGiziController::upload');
    });

    // Buku Kas Operasional
    $routes->group('buku-kas', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'BukuKasController::index');
        $routes->get('create', 'BukuKasController::create', ['filter' => 'role:akuntan,admin']);
        $routes->post('store', 'BukuKasController::store', ['filter' => 'role:akuntan,admin']);
        $routes->get('edit/(:num)', 'BukuKasController::edit/$1', ['filter' => 'role:akuntan,admin']);
        $routes->post('update/(:num)', 'BukuKasController::update/$1', ['filter' => 'role:akuntan,admin']);
        $routes->post('delete/(:num)', 'BukuKasController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('report', 'BukuKasController::report');
        $routes->get('export-pdf', 'BukuKasController::exportPdf');
        $routes->get('export-excel', 'BukuKasController::exportExcel');
    });

    // Petty Cash
    $routes->group('petty-cash', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'PettyCashController::index');
        $routes->get('create', 'PettyCashController::create', ['filter' => 'role:akuntan,admin']);
        $routes->post('store', 'PettyCashController::store', ['filter' => 'role:akuntan,admin']);
        $routes->get('edit/(:num)', 'PettyCashController::edit/$1', ['filter' => 'role:akuntan,admin']);
        $routes->post('update/(:num)', 'PettyCashController::update/$1', ['filter' => 'role:akuntan,admin']);
        $routes->post('delete/(:num)', 'PettyCashController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('report', 'PettyCashController::report');
        $routes->get('export-pdf', 'PettyCashController::exportPdf');
        $routes->get('export-excel', 'PettyCashController::exportExcel');
    });

    // Pengajuan Barang Rusak (PIC)
    $routes->group('pengajuan-barang-rusak', function ($routes) {
        $routes->get('', 'PengajuanBarangRusakController::index');
        $routes->get('create', 'PengajuanBarangRusakController::create', ['filter' => 'role:pic']);
        $routes->post('store', 'PengajuanBarangRusakController::store', ['filter' => 'role:pic']);
        $routes->get('show/(:num)', 'PengajuanBarangRusakController::show/$1');
        $routes->get('edit/(:num)', 'PengajuanBarangRusakController::edit/$1', ['filter' => 'role:pic']);
        $routes->post('update/(:num)', 'PengajuanBarangRusakController::update/$1', ['filter' => 'role:pic']);
        $routes->post('delete/(:num)', 'PengajuanBarangRusakController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('export-pdf/(:num)', 'PengajuanBarangRusakController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'PengajuanBarangRusakController::exportExcel/$1');
        $routes->post('approve/(:num)', 'PengajuanBarangRusakController::approve/$1', ['filter' => 'role:admin']);
        $routes->post('reject/(:num)', 'PengajuanBarangRusakController::reject/$1', ['filter' => 'role:admin']);
    });

    // Pengadaan Barang (PIC)
    $routes->group('pengadaan-barang', function ($routes) {
        $routes->get('', 'PengadaanBarangController::index');
        $routes->get('create', 'PengadaanBarangController::create', ['filter' => 'role:pic']);
        $routes->post('store', 'PengadaanBarangController::store', ['filter' => 'role:pic']);
        $routes->get('show/(:num)', 'PengadaanBarangController::show/$1');
        $routes->get('edit/(:num)', 'PengadaanBarangController::edit/$1', ['filter' => 'role:pic']);
        $routes->post('update/(:num)', 'PengadaanBarangController::update/$1', ['filter' => 'role:pic']);
        $routes->post('delete/(:num)', 'PengadaanBarangController::delete/$1', ['filter' => 'role:admin']);
        $routes->get('export-pdf/(:num)', 'PengadaanBarangController::exportPdf/$1');
        $routes->get('export-excel/(:num)', 'PengadaanBarangController::exportExcel/$1');
        $routes->post('approve/(:num)', 'PengadaanBarangController::approve/$1', ['filter' => 'role:admin']);
        $routes->post('reject/(:num)', 'PengadaanBarangController::reject/$1', ['filter' => 'role:admin']);
    });

    // Quality Management & Nutrition Modules
    $modules = [
        'uji-cita-rasa'          => 'UjiCitaRasaController',
        'pemeriksaan-sampel'     => 'PemeriksaanSampelController',
        'makanan-lebih'          => 'MakananLebihController',
        'serah-terima-bahan'     => 'SerahTerimaBahanController',
        'monitoring-suhu-masak'  => 'MonitoringSuhuMasakController',
        'thawing-air'            => 'ThawingAirController',
        'thawing-chiller'        => 'ThawingChillerController',
        'suhu-ruangan'           => 'SuhuRuanganController',
        'suhu-chiller-freezer'   => 'SuhuChillerFreezerController',
        'pencucian-bahan'        => 'PencucianBahanController',
        'estimasi-anggaran'      => 'EstimasiAnggaranController',
        'analisis-gizi'          => 'AnalisisGiziController',
        'checklist-masakan'      => 'ChecklistMasakanController',
        // Operational & Sanitation
        'sanitasi-ruangan'       => 'SanitasiRuanganController',
        'pembersihan-harian'     => 'PembersihanHarianController',
        'pembersihan-mingguan'   => 'PembersihanMingguanController',
        'pembuangan-sampah'      => 'PembuanganSampahController',
        'pembersihan-bak-sampah' => 'PembersihanBakSampahController',
        'pembersihan-lantai'     => 'PembersihanLantaiController',
        'pengeluaran-chemical'   => 'PengeluaranChemicalController',
        // Maintenance & Hygiene
        'pembersihan-transportasi' => 'PembersihanTransportasiController',
        'pembersihan-trolly'       => 'PembersihanTrollyController',
        'higiene-personil'         => 'HigienePersonilController',
    ];

    foreach ($modules as $uri => $controller) {
        $routes->group($uri, function ($routes) use ($controller) {
            $routes->get('', "$controller::index");
            $routes->get('create', "$controller::create", ['filter' => 'role:ahli_gizi,admin']);
            $routes->post('store', "$controller::store", ['filter' => 'role:ahli_gizi,admin']);
            $routes->get('show/(:num)', "$controller::show/$1");
            $routes->get('edit/(:num)', "$controller::edit/$1", ['filter' => 'role:ahli_gizi,admin']);
            $routes->post('update/(:num)', "$controller::update/$1", ['filter' => 'role:ahli_gizi,admin']);
            $routes->post('delete/(:num)', "$controller::delete/$1", ['filter' => 'role:admin']);
            $routes->get('print/(:num)', "$controller::print/$1");
            $routes->get('export-pdf/(:num)', "$controller::exportPdf/$1");
            $routes->get('export-excel/(:num)', "$controller::exportExcel/$1");
        });
    }
});

// Temporary migration route for database setup
$routes->get('migrate-db-temp', 'MigrationController::index');
$routes->get('update-db-special', 'UpdateDbController::index');
$routes->get('truncate-all', 'TruncateDbController::index');

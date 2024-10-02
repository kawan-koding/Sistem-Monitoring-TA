<?php

use App\Http\Controllers\Administrator\Profile\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\JenisTAController;
use App\Http\Controllers\PeriodeTAController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KuotaDosenController;
use App\Http\Controllers\PengajuanTaMahasiswaController;
use App\Http\Controllers\PengajuanTaKaprodiController;
use App\Http\Controllers\DaftarTaKaprodiController;
use App\Http\Controllers\PembagianDosenController;
use App\Http\Controllers\DaftarTaAdminController;
use App\Http\Controllers\DaftarBimbinganDosenController;
use App\Http\Controllers\JadwalSeminarController;
use App\Http\Controllers\JadwalUjiDosenController;
use App\Http\Controllers\JadwalSeminarMahasiswaController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RumpunIlmuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'portal'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/proses', [LoginController::class, 'authenticate'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    
Route::get('/oauth', [OAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/oauth/callback', [OAuthController::class, 'callback'])->name('oauth.callback');
Route::get('/oauth/refresh', [OAuthController::class, 'refresh'])->name('oauth.refresh');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('admin.monitoring');
    Route::get('/switching', [DashboardController::class, 'switching'])->name('admin.switching');
    Route::get('/switcher/{role}', [DashboardController::class, 'switcher'])->name('admin.switcher');

    //Topik
    Route::prefix('topik')->group(function () {
        Route::get('', [TopikController::class, 'index'])->name('admin.topik')->middleware('can:read-topik');
        Route::post('/store', [TopikController::class, 'store'])->name('admin.topik.store');
        Route::get('/show/{id}', [TopikController::class, 'show'])->name('admin.topik.show');
        Route::post('/update', [TopikController::class, 'update'])->name('admin.topik.update');
        Route::get('/destroy/{id}', [TopikController::class, 'destroy'])->name('admin.topik.delete');
        Route::get('/rekapitulasi', [DaftarTaAdminController::class, 'rekapitulasi'])->name('admin.rekapitulasi');
    });

    //Jenis
    Route::prefix('jenis')->group(function () {
        Route::get('', [JenisTAController::class, 'index'])->name('admin.jenis_ta')->middleware('can:read-jenis');
        Route::post('/store', [JenisTAController::class, 'store'])->name('admin.jenis_ta.store');
        Route::get('/show/{id}', [JenisTAController::class, 'show'])->name('admin.jenis_ta.show');
        Route::post('/update', [JenisTAController::class, 'update'])->name('admin.jenis_ta.update');
        Route::get('/destroy/{id}', [JenisTAController::class, 'destroy'])->name('admin.jenis_ta.delete');
    });

    //Periode
    Route::prefix('periode')->group(function () {
        Route::get('', [PeriodeTAController::class, 'index'])->name('admin.periode')->middleware('can:read-periode');
        Route::post('/store', [PeriodeTAController::class, 'store'])->name('admin.periode.store');
        Route::get('/show/{id}', [PeriodeTAController::class, 'show'])->name('admin.periode.show');
        Route::post('/update', [PeriodeTAController::class, 'update'])->name('admin.periode.update');
        Route::get('/destroy/{id}', [PeriodeTAController::class, 'destroy'])->name('admin.periode.delete');
        Route::get('/change/{id}', [PeriodeTAController::class, 'change'])->name('admin.periode.change');
    });

    //Dosen
    Route::prefix('dosen')->group(function () {
        Route::get('', [DosenController::class, 'index'])->name('admin.dosen')->middleware('can:read-dosen');
        Route::post('/store', [DosenController::class, 'store'])->name('admin.dosen.store');
        Route::get('/show/{id}', [DosenController::class, 'show'])->name('admin.dosen.show');
        Route::post('/update', [DosenController::class, 'update'])->name('admin.dosen.update');
        Route::get('/destroy/{id}', [DosenController::class, 'destroy'])->name('admin.dosen.delete');
        Route::post('/import', [DosenController::class, 'import'])->name('admin.dosen.import');
        Route::get('/tarik-data', [DosenController::class, 'tarikData'])->name('admin.dosen.tarik-data');
    });

    //Daftar TA
    Route::prefix('daftarta')->group(function () {
        Route::get('', [DaftarTaAdminController::class, 'index'])->name('admin.daftarta')->middleware('can:read-daftarta-admin');
        Route::post('/store', [DaftarTaAdminController::class, 'store'])->name('admin.daftarta.store');
        Route::get('/show/{id}', [DaftarTaAdminController::class, 'show'])->name('admin.daftarta.show');
        Route::get('/edit/{id}', [DaftarTaAdminController::class, 'edit'])->name('admin.daftarta.edit');
        Route::get('/detail/{id}', [DaftarTaAdminController::class, 'detail'])->name('admin.daftarta.detail');
        Route::post('/update/{id}', [DaftarTaAdminController::class, 'update'])->name('admin.daftarta.update');
        Route::get('/destroy/{id}', [DaftarTaAdminController::class, 'destroy'])->name('admin.daftarta.delete');
    });

    //Mahasiswa
    Route::prefix('mahasiswa')->group(function () {
        Route::get('', [MahasiswaController::class, 'index'])->name('admin.mahasiswa')->middleware('can:read-mahasiswa');
        Route::post('store', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
        Route::get('{mahasiswa}/show', [MahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
        Route::post('{mahasiswa}/update', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
        Route::get('{mahasiswa}/destroy', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.delete');
        Route::post('import', [MahasiswaController::class, 'import'])->name('admin.mahasiswa.import');
    });

    //Ruangan
    Route::prefix('ruangan')->group(function () {
        Route::get('', [RuanganController::class, 'index'])->name('admin.ruangan')->middleware('can:read-ruangan');
        Route::post('/store', [RuanganController::class, 'store'])->name('admin.ruangan.store');
        Route::get('/show/{id}', [RuanganController::class, 'show'])->name('admin.ruangan.show');
        Route::post('/update', [RuanganController::class, 'update'])->name('admin.ruangan.update');
        Route::get('/destroy/{id}', [RuanganController::class, 'destroy'])->name('admin.ruangan.delete');
    });

    //Ruangan
    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('admin.user')->middleware('can:read-users');
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('admin.user.show');
        Route::post('/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
    });

    //Kuota Dosen
    Route::prefix('kuotadosen')->group(function () {
        Route::get('', [KuotaDosenController::class, 'index'])->name('admin.kuotadosen')->middleware('can:read-kuota');
        Route::get('/store', [KuotaDosenController::class, 'store'])->name('admin.kuotadosen.store');
    });

    //Jadwal Seminar
    Route::prefix('jadwal-seminar')->group(function () {
        Route::get('', [JadwalSeminarController::class, 'index'])->name('admin.jadwal-seminar')->middleware('can:read-seminar-admin');
        Route::get('/tambahkan-jadwal/{id}', [JadwalSeminarController::class, 'tambahJadwal'])->name('admin.jadwal-seminar.tambahkan-jadwal')->middleware('can:read-seminar-admin');
        Route::post('/store/{id}', [JadwalSeminarController::class, 'store'])->name('admin.jadwal-seminar.store');
        Route::get('/chekRuangan', [JadwalSeminarController::class, 'chekRuangan'])->name('admin.jadwal-seminar.chekRuangan');
    });

    //setting
    Route::prefix('settings')->group(function () {
        Route::get('', [SettingController::class, 'index'])->name('admin.settings')->middleware('can:read-settings');
        Route::post('store', [SettingController::class, 'store'])->name('admin.settings.store');
    });

});

Route::prefix('kaprodi')->middleware(['admin'])->group(function () {

    //Pengajuan TA Kaprodi
    Route::prefix('pengajuan-ta-kaprodi')->group(function () {
        Route::get('', [PengajuanTaKaprodiController::class, 'index'])->name('kaprodi.pengajuan-ta')->middleware('can:read-pengajuanta-kaprodi');
        Route::get('/acc/{id}', [PengajuanTaKaprodiController::class, 'acc'])->name('kaprodi.pengajuan-ta.acc');
        Route::post('/reject/{id}', [PengajuanTaKaprodiController::class, 'reject'])->name('kaprodi.pengajuan-ta.reject');
    });

    //Daftar TA Kaprodi
    Route::prefix('daftar-ta-kaprodi')->group(function () {
        Route::get('', [DaftarTaKaprodiController::class, 'index'])->name('kaprodi.daftar-ta')->middleware('can:read-daftarta-kaprodi');
        Route::get('/detail/{id}', [DaftarTaKaprodiController::class, 'show'])->name('kaprodi.daftar-ta.show');
    });

    //Daftar TA Kaprodi
    Route::prefix('pembagian-dosen-kaprodi')->group(function () {
        Route::get('', [PembagianDosenController::class, 'index'])->name('kaprodi.pembagian-dosen')->middleware('can:read-bagidosen-kaprodi');
        Route::get('/edit/{id}', [PembagianDosenController::class, 'edit'])->name('kaprodi.pembagian-dosen.edit');
        Route::post('/update/{id}', [PembagianDosenController::class, 'update'])->name('kaprodi.pembagian-dosen.update');
    });

});

Route::prefix('dosen')->middleware(['admin'])->group(function () {
    Route::prefix('daftar-bimbingan')->group(function () {
        Route::get('', [DaftarBimbinganDosenController::class, 'index'])->name('dosen.daftar_bimbingan')->middleware('can:read-daftar-bimbingan');
        Route::get('/show_bimbingan/{id}', [DaftarBimbinganDosenController::class, 'show_bimbingan'])->name('dosen.daftar_bimbingan.show_bimbingan');
        Route::get('/show_uji/{id}', [DaftarBimbinganDosenController::class, 'show_uji'])->name('dosen.daftar_bimbingan.show_uji');
        Route::get('/show_revisi/{id}', [DaftarBimbinganDosenController::class, 'show_revisi'])->name('dosen.daftar_bimbingan.show_revisi');
        Route::get('/status_revisi/{id}', [DaftarBimbinganDosenController::class, 'status_revisi'])->name('dosen.daftar_bimbingan.status_revisi');
    });

    Route::prefix('jadwal-uji')->group(function () {
        Route::get('', [JadwalUjiDosenController::class, 'index'])->name('dosen.jadwal-uji')->middleware('can:read-jadwaluji');
        Route::get('/show/{id}', [JadwalUjiDosenController::class, 'show'])->name('dosen.jadwal-uji.show')->middleware('can:read-jadwaluji');
        Route::get('/delete/{id}', [JadwalUjiDosenController::class, 'delete_uraian'])->name('dosen.jadwal-uji.delete');
        Route::get('/delete-nilai/{id}', [JadwalUjiDosenController::class, 'delete_nilai'])->name('dosen.jadwal-uji.delete-nilai');
        Route::post('/create_revisi', [JadwalUjiDosenController::class, 'create_revisi'])->name('dosen.jadwal-uji.create_revisi');
        Route::post('/update-revisi', [JadwalUjiDosenController::class, 'update_revisi'])->name('dosen.jadwal-uji.update-revisi');
        Route::get('/create_nilai', [JadwalUjiDosenController::class, 'create_nilai'])->name('dosen.jadwal-uji.create_nilai');
        Route::post('/update_status_seminar', [JadwalUjiDosenController::class, 'update_status_seminar'])->name('dosen.jadwal-uji.status-update');
    });
    Route::prefix('rumpun-ilmu')->group(function () {
        Route::get('', [RumpunIlmuController::class, 'index'])->name('dosen.rumpun-ilmu')->middleware('can:read-rumpunilmu');
        Route::post('create', [RumpunIlmuController::class, 'create'])->name('dosen.rumpun-ilmu.store')->middleware('can:create-rumpunilmu');
        Route::post('update', [RumpunIlmuController::class, 'update'])->name('dosen.rumpun-ilmu.update')->middleware('can:update-rumpunilmu');
        Route::get('/show/{id}', [RumpunIlmuController::class, 'show'])->name('dosen.rumpun-ilmu.show')->middleware('can:read-rumpunilmu');
        Route::get('/delete/{id}', [RumpunIlmuController::class, 'destroy'])->name('dosen.rumpun-ilmu.delete');
    });
});

//mahasiswa
Route::prefix('mahasiswa')->middleware(['admin'])->group(function () {
    //mahasiswa pengajuan ta
    Route::prefix('pengajuan-ta')->group(function () {
        Route::get('', [PengajuanTaMahasiswaController::class, 'index'])->name('mahasiswa.pengajuan-ta')->middleware('can:read-pengajuanta-mahasiswa');
        Route::get('/create', [PengajuanTaMahasiswaController::class, 'create'])->name('mahasiswa.pengajuan-ta.create')->middleware('can:read-pengajuanta-mahasiswa');
        Route::post('/store', [PengajuanTaMahasiswaController::class, 'store'])->name('mahasiswa.pengajuan-ta.store');
        Route::get('/edit/{id}', [PengajuanTaMahasiswaController::class, 'edit'])->name('mahasiswa.pengajuan-ta.edit');
        Route::post('/update/{id}', [PengajuanTaMahasiswaController::class, 'update'])->name('mahasiswa.pengajuan-ta.update');
        Route::get('/show/{id}', [PengajuanTaMahasiswaController::class, 'show'])->name('mahasiswa.pengajuan-ta.show');
        Route::post('/unggah_berkas/{id}', [PengajuanTaMahasiswaController::class, 'unggah_berkas'])->name('mahasiswa.pengajuan-ta.unggah-berkas');
        Route::get('/print_nilai/{id}', [PengajuanTaMahasiswaController::class, 'print_nilai'])->name('mahasiswa.pengajuan-ta.print_nilai');
        Route::get('/print_rekap/{id}', [PengajuanTaMahasiswaController::class, 'print_rekap'])->name('mahasiswa.pengajuan-ta.print_rekap');
        Route::get('/print_revisi/{id}', [PengajuanTaMahasiswaController::class, 'print_revisi'])->name('mahasiswa.pengajuan-ta.print_revisi');
        Route::get('/cek-dosen', [PengajuanTaMahasiswaController::class, 'cekDosen'])->name('mahasiswa.pengajuan-ta.cekdosen');
        Route::get('/print_pemb1/{id}', [PengajuanTaMahasiswaController::class, 'printPembSatu'])->name('mahasiswa.pengajuan-ta.print_pemb1');
        Route::get('/print_pemb2/{id}', [PengajuanTaMahasiswaController::class, 'printPembDua'])->name('mahasiswa.pengajuan-ta.print_pemb2');
    });

    Route::prefix('jadwal-seminar')->group(function () {
        Route::get('', [JadwalSeminarMahasiswaController::class, 'index'])->name('mahasiswa.jadwal-seminar')->middleware('can:read-jadwalseminar-mahasiswa');
        Route::get('/show/{id}', [JadwalSeminarMahasiswaController::class, 'show'])->name('mahasiswa.jadwal-seminar.show')->middleware('can:read-jadwalseminar-mahasiswa');
    });
});

Route::prefix('apps')->middleware(['auth'])->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('apps.profile');
    route::post('update', [ProfileController::class, 'update'])->name('apps.profile.update');
});

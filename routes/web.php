<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\KuotaDosenController;
use App\Http\Controllers\RumpunIlmuController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\DaftarTaAdminController;
use App\Http\Controllers\JadwalSeminarController;
use App\Http\Controllers\JadwalUjiDosenController;
use App\Http\Controllers\PembagianDosenController;
use App\Http\Controllers\DaftarTaKaprodiController;
use App\Http\Controllers\PengajuanTaKaprodiController;
use App\Http\Controllers\DaftarBimbinganDosenController;
use App\Http\Controllers\PengajuanTaMahasiswaController;

use App\Http\Controllers\JadwalSeminarMahasiswaController;
use App\Http\Controllers\Administrator\Role\RoleController;
use App\Http\Controllers\Administrator\User\UserController;
use App\Http\Controllers\Administrator\Dosen\DosenController;
use App\Http\Controllers\Administrator\JenisTA\JenisTAController;
use App\Http\Controllers\Administrator\Jurusan\JurusanController;
use App\Http\Controllers\Administrator\Ruangan\RuanganController;
use App\Http\Controllers\Administrator\TopikTA\TopikTAController;
use App\Http\Controllers\Administrator\DaftarTA\DaftarTAController;
use App\Http\Controllers\Administrator\Dashboard\DashboardController;
use App\Http\Controllers\Administrator\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Administrator\PeriodeTA\PeriodeTAController;
use App\Http\Controllers\Administrator\PengajuanTA\PengajuanTAController;
use App\Http\Controllers\Administrator\ProgramStudi\ProgramStudiController;
use App\Http\Controllers\Administrator\RekomendasiTopik\RekomendasiTopikController;

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

Route::get('/', function() {
    return view('index');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.process');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    
Route::get('oauth', [AuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('oauth/callback', [AuthController::class, 'callback'])->name('oauth.callback');
Route::get('oauth/refresh', [AuthController::class, 'refresh'])->name('oauth.refresh');

Route::prefix('apps')->middleware('auth')->group(function () {
    Route::get('switching', [AuthController::class, 'switching'])->name('apps.switching');
    Route::get('switcher/{role}', [AuthController::class, 'switcher'])->name('apps.switcher');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('apps.dashboard');

    Route::prefix('users')->middleware('can:read-users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('apps.users');
        Route::post('store', [UserController::class, 'store'])->name('apps.users.store');
        Route::get('{user}/show', [UserController::class, 'show'])->name('apps.users.show');
        Route::post('{user}/update', [UserController::class, 'update'])->name('apps.users.update');
        Route::get('{user}/delete', [UserController::class, 'destroy'])->name('apps.users.delete');
    });

    Route::prefix('roles')->middleware('can:read-roles')->group(function() {
        Route::get('', [RoleController::class, 'index'])->name('apps.roles');
        Route::get('get-data', [RoleController::class, 'getData'])->name('apps.roles.get-data');
        Route::get('{role}/change', [RoleController::class, 'change'])->name('apps.roles.change')->middleware('can:read-permissions');
        Route::post('{role}/change-permission', [RoleController::class, 'changePermissions'])->name('apps.roles.change-permissions')->middleware('can:change-permissions');
    });

    Route::prefix('mahasiswa')->middleware('can:read-mahasiswa')->group(function () {
        Route::get('', [MahasiswaController::class, 'index'])->name('apps.mahasiswa');
        Route::post('store', [MahasiswaController::class, 'store'])->name('apps.mahasiswa.store');
        Route::get('{mahasiswa}/show', [MahasiswaController::class, 'show'])->name('apps.mahasiswa.show');
        Route::post('{mahasiswa}/update', [MahasiswaController::class, 'update'])->name('apps.mahasiswa.update');
        Route::get('{mahasiswa}/destroy', [MahasiswaController::class, 'destroy'])->name('apps.mahasiswa.delete');
        Route::post('import', [MahasiswaController::class, 'import'])->name('apps.mahasiswa.import');
    });

    Route::prefix('jurusan')->middleware('can:read-jurusan')->group(function () {
        Route::get('', [JurusanController::class, 'index'])->name('apps.jurusan');
        Route::post('store', [JurusanController::class, 'store'])->name('apps.jurusan.store');
        Route::get('{jurusan}/show', [JurusanController::class, 'show'])->name('apps.jurusan.show');
        Route::post('{jurusan}/update', [JurusanController::class, 'update'])->name('apps.jurusan.update');
        Route::delete('{jurusan}/destroy', [JurusanController::class, 'destroy'])->name('apps.jurusan.delete');
    });

    Route::prefix('program-studi')->middleware('can:read-program-studi')->group(function () {
        Route::get('', [ProgramStudiController::class, 'index'])->name('apps.program-studi');
        Route::post('store', [ProgramStudiController::class, 'store'])->name('apps.program-studi.store');
        Route::get('{programStudi}/show', [ProgramStudiController::class, 'show'])->name('apps.program-studi.show');
        Route::post('{programStudi}/update', [ProgramStudiController::class, 'update'])->name('apps.program-studi.update');
        Route::delete('{programStudi}/destroy', [ProgramStudiController::class, 'destroy'])->name('apps.program-studi.delete');
    });

    Route::prefix('ruangan')->middleware('can:read-ruangan')->group(function () {
        Route::get('', [RuanganController::class, 'index'])->name('apps.ruangan');
        Route::post('store', [RuanganController::class, 'store'])->name('apps.ruangan.store');
        Route::get('show/{id}', [RuanganController::class, 'show'])->name('apps.ruangan.show');
        Route::post('update/{id}', [RuanganController::class, 'update'])->name('apps.ruangan.update');
        Route::get('destroy/{id}', [RuanganController::class, 'destroy'])->name('apps.ruangan.delete');
    });

    Route::prefix('topik')->middleware('can:read-topik')->group(function () {
        Route::get('', [TopikTAController::class, 'index'])->name('apps.topik');
        Route::post('/store', [TopikTAController::class, 'store'])->name('apps.topik.store');
        Route::get('/show/{id}', [TopikTAController::class, 'show'])->name('apps.topik.show');
        Route::post('/update/{id}', [TopikTAController::class, 'update'])->name('apps.topik.update');
        Route::get('/destroy/{id}', [TopikTAController::class, 'destroy'])->name('apps.topik.delete');
    });

    Route::prefix('jenis-ta')->middleware('can:read-jenis')->group(function () {
        Route::get('', [JenisTAController::class, 'index'])->name('apps.jenis-ta');
        Route::post('store', [JenisTAController::class, 'store'])->name('apps.jenis-ta.store');
        Route::get('/show/{id}', [JenisTAController::class, 'show'])->name('apps.jenis-ta.show');
        Route::post('/update/{id}', [JenisTAController::class, 'update'])->name('apps.jenis-ta.update');
        Route::get('/destroy/{id}', [JenisTAController::class, 'destroy'])->name('apps.jenis-ta.delete');
    });

    // Route::prefix('dosen')->middleware('can:read-dosen')->group(function () {
    //     Route::get('', [DosenController::class, 'index'])->name('apps.dosen');
    //     Route::post('/store', [DosenController::class, 'store'])->name('apps.dosen.store');
    //     Route::get('/show/{id}', [DosenController::class, 'show'])->name('apps.dosen.show');
    //     Route::post('/update/{id}', [DosenController::class, 'update'])->name('apps.dosen.update');
    //     Route::get('/destroy/{id}', [DosenController::class, 'destroy'])->name('apps.dosen.delete');
    //     Route::post('/import', [DosenController::class, 'import'])->name('apps.dosen.import');
    //     Route::get('/tarik-data', [DosenController::class, 'tarikData'])->name('apps.dosen.tarik-data');
    // });
    
    Route::prefix('periode')->middleware('can:read-periode')->group(function () {
        Route::get('', [PeriodeTAController::class, 'index'])->name('apps.periode');
        Route::post('store', [PeriodeTAController::class, 'store'])->name('apps.periode.store');
        Route::get('{periode}/show', [PeriodeTAController::class, 'show'])->name('apps.periode.show');
        Route::post('{periode}/update', [PeriodeTAController::class, 'update'])->name('apps.periode.update');
        Route::delete('{periode}/destroy', [PeriodeTAController::class, 'destroy'])->name('apps.periode.delete');
        Route::get('{periode}/change', [PeriodeTAController::class, 'change'])->name('apps.periode.change');
    });

    Route::prefix('daftar-ta')->group(function () {
        Route::get('', [DaftarTAController::class, 'index'])->name('apps.daftar-ta')->middleware('can:read-daftarta');
        Route::post('/store', [DaftarTAController::class, 'store'])->name('apps.daftar-ta.store');
        Route::get('/show/{id}', [DaftarTAController::class, 'show'])->name('apps.daftar-ta.show');
        Route::get('/edit/{id}', [DaftarTAController::class, 'edit'])->name('apps.daftar-ta.edit');
        Route::get('/detail/{id}', [DaftarTAController::class, 'detail'])->name('apps.daftar-ta.detail');
        Route::post('/update/{id}', [DaftarTAController::class, 'update'])->name('apps.daftar-ta.update');
        Route::get('/destroy/{id}', [DaftarTAController::class, 'destroy'])->name('apps.daftar-ta.delete');
    });

    Route::prefix('pengajuan-ta')->group(function () {
        Route::get('', [PengajuanTAController::class, 'index'])->name('apps.pengajuan-ta');
        // Route::get('/create', [PengajuanTaMahasiswaController::class, 'create'])->name('mahasiswa.pengajuan-ta.create')->middleware('can:read-pengajuanta-mahasiswa');
        // Route::post('/store', [PengajuanTaMahasiswaController::class, 'store'])->name('mahasiswa.pengajuan-ta.store');
        // Route::get('/edit/{id}', [PengajuanTaMahasiswaController::class, 'edit'])->name('mahasiswa.pengajuan-ta.edit');
        // Route::post('/update/{id}', [PengajuanTaMahasiswaController::class, 'update'])->name('mahasiswa.pengajuan-ta.update');
        // Route::get('/show/{id}', [PengajuanTaMahasiswaController::class, 'show'])->name('mahasiswa.pengajuan-ta.show');
        // Route::post('/unggah_berkas/{id}', [PengajuanTaMahasiswaController::class, 'unggah_berkas'])->name('mahasiswa.pengajuan-ta.unggah-berkas');
        // Route::get('/print_nilai/{id}', [PengajuanTaMahasiswaController::class, 'print_nilai'])->name('mahasiswa.pengajuan-ta.print_nilai');
        // Route::get('/print_rekap/{id}', [PengajuanTaMahasiswaController::class, 'print_rekap'])->name('mahasiswa.pengajuan-ta.print_rekap');
        // Route::get('/print_revisi/{id}', [PengajuanTaMahasiswaController::class, 'print_revisi'])->name('mahasiswa.pengajuan-ta.print_revisi');
        // Route::get('/cek-dosen', [PengajuanTaMahasiswaController::class, 'cekDosen'])->name('mahasiswa.pengajuan-ta.cekdosen');
        // Route::get('/print_pemb1/{id}', [PengajuanTaMahasiswaController::class, 'printPembSatu'])->name('mahasiswa.pengajuan-ta.print_pemb1');
        // Route::get('/print_pemb2/{id}', [PengajuanTaMahasiswaController::class, 'printPembDua'])->name('mahasiswa.pengajuan-ta.print_pemb2');
    });

    Route::prefix('rekomendasi-topik')->middleware('can:read-rekomendasi-topik')->group(function () {
       Route::get('', [RekomendasiTopikController::class, 'index'])->name('apps.rekomendasi-topik'); 
       Route::post('store', [RekomendasiTopikController::class, 'store'])->name('apps.rekomendasi-topik.store')->middleware('can:create-rekomendasi-topik');
       Route::get('{id}/show', [RekomendasiTopikController::class, 'show'])->name('apps.rekomendasi-topik.show'); 
    });
});


// Route::prefix('admin')->middleware(['admin'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
//     Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('admin.monitoring');
//     Route::get('/switching', [DashboardController::class, 'switching'])->name('admin.switching');
//     Route::get('/switcher/{role}', [DashboardController::class, 'switcher'])->name('admin.switcher');


//     //Dosen
//     

//     //Daftar TA
//     Route::prefix('daftarta')->group(function () {
//         Route::get('', [DaftarTaAdminController::class, 'index'])->name('admin.daftarta')->middleware('can:read-daftarta-admin');
//         Route::post('/store', [DaftarTaAdminController::class, 'store'])->name('admin.daftarta.store');
//         Route::get('/show/{id}', [DaftarTaAdminController::class, 'show'])->name('admin.daftarta.show');
//         Route::get('/edit/{id}', [DaftarTaAdminController::class, 'edit'])->name('admin.daftarta.edit');
//         Route::get('/detail/{id}', [DaftarTaAdminController::class, 'detail'])->name('admin.daftarta.detail');
//         Route::post('/update/{id}', [DaftarTaAdminController::class, 'update'])->name('admin.daftarta.update');
//         Route::get('/destroy/{id}', [DaftarTaAdminController::class, 'destroy'])->name('admin.daftarta.delete');
//     });

//     //Kuota Dosen
//     Route::prefix('kuotadosen')->group(function () {
//         Route::get('', [KuotaDosenController::class, 'index'])->name('admin.kuotadosen')->middleware('can:read-kuota');
//         Route::get('/store', [KuotaDosenController::class, 'store'])->name('admin.kuotadosen.store');
//     });

//     //Jadwal Seminar
//     Route::prefix('jadwal-seminar')->group(function () {
//         Route::get('', [JadwalSeminarController::class, 'index'])->name('admin.jadwal-seminar')->middleware('can:read-seminar-admin');
//         Route::get('/tambahkan-jadwal/{id}', [JadwalSeminarController::class, 'tambahJadwal'])->name('admin.jadwal-seminar.tambahkan-jadwal')->middleware('can:read-seminar-admin');
//         Route::post('/store/{id}', [JadwalSeminarController::class, 'store'])->name('admin.jadwal-seminar.store');
//         Route::get('/chekRuangan', [JadwalSeminarController::class, 'chekRuangan'])->name('admin.jadwal-seminar.chekRuangan');
//     });

//     //setting
//     Route::prefix('settings')->group(function () {
//         Route::get('', [SettingController::class, 'index'])->name('admin.settings')->middleware('can:read-settings');
//         Route::post('store', [SettingController::class, 'store'])->name('admin.settings.store');
//     });

// });

// Route::prefix('kaprodi')->middleware(['admin'])->group(function () {

//     //Pengajuan TA Kaprodi
//     Route::prefix('pengajuan-ta-kaprodi')->group(function () {
//         Route::get('', [PengajuanTaKaprodiController::class, 'index'])->name('kaprodi.pengajuan-ta')->middleware('can:read-pengajuanta-kaprodi');
//         Route::get('/acc/{id}', [PengajuanTaKaprodiController::class, 'acc'])->name('kaprodi.pengajuan-ta.acc');
//         Route::post('/reject/{id}', [PengajuanTaKaprodiController::class, 'reject'])->name('kaprodi.pengajuan-ta.reject');
//     });

//     //Daftar TA Kaprodi
//     Route::prefix('daftar-ta-kaprodi')->group(function () {
//         Route::get('', [DaftarTaKaprodiController::class, 'index'])->name('kaprodi.daftar-ta')->middleware('can:read-daftarta-kaprodi');
//         Route::get('/detail/{id}', [DaftarTaKaprodiController::class, 'show'])->name('kaprodi.daftar-ta.show');
//     });

//     //Daftar TA Kaprodi
//     Route::prefix('pembagian-dosen-kaprodi')->group(function () {
//         Route::get('', [PembagianDosenController::class, 'index'])->name('kaprodi.pembagian-dosen')->middleware('can:read-bagidosen-kaprodi');
//         Route::get('/edit/{id}', [PembagianDosenController::class, 'edit'])->name('kaprodi.pembagian-dosen.edit');
//         Route::post('/update/{id}', [PembagianDosenController::class, 'update'])->name('kaprodi.pembagian-dosen.update');
//     });

// });

// Route::prefix('dosen')->middleware(['admin'])->group(function () {
//     Route::prefix('daftar-bimbingan')->group(function () {
//         Route::get('', [DaftarBimbinganDosenController::class, 'index'])->name('dosen.daftar_bimbingan')->middleware('can:read-daftar-bimbingan');
//         Route::get('/show_bimbingan/{id}', [DaftarBimbinganDosenController::class, 'show_bimbingan'])->name('dosen.daftar_bimbingan.show_bimbingan');
//         Route::get('/show_uji/{id}', [DaftarBimbinganDosenController::class, 'show_uji'])->name('dosen.daftar_bimbingan.show_uji');
//         Route::get('/show_revisi/{id}', [DaftarBimbinganDosenController::class, 'show_revisi'])->name('dosen.daftar_bimbingan.show_revisi');
//         Route::get('/status_revisi/{id}', [DaftarBimbinganDosenController::class, 'status_revisi'])->name('dosen.daftar_bimbingan.status_revisi');
//     });

//     Route::prefix('jadwal-uji')->group(function () {
//         Route::get('', [JadwalUjiDosenController::class, 'index'])->name('dosen.jadwal-uji')->middleware('can:read-jadwaluji');
//         Route::get('/show/{id}', [JadwalUjiDosenController::class, 'show'])->name('dosen.jadwal-uji.show')->middleware('can:read-jadwaluji');
//         Route::get('/delete/{id}', [JadwalUjiDosenController::class, 'delete_uraian'])->name('dosen.jadwal-uji.delete');
//         Route::get('/delete-nilai/{id}', [JadwalUjiDosenController::class, 'delete_nilai'])->name('dosen.jadwal-uji.delete-nilai');
//         Route::post('/create_revisi', [JadwalUjiDosenController::class, 'create_revisi'])->name('dosen.jadwal-uji.create_revisi');
//         Route::post('/update-revisi', [JadwalUjiDosenController::class, 'update_revisi'])->name('dosen.jadwal-uji.update-revisi');
//         Route::get('/create_nilai', [JadwalUjiDosenController::class, 'create_nilai'])->name('dosen.jadwal-uji.create_nilai');
//         Route::post('/update_status_seminar', [JadwalUjiDosenController::class, 'update_status_seminar'])->name('dosen.jadwal-uji.status-update');
//     });
//     Route::prefix('rumpun-ilmu')->group(function () {
//         Route::get('', [RumpunIlmuController::class, 'index'])->name('dosen.rumpun-ilmu')->middleware('can:read-rumpunilmu');
//         Route::post('create', [RumpunIlmuController::class, 'create'])->name('dosen.rumpun-ilmu.store')->middleware('can:create-rumpunilmu');
//         Route::post('update', [RumpunIlmuController::class, 'update'])->name('dosen.rumpun-ilmu.update')->middleware('can:update-rumpunilmu');
//         Route::get('/show/{id}', [RumpunIlmuController::class, 'show'])->name('dosen.rumpun-ilmu.show')->middleware('can:read-rumpunilmu');
//         Route::get('/delete/{id}', [RumpunIlmuController::class, 'destroy'])->name('dosen.rumpun-ilmu.delete');
//     });
// });

// //mahasiswa
// Route::prefix('mahasiswa')->middleware(['admin'])->group(function () {
//     //mahasiswa pengajuan ta
//     Route::prefix('pengajuan-ta')->group(function () {
//         Route::get('', [PengajuanTaMahasiswaController::class, 'index'])->name('mahasiswa.pengajuan-ta')->middleware('can:read-pengajuanta-mahasiswa');
//         Route::get('/create', [PengajuanTaMahasiswaController::class, 'create'])->name('mahasiswa.pengajuan-ta.create')->middleware('can:read-pengajuanta-mahasiswa');
//         Route::post('/store', [PengajuanTaMahasiswaController::class, 'store'])->name('mahasiswa.pengajuan-ta.store');
//         Route::get('/edit/{id}', [PengajuanTaMahasiswaController::class, 'edit'])->name('mahasiswa.pengajuan-ta.edit');
//         Route::post('/update/{id}', [PengajuanTaMahasiswaController::class, 'update'])->name('mahasiswa.pengajuan-ta.update');
//         Route::get('/show/{id}', [PengajuanTaMahasiswaController::class, 'show'])->name('mahasiswa.pengajuan-ta.show');
//         Route::post('/unggah_berkas/{id}', [PengajuanTaMahasiswaController::class, 'unggah_berkas'])->name('mahasiswa.pengajuan-ta.unggah-berkas');
//         Route::get('/print_nilai/{id}', [PengajuanTaMahasiswaController::class, 'print_nilai'])->name('mahasiswa.pengajuan-ta.print_nilai');
//         Route::get('/print_rekap/{id}', [PengajuanTaMahasiswaController::class, 'print_rekap'])->name('mahasiswa.pengajuan-ta.print_rekap');
//         Route::get('/print_revisi/{id}', [PengajuanTaMahasiswaController::class, 'print_revisi'])->name('mahasiswa.pengajuan-ta.print_revisi');
//         Route::get('/cek-dosen', [PengajuanTaMahasiswaController::class, 'cekDosen'])->name('mahasiswa.pengajuan-ta.cekdosen');
//         Route::get('/print_pemb1/{id}', [PengajuanTaMahasiswaController::class, 'printPembSatu'])->name('mahasiswa.pengajuan-ta.print_pemb1');
//         Route::get('/print_pemb2/{id}', [PengajuanTaMahasiswaController::class, 'printPembDua'])->name('mahasiswa.pengajuan-ta.print_pemb2');
//     });

//     Route::prefix('jadwal-seminar')->group(function () {
//         Route::get('', [JadwalSeminarMahasiswaController::class, 'index'])->name('mahasiswa.jadwal-seminar')->middleware('can:read-jadwalseminar-mahasiswa');
//         Route::get('/show/{id}', [JadwalSeminarMahasiswaController::class, 'show'])->name('mahasiswa.jadwal-seminar.show')->middleware('can:read-jadwalseminar-mahasiswa');
//     });
// });

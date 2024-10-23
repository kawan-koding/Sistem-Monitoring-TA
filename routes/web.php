<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RumpunIlmuController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\DaftarTaAdminController;
use App\Http\Controllers\JadwalUjiDosenController;
use App\Http\Controllers\DaftarTaKaprodiController;
use App\Http\Controllers\PengajuanTaKaprodiController;
use App\Http\Controllers\DaftarBimbinganDosenController;
use App\Http\Controllers\PengajuanTaMahasiswaController;
use App\Http\Controllers\JadwalSeminarMahasiswaController;
use App\Http\Controllers\Administrator\Role\RoleController;
use App\Http\Controllers\Administrator\User\UserController;
use App\Http\Controllers\Administrator\Dosen\DosenController;

use App\Http\Controllers\Administrator\Jadwal\JadwalController;
use App\Http\Controllers\Administrator\JenisTA\JenisTAController;
use App\Http\Controllers\Administrator\Jurusan\JurusanController;
use App\Http\Controllers\Administrator\Profile\ProfileController;
use App\Http\Controllers\Administrator\Ruangan\RuanganController;
use App\Http\Controllers\Administrator\Setting\SettingController;
use App\Http\Controllers\Administrator\TopikTA\TopikTAController;
use App\Http\Controllers\Administrator\DaftarTA\DaftarTAController;
use App\Http\Controllers\Administrator\Template\TemplateController;
use App\Http\Controllers\Administrator\Dashboard\DashboardController;
use App\Http\Controllers\Administrator\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Administrator\PeriodeTA\PeriodeTAController;
use App\Http\Controllers\Administrator\KuotaDosen\KuotaDosenController;
use App\Http\Controllers\Administrator\PengajuanTA\PengajuanTAController;
use App\Http\Controllers\Administrator\ProgramStudi\ProgramStudiController;
use App\Http\Controllers\Administrator\JadwalSeminar\JadwalSeminarController;
use App\Http\Controllers\Administrator\KategoriNilai\KategoriNilaiController;
use App\Http\Controllers\Administrator\PembagianDosen\PembagianDosenController;
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
})->middleware('guest');
Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.process')->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('oauth', [AuthController::class, 'redirect'])->name('oauth.redirect')->middleware('guest');
Route::get('oauth/callback', [AuthController::class, 'callback'])->name('oauth.callback')->middleware('guest');
Route::get('oauth/refresh', [AuthController::class, 'refresh'])->name('oauth.refresh')->middleware('guest');

Route::prefix('apps')->middleware('auth')->group(function () {
    Route::get('switching', [AuthController::class, 'switching'])->name('apps.switching');
    Route::get('switcher/{role}', [AuthController::class, 'switcher'])->name('apps.switcher');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('apps.dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('apps.profile');
    Route::post('{user}/update', [ProfileController::class, 'update'])->name('apps.profile.update');
    Route::post('{user}/updatePassword', [ProfileController::class, 'updatePassword'])->name('apps.profile.update-password');

    Route::prefix('users')->middleware('can:read-users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('apps.users');
        Route::post('store', [UserController::class, 'store'])->name('apps.users.store')->middleware('can:create-users');
        Route::get('{user}/show', [UserController::class, 'show'])->name('apps.users.show');
        Route::post('{user}/update', [UserController::class, 'update'])->name('apps.users.update')->middleware('can:update-users');
        Route::get('{user}/delete', [UserController::class, 'destroy'])->name('apps.users.delete')->middleware('can:delete-users');
    });

    Route::prefix('roles')->middleware('can:read-roles')->group(function() {
        Route::get('', [RoleController::class, 'index'])->name('apps.roles');
        Route::get('{role}/change', [RoleController::class, 'change'])->name('apps.roles.change')->middleware('can:read-permissions');
        Route::post('{role}/change-permission', [RoleController::class, 'changePermissions'])->name('apps.roles.change-permissions')->middleware('can:change-permissions');
    });

    Route::prefix('mahasiswa')->middleware('can:read-mahasiswa')->group(function () {
        Route::get('', [MahasiswaController::class, 'index'])->name('apps.mahasiswa');
        Route::post('store', [MahasiswaController::class, 'store'])->name('apps.mahasiswa.store')->middleware('can:create-mahasiswa');
        Route::get('{mahasiswa}/show', [MahasiswaController::class, 'show'])->name('apps.mahasiswa.show');
        Route::post('{mahasiswa}/update', [MahasiswaController::class, 'update'])->name('apps.mahasiswa.update')->middleware('can:update-mahasiswa');
        Route::get('{mahasiswa}/destroy', [MahasiswaController::class, 'destroy'])->name('apps.mahasiswa.delete')->middleware('can:delete-mahasiswa');
        Route::post('import', [MahasiswaController::class, 'import'])->name('apps.mahasiswa.import')->middleware('can:import-mahasiswa');
        Route::get('export',[MahasiswaController::class, 'exportExcel'])->name('apps.mahasiswa.export');
    });

    Route::prefix('jurusan')->middleware('can:read-jurusan')->group(function () {
        Route::get('', [JurusanController::class, 'index'])->name('apps.jurusan');
        Route::post('store', [JurusanController::class, 'store'])->name('apps.jurusan.store')->middleware('can:create-jurusan');
        Route::get('{jurusan}/show', [JurusanController::class, 'show'])->name('apps.jurusan.show');
        Route::post('{jurusan}/update', [JurusanController::class, 'update'])->name('apps.jurusan.update')->middleware('can:update-jurusan');
        Route::get('{jurusan}/destroy', [JurusanController::class, 'destroy'])->name('apps.jurusan.delete')->middleware('can:delete-jurusan');
    });

    Route::prefix('program-studi')->middleware('can:read-program-studi')->group(function () {
        Route::get('', [ProgramStudiController::class, 'index'])->name('apps.program-studi');
        Route::post('store', [ProgramStudiController::class, 'store'])->name('apps.program-studi.store')->middleware('can:create-program-studi');
        Route::get('{programStudi}/show', [ProgramStudiController::class, 'show'])->name('apps.program-studi.show');
        Route::post('{programStudi}/update', [ProgramStudiController::class, 'update'])->name('apps.program-studi.update')->middleware('can:update-program-studi');
        Route::get('{programStudi}/destroy', [ProgramStudiController::class, 'destroy'])->name('apps.program-studi.delete')->middleware('can:delete-program-studi');
    });

    Route::prefix('ruangan')->middleware('can:read-ruangan')->group(function () {
        Route::get('', [RuanganController::class, 'index'])->name('apps.ruangan');
        Route::post('store', [RuanganController::class, 'store'])->name('apps.ruangan.store')->middleware('can:create-ruangan');
        Route::get('show/{id}', [RuanganController::class, 'show'])->name('apps.ruangan.show');
        Route::post('update/{id}', [RuanganController::class, 'update'])->name('apps.ruangan.update')->middleware('can:update-ruangan');
        Route::get('destroy/{id}', [RuanganController::class, 'destroy'])->name('apps.ruangan.delete')->middleware('can:delete-ruangan');
    });

    Route::prefix('topik')->middleware('can:read-topik')->group(function () {
        Route::get('', [TopikTAController::class, 'index'])->name('apps.topik');
        Route::post('/store', [TopikTAController::class, 'store'])->name('apps.topik.store')->middleware('can:create-topik');
        Route::get('/show/{id}', [TopikTAController::class, 'show'])->name('apps.topik.show');
        Route::post('/update/{id}', [TopikTAController::class, 'update'])->name('apps.topik.update')->middleware('can:update-topik');
        Route::get('/destroy/{id}', [TopikTAController::class, 'destroy'])->name('apps.topik.delete')->middleware('can:delete-topik');
    });

    Route::prefix('jenis-ta')->middleware('can:read-jenis')->group(function () {
        Route::get('', [JenisTAController::class, 'index'])->name('apps.jenis-ta');
        Route::post('store', [JenisTAController::class, 'store'])->name('apps.jenis-ta.store')->middleware('can:create-jenis');
        Route::get('/show/{id}', [JenisTAController::class, 'show'])->name('apps.jenis-ta.show');
        Route::post('/update/{id}', [JenisTAController::class, 'update'])->name('apps.jenis-ta.update')->middleware('can:update-jenis');
        Route::get('/destroy/{id}', [JenisTAController::class, 'destroy'])->name('apps.jenis-ta.delete')->middleware('can:delete-jenis');
    });

    Route::prefix('periode')->middleware('can:read-periode')->group(function () {
        Route::get('', [PeriodeTAController::class, 'index'])->name('apps.periode');
        Route::post('store', [PeriodeTAController::class, 'store'])->name('apps.periode.store')->middleware('can:create-periode');
        Route::get('{periode}/show', [PeriodeTAController::class, 'show'])->name('apps.periode.show');
        Route::post('{periode}/update', [PeriodeTAController::class, 'update'])->name('apps.periode.update')->middleware('can:update-periode');
        Route::get('{periode}/destroy', [PeriodeTAController::class, 'destroy'])->name('apps.periode.delete')->middleware('can:delete-periode');
        Route::get('{periode}/change', [PeriodeTAController::class, 'change'])->name('apps.periode.change')->middleware('can:change-periode');
    });


    Route::prefix('pengajuan-ta')->middleware('can:read-pengajuan-tugas-akhir')->group(function () {
        Route::get('', [PengajuanTAController::class, 'index'])->name('apps.pengajuan-ta');
        Route::get('create', [PengajuanTAController::class, 'create'])->name('apps.pengajuan-ta.create');
        Route::post('store', [PengajuanTAController::class, 'store'])->name('apps.pengajuan-ta.store')->middleware('can:create-pengajuan-tugas-akhir');
        Route::get('{pengajuanTA}/edit', [PengajuanTAController::class, 'edit'])->name('apps.pengajuan-ta.edit');
        Route::post('{pengajuanTA}/update', [PengajuanTAController::class, 'update'])->name('apps.pengajuan-ta.update')->middleware('can:update-pengajuan-tugas-akhir');
        Route::get('{pengajuanTA}/show', [PengajuanTAController::class, 'show'])->name('apps.pengajuan-ta.show');
        Route::post('{pengajuanTA}/unggah-berkas', [PengajuanTAController::class, 'unggah_berkas'])->name('apps.pengajuan-ta.unggah-berkas');
        Route::post('{pengajuanTA}/accept', [PengajuanTAController::class, 'accept'])->name('apps.pengajuan-ta.accept')->middleware('can:acc-pengajuan-tugas-akhir');
        Route::post('{pengajuanTA}/reject', [PengajuanTAController::class, 'reject'])->name('apps.pengajuan-ta.reject')->middleware('can:reject-pengajuan-tugas-akhir');
        Route::post('{pengajuanTA}/cancel', [PengajuanTAController::class, 'cancel'])->name('apps.pengajuan-ta.cancel')->middleware('can:cancel-pengajuan-tugas-akhir');
        // Route::get('/print_rekap/{id}', [PengajuanTAController::class, 'print_rekap'])->name('apps.pengajuan-ta.print_rekap');
        // Route::get('/print_revisi/{id}', [PengajuanTAController::class, 'print_revisi'])->name('apps.pengajuan-ta.print_revisi');
        // Route::get('/cek-dosen', [PengajuanTAController::class, 'cekDosen'])->name('apps.pengajuan-ta.cekdosen');
        // Route::get('/print_pemb1/{id}', [PengajuanTAController::class, 'printPembSatu'])->name('apps.pengajuan-ta.print_pemb1');
        // Route::get('/print_pemb2/{id}', [PengajuanTAController::class, 'printPembDua'])->name('apps.pengajuan-ta.print_pemb2');
    });

    Route::prefix('rekomendasi-topik')->middleware('can:read-rekomendasi-topik')->group(function () {
        Route::get('', [RekomendasiTopikController::class, 'index'])->name('apps.rekomendasi-topik'); 
        Route::post('store', [RekomendasiTopikController::class, 'store'])->name('apps.rekomendasi-topik.store')->middleware('can:create-rekomendasi-topik');
        Route::get('{rekomendasiTopik}/show', [RekomendasiTopikController::class, 'show'])->name('apps.rekomendasi-topik.show'); 
        Route::post('{rekomendasiTopik}/update', [RekomendasiTopikController::class, 'update'])->name('apps.rekomendasi-topik.update')->middleware('can:update-rekomendasi-topik'); 
        Route::get('{rekomendasiTopik}/delete', [RekomendasiTopikController::class, 'destroy'])->name('apps.rekomendasi-topik.delete')->middleware('can:delete-rekomendasi-topik'); 
        Route::post('{rekomendasiTopik}/mengambil-topik', [RekomendasiTopikController::class, 'ambilTopik'])->name('apps.ambil-topik');
        Route::get('{rekomendasiTopik}/detail', [RekomendasiTopikController::class, 'detail'])->name('apps.rekomendasi-topik.detail'); 
        Route::post('{rekomendasiTopik}/acc', [RekomendasiTopikController::class, 'acc'])->name('apps.rekomendasi-topik.acc');
        Route::post('{rekomendasiTopik}/reject-topik', [RekomendasiTopikController::class, 'rejectTopik'])->name('apps.rekomendasi-topik.rejcet-topik');
        Route::get('topik-yang-diambil', [RekomendasiTopikController::class, 'apply'])->name('apps.topik-yang-diambil');
        Route::get('{ambilTawaran}/hapus-topik', [RekomendasiTopikController::class, 'deleteTopik'])->name('apps.hapus-topik-yang-diambil');
        Route::post('{ambilTawaran}/accept', [RekomendasiTopikController::class, 'accept'])->name('apps.rekomendasi-topik.accept');
        Route::post('{ambilTawaran}/reject', [RekomendasiTopikController::class, 'reject'])->name('apps.rekomendasi-topik.reject');
        Route::get('{ambilTawaran}/hapus-mahasiswa-terkait', [RekomendasiTopikController::class, 'deleteMhs'])->name('apps.hapus-mahasiswa-terkait');
    });
    
    Route::prefix('dosen')->middleware('can:read-dosen')->group(function () {
        Route::get('', [DosenController::class, 'index'])->name('apps.dosen');
        Route::post('store', [DosenController::class, 'store'])->name('apps.dosen.store');
        Route::get('{dosen}/show', [DosenController::class, 'show'])->name('apps.dosen.show');
        Route::post('{dosen}/update', [DosenController::class, 'update'])->name('apps.dosen.update');
        Route::get('{dosen}/destroy', [DosenController::class, 'destroy'])->name('apps.dosen.delete');
        Route::post('import', [DosenController::class, 'import'])->name('apps.dosen.import');
        Route::get('tarik-data', [DosenController::class, 'tarikData'])->name('apps.dosen.tarik-data');
        Route::get('export', [DosenController::class, 'exportExcel'])->name('apps.dosen.export');
    });

    Route::prefix('kuota-dosen')->middleware('can:read-kuota')->group( function() {
        Route::get('', [KuotaDosenController::class, 'index'])->name('apps.kuota-dosen');
        Route::post('store', [KuotaDosenController::class, 'store'])->name('apps.kuota-dosen.store')->middleware('can:update-kuota');
        Route::post('create-all', [KuotaDosenController::class, 'createAll'])->name('apps.kuota-dosen.create-all')->middleware('can:update-kuota');
    });
    
    Route::prefix('settings')->middleware('can:read-setting')->group( function() {
        Route::get('', [SettingController::class, 'index'])->name('apps.settings');
        Route::get('{setting}/show', [SettingController::class, 'show'])->name('apps.settings.show');
        Route::post('{setting}/update', [SettingController::class, 'update'])->name('apps.settings.update')->middleware('can:update-setting');
    });
    
    Route::prefix('pembagian-dosen')->middleware('can:read-pembagian-dosen')->group( function() {
        Route::get('', [PembagianDosenController::class, 'index'])->name('apps.pembagian-dosen');
        Route::get('{tugasAkhir}/edit', [PembagianDosenController::class, 'edit'])->name('apps.pembagian-dosen.edit');
        Route::post('{tugasAkhir}/update', [PembagianDosenController::class, 'update'])->name('apps.pembagian-dosen.update')->middleware('can:update-pembagian-dosen');
    });

    Route::prefix('daftar-tugas-akhir')->middleware('can:read-daftar-ta')->group( function() {
        Route::get('', [DaftarTaController::class, 'index'])->name('apps.daftar-ta'); 
        Route::get('{tugasAkhir}/show', [DaftarTaController::class, 'show'])->name('apps.daftar-ta.show')->middleware('can:read-daftar-ta');
        Route::get('{tugasAkhir}/edit', [DaftarTaController::class, 'edit'])->name('apps.daftar-ta.edit');
        Route::post('{tugasAkhir}/update', [DaftarTaController::class, 'update'])->name('apps.daftar-ta.update')->middleware('can:update-daftar-ta');
        Route::get('{tugasAkhir}/destroy', [DaftarTaController::class, 'destroy'])->name('apps.daftar-ta.delete')->middleware('can:delete-daftar-ta');
    });

    Route::prefix('jadwal-seminar')->middleware('can:read-jadwal-seminar')->group( function() {
        Route::get('', [JadwalSeminarController::class, 'index'])->name('apps.jadwal-seminar');
        Route::post('sudah-terjadwal', [JadwalSeminarController::class, 'scheduled'])->name('apps.jadwal-seminar.sudah-terjadwal');
        Route::post('telah-seminar', [JadwalSeminarController::class, 'haveSeminar'])->name('apps.jadwal-seminar.telah-seminar');
        Route::get('{jadwalSeminar}/edit', [JadwalSeminarController::class, 'edit'])->name('apps.jadwal-seminar.edit');
        Route::post('{jadwalSeminar}/update', [JadwalSeminarController::class, 'update'])->name('apps.jadwal-seminar.update')->middleware('can:update-jadwal-seminar');
        Route::get('{jadwalSeminar}/show', [JadwalSeminarController::class, 'show'])->name('apps.jadwal-seminar.show');
        Route::get('{jadwalSeminar}/unggah-berkas', [JadwalSeminarController::class, 'uploadFile'])->name('apps.jadwal-seminar.unggah-berkas');
    });

    Route::prefix('kategori-nilai')->middleware('can:read-kategori-nilai')->group( function() {
       Route::get('', [KategoriNilaiController::class, 'index'])->name('apps.kategori-nilai');
       Route::post('store', [KategoriNilaiController::class, 'store'])->name('apps.kategori-nilai.store')->middleware('can:create-kategori-nilai');
       Route::get('{kategoriNilai}/show', [KategoriNilaiController::class, 'show'])->name('apps.kategori-nilai.show');
       Route::post('{kategoriNilai}/update', [KategoriNilaiController::class, 'update'])->name('apps.kategori-nilai.update')->middleware('can:update-kategori-nilai');
       Route::get('{kategoriNilai}/destroy', [KategoriNilaiController::class, 'destroy'])->name('apps.kategori-nilai.delete')->middleware('can:delete-kategori-nilai'); 
    });

    Route::prefix('templates')->group( function(){
        Route::get('',[TemplateController::class, 'index'])->name('apps.templates');
        Route::get('lembar-penilaian',[TemplateController::class, 'lembarPenilaian'])->name('apps.templates.lembar-penilaian');
    });
    
    Route::prefix('jadwal')->middleware('read-jadwal')->group( function(){
        Route::get('',[JadwalController::class, 'index'])->name('apps.jadwal');
    });

    Route::get('penilaian', function(){
        return view('administrator.template.lembar-penilaian');
    }); 
});

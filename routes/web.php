<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
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
use App\Http\Controllers\Administrator\Archive\ArchiveController;
use App\Http\Controllers\Administrator\JenisTA\JenisTAController;
use App\Http\Controllers\Administrator\Jurusan\JurusanController;
use App\Http\Controllers\Administrator\Panduan\PanduanController;
use App\Http\Controllers\Administrator\Profile\ProfileController;
use App\Http\Controllers\Administrator\Ruangan\RuanganController;
use App\Http\Controllers\Administrator\Setting\SettingController;
use App\Http\Controllers\Administrator\TopikTA\TopikTAController;
use App\Http\Controllers\Administrator\DaftarTA\DaftarTAController;
use App\Http\Controllers\Administrator\Dashboard\DashboardController;
use App\Http\Controllers\Administrator\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Administrator\PeriodeTA\PeriodeTAController;
use App\Http\Controllers\Administrator\KuotaDosen\KuotaDosenController;
use App\Http\Controllers\Administrator\PengajuanTA\PengajuanTAController;
use App\Http\Controllers\Administrator\JadwalSidang\JadwalSidangController;
use App\Http\Controllers\Administrator\JenisDokumen\JenisDokumenController;
use App\Http\Controllers\Administrator\ProfileDosen\ProfileDosenController;
use App\Http\Controllers\Administrator\ProgramStudi\ProgramStudiController;
use App\Http\Controllers\Administrator\JadwalSeminar\JadwalSeminarController;
use App\Http\Controllers\Administrator\KategoriNilai\KategoriNilaiController;
use App\Http\Controllers\Administrator\PembagianDosen\PembagianDosenController;
use App\Http\Controllers\Administrator\DaftarBimbingan\DaftarBimbinganController;
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

Route::middleware('guest')->group(function() {
    Route::get('',[HomeController::class, 'index'])->name('home');
    Route::get('tawaran-topik',[HomeController::class, 'topik'])->name('guest.rekomendasi-topik');
    Route::get('tugas-akhir',[HomeController::class, 'tugasAkhir'])->name('guest.judul-tugas-akhir');
    Route::get('jadwal',[HomeController::class, 'jadwal'])->name('guest.jadwal');
    Route::get('get-jadwal',[HomeController::class, 'getJadwal'])->name('guest.get-jadwal');
    Route::get('get-all-jadwal',[HomeController::class, 'getAllJadwal'])->name('guest.get-all-jadwal');
    Route::get('get-daftar-mahasiswa',[HomeController::class, 'getDaftarMahasiswa'])->name('guest.get-daftar-mahasiswa');
});

Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.process')->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('oauth', [AuthController::class, 'redirect'])->name('oauth.redirect')->middleware('guest');
Route::get('oauth/callback', [AuthController::class, 'callback'])->name('oauth.callback')->middleware('guest');
Route::get('oauth/refresh', [AuthController::class, 'refresh'])->name('oauth.refresh')->middleware('guest');

Route::prefix('apps')->middleware('auth')->group(function () {
    Route::get('switching', [AuthController::class, 'switching'])->name('apps.switching');
    Route::get('switcher/{role}', [AuthController::class, 'switcher'])->name('apps.switcher');
    Route::get('profile', [ProfileController::class, 'index'])->name('apps.profile');
    Route::post('{user}/update', [ProfileController::class, 'update'])->name('apps.profile.update');
    Route::post('{user}/updatePassword', [ProfileController::class, 'updatePassword'])->name('apps.profile.update-password');

    Route::prefix('dashboard')->group(function() {
        Route::get('', [DashboardController::class, 'index'])->name('apps.dashboard');
        Route::get('get-graduated-data', [DashboardController::class, 'getGraduatedData'])->name('apps.dashboard.get-graduated-data');
        Route::get('get-student-data', [DashboardController::class, 'getStudentData'])->name('apps.dashboard.get-student-data');
        Route::get('get-schedule-data', [DashboardController::class, 'getScheduleData'])->name('apps.dashboard.get-schedule-data');
        Route::get('export-jadwal', [DashboardController::class, 'exportJadwal'])->name('apps.dashboard.export-jadwal');
    });

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
        Route::post('{pengajuanTA}/revisi', [PengajuanTAController::class, 'revisi'])->name('apps.pengajuan-ta.revisi');
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
        Route::get('{ambilTawaran}/edit-topik', [RekomendasiTopikController::class, 'editTopik'])->name('apps.edit-topik-terkait');
        Route::post('{ambilTawaran}/update-topik', [RekomendasiTopikController::class, 'updateTopik'])->name('apps.update-topik-terkait');
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
        Route::post('create-all', [KuotaDosenController::class, 'createAll'])->name('apps.kuota-dosen.create-all')->middleware('can:update-kuota');
        Route::get('{kuotaDosen}/show', [KuotaDosenController::class, 'show'])->name('apps.kuota-dosen.show');
        Route::post('{kuotaDosen}/update', [KuotaDosenController::class, 'update'])->name('apps.kuota-dosen.update')->middleware('can:update-kuota');
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
        Route::get('export-tugas-akhir', [DaftarTaController::class, 'exportAll'])->name('apps.daftar-ta.export');
    });

    Route::prefix('jadwal-seminar')->middleware('can:read-jadwal-seminar')->group( function() {
        Route::get('', [JadwalSeminarController::class, 'index'])->name('apps.jadwal-seminar');
        Route::get('export', [JadwalSeminarController::class, 'export'])->name('apps.jadwal-seminar.export');
        Route::post('sudah-terjadwal', [JadwalSeminarController::class, 'scheduled'])->name('apps.jadwal-seminar.sudah-terjadwal');
        Route::post('telah-seminar', [JadwalSeminarController::class, 'haveSeminar'])->name('apps.jadwal-seminar.telah-seminar');
        Route::get('{jadwalSeminar}/edit', [JadwalSeminarController::class, 'edit'])->name('apps.jadwal-seminar.edit');
        Route::post('{jadwalSeminar}/update', [JadwalSeminarController::class, 'update'])->name('apps.jadwal-seminar.update')->middleware('can:update-jadwal-seminar');
        Route::get('{jadwalSeminar}/show', [JadwalSeminarController::class, 'show'])->name('apps.jadwal-seminar.show');
        Route::post('{jadwalSeminar}/unggah-berkas', [JadwalSeminarController::class, 'uploadDocument'])->name('apps.jadwal-seminar.unggah-berkas');
        Route::get('{jadwalSeminar}/detail', [JadwalSeminarController::class, 'detail'])->name('apps.jadwal-seminar.detail');
        Route::get('{jadwalSeminar}/show', [JadwalSeminarController::class, 'show'])->name('apps.jadwal-seminar.show');
        Route::post('{jadwalSeminar}/validate', [JadwalSeminarController::class, 'validasiBerkas'])->name('apps.jadwal-seminar.validate');
        Route::get('{jadwalSeminar}/reset', [JadwalSeminarController::class, 'reset'])->name('apps.jadwal-seminar.reset');
    });

    Route::prefix('kategori-nilai')->middleware('can:read-kategori-nilai')->group( function() {
       Route::get('', [KategoriNilaiController::class, 'index'])->name('apps.kategori-nilai');
       Route::post('store', [KategoriNilaiController::class, 'store'])->name('apps.kategori-nilai.store')->middleware('can:create-kategori-nilai');
       Route::get('{kategoriNilai}/show', [KategoriNilaiController::class, 'show'])->name('apps.kategori-nilai.show');
       Route::post('{kategoriNilai}/update', [KategoriNilaiController::class, 'update'])->name('apps.kategori-nilai.update')->middleware('can:update-kategori-nilai');
       Route::get('{kategoriNilai}/destroy', [KategoriNilaiController::class, 'destroy'])->name('apps.kategori-nilai.delete')->middleware('can:delete-kategori-nilai');
    });

    Route::prefix('jadwal')->middleware('can:read-jadwal-seminar')->group( function(){
        Route::get('{jenis?}',[JadwalController::class, 'index'])->name('apps.jadwal');
        Route::get('{jadwal}/penilaian',[JadwalController::class, 'evaluation'])->name('apps.jadwal.penilaian');
        Route::post('{jadwal}/revisi',[JadwalController::class, 'revisi'])->name('apps.jadwal.revisi');
        Route::post('{jadwal}/nilai',[JadwalController::class, 'nilai'])->name('apps.jadwal.nilai');
        Route::post('{jadwal}/update-status',[JadwalController::class, 'updateStatus'])->name('apps.jadwal.update-status');
        Route::get('{revisi}/revision-valid', [JadwalController::class, 'revisionValid'])->name('apps.jadwal.revision-valid');
        Route::get('{revisi}/mentor-validation', [JadwalController::class, 'mentorValidation'])->name('apps.jadwal.mentor-validation');
    });

    Route::prefix('cetak')->group( function(){
        Route::get('{jadwal}/revisi',[JadwalController::class, 'cetakRevisi'])->name('apps.cetak.revisi');
        Route::get('{jadwal}/nilai',[JadwalController::class, 'cetakNilai'])->name('apps.cetak.nilai');
        Route::get('{jadwal}/rekapitulasi',[JadwalController::class, 'cetakRekap'])->name('apps.cetak.rekapitulasi');
    });

    Route::prefix('daftar-bimbingan')->middleware('can:read-daftar-bimbingan')->group( function(){
        Route::get('', [DaftarBimbinganController::class, 'index'])->name('apps.daftar-bimbingan');
        Route::get('{bimbingUji}/show', [DaftarBimbinganController::class, 'show'])->name('apps.daftar-bimbingan.show');
    });

    Route::prefix('jenis-dokumen')->middleware('can:read-jenis-dokumen')->group( function() {
        Route::get('',[JenisDokumenController::class,'index'])->name('apps.jenis-dokumen');
        Route::post('store', [JenisDokumenController::class, 'store'])->name('apps.jenis-dokumen.store')->middleware('can:create-jenis-dokumen');
        Route::get('{jenisDokumen}/show', [JenisDokumenController::class, 'show'])->name('apps.jenis-dokumen.show');
        Route::post('{jenisDokumen}/update', [JenisDokumenController::class, 'update'])->name('apps.jenis-dokumen.update')->middleware('can:update-jenis-dokumen');
        Route::get('{jenisDokumen}/destroy', [JenisDokumenController::class, 'destroy'])->name('apps.jenis-dokumen.delete')->middleware('can:delete-jenis-dokumen');
    });

    Route::prefix('jadwal-sidang')->middleware('can:read-daftar-sidang')->group( function() {
       Route::get('{jenis?}',[JadwalSidangController::class,'index'])->name('apps.jadwal-sidang');
       Route::get('{sidang}/detail',[JadwalSidangController::class,'show'])->name('apps.jadwal-sidang.detail');
       Route::post('{sidang}/daftar-sidang',[JadwalSidangController::class,'register'])->name('apps.jadwal-sidang.register');
       Route::post('{sidang}/unggah-berkas',[JadwalSidangController::class,'uploadfile'])->name('apps.jadwal-sidang.unggah-berkas');
       Route::post('{jadwalSidang}/update',[JadwalSidangController::class,'update'])->name('apps.jadwal-sidang.update');
       Route::get('{jadwalSidang}/edit',[JadwalSidangController::class,'edit'])->name('apps.jadwal-sidang.edit');
       Route::post('{jadwalSidang}/validasi-berkas',[JadwalSidangController::class,'validasiBerkas'])->name('apps.jadwal-sidang.validasi-berkas');
       Route::post('{sidang}/nilai', [JadwalSidangController::class, 'nilai'])->name('apps.jadwal-sidang.nilai');
       Route::post('{sidang}/revisi', [JadwalSidangController::class, 'revisi'])->name('apps.jadwal-sidang.revisi');
       Route::post('{sidang}/update-status', [JadwalSidangController::class, 'updateStatus'])->name('apps.jadwal-sidang.update-status');
       Route::get('{sidang}/revisi', [JadwalSidangController::class, 'cetakRevisi'])->name('apps.jadwal-sidang.revisi');
       Route::get('{sidang}/nilai', [JadwalSidangController::class, 'cetakNilai'])->name('apps.jadwal-sidang.nilai');
       Route::get('{sidang}/rekapitulasi', [JadwalSidangController::class, 'cetakRekap'])->name('apps.jadwal-sidang.rekapitulasi');
       Route::get('{revisi}/revision-valid', [JadwalSidangController::class, 'revisionValid'])->name('apps.jadwal-sidang.revision-valid');
       Route::get('{revisi}/mentor-validation', [JadwalSidangController::class, 'mentorValidation'])->name('apps.jadwal-sidang.mentor-validation');
       Route::get('{sidang}/show-data',[JadwalSidangController::class,'showData'])->name('apps.jadwal-sidang.show-data');
    });
    Route::get('export-jadwal-sidang', [JadwalSidangController::class,'export'])->name('apps.jadwal-sidang.export');

    Route::prefix('profile-dosen')->group( function() {
       Route::get('',[ProfileDosenController::class,'index'])->name('apps.profile-dosen');
    });

    Route::prefix('archives')->group( function() {
       Route::get('',[ArchiveController::class,'index'])->name('apps.archives');
       Route::get('{tugasAkhir}/show', [ArchiveController::class, 'show'])->name('apps.archives.show');
    });

    Route::get('guide', [PanduanController::class, 'index'])->name('apps.guide');

    Route::get('coming-soon', function(){
        return view('errors.coming-soon');
    })->name('apps.coming-soon');
});

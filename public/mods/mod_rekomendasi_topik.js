function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/store`);
    $('#myModalLabel').html('Tambah Rekomendasi Topik')
    $('#judul').val('')
    $('#deskripsi').val('')
    $('#jenis_ta_id').val('')
    $('#program_studi_id').val('')
    $('#kuota').val('')
    $('#tipe').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/${id}/update`);
    $('#myModalLabel').html('Ubah Rekomendasi Topik')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#judul').val(response.judul)
            $('#kuota').val(response.kuota)
            $('#tipe').val(response.tipe)
            $('#deskripsi').val(response.deskripsi)
            $('#jenis_ta_id').val(response.jenis_ta_id)
            $('#program_studi_id').val(response.program_studi_id)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

$(document).ready(function() {
    $(document).on('click', '*[data-toggle="get-topik"]', function () {
        const id = $(this).data('id');
        $('#myImportFormulir').attr('action', `${BASE_URL}/apps/rekomendasi-topik/${id}/mengambil-topik`);
        $('#myModalLabelApply').html('Ambil Topik');
        $('#description').val('');
        $('#myModalApply').modal('show');
    });



    $(document).on('click', '*[data-toggle="reject-mhs"]', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        Swal.fire({
            title: "Tolak Mahasiswa?",
            text: "Apakah kamu yakin untuk menolak data ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            // cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Saya Yakin!"
        }).then((result) => {
            if (result.value) {
                $('#approveForm').attr('action', url).attr('method', 'POST').submit();
            }
        });
    });

    $(document).on('click', '*[data-toggle="approve-mhs"]', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        Swal.fire({
            title: "Setujui Mahasiswa?",
            text: "Apakah kamu yakin untuk menyetujui data ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Saya Yakin!"
        }).then((result) => {
            if (result.value) {
                $('#approveForm').attr('action', url).attr('method', 'POST').submit();;
            }
        });
    });
    
    $(document).on('click', '*[data-toggle="reject-topik"]', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('#modalReject').find('form').attr('action', url);
        $('#modalReject').find('.modal-title').html('Tolak Topik?');
        $('#modalReject').modal('show');
        $('#catatan').val('');
    });

    $(document).on('click', '*[data-toggle="acc"]', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        Swal.fire({
            title: "Setujui Topik?",
            text: "Apakah kamu yakin untuk menyetujui data ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Saya Yakin!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        window.location.reload();
                    }
                });
            }
        });
    });

    $('#jenis_ta_id').on('change', function () {
        let selectedValue = $(this).val();
        if (selectedValue === 'lainnya') {
            $('#new_jenis').show();
        } else {
            $('#new_jenis').hide();
        }
    });
});

function hapusRekomendasi(e, url) {
    Swal.fire({
        title: "Hapus Topik yang ditawarkan?",
        text: "Apakah kamu yakin untuk menghapus data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON.message
                    });
                }
            });
        }
    });
}

function hapusTopikTerkait(e, url) {
    Swal.fire({
        title: "Hapus Topik yang diambil?",
        text: "Apakah kamu yakin untuk menghapus data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON.message
                    });
                }
            });
        }
    });
}

function hapusMahasiswaTerkait(e, url) {
     Swal.fire({
         title: "Hapus Mahasiswa?",
         text: "Apakah kamu yakin untuk menghapus data ini!",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Hapus!"
     }).then((result) => {
         if (result.value) {
             $.ajax({
                 url: url,
                 type: "GET",
                 success: function (data) {
                     Swal.fire({
                         icon: 'success',
                         title: 'Berhasil!',
                         text: data.message
                     }).then(() => {
                         window.location.reload();
                     });
                 },
                error: function (xhr) {
                    Swal.fire({
                         icon: 'error',
                         title: 'Oops...',
                         text: xhr.responseJSON.message
                    });
                }
            });
        }
    });
};

function editTopikTerkait(id, urlShow) {
    $('#myModalAction').attr("action", `${BASE_URL}/apps/rekomendasi-topik/${id}/update-topik`);
    $('#myModalLabelApply').html('Ubah Topik Yang Diambil');
    
    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#description').val(response.description);
            if (response.file) {
                $('#documentLink').html(`
                    <a href = "${BASE_URL}/storage/files/apply-topik/${response.file}"target = "_blank" class="text-primary small">Lihat Dokumen</a>
                `);
            } else {
                // Sembunyikan link jika tidak ada dokumen
                $('#documentLink').html('');
            }
        },

        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModalApply').modal('show');
}
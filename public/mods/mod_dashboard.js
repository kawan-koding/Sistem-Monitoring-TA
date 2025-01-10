
$(document).ready(function () {
    var isDragging = false;
    var startX, scrollLeft;

    $('[data-role="resizable-item"]').on("mousedown", function (e) {
        isDragging = true;
        startX = e.pageX - $(this).offset().left;
        scrollLeft = $('[data-role="resizable-container"]').scrollLeft();
        $(this).css("cursor", "grabbing"); // Ubah kursor saat dragging
    });

    $('[data-role="resizable-item"]').on("mouseleave mouseup", function () {
        isDragging = false;
        $(this).css("cursor", "grab"); // Kembalikan kursor
    });

    $('[data-role="resizable-item"]').on("mousemove", function (e) {
        if (!isDragging) return;
        e.preventDefault();
        var x = e.pageX - $(this).offset().left;
        var walk = (x - startX) * 0.8; // Kecepatan scroll, bisa diubah sesuai keinginan
        $('[data-role="resizable-container"]').scrollLeft(scrollLeft - walk);
    });

    // Memastikan item dengan class 'active' berada di kiri
    currentScrollActived();

    // event to move date actived
    $(".date-item")
        .unbind()
        .on("click", function (e) {
            e.preventDefault();
            $(".date-item.active").removeClass("active");
            $(this).addClass("active");
            currentScrollActived();
            getScheduleData();
        });

    // getting schedule data
    getScheduleData();
});

async function getScheduleData(data = null) {
    var date = $(".date-item.active").data("value");
    var renderComponent = $("#schedule-content");
    var res;

    if (data == null) {
        res = await fetch(
            `${BASE_URL}/apps/dashboard/get-schedule-data?date=${date}`
        );
    }

    if (data != null || res.status == 200) {
        if (data == null) {
            data = await res.json();
        }

        var render = ``;

        if (data.data.length == 0) {
            render += `
                <div class="d-flex align-items-center justify-content-center py-5">
                    <div class="text-center py-5">
                        <img src="${ASSET_URL}assets/images/no-data.png" height="350" alt="">
                        <p class="text-muted m-0">Tidak ada jadwal yang ditemukan.</p>
                    </div>
                </div>
            `;
        } else {
            render += `
                <table class="table zero-configuration" style="font-size: 14px!important">
                    <thead>
                        <th>No.</th>
                        <th>Nama</th>
                        <th style="min-width: 250px">Judul</th>
                        <th>Pembimbing</th>
                        <th>Penguji</th>
                        <th>Waktu dan Tempat</th>
                    </thead>
                    <tbody>`;

            for (var i = 0; i < data.data.length; i++) {
                var item = data.data[i];

                render += `
                    <tr>
                        <td width="25">${i + 1}</td>
                        <td style="white-space: nowrap">
                            <span class="badge badge-soft-info">${ucfirst(
                                item.type
                            )}</span>
                            <span class="badge badge-soft-primary">${ucfirst(
                                item.tugas_akhir.mahasiswa.program_studi.display
                            )}</span>
                            <span class="badge badge-soft-secondary">${ucfirst(
                                item.tugas_akhir.tipe == "I"
                                    ? "Individu"
                                    : "Kelompok"
                            )}</span>
                            <p class="m-0 p-0">${
                                item.tugas_akhir.mahasiswa.nim
                            } - ${item.tugas_akhir.mahasiswa.nama_mhs}</p>
                        </td>
                        <td>${item.tugas_akhir.judul}</td>
                        <td style="white-space: nowrap">
                            <ol>
                                ${item.tugas_akhir.bimbing_uji
                                    .filter(
                                        (bimbing) =>
                                            bimbing.jenis == "pembimbing"
                                    )
                                    .map(
                                        (bimbing) =>
                                            `<li>${bimbing.dosen.name}</li>`
                                    )
                                    .join("")}
                            </ol>
                        </td>
                        <td style="white-space: nowrap">
                            <ol>
                                ${item.tugas_akhir.bimbing_uji
                                    .filter(
                                        (bimbing) => bimbing.jenis == "penguji"
                                    )
                                    .map(
                                        (bimbing) =>
                                            `<li>${bimbing.dosen.name}</li>`
                                    )
                                    .join("")}
                            </ol>
                        </td>
                        <td class="text-center">
                            <strong>${
                                item.ruangan?.nama_ruangan ?? "-"
                            }</strong>
                            <p class="m-0">${formatTime(
                                item.jam_mulai ?? "99:99:99"
                            )} - ${formatTime(
                    item.jam_selesai ?? "99:99:99"
                )}</p>
                </td>`;
            }

            render += `</tbody>
                </table>`;
        }

        renderComponent.html(render);

        var timeout;

        $('[data-role="schedule-search"]')
            .unbind()
            .on("input", function () {
                var keyword = $(this).val();
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    data.data = data.data.filter(
                        (item) =>
                            item.tugas_akhir.judul
                                .toLowerCase()
                                .includes(keyword.toLowerCase()) ||
                            item.tugas_akhir.mahasiswa.nama_mhs
                                .toLowerCase()
                                .includes(keyword.toLowerCase()) ||
                            item.tugas_akhir.mahasiswa.nim
                                .toLowerCase()
                                .includes(keyword.toLowerCase()) ||
                            item.tugas_akhir.bimbing_uji
                                .filter((bimbing) => bimbing.dosen.name.toLowerCase().includes(keyword.toLowerCase())).length > 0 ||
                            item.ruangan.nama_ruangan
                                .toLowerCase()
                                .includes(keyword.toLowerCase())

                    );
                    getScheduleData(keyword != '' ? data : null);
                }, 500);
            });
        return;
    }

    swal.fire({
        title: "Oops!",
        text: "Gagal memuat data jadwal seminar / sidang",
        type: "warning",
    });
}

function currentScrollActived() {
    var activeItem = $('[data-role="resizable-item"] > .active');
    var containerLeft = $('[data-role="resizable-container"]').offset().left;
    var activeItemLeft = activeItem.offset().left;

    if (activeItemLeft > containerLeft) {
        // Jika elemen aktif keluar dari layar di sebelah kiri, scroll ke kiri
        $('[data-role="resizable-container"]').animate(
            {
                scrollLeft:
                    $('[data-role="resizable-container"]').scrollLeft() -
                    (containerLeft - activeItemLeft),
            },
            1000
        );
    }
}

function formatTime(timeString) {
    // Split the time string by the colon `:`
    const [hours, minutes] = timeString.split(":");

    // Return the formatted time as H:i
    return hours == "99" && minutes == "99" ? "-" : `${hours}:${minutes}`;
}

function ucfirst(str) {
    if (!str) return str; // Handle empty string cases
    return str.charAt(0).toUpperCase() + str.slice(1);
}

$(".chevron-button").on("click", function () {
    const direction = $(this).data("direction");
    const scrollAmount = direction === "left" ? "-=600" : "+=600";

    $('[data-role="resizable-container"]').animate({
        scrollLeft: scrollAmount,
    }, 300);
});

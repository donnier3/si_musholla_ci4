<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tabel Video</h4>
                    <button class="btn btn-primary btn-sm btn-round ml-auto btnAdd" data-toggle="modal" data-target="#addRowModal">
                        <i class="fa fa-plus-circle"></i> &nbsp; Add Video
                    </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="tblvideo" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kategori Video</th>
                                <th>Judul Video</th>
                                <th>Hist</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function daftarvideo() {
        var table = $('#tblvideo').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/auth/video/listvideo",
                "type": "POST"
            },
            "oLanguage": {
                "sEmptyTable": "Tidak ada data pada tabel"
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false
            }],
        })
    }

    $(document).ready(function() {
        daftarvideo();

        $('.date').datepicker({
            todayBtn: "linked",
            language: "id",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            orientation: 'bottom'
        });

        $('.btnAdd').on('click', function(e) {
            $.ajax({
                url: "/auth/video/modalTambahvideo",
                dataType: "json",
                beforeSend: function() {
                    $('.btnAdd').attr('disabled', true);
                    $('.btnAdd').html('<i class="fas fa-spin fa-spinner"></i> Process..');
                },
                complete: function() {
                    $('.btnAdd').attr('disabled', false);
                    $('.btnAdd').html('<i class="fas fa-plus-circle"></i> &nbsp; Add video ');
                },
                success: function(response) {
                    $('.view-modal').html(response.data).show();
                    $('#modal-tambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

    function ajax_edit(id_video) {
        $.ajax({
            type: "post",
            url: "/auth/video/editvideo",
            data: {
                id_video: id_video
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.view-modal').html(response.sukses).show();
                    $('#modal-edit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function ajax_view(id_video) {
        $.ajax({
            type: "post",
            url: "/auth/video/viewfile",
            data: {
                id_video: id_video
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.view-modal').html(response.sukses).show();
                    $('#modal-view').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function ajax_delete(id_video, judul_video, file_video) {
        swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus video " + judul_video + " ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: "Tidak"
        }).then((result) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            });
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "/auth/video/delete_video",
                    data: {
                        id_video: id_video,
                        file_video: file_video
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Toast.fire({
                                icon: 'success',
                                title: response.sukses
                            })
                            data_video();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
</script>
@extends('admin.template.master')

@section('title', "$subtitle $title")

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ $subtitle }}</li>
                        <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-info mr-2" id="btnCetakLabel">
                            <i class="fas fa-print"></i> Cetak Label
                        </button>
                        <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produks as $produk)
                                <tr>
                                    <td class="text-center">
                                        <input class="form-check-input" name="id_produk[]" type="checkbox" value="{{ $produk->id }}">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $produk->NamaProduk }}</td>
                                    <td>{{ rupiah($produk->Harga) }}</td>
                                    <td>{{ $produk->Stok }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="form-delete-produk d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-warning btnTambahStok"
                                                data-toggle="modal"
                                                data-target="#modalTambahStok"
                                                data-id_produk="{{ $produk->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Tambah Stok --}}
    <div class="modal fade" id="modalTambahStok" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-tambah-stok" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Stok</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_produk" id="id_produk">
                        <label>Jumlah Stok</label>
                        <input type="number" name="Stok" id="nilaiTambahStok" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    {{-- DataTables --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    {{-- SweetAlert2 & Logic --}}
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        // Konfirmasi hapus
        $(document).on('submit', '.form-delete-produk', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Set ID produk di modal
        $(document).on('click', '.btnTambahStok', function() {
            $('#id_produk').val($(this).data('id_produk'));
        });

        // Submit tambah stok
        $('#form-tambah-stok').submit(function(e) {
            e.preventDefault();
            let dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";
            $.ajax({
                type: "PUT",
                url: "{{ route('produk.tambahStok', ':id') }}".replace(':id', $('#id_produk').val()),
                data: dataForm,
                dataType: "json",
                success: function(data) {
                    Swal.fire('Sukses', data.message, 'success').then(() => {
                        location.reload();
                    });
                    $('#modalTambahStok').modal('hide');
                    $('#form-tambah-stok')[0].reset();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON.message ?? 'Terjadi kesalahan.', 'error');
                }
            });
        });

        // Cetak label
        $('#btnCetakLabel').click(function() {
            let id_produk = [];
            $('input[name="id_produk[]"]:checked').each(function() {
                id_produk.push($(this).val());
            });
            if (id_produk.length === 0) {
                Swal.fire('Peringatan', 'Pilih produk terlebih dahulu!', 'warning');
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ route('produk.cetakLabel') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_produk: id_produk
                },
                dataType: "json",
                success: function(data) {
                    window.open(data.url, '_blank');
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON.message ?? 'Terjadi kesalahan.', 'error');
                }
            });
        });

        // Check All
        $('#checkAll').click(function () {
            $('input[name="id_produk[]"]').prop('checked', this.checked);
        });
    </script>
@endsection

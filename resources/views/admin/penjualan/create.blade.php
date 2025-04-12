@extends('admin.template.master')

@section('title', $title)

@section('css')
    <!-- DataTables -->
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
                        <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>
                        <li class="breadcrumb-item active">{{ $subtitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-warning float-right">Kembali</a>
                </div>
                <form action="{{ route('penjualan.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="penjualan">
                                <tr>
                                    <td>
                                        <select name="ProdukId[]" class="form-control kode-produk" onchange="pilihProduk(this)">
                                            <option value="">Pilih Produk</option>
                                            @foreach ($produks as $produk)
                                                <option value="{{ $produk->id }}" data-harga="{{ $produk->Harga }}">{{ $produk->NamaProduk }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="harga[]" class="form-control harga" readonly></td>
                                    <td><input type="number" name="JumlahProduk[]" class="form-control jumlahProduk" oninput="hitungTotal(this)"></td>
                                    <td><input type="text" name="TotalHarga[]" class="form-control totalHarga" readonly></td>
                                    <td><button type="button" class="btn btn-danger" onclick="hapusProduk(this)">Hapus</button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Total harga</td>
                                    <td colspan="2">
                                        <input type="text" id="total" name="total" class="form-control" readonly>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" class="btn btn-primary mt-3" onclick="tambahProduk()">Tambah Produk</button>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
    <!-- DataTables & AdminLTE Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script>
        function tambahProduk() {
            const row = `
            <tr>
                <td>
                    <select name="ProdukId[]" class="form-control kode-produk" onchange="pilihProduk(this)">
                        <option value="">Pilih Produk</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}" data-harga="{{ $produk->Harga }}">{{ $produk->NamaProduk }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="harga[]" class="form-control harga" readonly></td>
                <td><input type="number" name="JumlahProduk[]" class="form-control jumlahProduk" oninput="hitungTotal(this)"></td>
                <td><input type="text" name="TotalHarga[]" class="form-control totalHarga" readonly></td>
                <td><button type="button" class="btn btn-danger" onclick="hapusProduk(this)">Hapus</button></td>
            </tr>`;
            $('#penjualan').append(row);
        }

        function hapusProduk(button) {
            $(button).closest('tr').remove();
            hitungTotalAkhir();
        }

        function pilihProduk(select) {
            const row = $(select).closest('tr');
            const harga = $('option:selected', select).data('harga');
            const selectedId = $(select).val();

            const isDuplicate = $(".kode-produk").not(select).filter((_, el) => el.value === selectedId).length > 0;

            if (isDuplicate) {
                alert('Produk sudah dipilih');
                $(select).val('');
                row.find('.harga').val('');
                return;
            }

            row.find('.harga').val(harga);
        }

        function hitungTotal(input) {
            const row = $(input).closest('tr');
            const harga = parseFloat(row.find('.harga').val());
            const jumlah = parseFloat($(input).val());
            const total = harga * jumlah;
            row.find('.totalHarga').val(total || 0);
            hitungTotalAkhir();
        }

        function hitungTotalAkhir() {
            let total = 0;
            $('.totalHarga').each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            $('#total').val(total);
        }
    </script>
@endsection

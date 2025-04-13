@extends('admin.template.master')

@section('title', "$subtitle $title")

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
            <h3 class="card-title m-0">{{ $title }}</h3>
            <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-primary">
              <i class="fas fa-plus"></i> Tambah Penjualan
            </a>
          </div>

          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table id="penjualanTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal Penjualan</th>
                  <th>Harga</th>
                  <th>Penjual</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($penjualans as $penjualan)
                  <tr>
                    <td></td> {{-- Kolom nomor diisi otomatis oleh DataTables --}}
                    <td>{{ $penjualan->TanggalPenjualan }}</td>
                    <td>{{ rupiah($penjualan->TotalHarga) }}</td>
                    <td>{{ $penjualan->name }}</td>
                    <td>
                      @if ($penjualan->StatusBayar == 'Lunas')
                        <a href="{{ route('penjualan.nota', $penjualan->id) }}" class="btn btn-sm btn-success" target="_blank">
                          <i class="fas fa-receipt"></i> Nota
                        </a>
                      @else
                        <a href="{{ route('penjualan.bayarCash', $penjualan->id) }}" class="btn btn-sm btn-secondary">
                          <i class="fas fa-money-bill-wave"></i> Bayar
                        </a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('js')
  <!-- DataTables & Plugins -->
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

  <script>
    $(function () {
      let dt_buttons = [
        {
          extend: 'excelHtml5',
          text: '<i class="far fa-file-excel"></i> Export Excel',
          titleAttr: 'Export ke Excel',
        },
        {
          extend: 'print',
          text: '<i class="fas fa-print"></i> Print',
          titleAttr: 'Print tabel',
        },
        {
          extend: 'colvis',
          text: 'Tampilan Kolom',
          titleAttr: 'Pilih Kolom',
        }
      ];

      let table = $("#penjualanTable").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        order: [[1, 'desc']],
        buttons: dt_buttons,
        columnDefs: [
          {
            targets: 0,
            searchable: false,
            orderable: false,
          }
        ],
        language: {
          search: '<i class="fas fa-search"></i>',
          searchPlaceholder: 'Cari data...'
        }
      });

      // Otomatis isi kolom nomor urut
      table.on('order.dt search.dt draw.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1;
        });
      }).draw();

      table.buttons().container().appendTo('#penjualanTable_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection

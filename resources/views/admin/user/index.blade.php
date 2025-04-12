@extends('admin.template.master')

@section('title', "$subtitle $title")

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
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0">{{ $title }}</h3>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </a>
          </div>

          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="userTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Dibuat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{!! badge_role($user->role) !!}</td>
                    <td>{{ date_formater($user->created_at) }}</td>
                    <td>
                      <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block form-delete-user">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
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

      $("#userTable").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        order: [[3, 'desc']],
        buttons: dt_buttons,
        language: {
          search: '<i class="fas fa-search"></i>',
          searchPlaceholder: 'Cari data...'
        }
      }).buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');

      $(document).on('submit', '.form-delete-user', function (e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
          title: 'Yakin ingin menghapus?',
          text: 'Data yang dihapus tidak bisa dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
@endsection

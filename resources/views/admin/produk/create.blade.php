@extends('admin.template.master')

@section('css')
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
                    <a href="{{ route('produk.index') }}" class="btn btn-sm btn-warning float-right">Kembali</a>
                </div>
                <div class="card-body">
                    <form id="form-create-produk" method="post">
                        <label for="">Nama Produk</label>
                        <input type="text" name="NamaProduk" class="form-control" required>
                        <label for="">Harga</label>
                        <input type="number" name="Harga" class="form-control" required>
                        <label for="">Stok</label>
                        <input type="number" name="Stok" class="form-control" required>
                        <button class="btn btn-primary mt-3" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $("#form-create-produk").submit(function (e) {
            e.preventDefault();
            const dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";

            $.ajax({
                type: "POST",
                url: "{{ route('produk.store') }}",
                data: dataForm,
                dataType: "json",
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('produk.index') }}";
                        }
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message ?? 'Terjadi kesalahan.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endsection

@extends('layouts.main')

@section('content')

@auth
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Tambah Data Pengampu</h3>
            </div>
            <div class="card-header">

                <form action="/support/store" method="post">
                    {{ csrf_field() }}

                    Masukan Semester
                    <select name="semester" id="semesterDropdown" class="form-control">
                        <option value="">== Pilih Semester ==</option>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                    <!-- <select id="semesterDropdown" name="semester">
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select> -->
                    <br>
                    Masukan Mata Kuliah
                    <select id="mataKuliahDropdown" name="mata_kuliah" class="form-control">
                        <!-- Opsi mata kuliah akan di-generate menggunakan JavaScript -->
                    </select>


                    <br>
                    Masukan Dosen
                    <select name="kode_dosen" id="kode_dosen" class="form-control">
                        <option value="">== Pilih Dosen ==</option>
                        @foreach ($lecture as $key => $value)

                        <option value="{{ $value->kode }}">{{ $value->nama }}</option>
                        @endforeach
                    </select>
                    <br>
                    Masukan Kelas <input type="text" name="kelas" required="required" class="form-control">


                    <br>
                    Tahun Akademik <input type="text" name="tahun_akademik" required="required" class="form-control">
                    <br>

                    <a href="/support">

                        <button type="button" class="btn btn-danger">Kembali</button>
                    </a>
                    <a href="/support">

                        <button type="submit" class="btn btn-success">Simpan</button>
                    </a>
                </form>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#mataKuliahDropdown").attr("disabled", true);
                        $('#semesterDropdown').change(function() {
                            var selectedSemester = $(this).val();
                            // console.log(selectedSemester, 'getMatkul')
                            // Kirim permintaan AJAX ke endpoint Laravel untuk mendapatkan data mata kuliah berdasarkan semester
                            $.ajax({
                                url: '{{ route("getMataKuliahBySemester") }}',
                                method: 'GET',
                                data: {
                                    semester: selectedSemester
                                },
                                success: function(response) {
                                    $("#mataKuliahDropdown").attr("disabled", false);

                                    // Hapus semua opsi mata kuliah yang ada sebelumnya
                                    $('#mataKuliahDropdown').empty();

                                    // Tambahkan opsi mata kuliah baru berdasarkan data yang diterima
                                    $.each(response, function(key, value) {
                                        console.log(value)

                                        $('#mataKuliahDropdown').append('<option value="' + key + '">' + value + '</option>');
                                    });
                                }
                            });
                        });
                    });
                </script>

                @endauth

                @guest

                <p>guest day</p>
                @endguest
            </div>
            @endsection

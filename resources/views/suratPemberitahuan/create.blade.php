@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tambah Surat Pemberitahuan</h1>
    </div>
</section>
<form class="main-form" action="{{route('suratPemberitahuan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3" id="jenis_surat">
        <label for="" class="form-label">Jenis Surat</label>
        <input type="text" name="jenis_surat" placeholder="Surat Pemberitahuan" class="form-control @error('jenis_surat') is-invalid @enderror" value="{{ old('jenis_surat') }}">
        @error('jenis_surat')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <input type="hidden" name="no_surat" placeholder="Nomor Surat" id="no_surat" class="form-control @error('no_surat') is-invalid @enderror">
        @error('no_surat')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Kode Instansi</label>
        <select name="kode_instansi" class="form-control @error('kode_instansi') is-invalid @enderror" value="{{ old('kode_instansi') }}" id="kode_instansi">
            <option value="">Kode Instansi</option>
            @foreach ($instansis as $value)
            <option value="{{ $value->id }}" {{ old('kode_instansi') == $value->id ? 'selected' : null }}> {{$value->kode_instansi}} </option>
            @endforeach
        </select>
        @error('kode_instansi')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3" id="tempat_surat">
        <label for="" class="form-label">Tempat</label>
        <input type="text" name="tempat_surat" placeholder="Tempat Surat" class="form-control @error('tempat_surat') is-invalid @enderror" value="{{ old('tempat_surat') }}">
        @error('tempat_surat')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3" id="tanggal_surat">
        <label for="" class="form-label">Tanggal Surat</label>
        <input type="date" name="tanggal_surat" placeholder="Tanggal Surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat') }}">
        @error('tanggal_surat')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3" id="pengirim">
        <label for="" class="form-label">Pengirim</label>
        <input type="text" name="pengirim" placeholder="Pengirim Surat" class="form-control @error('pengirim') is-invalid @enderror" id="pengirim" value="{{ old('pengirim') }}">
        @error('pengirim')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3" id="perihal">
        <label for="" class="form-label">Perihal</label>
        <input type="text" name="perihal" placeholder="Perihal" class="form-control @error('perihal') is-invalid @enderror" value="{{ old('perihal') }}">
        @error('perihal')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3" id="pnrm_surat">
        <label for="" class="form-label">Penerima Surat</label>
        <input type="text" name="pnrm_surat" placeholder="Penerima Surat" class="form-control @error('pnrm_surat') is-invalid @enderror" value="{{ old('pnrm_surat') }}">
        @error('pnrm_surat')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3" id="alamat_surat">
        <label for="" class="form-label">Alamat Tujuan</label>
        <input type="text" name="alamat_surat" placeholder="Alamat Tujuan" class="form-control @error('alamat_surat') is-invalid @enderror" value="{{ old('alamat_surat') }}">
        @error('alamat_surat')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="isi_surat" class="form-label">Isi Surat</label>
        <input type="hidden">
        <textarea name="isi_surat" id="isi_surat"></textarea>
    </div>
    <div class="mb-3">
        <label for="" class="form-label"> Tanda Tangan</label>
        <input disabled id="nama_pj" type="text" name="nama_pj" placeholder="Tanda Tangan" class="form-control @error('nama_pj') is-invalid @enderror" value="{{ old('nama_pj') }}">
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
    <a href="{{ route('suratPemberitahuan.index') }}" class="btn btn-secondary">Batal</a>
</form>

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->

@endsection

@push('scripts')

<script>
    $('#kode_instansi').on('change', function(e) {

        // console.log($('#kode_instansi').val());
        instansi_id = $('#kode_instansi').val();

        $('#nama_pj').val(instansi_id);

        $.ajax({
            url: "{{route('generateLetterNumber')}}",
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                kode_instansi: $('#kode_instansi').val(),
            },
            success: function(res) {
                // console.log(res);
                $('#no_surat').val(res.letterNumber)
                $('#nama_pj').val(res.nama_pj);
            }
        })
    });
</script>

@endpush

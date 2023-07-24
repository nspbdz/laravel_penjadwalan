@extends('layouts.main')

@section('content')

@auth


<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Data Jadwal Kuliah</h3>
            </div>
            <div class="card-header">
                <form class="form" method="POST" action="/algoritma">
                    <form class="form" method="GET" action="/schedule">
                        {{ csrf_field() }}


                        <label> Semester</label>
                        <select id="semester_tipe" name="semester_tipe" class="form-control">
                            <option value="1" <?php echo isset($semester_tipe) ? ($semester_tipe === '1' ? 'selected' : '') : ''; ?> /> GANJIL
                            <option value="0" <?php echo isset($semester_tipe) ? ($semester_tipe === '0' ? 'selected' : '') : ''; ?> /> GENAP
                        </select>
                        <label>Tahun Akademik</label>

                        <select id="tahun_akademik" name="tahun_akademik" class="form-control">
                            @foreach($tahun as $item)
                            <option value="{{$item->tahun}}" <?php echo isset($tahun_akademik) ? ($tahun_akademik === '{{$item->tahun}}' ? 'selected' : '') : ''; ?> /> {{$item->tahun}}
                            <!-- <option value="2021-2022" <?php echo isset($tahun_akademik) ? ($tahun_akademik === '2021-2022' ? 'selected' : '') : ''; ?> /> 2021-2022
                        <option value="2022-2023" <?php echo isset($tahun_akademik) ? ($tahun_akademik === '2022-2023' ? 'selected' : '') : ''; ?> /> 2022-2023 -->
                            @endforeach
                        </select>


                        <label>Jumlah Populasi</label>
                        <input type="text" class="form-control" name="jumlah_populasi" value="<?php echo isset($jumlah_populasi) ? $jumlah_populasi : '10'; ?>">
            </div>
            <div class=" card-header">
                <label>Probabilitas CrossOver</label>
                <input type="text" class="form-control" name="probabilitas_crossover" value="<?php echo isset($probabilitas_crossover) ? $probabilitas_crossover : '0.70'; ?>">

                <label>Probabilitas Mutasi</label>
                <input type="text" class="form-control" name="probabilitas_mutasi" value="<?php echo isset($probabilitas_mutasi) ? $probabilitas_mutasi : '0.40'; ?>">

                <label>Jumlah Generasi</label>
                <input type="text" class="form-control" name="jumlah_generasi" value="<?php echo isset($jumlah_generasi) ? $jumlah_generasi : '1000'; ?>">
            </div>
            <div class="card-header">
                <button type="submit" class=" btn btn-danger pull-left" onclick="ShowProgressAnimation();">Proses</button>
                <a class="btn btn-info" href="{{ route('schedule.export') }}">Export Excel</a>
            </div>

            </form>
            <br><br>
            <div>


            </div>


        </div>

        <div id="content_ajax">

            <div class="pagination pull-right" id="ajax_paging">
                <ul>
                    <?php //echo $this->pagination->create_links();
                    ?>
                </ul>
            </div>



        </div>

        <h3>Jadwal Kuliah</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table border="2">
                    <tr>

                        <th>Hari</th>
                        <th colspan="2" style="text-align:center;">Jam</th>

                        @foreach($kelasrpl as $item)

                        <th>{{$item ->nama}}</th>
                        @endforeach

                        @php
                        $sks = ['2','3','4'];
                        $hari =['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                        $hariCount = count($hari);
                        $jamCount = count($jam);
                        $sksCount = count($sks);



                        @endphp
                    </tr>
                    @for ($h = 0; $h < $hariCount; $h++) @for ($i=0; $i < $jamCount; $i++) <tr>
                        @if ($i === 0)
                        <td rowspan="{{ $jamCount }}" style="vertical-align: middle;">{{ $hari[$h] }}</td>
                        @endif
                        <td>{{ $jam[$i]->kode}}</td>

                        <td>{{ $jam[$i]->range_jam}}</td>

                        @foreach ($kelasrpl as $kls)
                        <td>

                            <!-- {{ $schedulerpl[$hari[$h]][$jam[$i]->range_jam][$kls->nama]??'' }} -->
                            {{ $tableData[$hari[$h]][$jam[$i]->range_jam][$kls->nama] ?? '' }}

                        </td>

                        @endforeach





                        </tr>


                        @endfor
                        @endfor
                </table>
            </div>
        </div>



        <h3>Jadwal Kuliah Bentrok</h3>
        <div class="card-body">
            <div class="table-responsive">
                <table border="2">
                    <tr>

                        <th>Hari</th>
                        <th colspan="2" style="text-align:center;">Jam</th>

                        @foreach($kelasrpl as $item)

                        <th>{{$item ->nama}}</th>
                        @endforeach

                        @php
                        $sks = ['2','3','4'];
                        $hari =['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                        $hariCount = count($hari);
                        $jamCount = count($jam);
                        $sksCount = count($sks);



                        @endphp
                    </tr>
                    @for ($h = 0; $h < $hariCount; $h++) @for ($i=0; $i < $jamCount; $i++) <tr>
                        @if ($i === 0)
                        <td rowspan="{{ $jamCount }}" style="vertical-align: middle;">{{ $hari[$h] }}</td>
                        @endif
                        <td>{{ $jam[$i]->kode}}</td>

                        <td>{{ $jam[$i]->range_jam}}</td>

                        @foreach ($kelasrpl as $kls)
                        <td>

                            <!-- {{ $schedulerpl[$hari[$h]][$jam[$i]->range_jam][$kls->nama]??'' }} -->
                            {{ $tableDataBentrok[$hari[$h]][$jam[$i]->range_jam][$kls->nama] ?? '' }}

                        </td>

                        @endforeach





                        </tr>


                        @endfor
                        @endfor
                </table>
            </div>
        </div>




        @endauth

        @guest

        <p>guest day</p>
        @endguest
    </div>
    @endsection
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.kode-jam-dropdown').on('change', function() {
                // console.log('test');
                var row = $(this).data('row');
                var id = $(this).data('id');
                var kodeJam = $(this).val();
                // Kirim permintaan AJAX ke endpoint untuk mengupdate kode jam dalam database
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route("schedule.updateKodeJam")}}', // Ganti dengan URL endpoint Laravel Anda
                    method: 'POST',
                    data: {
                        id: id,
                        row: row,
                        kodeJam: kodeJam
                    },
                    success: function(response) {

                        // Lakukan tindakan lain setelah berhasil mengupdate kode jam
                        if (response.success) {
                            // Refresh halaman setelah menerima respons sukses
                            location.reload();
                        } else {
                            alert('Data Bentrok');
                            // console.log(response);
                        }
                    }
                });
            });

            $('#prodiDropdown').on('change', function() {
                var prodi = $(this).val();
                var currentUrl = "{{route('schedule.index')}}";

                // Menambahkan query GET yang diinginkan
                var updatedUrl = currentUrl + '?getprodi=' + prodi;

                // Melakukan refresh halaman dengan URL yang diperbarui
                window.location.href = updatedUrl;

            });
        });
    </script>
    @endpush
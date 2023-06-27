<?php
// dd($schedule);

?>
<table>
    <thead>
        <tr>
            <th>no</th>
            <th>hari</th>
            <th>jam</th>
            <th>Matakuliah</th>
            <th>sks</th>
            <th>semester</th>
            <th>kelas</th>
            <th>ruang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($schedule as $index => $item)
        <tr>

            <td>{{ $index+1 }}</td>
            <td>{{ $item->nama_hari }}</td>
            <td>{{ $item->range_jam }}</td>
            <td>{{ $item->matkul_name }}</td>
            <td>{{ $item->sks }}</td>
            <td>{{ $item->semester }}</td>
            <td>{{ $item->kelas }}</td>
            <td>{{ $item->nama_ruang }}</td>

        </tr>
        @endforeach
    </tbody>
</table>

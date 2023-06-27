<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        // Data dosen
        $dosen = [
            'Dosen A',
            'Dosen B',
            'Dosen C',
            'Dosen e',
            'Dosen f',
            'Dosen 1',
            'Dosen 2',
            'Dosen 3',
            'Dosen 4',
            'Dosen 5',
            'Dosen 132',
            'Dosen 132',
            'Dosen 132',
            'Dosen 132',
            'Dosen 132',
            'Dosen 132',
            'Dosen 132',
            'Dosen 132',
        ];

        // Data kelas
        $kelas = [
            'Kelas X',
            'Kelas Y',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
            'Kelas Z',
        ];

        // Data hari
        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
        ];

        // Data ruang
        $ruang = [
            'Ruang 101',
            'Ruang 102',
            'Ruang 103',
        ];

        // Data sesi
        $sesi = [
            'Sesi 1',
            'Sesi 2',
            'Sesi 3',
        ];

        // Jadwal penjadwalan
        $jadwal = [];

        // Looping untuk mengisi jadwal
        foreach ($hari as $h) {
            foreach ($sesi as $s) {
                $dosenRandom = array();
                $kelasRandom = array();
                // Memilih dosen secara acak
                $dosenRandom = $dosen[array_rand($dosen)];

                // Memilih kelas secara acak
                $kelasRandom = $kelas[array_rand($kelas)];

                // Memilih ruang secara acak
                $ruangRandom = $ruang[array_rand($ruang)];

                // Menentukan jadwal untuk dosen, kelas, dan ruang
                $jadwal[$h][$s] = [
                    'Dosen' =>  $dosenRandom,
                    'Kelas' => $kelasRandom,
                    'Ruang' => $ruangRandom,
                ];

                // Menghapus dosen dan kelas dari daftar untuk sesi berikutnya
                unset($dosen[array_search($dosenRandom, $dosen)]);
                unset($kelas[array_search($kelasRandom, $kelas)]);
            }

            // Mengatur ulang array dosen dan kelas setiap harinya
            $dosen = array_values($dosen);
            $kelas = array_values($kelas);
        }
        foreach ($jadwal as $h => $sesi) {
            echo "Hari: $h <br>";
            foreach ($sesi as $s => $data) {
                echo "Sesi: $s <br>";
                echo "Dosen: " . $data['Dosen'] . "<br>";
                echo "Kelas: " . $data['Kelas'] . "<br>";
                echo "Ruang: " . $data['Ruang'] . "<br>";
                echo "<br>";
            }
        }
        echo "<br>";
        // dd($sesi);
        return view('test.index',);

        // Menampilkan jadwal
        //     foreach ($jadwal as $h => $sesi) {
        //         echo "Hari: $h <br>";
        //         foreach ($sesi as $s => $data) {
        //             echo "Sesi: $s <br>";
        //             echo "Dosen: " . $data['Dosen'] . "<br>";
        //             echo "Kelas: " . $data['Kelas'] . "<br>";
        //             echo "Ruang: " . $data['Ruang'] . "<br>";
        //             echo "<br>";
        //         }
        //         echo "<br>";
        //     }
    }
}

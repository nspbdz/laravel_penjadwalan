<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Hari;
use App\Models\Hour;
use App\Models\Lecture;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Wb;
use App\Models\Wtb;

class AlgoritmaGenetikaController extends Controller
{
    private $wb = [];
    private $wtb = [];
    // Inisialisasi populasi awal
    private function initializePopulation($populationSize, $courses, $timeslots, $rooms, $instructors)
    {
        $population = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $schedule = [];

            foreach ($courses as $course) {
                $explode = explode(' - ', $course);
                $courseId = $explode[0];
                $dosenId = $explode[1];
                $jenis = $explode[2];
                $class = $explode[3];
                $sks = $explode[4];
                // dd($rooms);
                if (!empty($this->wb[$courseId])) {
                    $day = $this->wb[$courseId]['day'];
                    $time = $this->wb[$courseId]['time'];
                    $ruang = $this->wb[$courseId]['ruang'];
                    $randomTimeslot = $this->getTimeSlot($timeslots, $day, $time);
                    $randomRoom = $this->getRuangan($rooms, $ruang);
                } elseif (!empty($this->wtb[$dosenId])) {
                    $randomTimeslot = $this->getRandomTimeSlotWtb($timeslots, $this->wtb[$dosenId]);
                    $randomRoom = $this->getRandomRuangan($rooms, $jenis);
                } else {
                    // $randomTimeslot = $this->getRandomTimeSlot($timeslots, $course);
                    $randomTimeslot = $timeslots[rand(0, count($timeslots) - 1)];
                    $randomRoom = $this->getRandomRuangan($rooms, $jenis);
                }



                $instructor = $this->checkDosen($dosenId, $instructors);
                // $randomInstructor = $instructors[rand(0, count($instructors) - 1)];


                $schedule[$course] = [
                    'timeslot' => $randomTimeslot,
                    'room' => $randomRoom,
                    'instructor' => $instructor,
                    'class' => ['id' => $class],
                    'sks' => $sks
                ];
            }

            $population[] = $schedule;
        }
        // dd($population);

        return $population;
    }

    // Evaluasi fitness
    private function calculateFitness($schedule)
    {
        // Implementasikan fungsi penilaian fitness sesuai kebutuhan Anda
        // Misalnya, dapat berdasarkan jumlah bentrok atau preferensi pengguna

        $fitness = 0;

        // Contoh: Menambahkan satu poin fitness jika tidak ada bentrok
        $timeSlots = [];

        // dd($schedule);
        // dd($schedule);
        foreach ($schedule as $course) {
            // dd($course);

            $timeslotId = $course['timeslot']['id'];
            $roomId = $course['room']['id'];
            $instructorId = $course['instructor']['id'];
            $classId = $course['class']['id'];
            $sks = $course['sks'];

            for ($i = 0; $i < $sks; $i++) {
                $timeslotRoom = $timeslotId + $i . 'T-R' . $roomId;
                $timeslotInstructor = $timeslotId + $i . 'T-I' . $instructorId;
                $timeslotClass = $timeslotId + $i . 'T-C' . $classId;
            }

            // if ($this->isTimeUnavailable($course)) {
            //     // Mengurangi fitness jika waktu tidak tersedia
            //     $fitness -= 100; // Nilai pengurangan fitness yang bisa disesuaikan
            // } elseif ($this->isTimeAvailable($course)) {
            //     // Menambah fitness jika waktu tersedia
            //     $fitness += 1; // Nilai penambahan fitness yang bisa disesuaikan
            // }

            if (isset($timeSlots[$timeslotRoom]) || isset($timeSlots[$timeslotInstructor]) || isset($timeSlots[$timeslotClass])) {
                $fitness++; // Bentrok ditemukan, tambahkan poin fitness
            } else {
                $timeSlots[$timeslotRoom] = true;
                $timeSlots[$timeslotInstructor] = true;
                $timeSlots[$timeslotClass] = true;
            }

            // Implementasikan aturan penilaian fitness tambahan sesuai kebutuhan
            // Misalnya, menambahkan atau mengurangi poin fitness berdasarkan preferensi
        }

        return $fitness;
    }

    // Seleksi orang tua menggunakan turnamen
    private function selectParents($population, $tournamentSize)
    {
        $parents = [];

        for ($i = 0; $i < 2; $i++) {
            $tournamentPopulation = [];

            // Pilih individu secara acak untuk turnamen
            for ($j = 0; $j < $tournamentSize; $j++) {
                $randomIndividual = $population[rand(0, count($population) - 1)];
                $tournamentPopulation[] = $randomIndividual;
            }

            // Pilih individu dengan fitness terbaik
            $bestFitness = PHP_INT_MAX;
            $selectedIndividual = null;

            foreach ($tournamentPopulation as $individual) {
                $fitness = $this->calculateFitness($individual);

                if ($fitness < $bestFitness) {
                    $bestFitness = $fitness;
                    $selectedIndividual = $individual;
                }
            }

            $parents[] = $selectedIndividual;
        }

        return $parents;
    }

    // Operasi crossover menggunakan satu titik potong
    private function crossover($parent1, $parent2)
    {
        $child = [];

        // Ambil titik potong acak
        $cutPoint = rand(1, count($parent1) - 1);

        // Ambil gen dari parent1 sebelum titik potong
        for ($i = 0; $i < $cutPoint; $i++) {
            $course = array_keys($parent1)[$i];
            $child[$course] = $parent1[$course];
        }

        // Ambil gen dari parent2 setelah titik potong
        $remainingCourses = array_slice(array_keys($parent2), $cutPoint);

        foreach ($remainingCourses as $course) {
            $child[$course] = $parent2[$course];
        }

        return $child;
    }

    // Mutasi individu dengan mengganti gen secara acak
    private function mutate($individual, $mutationRate, $timeslots, $rooms, $instructors)
    {
        foreach ($individual as $course => $details) {
            if (rand(0, 100) < $mutationRate) {
                $explode = explode(' - ', $course);
                $courseId = $explode[0];
                $dosenId = $explode[1];
                $jenis = $explode[2];
                $class = $explode[3];
                $sks = $explode[4];
                // $randomRoom = $rooms[rand(0, count($rooms) - 1)];
                if (!empty($this->wb[$courseId])) {
                    $day = $this->wb[$courseId]['day'];
                    $time = $this->wb[$courseId]['time'];
                    $ruang = $this->wb[$courseId]['ruang'];
                    $randomTimeslot = $this->getTimeSlot($timeslots, $day, $time);
                    $randomRoom = $this->getRuangan($rooms, $ruang);
                } elseif (!empty($this->wtb[$dosenId])) {
                    $randomTimeslot = $this->getRandomTimeSlotWtb($timeslots, $this->wtb[$dosenId]);
                    $randomRoom = $this->getRandomRuangan($rooms, $jenis);
                } else {
                    // $randomTimeslot = $this->getRandomTimeSlot($timeslots, $course);
                    $randomTimeslot = $timeslots[rand(0, count($timeslots) - 1)];
                    $randomRoom = $this->getRandomRuangan($rooms, $jenis);
                }
                $instructor = $this->checkDosen($dosenId, $instructors);

                $individual[$course]['timeslot'] = $randomTimeslot;
                $individual[$course]['room'] = $randomRoom;
                $individual[$course]['instructor'] = $instructor;
                $individual[$course]['class'] = ['id' => $class];
                $individual[$course]['sks'] = $sks;
            }
        }

        return $individual;
    }

    private function checkDosen($id, $data)
    {
        $key = array_search($id, array_column($data, 'id'));
        if ($key !== false) {
            // $foundElement = $data[$key];
            return $data[$key];
        }
        return 'Dosen Tidak Ditemukan';
    }

    private function getRandomRuangan($array, $jenisToSearch)
    {
        if ($jenisToSearch == 'PRAKTIKUM') {
            $jenisToSearch = 'LABORATORIUM';
        }
        $results = array_filter($array, function ($element) use ($jenisToSearch) {
            return $element['jenis'] === $jenisToSearch;
        });

        $randomElement = null;

        if (!empty($results)) {
            $randomKey = array_rand($results);
            $randomElement = $results[$randomKey];
        }

        return $randomElement;
    }

    private function getRuangan($array, $id)
    {

        $results = array_filter($array, function ($element) use ($id) {
            return $element['id'] == $id;
        });

        $randomElement = null;

        if (!empty($results)) {
            $randomKey = array_rand($results);
            $randomElement = $results[$randomKey];
        }

        return $randomElement;
    }

    private function getTimeSlot($array, $searchIdDay, $searchIdTime)
    {
        // dd($course);
        $results = array_filter($array, function ($item) use ($searchIdDay, $searchIdTime) {
            return $item['id_day'] == $searchIdDay && $item['id_time'] == $searchIdTime;
        });

        $randomElement = null;

        if (!empty($results)) {
            $randomKey = array_rand($results);
            $randomElement = $results[$randomKey];
        }

        return $randomElement;
    }

    private function getRandomTimeSlotWtb($array, $arrayHapus)
    {
        $compare = function ($a, $b) {
            return ($a['day'] === $b['day'] && $a['time'] === $b['time']) ? 0 : -1;
        };

        $results = array_udiff($array, $arrayHapus, $compare);

        $randomElement = null;

        if (!empty($results)) {
            $randomKey = array_rand($results);
            $randomElement = $results[$randomKey];
        }

        return $randomElement;
    }

    //     $compare = function ($a, $b) {
    //     return $a <=> $b;
    // };

    // $arrahasil = array_udiff($array, $arrayhapus, $compare);
    // print_r($arrahasil);

    // Fungsi untuk memeriksa waktu tidak tersedia
    // private function isTimeUnavailable($course)
    // {
    //     // Ambil data waktu tidak tersedia dari database atau sumber data lainnya
    //     $unavailableTimes = UnavailableTime::all(); // Menggunakan contoh model UnavailableTime, sesuaikan dengan model Anda

    //     // Periksa apakah waktu matakuliah bertabrakan dengan waktu tidak tersedia
    //     foreach ($unavailableTimes as $unavailableTime) {
    //         if ($course->start_time >= $unavailableTime->start_time && $course->end_time <= $unavailableTime->end_time) {
    //             return true; // Waktu tidak tersedia ditemukan
    //         }
    //     }

    //     return false; // Waktu tersedia
    // }

    // Fungsi untuk memeriksa waktu bersedia
    // private function isTimeAvailable($course)
    // {
    //     // Ambil data waktu bersedia dari database atau sumber data lainnya
    //     $availableTimes = AvailableTime::all(); // Menggunakan contoh model AvailableTime, sesuaikan dengan model Anda

    //     // Periksa apakah waktu matakuliah cocok dengan waktu bersedia
    //     foreach ($availableTimes as $availableTime) {
    //         if ($course->start_time >= $availableTime->start_time && $course->end_time <= $availableTime->end_time) {
    //             return true; // Waktu bersedia ditemukan
    //         }
    //     }

    //     return false; // Waktu tidak bersedia
    // }


    // Menggabungkan langkah-langkah algoritma genetika
    private function runGeneticAlgorithm($populationSize, $tournamentSize, $mutationRate, $maxGenerations, $courses, $timeslots, $rooms, $instructors)
    {
        $population = $this->initializePopulation($populationSize, $courses, $timeslots, $rooms, $instructors);

        for ($generation = 0; $generation < $maxGenerations; $generation++) {
            $nextGeneration = [];

            for ($i = 0; $i < $populationSize; $i++) {
                $parents = $this->selectParents($population, $tournamentSize);

                $child = $this->crossover($parents[0], $parents[1]);

                $child = $this->mutate($child, $mutationRate, $timeslots, $rooms, $instructors);

                $nextGeneration[] = $child;
            }

            $population = $nextGeneration;
        }

        // Mengembalikan individu terbaik setelah generasi terakhir
        $bestIndividual = null;
        $bestFitness = PHP_INT_MAX;

        foreach ($population as $individual) {
            $fitness = $this->calculateFitness($individual);

            if ($fitness < $bestFitness) {
                $bestFitness = $fitness;
                $bestIndividual = $individual;
            }
            // $bestIndividual['fitness'] = $fitness;
        }
        // dd($bestIndividual);
        return $bestIndividual;
    }

    // Contoh penggunaan algoritma genetika

    public function build()
    {
        $populationSize = 10;
        $tournamentSize = 5;
        $mutationRate = 40; // Persentase mutasi (0-100)
        $maxGenerations = 1000;

        // Sample $courses = ['Course 1', 'Course 2', 'Course 3', 'Course 4', 'Course 5'];
        $courses = (new Course())->getCourse(request('tahun_akademik'), request('semester_tipe'));

        // dd($courses);
        // Contoh $timeslots = [
        //     ['id' => 1, 'day' => 'Monday', 'time' => '08:00'],
        //     ['id' => 2, 'day' => 'Monday', 'time' => '10:00'],
        //     ['id' => 3, 'day' => 'Tuesday', 'time' => '13:00'],
        //     ['id' => 4, 'day' => 'Wednesday', 'time' => '09:00'],
        //     ['id' => 5, 'day' => 'Thursday', 'time' => '15:00'],
        // ];

        $days = (new Hari())->getHari();
        $times = (new Hour())->getJam();
        $i = 0;
        foreach ($days as $hari) {
            foreach ($times as $time) {
                $timeslots[] = [
                    'id' => $i,
                    'day' => $hari->nama,
                    'time' => $time->range_jam,
                    'id_day' => $hari->kode,
                    'id_time' => $time->kode
                ];
                $i++;
            }
        }

        // $rooms = [
        //     ['id' => 1, 'name' => 'Room 1'],
        //     ['id' => 2, 'name' => 'Room 2'],
        //     ['id' => 3, 'name' => 'Room 3'],
        // ];

        $roomsObj = (array) (new Room())->getRoom();
        $rooms = json_decode(json_encode($roomsObj), true);

        // dd(count($rooms));
        // dd($rooms);

        // $instructors = [
        //     ['id' => 1, 'name' => 'Instructor 1'],
        //     ['id' => 2, 'name' => 'Instructor 2'],
        //     ['id' => 3, 'name' => 'Instructor 3'],
        // ];

        $instructorsObj = (array) (new Lecture)->getDosen();
        $instructors = json_decode(json_encode($instructorsObj), true);

        $resultWb = Wb::all();
        foreach ($resultWb as $row) {
            $this->wb[$row->kode_pengampu]['day'] = $row->kode_hari;
            $this->wb[$row->kode_pengampu]['time'] = $row->kode_jam;
            $this->wb[$row->kode_pengampu]['ruang'] = $row->kode_ruang;
        }

        $resultWtb = Wtb::all();
        foreach ($resultWtb as $row) {
            $this->wtb[$row->kode_dosen][] = [
                'day' => $row->kode_hari,
                'time' => $row->kode_jam
            ];
        }

        // dd($this->wb);

        $result = $this->runGeneticAlgorithm($populationSize, $tournamentSize, $mutationRate, $maxGenerations, $courses, $timeslots, $rooms, $instructors);
        Schedule::truncate();
        // Tampilkan hasil penjadwalan
        echo "Best Schedule:<br>";
        echo "<table>";
        echo "<tr>
        <td>Mata Kuliah</td>
        <td>Waktu</td>
        <td>Ruang</td>
        <td>Dosen</td>
        </tr>";
        foreach ($result as $course => $details) {
            // dd($details);
            echo "<tr>";
            echo "<td>$course<br>";
            echo "<td>{$details['timeslot']['day']} {$details['timeslot']['time']}</td>";
            echo "<td>{$details['room']['name']}</td>";
            echo "<td>{$details['instructor']['name']}</td>";
            // echo "<td>{$details['fitness']}</td>";
            echo "</tr>";
            $explode = explode(' - ', $course);

            $schedule = new Schedule;
            $schedule->kode_pengampu = $explode[0];
            $schedule->kode_jam = $details['timeslot']['id_time'];
            $schedule->kode_hari = $details['timeslot']['id_day'];
            $schedule->kode_ruang = $details['room']['id'];

            $schedule->save();
        }
        echo "</table>";
    }
}

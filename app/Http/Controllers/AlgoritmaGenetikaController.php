<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Hari;
use App\Models\Hour;
use App\Models\Lecture;
use App\Models\Room;

class AlgoritmaGenetikaController extends Controller
{
    // Inisialisasi populasi awal
    function initializePopulation($populationSize, $courses, $timeslots, $rooms, $instructors)
    {
        $population = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $schedule = [];

            foreach ($courses as $course) {
                $randomTimeslot = $timeslots[rand(0, count($timeslots) - 1)];
                // dd(count($rooms));
                // dd($rooms);
                // $randomRoom = $rooms[rand(0, count($rooms) - 1)];
                $explode = explode(' - ', $course);
                $jenis = $explode[2];
                $randomRoom = $this->getRandomRuangan($rooms, $jenis);
                $dosenId = $explode[1];
                $instructor = $this->checkDosen($dosenId, $instructors);
                // $randomInstructor = $instructors[rand(0, count($instructors) - 1)];

                $schedule[$course] = [
                    'timeslot' => $randomTimeslot,
                    'room' => $randomRoom,
                    'instructor' => $instructor,
                ];
            }

            $population[] = $schedule;
        }

        return $population;
    }

    // Evaluasi fitness
    function calculateFitness($schedule)
    {
        // Implementasikan fungsi penilaian fitness sesuai kebutuhan Anda
        // Misalnya, dapat berdasarkan jumlah bentrok atau preferensi pengguna

        $fitness = 0;

        // Contoh: Menambahkan satu poin fitness jika tidak ada bentrok
        $timeSlots = [];

        // dd($schedule);
        // dd($schedule);
        foreach ($schedule as $course) {
            $timeslotId = $course['timeslot']['id'];
            $roomId = $course['room']['id'];
            $instructorId = $course['instructor']['id'];

            $timeslotRoom = $timeslotId . '-' . $roomId;
            $timeslotInstructor = $timeslotId . '-' . $instructorId;

            if (isset($timeSlots[$timeslotRoom]) || isset($timeSlots[$timeslotInstructor])) {
                $fitness++; // Bentrok ditemukan, tambahkan poin fitness
            } else {
                $timeSlots[$timeslotRoom] = true;
                $timeSlots[$timeslotInstructor] = true;
            }

            // Implementasikan aturan penilaian fitness tambahan sesuai kebutuhan
            // Misalnya, menambahkan atau mengurangi poin fitness berdasarkan preferensi
        }

        return $fitness;
    }

    // Seleksi orang tua menggunakan turnamen
    function selectParents($population, $tournamentSize)
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
    function crossover($parent1, $parent2)
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
    function mutate($individual, $mutationRate, $timeslots, $rooms, $instructors)
    {
        foreach ($individual as $course => $details) {
            if (rand(0, 100) < $mutationRate) {
                $randomTimeslot = $timeslots[rand(0, count($timeslots) - 1)];
                $explode = explode(' - ', $course);
                // $randomRoom = $rooms[rand(0, count($rooms) - 1)];
                $jenis = $explode[2];
                $randomRoom = $this->getRandomRuangan($rooms, $jenis);
                $dosenId = $explode[1];
                $instructor = $this->checkDosen($dosenId, $instructors);

                $individual[$course]['timeslot'] = $randomTimeslot;
                $individual[$course]['room'] = $randomRoom;
                $individual[$course]['instructor'] = $instructor;
            }
        }

        return $individual;
    }

    function checkDosen($id, $data)
    {
        $key = array_search($id, array_column($data, 'id'));
        if ($key !== false) {
            // $foundElement = $data[$key];
            return $data[$key];
        }
        return 'Dosen Tidak Ditemukan';
    }

    function getRandomRuangan($array, $jenisToSearch)
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

    // Menggabungkan langkah-langkah algoritma genetika
    function runGeneticAlgorithm($populationSize, $tournamentSize, $mutationRate, $maxGenerations, $courses, $timeslots, $rooms, $instructors)
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
        }

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
                    'day' => $hari,
                    'time' => $time
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

        $result = $this->runGeneticAlgorithm($populationSize, $tournamentSize, $mutationRate, $maxGenerations, $courses, $timeslots, $rooms, $instructors);

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
            echo "<tr>";
            echo "<td>$course<br>";
            echo "<td>{$details['timeslot']['day']} {$details['timeslot']['time']}</td>";
            echo "<td>{$details['room']['name']}</td>";
            echo "<td>{$details['instructor']['name']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

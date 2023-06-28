<?php

namespace App\Http\Controllers;

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
                $randomRoom = $rooms[rand(0, count($rooms) - 1)];
                $randomInstructor = $instructors[rand(0, count($instructors) - 1)];

                $schedule[$course] = [
                    'timeslot' => $randomTimeslot,
                    'room' => $randomRoom,
                    'instructor' => $randomInstructor,
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
                $randomRoom = $rooms[rand(0, count($rooms) - 1)];
                $randomInstructor = $instructors[rand(0, count($instructors) - 1)];

                $individual[$course]['timeslot'] = $randomTimeslot;
                $individual[$course]['room'] = $randomRoom;
                $individual[$course]['instructor'] = $randomInstructor;
            }
        }

        return $individual;
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

        $courses = ['Course 1', 'Course 2', 'Course 3', 'Course 4', 'Course 5'];
        $timeslots = [
            ['id' => 1, 'day' => 'Monday', 'time' => '08:00'],
            ['id' => 2, 'day' => 'Monday', 'time' => '10:00'],
            ['id' => 3, 'day' => 'Tuesday', 'time' => '13:00'],
            ['id' => 4, 'day' => 'Wednesday', 'time' => '09:00'],
            ['id' => 5, 'day' => 'Thursday', 'time' => '15:00'],
        ];
        $rooms = [
            ['id' => 1, 'name' => 'Room 1'],
            ['id' => 2, 'name' => 'Room 2'],
            ['id' => 3, 'name' => 'Room 3'],
        ];
        $instructors = [
            ['id' => 1, 'name' => 'Instructor 1'],
            ['id' => 2, 'name' => 'Instructor 2'],
            ['id' => 3, 'name' => 'Instructor 3'],
        ];

        $result = $this->runGeneticAlgorithm($populationSize, $tournamentSize, $mutationRate, $maxGenerations, $courses, $timeslots, $rooms, $instructors);

        // Tampilkan hasil penjadwalan
        echo "Best Schedule:<br>";
        foreach ($result as $course => $details) {
            echo "Course: $course<br>";
            echo "Timeslot: {$details['timeslot']['day']} {$details['timeslot']['time']}<br>";
            echo "Room: {$details['room']['name']}<br>";
            echo "Instructor: {$details['instructor']['name']}<br>";
            echo "--------<br>";
        }
    }
}

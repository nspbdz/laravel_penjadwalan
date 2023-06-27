<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penjadwalan Matakuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

    <!-- Section: Design Block -->
    <section class="">
        <!-- Jumbotron -->
        <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="my-5 display-5 fw-bold ls-tight">
                            Penjadwalan Matakuliah Jurusan Teknik Informatika <br />
                            <span class="text-primary display-6 fw-bold"> Politeknik Negeri Indramayu</span>
                        </h1>
                        <p style="color: hsl(217, 10%, 50.8%)">
                        Penjadwalan ini dikhususkan untuk jurusan teknik informatika di Politeknik Negeri Indramayu.
                            penjadwalan mata kuliah ini memudahkan dalam menyusun jadwal matakuliah du jurusan teknik infotmatika
                            Politeknik Negeri Indramayu.
                            Penjadwalan Matakuliah ini diproses menggunakan metode algoritma Genetika dan algortima Pattern Search.
                       </p>
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card">
                            <div class="card-body py-5 px-md-5">

                                <form method="POST" action="{{ route('login.perform') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                                    <!-- 2 column grid layout with text inputs for the first and last names -->
                                    <div class="row">
                                        <div class="col-md-8 mb-4">
                                            <div class="form-outline">
                                                <h1 class="my-3 display-8 fw-bold ls-tight">Silahkan Masuk!</h1>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Email input -->
                                    <div class="form-outline mb-4">
                                        <!-- <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus> -->
    
                                        <input type="text" id="form-control" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
                                        <label class="form-label" for="form3Example3">Masukan Username</label>
                                        @if ($errors->has('username'))
                                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <!-- <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required"> -->

                                        <input type="password" id="form-control" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                                        <label class="form-label" for="form3Example4">Password</label>
                                        @if ($errors->has('password'))
                                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <!-- Checkbox -->


                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary btn-block mb-4">
                                        Masuk
                                    </button>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
     
</body>

</html>

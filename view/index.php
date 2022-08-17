<?php
require_once '../api/curl.php';

if (isset($_GET['key'])) {
    $key = $_GET["key"];
    $endpoint = "https://masak-apa-tomorisakura.vercel.app/api/recipe/:$key";

    $results = curl($endpoint)["results"];
    $ingredients = $results["ingredient"];
    $steps = $results["step"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ACEACE" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/home.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../css/utilities.css" type="text/css" media="all" />

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <title>Cari Resep Makanan</title>
</head>

<body>
    <!-- header -->
    <div class="container bg-orange rounded-bottom">
        <div class="row mx-0 px-1">
            <div class="col-12 mt-3 d-flex mb-3 align-items-center justify-content-center">
                <a href="../index.php"><i class="fas fa-concierge-bell text-white"> <span class="fw-bold fs-5 text-white">DETAIL RESEP MAKANAN</span></i></a>
            </div>
        </div>
    </div>
    <div class="container mt-4 bg-orange rounded p-3">
        <!-- View Resep Detail -->
        <div class="row">
            <div data-role="tracker" data-url="Detail Resep Makanan" class="px-3 mt-1 mb-3 w-50"></div>
            <div class="col-12">
                <?php
                $title = $results["title"];
                $thumb = $results["thumb"];
                $times = $results["times"];
                $portion = $results["servings"];
                $dificulty = $results["dificulty"];
                $author = $results["author"]["user"];
                $date = $results["author"]["datePublished"];
                ?>
                <ul class="list-style-none px-1">
                    <li>
                        <h5 class="fw-bold text-white"><?= $title ?></h5>
                    </li>
                    <li>
                        <img class="rounded img-fluid" width="50%" height="50%" src="<?= $thumb ?>" width="100%" alt="<?= $title ?>" />
                    </li>
                    <li>
                        <p class="font-md mt-1 mb-0 text-white">By <?= $author ?> at <?= $date ?></p>
                    </li>
                    <li class="text-white d-flex font-md align-items-center">
                        <i class="far fa-clock text-white me-1 font-md"></i>
                        <?= $times ?>
                    </li>
                    <li class="text-white font-md d-flex align-items-center">
                        <i class="fas fa-utensils text-white me-1 font-md"></i>
                        <?= $portion ?>
                    </li>
                    <li class="text-white d-flex font-md align-items-center">
                        <i class="fas fa-walking text-white me-1 font-md"></i>
                        <?= $dificulty ?>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Bahan masakan -->
        <div class="row">
            <div class="col-12 px-3 d-flex justify-content-between">
                <a class="text-white" style="text-decoration: none" data-bs-toggle="collapse" href="#collapseBahan" role="button" aria-expanded="false" aria-controls="collapseBahan">
                    <p class="text-white sct-title fw-500">Bahan Masakan</p>
                </a>
                <p><i class="text-white fas fa-chevron-down"></i></p>
            </div>
            <div class="collapse" id="collapseBahan">
                <div class="col-12 px-1 d-flex flex-wrap">
                    <?php
                    foreach ($ingredients as $item) {
                        echo '<span class="text-decoration-none font-md fs-500 fw-bold text-white bg-orange-sm me-1 d-block px-2 py-1 subtitle rounded d-inline-block mt-1">' . $item . '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Step by step -->
        <div class="row">
            <div class="col-12 px-3 d-flex justify-content-between">
                <a class="text-white" style="text-decoration: none" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <p class="sct-title fw-500 mb-0 mt-2">Langkah - Langkah Pembuatan</p>
                </a>
                <p><i class="text-white fas fa-chevron-down"></i></p>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="col-12 px-1 d-flex flex-wrap">
                    <?php
                    foreach ($steps as $item) {
                        echo '<span class="text-decoration-none font-md fs-500 fw-bold text-white bg-orange-sm me-1 d-block px-2 py-1 subtitle rounded d-inline-block mt-1 break-word">' . $item . '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/tracker.js" type="text/javascript" charset="utf-8"></script>

</html>
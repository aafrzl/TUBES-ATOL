<?php
require("api/curl.php");

//mengambil data API untuk rekomendasi resep
$end_point = "https://masak-apa-tomorisakura.vercel.app/api/recipes-length/?limit=5";
$recipes = curl($end_point)["results"];

//mengambil data APi untuk explore Resep
$endpoint = "https://masak-apa-tomorisakura.vercel.app/api/recipes/";
$exploreRecipes = curl($endpoint)["results"];

$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$query = (isset($_GET['key'])) ? $_GET['key'] : '';

//Searching resep makanan
if (isset($_GET['key'])) {
    $keyword = $_GET['key'];
    $keyPecah = explode(' ', $keyword);
    $keyPecah2 = implode('%20', $keyPecah);
    $endpoint = "https://masak-apa-tomorisakura.vercel.app/api/search/?q=$keyword";
    $results = curl($endpoint)["results"];
    $categories = false;

    $endpointYT = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBHO-Gf-fzGJZYbNcRkosw6omezGSNLPRM&q=Resep%20$keyPecah2&maxResult=6&part=snippet";
    $hasil = curl($endpointYT);
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
    <link rel="stylesheet" href="css/home.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/utilities.css" type="text/css" media="all" />

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <title>Resep Makanan | Tugas Besar ATOL</title>
</head>

<body>
    <!-- header -->
    <div class="container bg-orange rounded-bottom">
        <div class="row mx-0 px-1">
            <div class="col-12 mt-2 d-flex align-items-center justify-content-center">
                <a href="index.php"><i class="fas fa-concierge-bell text-white"> <span class="fw-bold fs-5 text-white">RESEP MAKANAN</span></i></a>
            </div>
            <div class="col-12 mt-3">
                <form action="" method="GET">
                    <div class="input-group input-group-md mb-3">
                        <input name="key" type="text" class="form-control py-2 px-3" placeholder="Mau masak apa hari ini ?" value="<?php if (isset($_GET['key'])) echo $_GET['key']; ?>">

                        <button class="btn btn-primary w-10" type="submit"><i class="fas fa-search text-white"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- rekomendasi -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 px-3 d-flex mb-0 justify-content-between">
                <p class="fw-bold fw-500">Rekomendasi untuk mu</p>
                <p><i class="fas fa-chevron-right"></i></p>
            </div>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    //render 5 element sebagai rekomendasi untuk user
                    $counter = 1;
                    foreach ($recipes as $recipe) { ?>
                        <div class="carousel-item <?php if ($counter <= 1) {
                                                        echo "active";
                                                    } ?>">
                            <img class="d-block card-img-top rounded" src="<?= $recipe['thumb'] ?>" alt="<?= $recipe['thumb'] ?>">
                            <div class="container">
                                <div class="carousel-caption bg-container-carousel">
                                    <p class="title fw-bold fw-300 text-white mb-0"><?= $recipe['title'] ?></p>
                                    <a class="text-white link text-decoration-none float-end" href="view/?key=<?= $recipe['key'] ?>">
                                        <span class="font-sm fw-300 mt-2 d-flex align-items-center">
                                            <i class="fas fa-eye mx-1 font-sm"></i>
                                            Baca lebih lanjut
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <?php $counter++ ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <!-- hasil dari searching resep API -->
    <div class="container mt-3">
        <div class="row">
            <?php
            if (isset($_GET['key'])) {
                $found = count($results);
                echo '<div class="col-12 px-3 d-flex mb-0 justify-content-between">
            <p class="sct-title mb-0">Search results for
                <br />
                <strong>
                    ' . $keyword . '
                </strong>
                <br />
                <i class="font-sm fw-300">' . $found . ' results found</i>
            </p>
        </div>';
            }
            ?>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 px-3 mt-3 d-flex flex-wrap justify-content-between">
                <?php
                if (isset($_GET['key'])) {
                    $limit = 4;
                    $limit_start = ($page - 1) * $limit;
                    $no = $limit_start + 1;

                    $all_recipes = array_splice($results, $limit_start, $limit, true);

                    foreach ($all_recipes as $recipe) {
                        $title = $recipe['title'];
                        $keyword = $recipe['key'];
                        $thumb = $recipe['thumb'];
                        $times = $recipe['times'];
                        $portion = $recipe['serving'];
                        $dificulty = $recipe['difficulty'];
                        echo '<div class="recipe-card mx-1 mt-1 mb-1 shadow-sm overflow-hidden">
                                <img src="' . $thumb . '" loading="lazy" width="100%" alt="' . $title . '" />
                                <div class="recipe-info mt-1 d-flex flex-nowrap">
                                    <span class="font-xsm mx-1 fw-300 fw-bold text-secondary">
                                        <i class="far fa-clock text-orange font-xsm"></i>
                                        ' . $times . '
                                    </span>
                                    <span class="font-xsm mx-1 fw-300 fw-bold text-secondary">
                                        <i class="fas fa-utensils text-orange font-xsm"></i>
                                        ' . $portion . '
                                    </span>
                                    <span class="font-xsm mx-1 fw-300 fw-bold text-secondary">
                                        <i class="fas fa-walking text-orange font-xsm"></i>
                                        ' . $dificulty . '
                                    </span>
                                </div>
                                <div class="recipe-title px-1 mt-2 mb-3">
                                    <a href="view/?key=' . $keyword . '" class="text-decoration-none link text-dark fw-500 font-md">' . $title . '</a>
                                </div>
                            </div>';
                    } ?>
                    <?php $count = count($results); ?>
                    <!-- PAGINATION -->
                    <nav class="container mt-3 mb-5 d-flex justify-content-center">
                        <ul class="pagination justify-content-center">
                            <?php
                            $key = $_GET['key'];
                            $jumlah_page = ceil($count / $limit);
                            $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                            $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                            $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;

                            if ($page == 1) {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                            } else {
                                $link_prev = ($page > 1) ? $page - 1 : 1;
                                echo '<li class="page-item"><a class="page-link" href="?key=' . $key . '&page=1">First</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="?key=' . $key . '&page=' . $link_prev . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                            }

                            for ($i = $start_number; $i <= $end_number; $i++) {
                                $link_active = ($page == $i) ? ' active' : '';
                                echo '<li class="page-item ' . $link_active . '"><a class="page-link" href="?key=' . $key . '&page=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($page == $jumlah_page) {
                                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                                echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
                            } else {
                                $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                                echo '<li class="page-item"><a class="page-link" href="?key=' . $key . '&page=' . $link_next . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                                echo '<li class="page-item"><a class="page-link" href="?key=' . $key . '&page=' . $jumlah_page . '">Last</a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                    <!-- hasil dari searching Youtube API -->
                    <div class="container mt-3">
                        <div class="col-12 px-3 d-flex justify-content-between">
                            <p class="sct-title fw-500 mb-4">Pencarian Video Resep <?= $_GET['key']; ?></p>
                        </div>
                        <div class="col-12 px-3 mt-3 d-flex flex-wrap justify-content-between">
                            <?php
                            if (!empty($hasil['items'])) {
                                foreach ($hasil['items'] as $item) {
                                    $videoId = $item['id']['videoId'];
                                    $title = $item['snippet']['title'];
                            ?>
                                    <div class="recipe-card mx-1 mt-1 shadow-sm overflow-hidden">
                                        <div class="ratio ratio-16x9 rounded">
                                            <iframe src="https://www.youtube.com/embed/<?= $videoId ?>" title="<?= $title ?>" allowfullscreen></iframe>
                                        </div>
                                        <div class="recipe-title px-1 mt-2 mb-3">
                                            <p class="text-dark fw-500 font-md"><?= $title; ?></p>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                } else { ?>
                    <!-- Explore Resep ketika user tidak searching resep -->
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-12 px-3 d-plex justify-content-between">
                                <p class="sct-title fw-500 mb-4">Explore Resep</p>
                            </div>
                            <div class="col-12 px-3 d-flex flex-wrap justify-content-between">
                                <?php
                                $limit = 4;
                                $limit_start = ($page - 1) * $limit;
                                $no = $limit_start + 1;

                                $all_recipes = array_splice($exploreRecipes, $limit_start, $limit, true);

                                foreach ($all_recipes as $recipe) {
                                    $title = $recipe['title'];
                                    $keyword = $recipe['key'];
                                    $thumb = $recipe['thumb'];
                                    $times = $recipe['times'];
                                    $portion = $recipe['portion'];
                                    $dificulty = $recipe['dificulty'];

                                    echo '<div class="recipe-card mx-1 mt-1 mb-1 shadow-sm overflow-hidden">
                                        <img src="' . $thumb . '" loading="lazy" width="100%" alt="' . $title . '" />
                                        <div class="recipe-info mt-1 d-flex flex-nowrap">
                                            <span class="font-xsm mx-1 fw-300 fw-bold text-secondary">
                                                <i class="far fa-clock text-orange font-xsm"></i>
                                                ' . $times . '
                                            </span>
                                            <span class="font-xsm mx-1 fw-300 fw-bold text-secondary">
                                                <i class="fas fa-utensils text-orange font-xsm"></i>
                                                ' . $portion . '
                                            </span>
                                            <span class="font-xsm mx-1 fw-300 fw-bold text-secondary">
                                                <i class="fas fa-walking text-orange font-xsm"></i>
                                                ' . $dificulty . '
                                            </span>
                                        </div>
                                        <div class="recipe-title px-1 mt-2 mb-3">
                                            <a href="view/?key=' . $keyword . '" class="text-decoration-none link text-dark fw-500 font-md">' . $title . '</a>
                                        </div>
                                    </div>';
                                }
                                ?>
                                <?php $count = count($exploreRecipes); ?>
                                <!-- PAGINATION -->
                                <nav class="container mt-3 mb-5 d-flex justify-content-center">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        $jumlah_page = ceil($count / $limit);
                                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                                        $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                                        $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;

                                        if ($page == 1) {
                                            echo '<li class="page-item disabled"><a class="page-link" href="#">Pertama</a></li>';
                                            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                                        } else {
                                            $link_prev = ($page > 1) ? $page - 1 : 1;
                                            echo '<li class="page-item"><a class="page-link" href="?page=1">Pertama</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="?page=' . $link_prev . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                                        }

                                        for ($i = $start_number; $i <= $end_number; $i++) {
                                            $link_active = ($page == $i) ? ' active' : '';
                                            echo '<li class="page-item ' . $link_active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                        }

                                        if ($page == $jumlah_page) {
                                            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                                            echo '<li class="page-item disabled"><a class="page-link" href="#">Terakhir</a></li>';
                                        } else {
                                            $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                                            echo '<li class="page-item"><a class="page-link" href="?page=' . $link_next . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="?page=' . $jumlah_page . '">Terakhir</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-12 px-3 d-flex justify-content-between">
                                <p class="sct-title fw-500 mb-4">Explore Video Resep Hari Ini</p>
                            </div>
                            <div class="col-12 px-3 mt-3 d-flex flex-wrap justify-content-between">
                                <?php
                                $keyword = 'Resep%20Makanan%20Hari%20Ini';
                                $endpointYT = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyBHO-Gf-fzGJZYbNcRkosw6omezGSNLPRM&q=$keyword&maxResult=6&part=snippet&order=date";
                                $hasil = curl($endpointYT);

                                if (!empty($hasil['items'])) {
                                    foreach ($hasil['items'] as $item) {
                                        $videoId = $item['id']['videoId'];
                                        $title = $item['snippet']['title'];
                                ?>
                                        <div class="recipe-card mx-1 mt-1 shadow-sm overflow-hidden">
                                            <div class="ratio ratio-16x9 rounded">
                                                <iframe src="https://www.youtube.com/embed/<?= $videoId ?>" title="<?= $title ?>" allowfullscreen></iframe>
                                            </div>
                                            <div class="recipe-title px-1 mt-2 mb-3">
                                                <p class="text-dark fw-500 font-md"><?= $title; ?></p>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                    //end if
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
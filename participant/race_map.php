<?php include('../includes/header.php'); ?>

<!-- Hero Section -->
<div class="container-fluid bg-primary text-white py-5 text-center">
    <h1 class="display-4 fw-bold">Marathon Race Map</h1>
    <p class="lead">Explore the map and detailed stages of the marathon below.</p>
</div>

<!-- Race Map Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Marathon Overview Map</h2>
    <p class="text-center">Click on the map to explore more about the marathon stages.</p>
    <div class="text-center mb-5">
        <a href="#stages">
            <img src="../images/map.png" alt="Race Map" class="img-fluid shadow-lg rounded" style="max-width: 90%; height: auto;">
        </a>
    </div>
</div>

<!-- Custom Gallery Carousel -->
<div class="container mt-5">
    <h3 class="text-center mb-4" id="stages">Race Stages Gallery</h3>

    <!-- Bootstrap Carousel -->
    <div id="multiImageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <?php
            $totalStages = 6; // Tổng số Stage
            $stagesPerSlide = 3; // Số ảnh hiển thị trên mỗi slide
            $active = 'active'; // Đánh dấu slide đầu tiên là active

            // Chia thành các slide, mỗi slide chứa $stagesPerSlide ảnh
            for ($i = 1; $i <= ceil($totalStages / $stagesPerSlide); $i++) {
                echo "<div class='carousel-item $active'>
                        <div class='row justify-content-center'>";

                // Hiển thị các stage trên slide hiện tại
                for ($j = 1; $j <= $stagesPerSlide; $j++) {
                    $stageNumber = ($i - 1) * $stagesPerSlide + $j;
                    if ($stageNumber > $totalStages) break; // Thoát nếu vượt quá tổng số stage

                    echo "
                        <div class='col-md-4 col-sm-6 d-flex justify-content-center'>
                            <div class='card shadow-sm' style='width: 18rem;'>
                                <a href='stage_details.php?stage=stage$stageNumber'>
                                    <img src='../images/thumbnails/stage{$stageNumber}_thumbnail.jpg' alt='Stage $stageNumber Thumbnail' class='card-img-top'>
                                </a>
                                <div class='card-body text-center'>
                                    <h5 class='card-title'>Stage $stageNumber</h5>
                                    <a href='stage_details.php?stage=stage$stageNumber' class='btn btn-primary btn-sm'>View Details</a>
                                </div>
                            </div>
                        </div>";
                }

                echo "  </div>
                      </div>";
                $active = ''; // Chỉ slide đầu tiên mới có class 'active'
            }
            ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#multiImageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#multiImageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Footer -->
<?php include('../includes/footer.php'); ?>

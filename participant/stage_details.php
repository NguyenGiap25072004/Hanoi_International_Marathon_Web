<?php include('../includes/header.php'); ?>

<?php
$stage = $_GET['stage'] ?? null;

if (!$stage || !in_array($stage, ['stage1', 'stage2', 'stage3', 'stage4', 'stage5', 'stage6'])) {
    die("<div class='alert alert-danger text-center'>Invalid stage selected.</div>");
}

$stage_details = [
    'stage1' => [
        'title' => 'Stage 1: Starting point at Hoan Kiem Lake.',
        'description' => 'Description: Begin your marathon journey at the iconic Hoan Kiem Lake, a symbol of Hanoi\'s rich history and culture. The serene waters and the historic Turtle Tower provide a picturesque backdrop as you embark on this exciting race.',
        'coordinates' => 'Coordinates: 21.0285° N, 105.8542° E'
    ],
    'stage2' => [
        'title' => 'Stage 2: Running through the Old Quarter.',
        'description' => 'Description: Experience the vibrant atmosphere of Hanoi\'s Old Quarter. This stage takes you through narrow streets bustling with life, where you can catch glimpses of traditional Vietnamese architecture, local markets, and the daily hustle and bustle of the city.',
        'coordinates' => 'Coordinates: 21.0333° N, 105.8500° E'
    ],
    'stage3' => [
        'title' => 'Stage 3: Scenic route along West Lake.',
        'description' => 'Description: Enjoy the scenic beauty of West Lake, Hanoi\'s largest freshwater lake. This stage offers a refreshing change of pace with its tranquil surroundings, lush greenery, and stunning views of the water. It\'s a perfect spot to soak in the natural beauty of the city.',
        'coordinates' => 'Coordinates: 21.0500° N, 105.8200° E'
    ],
    'stage4' => [
        'title' => 'Stage 4: Pass through Long Bien Bridge.',
        'description' => 'Description: Cross the historic Long Bien Bridge, a symbol of resilience and strength. This stage provides a unique perspective of Hanoi, with panoramic views of the Red River and the city\'s skyline. The bridge\'s iron structure and historical significance add a touch of nostalgia to your marathon journey.',
        'coordinates' => 'Coordinates: 21.0419° N, 105.8642° E'
    ],
    'stage5' => [
        'title' => 'Stage 5: Head towards the One Pillar pagoda.',
        'description' => 'Description: Run towards the One Pillar Pagoda, one of Vietnam\'s most iconic Buddhist temples. This stage takes you through peaceful surroundings, allowing you to appreciate the architectural beauty and spiritual significance of this ancient site.',
        'coordinates' => 'Coordinates: 21.0368° N, 105.8342° E'
    ],
    'stage6' => [
        'title' => 'Stage 6: Finish line at The Temple of Literature.',
        'description' => 'Description: Conclude your marathon at the Temple of Literature, Vietnam\'s first national university. This historic site, dedicated to Confucius, offers a grand and inspiring finish to your race. The beautiful courtyards, ancient trees, and traditional Vietnamese architecture make it a memorable end to your marathon journey.',
        'coordinates' => 'Coordinates: 21.0285° N, 105.8355° E'
    ]
];

$current_stage_detail = $stage_details[$stage];
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="display-4"><?php echo $current_stage_detail['title']; ?></h2>
        <p class="lead"><?php echo $current_stage_detail['description']; ?></p>
        <p class="text-muted"><?php echo $current_stage_detail['coordinates']; ?></p>
    </div>

    <!-- Hiển thị ảnh lớn của stage -->
    <div class="text-center">
        <img src="../images/gallery/<?php echo $stage; ?>.jpg" alt="<?php echo ucfirst($stage); ?> Image" class="img-fluid rounded shadow-lg" style="max-width: 80%; height: auto;">
    </div>

    <!-- Nút quay lại -->
    <div class="text-center mt-4">
        <a href="race_map.php" class="btn btn-secondary btn-lg shadow-sm">Back to Race Map</a>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

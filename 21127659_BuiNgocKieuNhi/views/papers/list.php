<?php
    session_start();
    $page_title = "List Papers - BBB";
    include(__DIR__ . '/../layout/header.php'); 
?>

<div class="main-container">
    <div class="paper-list-container">
        <h2 class="paper-list-title">List Papers</h2>
        <hr class="breakline">

        <div class="filter-dropdown">
            <button class="btn-filter">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <div class="dropdown-content">
                <a href="#" class="active">All</a>
                <?php foreach ($topics as $topic): ?>
                    <a href="#"><?= htmlspecialchars($topic['topic_name']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="paper-list-grid">
            <?php foreach ($papers as $paper): ?>
                <a href="index.php?action=detail-paper&id=<?= $paper['paper_id'] ?>" class="paper-list-card">
                    <h4 class="paper-list-title"><?= htmlspecialchars($paper['title']) ?></h4>
                    <p class="paper-list-description"><strong>Authors:</strong> <?= htmlspecialchars($paper['author_string_list']) ?></p>
                    <p class="paper-list-description"><strong>Topic:</strong> <?= htmlspecialchars($paper['topic_name']) ?></p>
                    <p class="paper-list-description"><strong>Conference:</strong> <?= htmlspecialchars($paper['conference_name']) ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <ul class="pagination">
            <li><a href="#">«</a></li>
            <li><a class="active" href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">»</a></li>
        </ul>
    </div>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>

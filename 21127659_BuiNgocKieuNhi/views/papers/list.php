<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $page_title = "List Papers - BBB";
    include(__DIR__ . '/../layout/header.php'); 
?>
<script src="/21127659_BuiNgocKieuNhi/assets/js/ajax.js"></script>

<div class="main-container">
    <div class="paper-list-container">
        <h2 class="paper-list-title">List Papers</h2>
        <hr class="breakline">

        <!-- Filter dropdown -->
        <div class="filter-dropdown">
            <button class="btn-filter">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <div class="dropdown-content">
                <a href="index.php?action=list-papers" class="active" data-id="" onclick="filterByTopic('', '')">All</a>
                <?php foreach ($topics as $topic): ?>
                    <a href="#" data-id="<?= $topic['topic_id'] ?>" onclick="filterByTopic('<?= $topic['topic_id'] ?>', '<?= addslashes($topic['topic_name']) ?>')">
                        <?= htmlspecialchars($topic['topic_name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Paper list -->
        <div id="search-result" class="paper-list-grid">
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
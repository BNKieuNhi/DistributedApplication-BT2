<?php
    $page_title = "Search Papers - BBB";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<?php if (empty($papers)): ?>
    <p>Không tìm thấy kết quả phù hợp.</p>
<?php else: ?>
    <p class="result-count">Có <strong><?= count($papers) ?></strong> kết quả</p>
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
<?php endif; ?>

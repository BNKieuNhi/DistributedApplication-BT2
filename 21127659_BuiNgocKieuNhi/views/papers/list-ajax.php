<?php
    $page_title = "List Papers - BBB";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<?php if (!empty($papers)): ?>
    <?php foreach ($papers as $paper): ?>
        <a href="index.php?action=detail-paper&id=<?= $paper['paper_id'] ?>" class="paper-list-card">
            <h4 class="paper-list-title"><?= htmlspecialchars($paper['title']) ?></h4>
            <p class="paper-list-description"><strong>Authors:</strong> <?= htmlspecialchars($paper['author_string_list']) ?></p>
            <p class="paper-list-description"><strong>Topic:</strong> <?= htmlspecialchars($paper['topic_name']) ?></p>
            <p class="paper-list-description"><strong>Conference:</strong> <?= htmlspecialchars($paper['conference_name']) ?></p>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <p>No papers found for this topic.</p>
<?php endif; ?>

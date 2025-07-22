<?php include(__DIR__ . '/../layout/header.php'); ?>

<!-- Main -->
<div class="main-container">
    <section class="intro-section">
        <div class="intro-left">
            <h2>Hello, wishing you a wonderful new day</h2>
            <p>
            This is a place where you can share your research papers and explore 
            works from other users around the world across a wide range of topics. 
            Let’s discover the latest scientific studies together.                
            </p>
            <a href="index.php?action=list-papers" class="btn-primary">All papers</a>
        </div>
        <div class="intro-right">
            <img src="/DistributedSystem/21127659_BuiNgocKieuNhi/assets/images/banner.png" alt="Banner image">
        </div>
    </section>

    <section class="topic-section">
        <div class="topic-header">
            Latest papers by topic
        </div>

        <hr class="breakline">

        <?php foreach ($latestPapersByTopic as $topicData): ?>
            <div class="topic">
                <h class="subtopic-header"><?= htmlspecialchars($topicData['topic_name']) ?></h>
                <!-- <a href="#" class="view-all">View All &gt;&gt;</a> -->
            </div>

            <?php foreach ($topicData['papers'] as $paper): ?>
                <a href="index.php?action=detail&paper_id=<?= $paper->paper_id ?>" class="paper-card">
                    <div class="paper-title"><?= htmlspecialchars($paper->title) ?></div>
                    <div class="paper-authors"><?= htmlspecialchars($paper->author_string_list) ?></div>
                </a>
            <?php endforeach; ?>
        <?php endforeach; ?>


    </section>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>

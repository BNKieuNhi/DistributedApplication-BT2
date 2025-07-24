<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Search Papers - BBB";
include(__DIR__ . '/../layout/header.php');
?>
<script src="/21127659_BuiNgocKieuNhi/assets/js/ajax.js"></script>

<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Advanced Search</h2>
        <hr class="breakline">

        <form class="search-form" onsubmit="searchPapers(); return false;">
            <div class="search-row">
                <label class="form-label" for="keyword">Keyword</label>
                <input type="text" id="keyword" class="input-field" placeholder="Article title">
            </div>

            <div class="search-row">
                <label class="form-label" for="author">Author</label>
                <select id="author" class="input-field">
                    <option value="">Select author</option>
                    <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['user_id'] ?>"><?= htmlspecialchars($author['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search-row">
                <label class="form-label" for="conference">Conference</label>
                <select id="conference" class="input-field">
                    <option value="">Select conference</option>
                    <?php foreach ($conferences as $conf): ?>
                    <option value="<?= $conf['conference_id'] ?>"><?= htmlspecialchars($conf['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search-row">
                <label class="form-label" for="topic">Topic</label>
                <select id="topic" class="input-field">
                    <option value="">Select topic</option>
                    <?php foreach ($topics as $t): ?>
                    <option value="<?= $t['topic_id'] ?>"><?= htmlspecialchars($t['topic_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search-btn-wrapper">
                <button type="submit" class="btn-primary p-center">
                    <i class="fa-solid fa-magnifying-glass"></i> Search
                </button>
            </div>
        </form>
    </section>

    <section class="paper-list-container">
        <h2 class="paper-list-title">Result</h2>
        <hr class="breakline">
        <div id="search-result">
            <!-- AJAX result will appear here -->
        </div>
    </section>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>

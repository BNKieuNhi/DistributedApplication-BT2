<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Add New Paper - BBB";
include(__DIR__ . '/../layout/header.php');
?>
<script src="/21127659_BuiNgocKieuNhi/assets/js/function.js"></script>
        
<!-- Main -->
<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Add New Paper</h2>
        <hr class="breakline">

        <form class="search-form" method="POST" action="index.php?action=add-paper">
            <div class="search-row">
                <label class="form-label" for="title">Title</label>
                <input type="text" id="title" name="title" class="input-field" placeholder="Article title" required>
            </div>

            <div class="search-row">
                <label class="form-label" for="summary">Summary</label>
                <input type="text" id="summary" name="summary" class="input-field" placeholder="Summary" required>
            </div>

            <div class="search-row">
                <label class="form-label" for="topic_id">Topic</label>
                <select id="topic_id" name="topic_id" class="input-field">
                    <option value="">Select topic</option>
                    <?php foreach ($topics as $topic): ?>
                        <option value="<?= $topic['topic_id'] ?>"><?= htmlspecialchars($topic['topic_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search-row">
                <label class="form-label" for="conference_id">Conference</label>
                <select id="conference_id" name="conference_id" class="input-field">
                    <option value="">Select conference</option>
                    <?php foreach ($conferences as $conf): ?>
                        <option value="<?= $conf['conference_id'] ?>"><?= htmlspecialchars($conf['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="author-list-section">
                <h3 class="form-label">List Author</h3>
                <hr class="breakline">

                <!-- Nơi chứa toàn bộ danh sách author -->
                <div id="author-list">
                    <div class="author-row">
                        <select name="authors[]" class="input-field">
                            <?php foreach ($authors as $author): ?>
                                <option value="<?= $author['user_id'] ?>"><?= htmlspecialchars($author['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="roles[]" class="input-field">
                            <option value="first_author">First Author</option>
                            <option value="member">Member</option>
                        </select>
                        <script>
                        const authorOptions = `<?php
                            foreach ($authors as $author) {
                                echo '<option value="' . $author['user_id'] . '">' . htmlspecialchars($author['full_name'], ENT_QUOTES) . '</option>';
                            }
                        ?>`;
                        </script>
                        <!-- Dòng đầu tiên không có nút xóa -->
                        <button type="button" class="delete-btn disabled-btn">✖</button>

                    </div>
                </div>

                <div class="add-author-link">
                    <a href="#" onclick="addAuthorRow(event)">+ Add new author</a>
                </div>
            </div>

            <div class="search-btn-wrapper">
                <button type="submit" class="btn-primary p-center">Add new paper</button>
            </div>
        </form>

    </section>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "User Profile - BBB";
include(__DIR__ . '/../layout/header.php');
?>

<!-- Main -->
<div class="main-container">
    <section class="profile-container">
        <div class="profile-header">
            <img src="/21127659_BuiNgocKieuNhi/assets<?= htmlspecialchars($author->image_path) ?>" 
                alt="Profile Avatar" class="profile-avatar" id="avatar-preview">
            <h2 class="profile-name"><?= htmlspecialchars($author->full_name) ?></h2>
        </div>

        <div class="profile-content">
            <div class="profile-section user-details">
                <div class="section-header">
                    <h3>User details</h3>
                    <a href="index.php?action=edit-profile" class="edit-profile">Edit profile</a>
                </div>

                <?php
                $profile = json_decode($author->profile_json_text, true);
                ?>

                <p class="user-detail"><strong>Bio</strong><br><?= htmlspecialchars($profile['bio'] ?? 'Updating...') ?></p>
                <p class="user-detail">
                    <strong>Interests</strong><br>
                    <?= isset($profile['interests']) && is_array($profile['interests']) 
                        ? htmlspecialchars(implode(", ", $profile['interests'])) 
                        : 'Updating...' ?>
                </p>
                <p class="user-detail"><strong>Education</strong><br><?= htmlspecialchars($profile['education'] ?? 'Updating...') ?></p>
                <p class="user-detail"><strong>Work Experiences</strong><br><?= htmlspecialchars($profile['experience'] ?? 'Updating...') ?></p>
                <p class="user-detail"><strong>Email address</strong><br><a class="edit-profile" href="mailto:<?= htmlspecialchars($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></a></p>
                <p class="user-detail"><strong>Website address</strong><br>
                    <a class="edit-profile" href="<?= htmlspecialchars($author->website ?? '#') ?>" target="_blank"><?= htmlspecialchars($author->website ?? 'N/A') ?></a>
                </p>
            </div>

            <div class="profile-section article-details">
                <div class="topic">
                    <h3 class="subtopic-header">Your Papers</h3>
                </div>

                <?php if (!empty($papers)): ?>
                    <?php foreach ($papers as $paper): ?>
                        <a href="index.php?action=detail-paper&id=<?= $paper['paper_id'] ?>" class="paper-card">
                            <div class="paper-title"><?= htmlspecialchars($paper['title']) ?></div>
                            <div class="paper-authors"><?= htmlspecialchars($paper['author_string_list']) ?></div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-result">You haven't submitted any papers yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>

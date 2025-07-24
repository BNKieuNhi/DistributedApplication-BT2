<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "User Profile - BBB";
include(__DIR__ . '/../layout/header.php');
?>
        
<!-- Main -->
<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Edit Profile</h2>
        <hr class="breakline">

        <form class="search-form" method="post" action="index.php?action=update-profile" enctype="multipart/form-data">
            <div class="profile-header">
                <img src="/21127659_BuiNgocKieuNhi/assets<?= htmlspecialchars($author->image_path) ?>"
                    alt="Profile Avatar" class="profile-avatar" id="avatar-preview">
                
                <input type="file" name="upload-photo" id="upload-photo" accept="image/*" hidden onchange="previewImage(event)">
                <button type="button" class="btn-primary" onclick="document.getElementById('upload-photo').click()">New photo</button>
            </div>

            <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('avatar-preview');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            </script>

            <div class="search-row">
                <label class="form-label" for="fullname">Fullname</label>
                <input type="text" id="fullname" name="fullname" class="input-field" 
                    value="<?= htmlspecialchars($author->full_name) ?>">

            </div>

            <div class="search-row">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field"
                    value="<?= htmlspecialchars($user['email'] ?? '') ?>">
            </div>

            <div class="search-row">
                <label class="form-label" for="website">Website</label>
                <input type="text" id="website" name="website" class="input-field"
                    value="<?= htmlspecialchars($author->website) ?>">
            </div>

            <div class="search-row">
                <label class="form-label" for="bio">Bio</label>
                <input type="text" id="bio" name="bio" class="input-field"
                    value="<?= htmlspecialchars($profile['bio'] ?? '') ?>">
            </div>

            <div class="search-row">
                <label class="form-label" for="interests">Interests</label>
                <input type="text" id="interests" name="interests" class="input-field"
                    value="<?= isset($profile['interests']) ? htmlspecialchars(implode(', ', $profile['interests'])) : '' ?>">
            </div>

            <div class="search-row">
                <label class="form-label" for="education">Education</label>
                <input type="text" id="education" name="education" class="input-field"
                    value="<?= htmlspecialchars($profile['education'] ?? '') ?>">
            </div>

            <div class="search-row">
                <label class="form-label" for="experience">Work Experiences</label>
                <input type="text" id="experience" name="experience" class="input-field"
                    value="<?= htmlspecialchars($profile['experience'] ?? '') ?>">
            </div>

            <div class="login-buttons">
                <button type="submit" class="btn-primary">Update</button>
                <button type="button" class="btn-outline" onclick="window.location.href='index.php?action=profile'">Cancel</button>
            </div>
        </form>  
    </section> 
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
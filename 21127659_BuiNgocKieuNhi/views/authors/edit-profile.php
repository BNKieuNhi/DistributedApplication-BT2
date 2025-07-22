<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - BBB</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
       <header class="nav-container">
            <div class="nav-left">
                <img src="/assets/images/smile-2_removebg.png" alt="Smile.png" class="nav-header__logo">
                <h1 class="nav-header__name">BBB</h1>
            </div>
            <div class="nav-items">
                <a class="nav-item" href="#">Homepage</a>
                <a class="nav-item" href="#">Papers</a>
                <a class="nav-item" href="#">Search</a>
            </div>
            <div class="nav-right">
                <a href="#" class="btn-header">Login</a>
            </div>
        </header>
        
        <!-- Main -->
        <div class="main-container">
            <section class="paper-list-container">
                <h2 class="paper-list-title">Edit Profile</h2>
                <hr class="breakline">

                <form class="search-form">
                    <div class="profile-header">
                        <img src="" alt="" class="profile-avatar" id="avatar-preview">
                        <input type="file" id="upload-photo" accept="image/*" hidden>
                        <button type="button" class="btn-primary" onclick="document.getElementById('upload-photo').click()">New photo</button>
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="fullname">Fullname</label>
                        <input type="text" id="fullname" class="input-field" value="John Smith">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" class="input-field" value="john.smith@example.com">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="website">Website</label>
                        <input type="text" id="website" class="input-field" value="http://johnsmith.com">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="bio">Bio</label>
                        <input type="text" id="bio" class="input-field" value="John is a researcher in computer science">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="interests">Interests</label>
                        <input type="text" id="interests" class="input-field" value="AI, Machine Learning">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="education">Education</label>
                        <input type="text" id="education" class="input-field" value="Master">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="experience">Work Experiences</label>
                        <input type="text" id="experience" class="input-field" value="None">
                    </div>

                    <div class="login-buttons">
                        <button type="submit" class="btn-primary">Update</button>
                        <button type="button" class="btn-outline">Cancel</button>
                    </div>
                </form>  
            </section> 
        </div>

        <!-- Footer -->
        <footer>
            <div class="footer-grid">
                <div class="footer-col">
                    <p><strong>Subject</strong><br>Distributed System - 21HTTT</p>
                    <p><strong>Student</strong><br>21127659 - Bui Ngoc Kieu Nhi</p>
                    </div>
                <div class="footer-col">
                    <p><strong>Monday - Saturday:</strong> 7:00 am - 9:00 pm</p>
                    <p><strong>Sunday:</strong> Close</p>
                </div>
                <div class="footer-col">
                    <p><strong>Address</strong><br>Nguyen Van Cu street, district 5, Ho Chi Minh city</p>
                    <p><strong>Phone</strong><br>01112023</p>
                </div>
            </div>
            <hr class="breakline">
            <div class="social-icons">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-facebook"></i>
            </div>
        </footer>
    </div>
</body>
</html>
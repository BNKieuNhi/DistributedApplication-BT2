<?php include '../layout/header.php'; ?>
        
        <!-- Main -->
        <div class="main-container">
            <section class="paper-list-container">
                <h2 class="paper-list-title">Advanced Search</h2>
                <hr class="breakline">

                <form class="search-form">
                    <div class="search-row">
                        <label class="form-label" for="keyword">Keyword</label>
                        <input type="text" id="keyword" class="input-field" placeholder="Article title">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="author">Author</label>
                        <select id="author" class="input-field">
                            <option>Select author</option>
                        </select>
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="conference">Conference</label>
                        <select id="conference" class="input-field">
                            <option>Select conference</option>
                        </select>
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="topic">Topic</label>
                        <select id="topic" class="input-field">
                            <option>Select topic</option>
                        </select>
                    </div>

                    <div class="search-row date-row">
                        <div class="search-row">
                            <label class="form-label" for="from">From</label>
                            <input type="date" id="from" class="input-field">
                        </div>
                        <div class="search-row">
                            <label class="form-label" for="to">To</label>
                            <input type="date" id="to" class="input-field">
                        </div>
                    </div>

                    <div class="search-btn-wrapper">
                        <button type="submit" class="btn-primary p-center">
                            <i class="fa-solid fa-magnifying-glass"></i> Search
                        </button>
                    </div>
                </form>
            </section>

            <!-- Result Section -->
            <section class="paper-list-container">
                <h2 class="paper-list-title">Result</h2>
                <hr class="breakline">
                <p class="result-count">Có <strong>4</strong> kết quả</p>

                <div class="paper-list-grid">
                    <a href="#" class="paper-list-card">
                        <h4 class="paper-list-title">Data Science Applications in Healthcare</h4>
                        <p class="paper-list-description"><strong>Authors:</strong> Michael Brown, Emily Davis, David Harris</p>
                        <p class="paper-list-description"><strong>Topic:</strong> Artificial Intelligence</p>
                        <p class="paper-list-description"><strong>Conference:</strong> ICAI 2024</p>
                    </a>

                    <a href="#" class="paper-list-card">
                        <h4 class="paper-list-title">Data Science Applications in Healthcare</h4>
                        <p class="paper-list-description"><strong>Authors:</strong> Michael Brown, Emily Davis, David Harris</p>
                        <p class="paper-list-description"><strong>Topic:</strong> Artificial Intelligence</p>
                        <p class="paper-list-description"><strong>Conference:</strong> ICAI 2024</p>
                    </a>
                </div>
            </section>

        </div>

<?php include '../layout/footer.php'; ?>

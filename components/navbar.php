<?php
?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark px-4 ">
    <a class="navbar-brand" href="/cwh/quiz/index.php">Quiz</a>
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId"
        aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<a class='nav-link' href='/cwh/quiz/components/logout.php'>logout</a>";
                } else {
                    echo "<a class='nav-link' href='/cwh/quiz/components/login.php'>login</a>";
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<a class='nav-link' href='/cwh/quiz/components/signup.php'>Sign Up</a>";
                }
                ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/cwh/quiz/components/dashboard.php">
                    <?php
                    if (isset($_SESSION['role']) == 'admin') {
                        echo 'Dashboard';
                    }
                    ?>
                </a>
            </li>

        </ul>

        <div class="nav-item d-flex flex-row">
            <h5 class="text-white mx-3">
                <?php if (isset($_SESSION['username']))
                    echo $_SESSION['username'] ?>
                </h5>
                <span class="text-white">
                <?php ?>
            </span>

        </div>
        <div class="nav-item">
            <small class="text-white">
            </small>
        </div>
    </div>
</nav>
<header id="header" class="transparent-header-modern fixed-header-bg-white w-100">
    <div class="main-nav secondary-nav hover-success-nav py-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light p-0">
                        <a class="navbar-brand position-relative" href="index.php">
                            <img class="nav-logo" src="images/logo/restatelg.png" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item"> <a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"> <a class="nav-link" href="about.php">About</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="contact.php">Contact</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="property.php">Properties</a> </li>
                                <!-- <li class="nav-item"> <a class="nav-link" href="agent.php">Agent</a> </li> -->
                            </ul>
                            <div class="ml-auto d-flex align-items-center">
                                <a class="btn btn-success d-none d-xl-block mr-3" style="border-radius:10px;" href="submitproperty.php">+ Pasang Iklan</a>
                                <ul class="navbar-nav">
                                    <?php if(isset($_SESSION['uemail'])) { ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="admin/user/<?= htmlspecialchars($_SESSION['uimage']); ?>" alt="User Photo" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 8px;">
                                                <?= htmlspecialchars($_SESSION['uname']); ?>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="nav-item"> <a class="nav-link" href="profile.php">Profile</a> </li>
                                                <li class="nav-item"> <a class="nav-link" href="feature.php">Your Property</a> </li>
                                                <li class="nav-item"> <a class="nav-link" href="logout.php">Logout</a> </li>
                                            </ul>
                                        </li>
                                    <?php } else { ?>
                                        <li class="nav-item"> <a class="nav-link" href="login.php">Login/Register</a> </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
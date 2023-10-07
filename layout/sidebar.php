<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <?php if ($_SESSION['role'] == 'kajur') { ?>
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="m_aslab.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Aslab
                </a>
                <div class="sb-sidenav-menu-heading">Manage</div>
                <a class="nav-link" href="m_tahunAkd.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Tahun Akademik
                </a>
                <a class="nav-link" href="m_jadwal.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Jadwal
                </a>
                <a class="nav-link" href="m_kelas.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-school"></i></div>
                    Data Kelas
                </a>
                <a class="nav-link" href="m_guru.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Guru
                </a>
                <a class="nav-link" href="m_ruangan.php">
                    <div class="sb-nav-link-icon"><i class="far fa-circle"></i></div>
                    Ruangan
                </a>
                <div class="sb-sidenav-menu-heading">Data</div>
                <a class="nav-link" href="m_inventaris.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Inventaris
                </a>

            <?php } ?>

            <?php if ($_SESSION['role'] == 'aslab') { ?>
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Manage</div>
                <a class="nav-link" href="m_inventaris.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Inventaris
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        <?php
        if ($_SESSION['role'] == 'kajur') {
            echo 'Ketua Jurusan (Kajur)';
        } elseif ($_SESSION['role'] == 'aslab') {
            echo 'Asisten lab (Aslab)';
        }
        ?>
    </div>
</nav>
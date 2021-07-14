<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= !isset($_GET['page']) ? 'active' : ''; ?>" href="/dashboard">
                <span data-feather="home"></span>
                Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $_GET['page'] == 'listar' ? 'active' : ''; ?>" href="/dashboard?page=listar">
                <span data-feather="list"></span>
                Listar Devedores
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $_GET['page'] == 'adicionar' ? 'active' : ''; ?>" href="/dashboard?page=adicionar">
                <span data-feather="plus"></span>
                Adicionar Devedor
                </a>
            </li>
        </ul>
    </div>
</nav>

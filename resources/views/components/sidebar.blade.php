<aside class="sidebar">

    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fa-solid fa-dollar-sign"></i>
        </div>

        <span>Meu Financeiro</span>
    </div>

    <nav class="sidebar-menu">

        <a href="/" class="menu-item active">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('incomes.index') }}" class="menu-item">
            <i class="fa-solid fa-arrow-trend-up"></i>
            <span>Receitas</span>
        </a>

        <a href="{{ route('expenses.index') }}" class="menu-item">
            <i class="fa-solid fa-arrow-trend-down"></i>
            <span>Despesas</span>
        </a>

        <a href="{{ route('installments.index') }}" class="menu-item">
            <i class="fa-solid fa-credit-card"></i>
            <span>Parcelamentos</span>
        </a>

        <a href="{{ route('receivables.index') }}" class="menu-item">
            <i class="fa-solid fa-hand-holding-dollar"></i>
            <span>A receber</span>
        </a>

        <a href="{{ route('goals.index') }}" class="menu-item">
            <i class="fa-solid fa-bullseye"></i>
            <span>Metas</span>
        </a>

        <a href="{{ route('categories.index') }}" class="menu-item">
            <i class="fa-solid fa-layer-group"></i>
            <span>Categorias</span>
        </a>


    </nav>

    <div class="sidebar-footer">

        <a href="#" class="menu-item">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Sair</span>
        </a>

    </div>

</aside>

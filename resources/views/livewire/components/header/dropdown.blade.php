<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user" src="/assets/images/user-default.jpeg" alt="Header Avatar">
    </button>
    <div class="dropdown-menu dropdown-menu-end pt-0">
        <a class="dropdown-item" href="{{route('profile')}}">
            <i class='bx bx-user-circle text-muted font-size-18 align-middle me-1'></i>
            <span class="align-middle">Meu Perfil</span>
        </a>
        @unless(Auth::user()->isUser())
        <a class="dropdown-item" href="{{route('company')}}">
            <i class='bx bx-buildings text-muted font-size-18 align-middle me-1'></i>
            <span class="align-middle">Empresa</span>
        </a>
        <a class="dropdown-item" href="{{route('roles.index')}}">
            <i class='bx bx-group text-muted font-size-18 align-middle me-1'></i>
            <span class="align-middle">Funções</span>
        </a>
        <a class="dropdown-item" href="{{route('permissions.index')}}">
            <i class='bx bx-id-card text-muted font-size-18 align-middle me-1'></i>
            <span class="align-middle">Permissões</span>
        </a>
        @endunless
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" wire:click="logout">
            <i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i>
            <span class="align-middle">Sair</span>
        </a>
    </div>
</div>
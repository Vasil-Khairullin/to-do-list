<aside class="offcanvas-lg offcanvas-start bg-body-tertiary shadow-sm rounded-4 h-100 sidebar-wrapper" tabindex="-1" id="sidebarMenu" style="width: 280px; min-height: 100vh;">
    
    <div class="offcanvas-header border-bottom d-lg-none p-3">
        <a href="{{ route('tasks.index') }}" class="d-flex align-items-center text-decoration-none text-body fw-bold fs-5 gap-2">
            <span class="bg-primary text-white rounded-3 p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-check2-square fs-5"></i>
            </span>
            <span>TaskFlow</span>
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Закрыть"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3 h-100">
        
        <div class="d-none d-lg-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
            <a href="{{ route('tasks.index') }}" class="d-flex align-items-center text-decoration-none text-body fw-bold fs-5 gap-2">
                <span class="bg-primary text-white rounded-3 p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-check2-square fs-5"></i>
                </span>
                <span>TaskFlow</span>
            </a>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1 fs-7">Pro</span>
        </div>

        <button class="btn btn-primary w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm mb-3" 
                data-bs-toggle="modal" 
                data-bs-target="#createTaskModal">
            <i class="bi bi-plus-lg fs-5"></i>
            <span>Новая задача</span>
        </button>

        <div class="overflow-y-auto flex-grow-1 pe-1">
            
            <div class="mb-3">
                <small class="text-uppercase text-muted fw-bold fs-8 tracking-wider px-2 d-block mb-2">Задачи</small>
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}" class="nav-link d-flex align-items-center justify-content-between rounded-3 {{ request()->routeIs('tasks.index') ? 'active' : 'text-body' }}">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-inbox fs-5"></i> Входящие
                            </span>
                            <span class="badge bg-secondary-subtle text-body rounded-pill fs-7">12</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 {{ request()->routeIs('tasks.today') ? 'active' : 'text-body' }}">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-sun text-warning fs-5"></i> Мой день
                            </span>
                            <span class="badge bg-primary rounded-pill fs-7">4</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-calendar3 text-info fs-5"></i> Запланировано
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-star text-danger fs-5"></i> Важное
                            </span>
                            <span class="badge bg-danger-subtle text-danger rounded-pill fs-7">2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle text-success fs-5"></i> Завершённые
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-3">
                <small class="text-uppercase text-muted fw-bold fs-8 tracking-wider px-2 d-block mb-2">Саморазвитие</small>
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('habits.index') }}" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-lightning-charge text-warning fs-5"></i> Привычки
                            </span>
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill fs-7"> 🔥 5 дней</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-stopwatch text-danger fs-5"></i> Фокус (Pomodoro)
                            </span>
                            <span class="badge bg-secondary-subtle text-muted fs-8">Скоро</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between px-2 mb-2">
                    <small class="text-uppercase text-muted fw-bold fs-8 tracking-wider">Категории</small>
                    <button class="btn btn-link text-decoration-none p-0 text-muted fs-6" title="Создать категорию" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
                <ul class="nav nav-pills flex-column gap-1">
                    <li>
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <span class="rounded-circle bg-primary d-inline-block" style="width: 10px; height: 10px;"></span>
                                Работа
                            </span>
                            <span class="text-muted fs-7">8</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <span class="rounded-circle bg-success d-inline-block" style="width: 10px; height: 10px;"></span>
                                Личное
                            </span>
                            <span class="text-muted fs-7">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <span class="rounded-circle bg-purple d-inline-block" style="width: 10px; height: 10px; background-color: #6f42c1;"></span>
                                Учёба
                            </span>
                            <span class="text-muted fs-7">5</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-3">
                <small class="text-uppercase text-muted fw-bold fs-8 tracking-wider px-2 d-block mb-2">Инструменты</small>
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-graph-up-arrow text-primary fs-5"></i> Аналитика
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-tags text-secondary fs-5"></i> Метки & Теги
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-people text-info fs-5"></i> Команды
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between rounded-3 text-body">
                            <span class="d-flex align-items-center gap-2">
                                <i class="bi bi-trash3 text-muted fs-5"></i> Корзина
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="pt-3 mt-auto border-top">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-body text-decoration-none dropdown-toggle p-2 rounded-3 hover-bg" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=0D6EFD&color=fff" alt="User" width="36" height="36" class="rounded-circle me-2 shadow-sm">
                    <div class="d-flex flex-column text-truncate me-auto">
                        <strong class="fs-7 text-truncate">{{ auth()->user()->name ?? 'Алексей' }}</strong>
                        <small class="text-muted fs-8 text-truncate">{{ auth()->user()->email ?? 'alex@example.com' }}</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2 mb-2" aria-labelledby="dropdownUser" style="width: 240px;">
                    <li><a class="dropdown-item rounded-2 py-2" href="{{ route('settings.index') }}"><i class="bi bi-gear me-2"></i> Настройки</a></li>
                    <li><a class="dropdown-item rounded-2 py-2" href="#"><i class="bi bi-palette me-2"></i> Темы оформления</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-2 py-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Выйти
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</aside>
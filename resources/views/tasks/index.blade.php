@extends('layouts.app')

@section('content')
<style>
    /* Кастомные стили в едином стиле с календарем и привычками */
    .tasks-container {
        font-family: inherit;
    }

    /* Карточка отдельной задачи */
    .task-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background-color: #ffffff;
    }

    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
    }

    /* Состояние выполненной задачи */
    .task-card.is-completed {
        opacity: 0.65;
        background-color: #f8f9fa;
    }

    .task-card.is-completed .task-title {
        text-decoration: line-through;
        color: #6c757d;
    }

    /* Кастомный современный чекбокс */
    .task-checkbox {
        width: 22px;
        height: 22px;
        border-radius: 50% !important;
        cursor: pointer;
        border: 2px solid #adb5bd;
        transition: all 0.2s ease;
    }

    .task-checkbox:checked {
        background-color: #198754;
        border-color: #198754;
    }

    /* Приоритеты */
    .priority-high-border { border-left: 4px solid #dc3545 !important; }
    .priority-medium-border { border-left: 4px solid #ffc107 !important; }

    /* Вложенные подзадачи (Subtasks) */
    .subtasks-wrapper {
        border-top: 1px dashed #e9ecef;
        margin-top: 12px;
        padding-top: 12px;
    }

    .subtask-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 6px 0;
        font-size: 0.875rem;
    }

    /* Бейджи категорий и дедлайнов */
    .task-badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap; /* Чтобы бейджи не переносились внутри себя */
    }

    /* Горизонтальный скролл для фильтров (UX для мобильных) */
    .filters-wrapper {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 4px;
        -ms-overflow-style: none; /* IE и Edge */
        scrollbar-width: none; /* Firefox */
    }
    
    .filters-wrapper::-webkit-scrollbar {
        display: none; /* Chrome, Safari и Opera */
    }

    .filter-pill {
        border-radius: 20px;
        padding: 6px 16px;
        font-weight: 500;
        font-size: 0.875rem;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.2s ease;
        flex-shrink: 0; /* Чтобы кнопки не сжимались при скролле */
    }

    .filter-pill.active {
        background-color: #212529;
        color: #ffffff;
    }

    .filter-pill:hover:not(.active) {
        background-color: #e9ecef;
        color: #212529;
    }

    /* Плавающая кнопка для мобильных устройств (FAB) */
    .fab-mobile {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1050;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        transition: transform 0.2s ease;
    }
    
    .fab-mobile:active {
        transform: scale(0.95);
    }

    /* Ограничение ширины поиска на десктопе */
    @media (min-width: 992px) {
        .search-container { max-width: 250px; }
    }
</style>

<div class="container-xl py-4 tasks-container px-3 px-md-4">
    <div class="row g-4">
        
        <!-- Левая колонка: Задачи -->
        <div class="col-lg-8">
            
            <!-- Заголовок и кнопка -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Мои задачи</h3>
                    <p class="text-muted small mb-0">Осталось выполнить 4 задачи на сегодня</p>
                </div>
                <!-- Кнопка для планшетов и ПК -->
                <button class="btn btn-primary rounded-pill px-4 py-2 d-none d-sm-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Новая задача
                </button>
            </div>

            <!-- Карточка прогресса -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-dark text-white p-2">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <span class="badge bg-primary mb-2 rounded-pill">Продуктивность</span>
                        <h5 class="fw-bold mb-1">Выполнено 3 из 7 задач</h5>
                        <p class="mb-0 opacity-75 small">Продолжайте в том же духе, чтобы закрыть все дедлайны!</p>
                    </div>
                    <div class="text-start text-md-end">
                        <span class="display-6 fw-bold text-success">43%</span>
                    </div>
                </div>
            </div>

            <!-- Фильтры и Поиск -->
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-stretch align-items-lg-center gap-3 mb-2">
                <!-- Скроллируемые фильтры для мобилок -->
                <div class="filters-wrapper flex-grow-1">
                    <a href="#" class="filter-pill active">Все задачи</a>
                    <a href="#" class="filter-pill">Сегодня <span class="badge bg-primary rounded-pill ms-1">4</span></a>
                    <a href="#" class="filter-pill">🔥 Важные</a>
                    <a href="#" class="filter-pill">Завершенные</a>
                </div>
            </div>

                <!-- Поиск на всю ширину на мобилках -->
                <div class="position-relative search-container w-100">
                    <input type="text" class="form-control rounded-pill ps-3 pe-4" placeholder="Поиск задачи...">
                </div>

            <!-- Список задач -->
            <div class="d-flex flex-column gap-3 mt-3">

                <!-- Задача 1 (Высокий приоритет + подзадачи) -->
                <div class="card task-card shadow-sm p-3 priority-high-border">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-3 w-100">
                                <input class="form-check-input task-checkbox mt-1 flex-shrink-0" type="checkbox">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 task-title text-break">Подготовить отчет по проекту Laravel</h6>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-2">
                                        <span class="task-badge bg-danger bg-opacity-10 text-danger">🔥 Высокая</span>
                                        <span class="task-badge bg-primary bg-opacity-10 text-primary">💼 Работа</span>
                                        <span class="text-muted small">🕒 Сегодня, 18:00</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-link text-muted p-0 flex-shrink-0" type="button" data-bs-toggle="dropdown">⋮</button>
                        </div>

                        <div class="subtasks-wrapper">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-semibold">Подзадачи (2 из 3)</span>
                                <span class="text-muted small">66%</span>
                            </div>
                            
                            <div class="subtask-item">
                                <input class="form-check-input task-checkbox flex-shrink-0" type="checkbox" checked style="width: 18px; height: 18px;">
                                <span class="text-decoration-line-through text-muted text-break">Спроектировать структуру базы данных</span>
                            </div>
                            
                            <div class="subtask-item">
                                <input class="form-check-input task-checkbox flex-shrink-0" type="checkbox" checked style="width: 18px; height: 18px;">
                                <span class="text-decoration-line-through text-muted text-break">Верстка Blade шаблонов</span>
                            </div>

                            <div class="subtask-item">
                                <input class="form-check-input task-checkbox flex-shrink-0" type="checkbox" style="width: 18px; height: 18px;">
                                <span class="text-break">Подключить контроллеры и Eloquent ORM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Задача 2 (Средний приоритет) -->
                <div class="card task-card shadow-sm p-3 priority-medium-border">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-3 w-100">
                                <input class="form-check-input task-checkbox mt-1 flex-shrink-0" type="checkbox">
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1 task-title text-break">Купить продукты на неделю</h6>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                        <span class="task-badge bg-success bg-opacity-10 text-success">🛒 Личное</span>
                                        <span class="text-muted small">🕒 Завтра</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-link text-muted p-0 flex-shrink-0" type="button">⋮</button>
                        </div>
                    </div>
                </div>

                <!-- Задача 3 (Обычная) -->
                <div class="card task-card shadow-sm p-3">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-3 w-100">
                                <input class="form-check-input task-checkbox mt-1 flex-shrink-0" type="checkbox">
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1 task-title text-break">Английский язык: 30 минут в Duolingo</h6>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                        <span class="task-badge bg-info bg-opacity-10 text-info">🎓 Обучение</span>
                                        <span class="task-badge bg-light text-dark">Ежедневная</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-link text-muted p-0 flex-shrink-0" type="button">⋮</button>
                        </div>
                    </div>
                </div>

                <!-- Задача 4 (Выполненная) -->
                <div class="card task-card shadow-sm p-3 is-completed">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-3 w-100">
                                <input class="form-check-input task-checkbox mt-1 flex-shrink-0" type="checkbox" checked>
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1 task-title text-break">Утренняя зарядка</h6>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                        <span class="task-badge bg-secondary bg-opacity-10 text-secondary">Здоровье</span>
                                        <span class="text-muted small">Выполнено в 08:30</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-link text-muted p-0 flex-shrink-0" type="button">⋮</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Правая колонка: Сайдбар -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <!-- sticky-lg-top позволяет прилипать только на ПК. На смартфонах сайдбар будет просто прокручиваться внизу -->
            <div class="sticky-lg-top" style="top: 24px;">
                
                <!-- Календарь -->
                <div class="mb-4">
                    @include('partials.calendar')
                </div>

                <!-- Категории -->
                <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 mb-lg-0">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Категории</h6>
                            <button class="btn btn-link btn-sm text-decoration-none p-0">+ Создать</button>
                        </div>
                        
                        <div class="d-flex flex-column gap-2">
                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none text-dark p-2 px-3 rounded-3 bg-light transition-all">
                                <span class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle bg-primary" style="width: 10px; height: 10px;"></span>
                                    Работа
                                </span>
                                <span class="badge bg-white text-dark border">3</span>
                            </a>

                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none text-dark p-2 px-3 rounded-3 transition-all hover-bg-light">
                                <span class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle bg-success" style="width: 10px; height: 10px;"></span>
                                    Личное
                                </span>
                                <span class="badge bg-light text-dark">2</span>
                            </a>

                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none text-dark p-2 px-3 rounded-3 transition-all hover-bg-light">
                                <span class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle bg-info" style="width: 10px; height: 10px;"></span>
                                    Обучение
                                </span>
                                <span class="badge bg-light text-dark">1</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Мобильная кнопка создания задачи (FAB). Появляется только на экранах < 576px -->
<button class="btn btn-primary d-sm-none fab-mobile" data-bs-toggle="modal" data-bs-target="#addTaskModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
</button>

@endsection
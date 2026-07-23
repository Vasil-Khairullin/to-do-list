@extends('layouts.app')

@section('content')
<style>
    /* Кастомные стили в единой концепции с задачами и календарем */
    .habits-container {
        font-family: inherit;
    }

    /* Карточка привычки */
    .habit-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background-color: #ffffff;
    }
    
    .habit-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
    }

    /* Дни недели внутри карточки привычки (Пн..Вс) */
    .habit-week-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }

    /* Адаптивность для супер-мелких экранов */
    @media (max-width: 380px) {
        .habit-week-grid { gap: 4px; }
    }

    .habit-day-btn {
        aspect-ratio: 1;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
        color: #6c757d;
        padding: 2px;
    }

    .habit-day-btn:hover:not(.completed) {
        background-color: #e9ecef;
        color: #212529;
    }

    /* Отмеченный день выполнения привычки */
    .habit-day-btn.completed {
        background-color: #198754;
        border-color: #198754;
        color: white;
        font-weight: 600;
    }

    /* День с пропуском или будущее */
    .habit-day-btn.is-today {
        border: 2px solid #0d6efd;
        background-color: #f8f9fa;
    }

    /* Многоразовая привычка - частичное выполнение сегодня */
    .habit-day-btn.is-partial {
        border: 2px solid #0dcaf0;
        color: #0dcaf0;
        font-weight: bold;
    }

    /* Бейдж серии (Streak) */
    .streak-badge {
        background-color: #fff3cd;
        color: #856404;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    /* Круг с иконкой привычки */
    .habit-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    /* Интерактивный счетчик для многоразовых привычек */
    .counter-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        line-height: 1;
        padding: 0;
        transition: transform 0.1s ease;
    }
    
    .counter-btn:active {
        transform: scale(0.9);
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
</style>

<div class="container-xl py-4 habits-container px-3 px-md-4">
    <div class="row g-4">
        
        <!-- Левая колонка: Список привычек -->
        <div class="col-lg-8">
            
            <!-- Заголовок и кнопка -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Трекер привычек</h3>
                    <p class="text-muted small mb-0">Формируйте полезные привычки день за днем</p>
                </div>
                <!-- Кнопка для планшетов и ПК -->
                <button class="btn btn-primary rounded-pill px-4 py-2 d-none d-sm-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addHabitModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Новая привычка
                </button>
            </div>

            <!-- Карточка прогресса дня -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white p-2">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <span class="badge bg-white text-primary mb-2 rounded-pill">Прогресс дня</span>
                        <h4 class="fw-bold mb-1">Выполнено 3 из 5 привычек</h4>
                        <p class="mb-0 opacity-75 small">Вы на верном пути! Осталось закрыть 2 привычки до конца дня.</p>
                    </div>
                    <div class="text-start text-md-end" style="min-width: 100px;">
                        <span class="display-6 fw-bold">60%</span>
                    </div>
                </div>
            </div>

            <!-- Список привычек -->
            <div class="d-flex flex-column gap-3">
                
                <!-- Привычка 1: Обычная (Выполнена сегодня) -->
                <div class="card habit-card shadow-sm p-3">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between mb-3 gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="habit-icon bg-warning bg-opacity-10 text-warning">🏃‍♂️</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-break">Утренняя пробежка</h6>
                                    <span class="text-muted small">Ежедневно • Здоровье</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-wrap justify-content-end gap-2">
                                <span class="streak-badge">🔥 14 дней</span>
                                <button class="btn btn-link text-muted p-0 ms-1 flex-shrink-0" type="button">⋮</button>
                            </div>
                        </div>

                        <div class="habit-week-grid">
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">ПН</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">ВТ</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">СР</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn completed is-today">
                                <span class="opacity-75" style="font-size: 0.65rem;">ЧТ</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">ПТ</span>
                                <span>25</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">СБ</span>
                                <span>26</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">ВС</span>
                                <span>27</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Привычка 2: Многоразовая (Требует 8 выполнений в день) -->
                <div class="card habit-card shadow-sm p-3">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between mb-3 gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="habit-icon bg-info bg-opacity-10 text-info">💧</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-break">Пить воду (8 стаканов)</h6>
                                    <span class="text-muted small">Многоразовая • Здоровье</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-wrap justify-content-end gap-2">
                                <span class="streak-badge">🔥 21 день</span>
                                <button class="btn btn-link text-muted p-0 ms-1 flex-shrink-0" type="button">⋮</button>
                            </div>
                        </div>

                        <!-- Интерактивный блок прогресса для текущего дня -->
                        <div class="bg-light rounded-3 p-2 px-3 mb-3 d-flex align-items-center gap-3">
                            <button class="btn btn-outline-secondary counter-btn flex-shrink-0" type="button">-</button>
                            <div class="flex-grow-1 text-center mt-1">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span class="text-muted">Прогресс сегодня:</span>
                                    <span class="text-info">5 / 8</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 62.5%"></div>
                                </div>
                            </div>
                            <button class="btn btn-info text-white counter-btn shadow-sm flex-shrink-0" type="button">+</button>
                        </div>

                        <div class="habit-week-grid">
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">ПН</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">ВТ</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">СР</span>
                                <span>✓</span>
                            </div>
                            <!-- Текущий день показывает долю выполнения (is-partial) -->
                            <div class="habit-day-btn is-today is-partial">
                                <span class="opacity-75" style="font-size: 0.65rem;">ЧТ</span>
                                <span class="fw-bold">5/8</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">ПТ</span>
                                <span>25</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">СБ</span>
                                <span>26</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">ВС</span>
                                <span>27</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Привычка 3: Обычная (Не выполнена сегодня) -->
                <div class="card habit-card shadow-sm p-3">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-start justify-content-between mb-3 gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="habit-icon bg-primary bg-opacity-10 text-primary">📚</div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-break">Читать 30 минут</h6>
                                    <span class="text-muted small">5 раз в неделю • Развитие</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-wrap justify-content-end gap-2">
                                <span class="streak-badge">🔥 5 дней</span>
                                <button class="btn btn-link text-muted p-0 ms-1 flex-shrink-0" type="button">⋮</button>
                            </div>
                        </div>

                        <div class="habit-week-grid">
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">ПН</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn completed">
                                <span class="opacity-75" style="font-size: 0.65rem;">ВТ</span>
                                <span>✓</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">СР</span>
                                <span>-</span>
                            </div>
                            <div class="habit-day-btn is-today text-primary" style="cursor: pointer;" title="Отметить выполнение">
                                <span class="opacity-75" style="font-size: 0.65rem;">ЧТ</span>
                                <span class="fw-bold fs-5 lh-1">+</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">ПТ</span>
                                <span>25</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">СБ</span>
                                <span>26</span>
                            </div>
                            <div class="habit-day-btn">
                                <span class="opacity-75" style="font-size: 0.65rem;">ВС</span>
                                <span>27</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Правая колонка: Сайдбар со статистикой -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <!-- sticky-lg-top фиксирует колонку только на ПК -->
            <div class="sticky-lg-top" style="top: 24px;">
                
                <div class="mb-4">
                    @include('partials.calendar')
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Статистика месяца</h6>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Лучшая серия (Streak)</span>
                            <span class="fw-bold">21 день 🔥</span>
                        </div>
                        <div class="progress mb-4" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Уровень дисциплины</span>
                            <span class="fw-bold text-success">88%</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 88%"></div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-flex align-items-center gap-3 bg-light rounded-3 p-2 px-3">
                            <div class="fs-2">🏆</div>
                            <div>
                                <h6 class="fw-bold mb-1">Железная воля</h6>
                                <p class="text-muted small mb-0 lh-sm">20 дней без пропусков привычек. Вы молодец!</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Мобильная кнопка добавления (FAB), скрыта на sm и больше -->
<button class="btn btn-primary d-sm-none fab-mobile" data-bs-toggle="modal" data-bs-target="#addHabitModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
</button>

@endsection
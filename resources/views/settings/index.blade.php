@extends('layouts.app')

@section('content')
<style>
    /* Кастомные стили в единой концепции с задачами и привычками */
    .settings-container {
        font-family: inherit;
    }

    /* Навигация настроек */
    .settings-nav {
        display: flex;
        gap: 0.5rem;
        -ms-overflow-style: none; /* IE и Edge */
        scrollbar-width: none; /* Firefox */
    }
    
    .settings-nav::-webkit-scrollbar {
        display: none; /* Chrome, Safari и Opera */
    }

    .settings-nav .nav-link {
        color: #495057;
        font-weight: 500;
        border-radius: 12px;
        padding: 10px 16px;
        transition: all 0.2s ease;
        white-space: nowrap; /* Защита от переноса текста в кнопках */
    }

    .settings-nav .nav-link:hover {
        background-color: #e9ecef;
        color: #212529;
    }

    .settings-nav .nav-link.active {
        background-color: #212529;
        color: #ffffff;
    }

    /* Селектор тем оформления */
    .theme-card {
        border: 2px solid #e9ecef;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        overflow: hidden;
    }

    .theme-card:hover {
        border-color: #adb5bd;
        transform: translateY(-2px);
    }

    .theme-card.active {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    .theme-preview {
        height: 70px;
        border-radius: 8px;
    }

    /* Кастомный загрузчик аватарки */
    .avatar-upload-wrapper {
        position: relative;
        width: 96px;
        height: 96px;
        flex-shrink: 0;
    }

    .avatar-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        transition: transform 0.2s ease;
    }

    .avatar-upload-btn:hover {
        transform: scale(1.1);
    }

    /* Цветовые акценты */
    .color-picker-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    .color-picker-dot:hover {
        transform: scale(1.15);
    }

    .color-picker-dot.active {
        border-color: #212529;
    }

    /* Адаптивные отступы для опасной зоны */
    .danger-zone-item {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    @media (min-width: 576px) {
        .danger-zone-item {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
</style>

<div class="container-xl py-4 settings-container px-3 px-md-4">
    <div class="row g-4">

        <div class="col-12 mb-2 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h3 class="fw-bold mb-1">Настройки</h3>
                <p class="text-muted small mb-0">Управление профилем, внешним видом и уведомлениями</p>
            </div>
        </div>

        <!-- Левая колонка: Навигация -->
        <div class="col-lg-3">
            <div class="sticky-lg-top" style="top: 24px;">
                <!-- На мобильных это будет горизонтальный скролл, на ПК - колонка -->
                <div class="nav flex-row flex-lg-column nav-pills settings-nav overflow-auto pb-2 pb-lg-0" id="v-pills-tab" role="tablist">
                    <button class="nav-link text-start active d-flex align-items-center gap-2" id="tab-profile-tab" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab">
                        <span>👤</span> Профиль и аккаунт
                    </button>
                    <button class="nav-link text-start d-flex align-items-center gap-2" id="tab-appearance-tab" data-bs-toggle="pill" data-bs-target="#tab-appearance" type="button" role="tab">
                        <span>🎨</span> Внешний вид
                    </button>
                    <button class="nav-link text-start d-flex align-items-center gap-2" id="tab-notifications-tab" data-bs-toggle="pill" data-bs-target="#tab-notifications" type="button" role="tab">
                        <span>🔔</span> Уведомления
                    </button>
                    <button class="nav-link text-start d-flex align-items-center gap-2" id="tab-security-tab" data-bs-toggle="pill" data-bs-target="#tab-security" type="button" role="tab">
                        <span>🔒</span> Безопасность
                    </button>
                    <!-- На ПК отступ сверху, на мобильных - слева -->
                    <button class="nav-link text-start text-danger d-flex align-items-center gap-2 mt-lg-3 ms-2 ms-lg-0" id="tab-danger-tab" data-bs-toggle="pill" data-bs-target="#tab-danger" type="button" role="tab">
                        <span>⚠️</span> Опасная зона
                    </button>
                </div>
            </div>
        </div>

        <!-- Правая колонка: Контент настроек -->
        <div class="col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">

                <!-- Профиль -->
                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4">
                            <h5 class="fw-bold mb-4">Личные данные</h5>
                            
                            <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start text-center text-sm-start gap-4 mb-4">
                                <div class="avatar-upload-wrapper mx-auto mx-sm-0">
                                    <img src="https://ui-avatars.com/api/?name=Алексей+Иванов&background=0D6EFD&color=fff&size=128" class="rounded-circle img-fluid shadow-sm" alt="Аватар">
                                    <label for="avatarInput" class="avatar-upload-btn" title="Изменить фото">📷</label>
                                    <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Фото профиля</h6>
                                    <p class="text-muted small mb-3 mb-sm-2">Рекомендуемый размер: 250x250 px (JPG, PNG)</p>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Удалить фото</button>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Имя</label>
                                    <input type="text" class="form-control rounded-3" name="name" value="Алексей Иванов" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Email адрес</label>
                                    <input type="email" class="form-control rounded-3" name="email" value="alexey@example.com" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Часовой пояс</label>
                                    <select class="form-select rounded-3" name="timezone">
                                        <option value="UTC+3" selected>(UTC+03:00) Москва, Санкт-Петербург</option>
                                        <option value="UTC+2">(UTC+02:00) Калининград</option>
                                        <option value="UTC+5">(UTC+05:00) Екатеринбург</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary w-100 w-sm-auto rounded-pill px-4 d-sm-inline-block">Сохранить изменения</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Внешний вид -->
                <div class="tab-pane fade" id="tab-appearance" role="tabpanel">
                    <form action="#" method="POST">
                        @csrf
                        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4">
                            <h5 class="fw-bold mb-2">Тема оформления</h5>
                            <p class="text-muted small mb-4">Выберите комфортную тему для работы</p>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-sm-4">
                                    <label class="theme-card p-3 active d-block">
                                        <div class="theme-preview bg-light border mb-2 d-flex align-items-center justify-content-center">
                                            <span class="fs-4">☀️</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="fw-semibold small">Светлая</span>
                                            <input class="form-check-input mt-0" type="radio" name="theme_mode" value="light" checked>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <label class="theme-card p-3 d-block">
                                        <div class="theme-preview bg-dark text-white mb-2 d-flex align-items-center justify-content-center">
                                            <span class="fs-4">🌙</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="fw-semibold small">Тёмная</span>
                                            <input class="form-check-input mt-0" type="radio" name="theme_mode" value="dark">
                                        </div>
                                    </label>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <label class="theme-card p-3 d-block">
                                        <div class="theme-preview bg-secondary bg-opacity-10 mb-2 d-flex align-items-center justify-content-center">
                                            <span class="fs-4">💻</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="fw-semibold small">Системная</span>
                                            <input class="form-check-input mt-0" type="radio" name="theme_mode" value="system">
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-2">Акцентный цвет интерфейса</h6>
                            <p class="text-muted small mb-3">Этот цвет будет использоваться для кнопок и активных иконок</p>

                            <div class="d-flex flex-wrap gap-3 mb-4">
                                <div class="color-picker-dot bg-primary active" title="Синий"></div>
                                <div class="color-picker-dot bg-success" title="Зеленый"></div>
                                <div class="color-picker-dot bg-danger" title="Красный"></div>
                                <div class="color-picker-dot bg-warning" title="Желтый"></div>
                                <div class="color-picker-dot bg-info" title="Голубой"></div>
                                <div class="color-picker-dot bg-dark" title="Графит"></div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary w-100 w-sm-auto rounded-pill px-4 d-sm-inline-block">Применить тему</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Уведомления -->
                <div class="tab-pane fade" id="tab-notifications" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4">
                        <h5 class="fw-bold mb-2">Уведомления и напоминания</h5>
                        <p class="text-muted small mb-4">Настройте, о чем и когда приложение должно вас оповещать</p>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 pb-3 border-bottom">
                                <div>
                                    <h6 class="fw-semibold mb-1 text-break">Напоминания о дедлайнах задач</h6>
                                    <p class="text-muted small mb-0 text-break">Присылать push-уведомление за 1 час до истечения срока</p>
                                </div>
                                <div class="form-check form-switch flex-shrink-0 align-self-start align-self-sm-center">
                                    <input class="form-check-input fs-5 m-0" type="checkbox" checked>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 pb-3 border-bottom">
                                <div>
                                    <h6 class="fw-semibold mb-1 text-break">Ежедневный дайджест привычек</h6>
                                    <p class="text-muted small mb-0 text-break">Напоминание о необходимости отметить привычки вечером</p>
                                </div>
                                <div class="form-check form-switch flex-shrink-0 align-self-start align-self-sm-center">
                                    <input class="form-check-input fs-5 m-0" type="checkbox" checked>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 pb-2">
                                <div>
                                    <h6 class="fw-semibold mb-1 text-break">Email-отчет за неделю</h6>
                                    <p class="text-muted small mb-0 text-break">Сводка продуктивности каждое воскресенье</p>
                                </div>
                                <div class="form-check form-switch flex-shrink-0 align-self-start align-self-sm-center">
                                    <input class="form-check-input fs-5 m-0" type="checkbox">
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-primary w-100 w-sm-auto rounded-pill px-4 d-sm-inline-block">Сохранить</button>
                        </div>
                    </div>
                </div>

                <!-- Безопасность -->
                <div class="tab-pane fade" id="tab-security" role="tabpanel">
                    <form action="#" method="POST">
                        @csrf
                        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4">
                            <h5 class="fw-bold mb-4">Смена пароля</h5>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Текущий пароль</label>
                                    <input type="password" class="form-control rounded-3" name="current_password">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold">Новый пароль</label>
                                    <input type="password" class="form-control rounded-3" name="new_password">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold">Подтвердите новый пароль</label>
                                    <input type="password" class="form-control rounded-3" name="new_password_confirmation">
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary w-100 w-sm-auto rounded-pill px-4 d-sm-inline-block">Обновить пароль</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Опасная зона -->
                <div class="tab-pane fade" id="tab-danger" role="tabpanel">
                    <div class="card border-1 border-danger border-opacity-25 shadow-sm rounded-4 p-3 p-md-4">
                        <h5 class="fw-bold text-danger mb-2">Экспорт и удаление данных</h5>
                        <p class="text-muted small mb-4">Здесь вы можете выгрузить свои данные или окончательно удалить аккаунт</p>

                        <div class="danger-zone-item pb-3 border-bottom mb-3">
                            <div>
                                <h6 class="fw-semibold mb-1">Экспорт всех данных (JSON/CSV)</h6>
                                <p class="text-muted small mb-0">Скачать архив со всеми вашими задачами и привычками</p>
                            </div>
                            <button class="btn btn-outline-secondary rounded-pill btn-sm px-3 flex-shrink-0 align-self-start align-self-sm-center">Скачать</button>
                        </div>

                        <div class="danger-zone-item">
                            <div>
                                <h6 class="fw-semibold text-danger mb-1">Удалить аккаунт</h6>
                                <p class="text-muted small mb-0">Все данные будут безвозвратно удалены из базы данных</p>
                            </div>
                            <button class="btn btn-danger rounded-pill btn-sm px-3 flex-shrink-0 align-self-start align-self-sm-center" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Удалить аккаунт</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
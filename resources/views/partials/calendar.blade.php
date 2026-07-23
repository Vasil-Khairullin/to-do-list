<style>
    /* Легкий, современный контейнер */
    .modern-calendar {
        font-family: inherit; /* Наследует чистый шрифт твоего проекта [cite: 56] */
        font-size: 0.9rem;
    }

    /* Настройка идеальной сетки через CSS Grid (замена кривым таблицам) */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px; /* Небольшой отступ между днями для "воздушности" */
        text-align: center;
    }

    /* Стилизация самих дней */
    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 12px; /* Современные мягкие скругления */
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.1s ease;
        position: relative;
        text-decoration: none;
        color: #212529; /* Bootstrap dark */
    }

    /* Мягкий hover-эффект вместо жестких рамок */
    .calendar-day:hover:not(.active):not(.text-muted) {
        background-color: #f8f9fa; /* Bootstrap light */
    }

    .calendar-day:active:not(.text-muted) {
        transform: scale(0.95); /* Легкое "вдавливание" при клике (UX) */
    }

    /* Выбранный день / Сегодня */
    .calendar-day.active {
        background-color: #0d6efd; /* Цвет можно привязать к системе тем БД [cite: 57, 106] */
        color: white !important;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3); /* Мягкое свечение */
    }

    /* Точка-индикатор наличия задач в этот день */
    .task-dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background-color: #0d6efd;
        position: absolute;
        bottom: 6px;
    }

    /* Белая точка, если день активен (синий фон) */
    .calendar-day.active .task-dot {
        background-color: white;
    }
</style>

<div class="card border-0 shadow-sm rounded-4 modern-calendar">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0 fw-bold fs-5">Сентябрь 2024</h6>
            <div class="d-flex gap-2">
                <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="calendar-grid mb-2 fw-semibold text-secondary" style="font-size: 0.8rem;">
            <div>Пн</div>
            <div>Вт</div>
            <div>Ср</div>
            <div>Чт</div>
            <div>Пт</div>
            <div class="text-danger opacity-75">Сб</div>
            <div class="text-danger opacity-75">Вс</div>
        </div>

        <div class="calendar-grid fw-medium">
            <div class="calendar-day text-muted opacity-50">26</div>
            <div class="calendar-day text-muted opacity-50">27</div>
            <div class="calendar-day text-muted opacity-50">28</div>
            <div class="calendar-day text-muted opacity-50">29</div>
            <div class="calendar-day text-muted opacity-50">30</div>
            <div class="calendar-day text-muted opacity-50">31</div>
            
            <div class="calendar-day">1</div>
            <div class="calendar-day">2</div>
            <div class="calendar-day">
                3
                <div class="task-dot"></div> </div>
            <div class="calendar-day">4</div>
            <div class="calendar-day">5</div>
            <div class="calendar-day">
                6
                <div class="task-dot bg-danger"></div> </div>
            <div class="calendar-day">7</div>
            <div class="calendar-day">8</div>
            <div class="calendar-day">9</div>
            
            <div class="calendar-day active">
                10
                <div class="task-dot"></div>
            </div>
            
            <div class="calendar-day">11</div>
            <div class="calendar-day">12</div>
            <div class="calendar-day">13</div>
            <div class="calendar-day">14</div>
            <div class="calendar-day">15</div>
            <div class="calendar-day">16</div>
            <div class="calendar-day">17</div>
            <div class="calendar-day">18</div>
            <div class="calendar-day">19</div>
            <div class="calendar-day">20</div>
            <div class="calendar-day">21</div>
            <div class="calendar-day">22</div>
            <div class="calendar-day">23</div>
            <div class="calendar-day">24</div>
            <div class="calendar-day">25</div>
            <div class="calendar-day">26</div>
            <div class="calendar-day">27</div>
            <div class="calendar-day">28</div>
            <div class="calendar-day">29</div>
            <div class="calendar-day">30</div>
            
            <div class="calendar-day text-muted opacity-50">1</div>
            <div class="calendar-day text-muted opacity-50">2</div>
            <div class="calendar-day text-muted opacity-50">3</div>
            <div class="calendar-day text-muted opacity-50">4</div>
            <div class="calendar-day text-muted opacity-50">5</div>
        </div>
    </div>
</div>
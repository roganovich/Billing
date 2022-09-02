## Easy Billing System

Небольшая CRM для обслуживания счетов корпоративных клиентов

### Задачи
 - Создание счетов
 - Просмотр истории движения средств на счетах
 - Возможность на одной учетной записи держать несколько счетов
 - Возможность пополнения счета из личного кабинета

### Конструкция сайта
 - Главная страница
   - Форма регистрации, восстановление пароля
 - Раздел статей
 - Личный кабинет
   - Просмотр/Редактирование личной информации
   - Просмотр/Создание/Редактирование счетов
   - Онлайн оплата через Экваринг Банка
 - Административная панель
   - Работа с пользователями
   - Работа со счетами
   - Работа со статьями
   - История оплат

## Скачивание проекта
- cd /your_sites_directory/
- git clone git@github.com:roganovich/Billing.git
- cd Billing

## Развертывание сервера
- docker-compose build
- docker-compose up -d
- docker exec -it billing_vue_app bash /var/www/docker/preloader.sh -d

## Работа с приложением
- Открываем сайт: http://localhost:8098/
- Вход в панель администратора:
    - http://localhost:8098/admin
    - admin@admin.loc
    - password


# Run the Vite development server...
npm run dev

# Build and version the assets for production...
npm run build

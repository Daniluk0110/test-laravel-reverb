import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Инициализация
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Слушаем канал
window.Echo.channel('public-chat')
    .listen('TestNotification', (e) => {
        console.log('Event received:', e);

        // 1. Находим контейнер
        const list = document.getElementById('notification-list');

        // Удаляем надпись "Ждем событий...", если она есть
        const emptyState = list.querySelector('.empty-state');
        if (emptyState) {
            emptyState.remove();
        }

        // 2. Получаем текущее время
        const now = new Date();
        const timeString = now.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        // 3. Создаем HTML элемента (карточку)
        const item = document.createElement('div');
        // Стили Tailwind для карточки: анимация появления, отступы, фон
        item.className = 'bg-gray-50 dark:bg-[#20201e] border border-gray-100 dark:border-[#3E3E3A] p-3 rounded-md shadow-sm flex flex-col gap-1 animate-pulse-once';

        // Вставляем содержимое (Сообщение + Время)
        item.innerHTML = `
            <div class="flex justify-between items-start">
                <span class="text-sm font-medium text-gray-800 dark:text-gray-200">${e.message}</span>
                <span class="text-[10px] text-gray-400 font-mono mt-0.5">${timeString}</span>
            </div>
        `;

        // 4. Добавляем в начало списка (новые сверху)
        list.prepend(item);
    });

// Добавим простую CSS анимацию для эффекта появления
const style = document.createElement('style');
style.innerHTML = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-pulse-once {
        animation: fadeIn 0.3s ease-out forwards;
    }
`;
document.head.appendChild(style);

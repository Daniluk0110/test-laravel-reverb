import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Настройки подключения
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

const logContainer = document.getElementById('reverb-log');
const statusInd = document.getElementById('status-indicator');

// Слушаем канал
window.Echo.channel('public-chat')
    .listen('TestNotification', (e) => {
        console.log('Прилетело:', e);

        // Меняем статус
        if(statusInd) {
            statusInd.innerText = 'Active';
            statusInd.classList.add('text-green-500');
        }

        // Убираем текст "пусто", если есть
        const empty = document.querySelector('.empty-msg');
        if (empty) empty.remove();

        // Время
        const time = new Date().toLocaleTimeString('ru-RU', {hour: '2-digit', minute:'2-digit', second:'2-digit'});

        // Создаем плашку сообщения
        const el = document.createElement('div');
        // Используем твои цвета из CSS
        el.className = "msg-appear p-3 rounded border border-gray-100 dark:border-[#3E3E3A] bg-gray-50 dark:bg-[#202020] flex flex-col gap-1 shadow-sm";

        el.innerHTML = `
            <div class="flex justify-between items-start">
                <span class="font-medium text-sm text-[#F53003] dark:text-[#FF4433]">New Event</span>
                <span class="text-[10px] text-gray-400 font-mono">${time}</span>
            </div>
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-tight">
                ${e.message}
            </p>
        `;

        // Добавляем ВВЕРХ списка
        logContainer.prepend(el);
    });

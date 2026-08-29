// ==========================================
// ИНИЦИАЛИЗАЦИЯ MATOMO ANALYTICS (Прямое подключение)
// ==========================================
var _paq = window._paq = window._paq || [];
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(function() {
    var u = "https://stats.empat.help/";
    _paq.push(['setTrackerUrl', u + 'matomo.php']);
    _paq.push(['setSiteId', '2']);
    var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
    g.async = true; g.src = u + 'matomo.js'; s.parentNode.insertBefore(g, s);
})();

// Запоминаем время загрузки страницы
const pageLoadTimestamp = Math.floor(Date.now() / 1000);
let isSubmitting = false;

// Мгновенное применение темы
(function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark-mode');
        if (document.body) document.body.classList.add('dark-mode');
    } else if (savedTheme === 'light') {
        document.documentElement.classList.remove('dark-mode');
        if (document.body) document.body.classList.remove('dark-mode');
    }
})();

// ==========================================
// ФУНКЦИИ УПРАВЛЕНИЯ МОДАЛЬНЫМ ОКНОМ (ВЫНЕСЕНЫ НАВЕРХ)
// ==========================================

function openNotifyModal(disableAnimation = false) {
    const modal = document.getElementById('notifyModal');
    if (modal) {
        if (disableAnimation) {
            modal.classList.add('no-animation');
        } else {
            modal.classList.remove('no-animation');
        }

        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }

        modal.classList.add('active');
        modal.style.setProperty('display', 'flex', 'important');
        modal.style.setProperty('visibility', 'visible', 'important');
        modal.style.setProperty('opacity', '1', 'important');
        
        document.body.style.overflow = 'hidden'; 
    }
}

function closeNotifyModal() {
    const modal = document.getElementById('notifyModal');
    if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
        
        document.body.style.overflow = ''; 
        document.body.style.paddingRight = '';

        setTimeout(() => {
            modal.classList.remove('no-animation');

            const formBlock = document.getElementById('notifyFormBlock');
            const successMsg = document.getElementById('notifySuccess');
            const alreadyMsg = document.getElementById('notifyAlready');
            const submitBtn = document.querySelector('#notifyForm button[type="submit"]');
            
            if (formBlock) formBlock.style.display = 'block';
            if (successMsg) successMsg.style.display = 'none';
            if (alreadyMsg) alreadyMsg.style.display = 'none';
            
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
            
            isSubmitting = false;
        }, 300);
    }
}

// ОСНОВНАЯ ФУНКЦИЯ ОБРАБОТКИ ФОРМЫ
function handleNotifySubmit(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    if (isSubmitting) return false;

    const input = document.getElementById('notifyEmailInput');
    const form = document.getElementById('notifyForm');
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
    const email = input ? input.value.trim() : '';

    if (!email) {
        alert('Пожалуйста, введите ваш email.');
        return false;
    }

    if (input) {
        input.blur();
    }

    isSubmitting = true;

    // ===================================================
    // УМНОЕ ОПРЕДЕЛЕНИЕ ЯЗЫКА
    // ===================================================
    const hiddenLangInput = document.getElementById('pageLang');
    const path = window.location.pathname.toLowerCase();
    const search = window.location.search.toLowerCase();
    const htmlLang = (document.documentElement.lang || '').toLowerCase().substring(0, 2);
    const browserLang = (navigator.language || navigator.userLanguage || '').toLowerCase().substring(0, 2);

    let currentLang = 'ru';

    if (hiddenLangInput && hiddenLangInput.value) {
        currentLang = hiddenLangInput.value.toLowerCase().substring(0, 2);
    } 
    else if (path.includes('/en/') || path.endsWith('/en') || search.includes('lang=en') || htmlLang === 'en') {
        currentLang = 'en';
    } else if (path.includes('/uk/') || path.endsWith('/uk') || search.includes('lang=uk') || htmlLang === 'uk') {
        currentLang = 'uk';
    } else if (path.includes('/ru/') || path.endsWith('/ru') || search.includes('lang=ru') || htmlLang === 'ru') {
        currentLang = 'ru';
    } 
    else if (['en', 'uk', 'ru'].includes(browserLang)) {
        currentLang = browserLang;
    }

    // Тексты статуса загрузки
    const loadingTexts = {
        ru: 'Отправка...',
        en: 'Sending...',
        uk: 'Надсилання...'
    };
    const activeLoadingText = loadingTexts[currentLang] || loadingTexts.ru;

    // Включаем визуальный статус и CSS-спиннер на кнопке
    const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
        submitBtn.style.cursor = 'wait';
        
        // Вставляем спиннер прямо в кнопку
        submitBtn.innerHTML = `
            <span style="display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                <span class="btn-spinner" style="
                    display: inline-block;
                    width: 14px;
                    height: 14px;
                    border: 2px solid currentColor;
                    border-right-color: transparent;
                    border-radius: 50%;
                    animation: btnSpinnerAnim 0.75s linear infinite;
                "></span>
                <span>${activeLoadingText}</span>
            </span>
        `;

        // Динамически добавляем keyframes анимацию, если её ещё нет
        if (!document.getElementById('btnSpinnerStyles')) {
            const style = document.createElement('style');
            style.id = 'btnSpinnerStyles';
            style.innerHTML = `@keyframes btnSpinnerAnim { to { transform: rotate(360deg); } }`;
            document.head.appendChild(style);
        }
    }

    // Подставляем email
    const emailDisplays = document.querySelectorAll('#userEnteredEmail, .userEnteredEmailClass');
    emailDisplays.forEach(el => {
        el.textContent = email;
    });

    const honeypotWebsite = form ? (form.querySelector('input[name="b_website"]')?.value || '') : '';
    const honeypotPhone = form ? (form.querySelector('input[name="phone_hp"]')?.value || '') : '';

    const errorMessages = {
        ru: {
            saveError: 'Произошла ошибка при сохранении. Попробуйте ещё раз.',
            networkError: 'Ошибка связи с сервером. Пожалуйста, проверьте подключение.'
        },
        en: {
            saveError: 'An error occurred while saving. Please try again.',
            networkError: 'Server communication error. Please check your connection.'
        },
        uk: {
            saveError: 'Сталася помилка під час збереження. Спробуйте ще раз.',
            networkError: 'Помилка зв\'язку з сервером. Будь ласка, перевірте підключення.'
        }
    };

    const activeErrorMsg = errorMessages[currentLang] || errorMessages.ru;

    fetch('/api/save_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
            email: email,
            lang: currentLang,
            b_website: honeypotWebsite,
            phone_hp: honeypotPhone,
            form_time: pageLoadTimestamp
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        const formBlock = document.getElementById('notifyFormBlock');
        const successBlock = document.getElementById('notifySuccess');
        const alreadyBlock = document.getElementById('notifyAlready');

        if (formBlock) formBlock.style.display = 'none';
        if (successBlock) successBlock.style.display = 'none';
        if (alreadyBlock) alreadyBlock.style.display = 'none';

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            if (originalBtnText) submitBtn.innerHTML = originalBtnText;
        }

        if (data.status === 'success') {
            // Трекинг успешной подписки в Matomo
            if (window._paq) {
                _paq.push(['trackEvent', 'Form', 'Subscribe', 'Success']);
            }

            if (successBlock) successBlock.style.display = 'block';
            if (input) input.value = '';
            openNotifyModal();
            setTimeout(closeNotifyModal, 10000);
        } else if (data.status === 'subscribed') {
            // Трекинг повторной подписки в Matomo
            if (window._paq) {
                _paq.push(['trackEvent', 'Form', 'Subscribe', 'Already Subscribed']);
            }

            if (alreadyBlock) alreadyBlock.style.display = 'block';
            if (input) input.value = '';
            openNotifyModal();
            setTimeout(closeNotifyModal, 10000);
        } else {
            isSubmitting = false;
            alert(activeErrorMsg.saveError);
        }
    })
    .catch(error => {
        isSubmitting = false;
        console.error('Error:', error);
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            if (originalBtnText) submitBtn.innerHTML = originalBtnText;
        }
        alert(activeErrorMsg.networkError);
    });

    return false;
}

// Показ уведомления об успешном копировании (безопасный вызов)
function showCopyToast() {
    const overlay = document.getElementById('copyOverlay');
    if (!overlay) return;

    // Добавляем класс .show
    overlay.classList.add('show');

    // Плавно скрываем через 2.5 секунды
    setTimeout(() => {
        overlay.classList.remove('show');
    }, 2500);
}

// ГЛОБАЛЬНАЯ ФУНКЦИЯ КОПИРОВАНИЯ С ТРЕКИНГОМ В MATOMO
function copyEmailToClipboard(email) {
    const textToCopy = email || window.location.href;

    // Вспомогательный старый метод копирования
    const fallbackCopy = function(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.top = '-9999px';
        textArea.style.left = '-9999px';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        
        try {
            textArea.focus();
            textArea.select();
            document.execCommand('copy');
            showCopyToast();
        } catch (err) {
            console.error('Ошибка фоллбэк копирования:', err);
        } finally {
            if (textArea.parentNode) {
                document.body.removeChild(textArea);
            }
        }
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(textToCopy).then(function() {
            showCopyToast();
        }).catch(function(err) {
            console.warn('Clipboard API не сработал, используем fallback:', err);
            fallbackCopy(textToCopy);
        });
    } else {
        fallbackCopy(textToCopy);
    }

    // Трекинг клика по кнопке копирования в Matomo
    if (window._paq) {
        _paq.push(['trackEvent', 'Email', 'Copy', textToCopy]);
    }
}

// ==========================================
// ГЛОБАЛЬНЫЙ ТРЕКИНГ FAQ (<details>) И ЭМОЦИЙ
// ==========================================

// Трекинг раскрытия FAQ через делегирование событий
document.addEventListener('toggle', function(event) {
    var detail = event.target;
    
    if (detail && detail.tagName === 'DETAILS' && detail.open) {
        var questionSpan = detail.querySelector('.faq-question > span:first-child');
        var summaryEl = detail.querySelector('summary');

        var questionText = questionSpan && questionSpan.textContent.trim() 
            ? questionSpan.textContent.trim() 
            : (summaryEl ? summaryEl.textContent.replace(/[❯]/g, '').trim() : 'FAQ Question');

        if (window._paq) {
            _paq.push(['trackEvent', 'FAQ Accordion', 'Open', questionText]);
        }
    }
}, true);

// Трекинг кликов по кнопкам эмоций (Mailto)
document.addEventListener('click', function(e) {
    const emotionBtn = e.target.closest('.emotion-btn');
    if (emotionBtn) {
        const emotionLabel = emotionBtn.querySelector('.emotion-label')?.textContent.trim() || 'Unknown Emotion';
        if (window._paq) {
            _paq.push(['trackEvent', 'Emotion Button', 'Click', emotionLabel]);
        }
    }
});

// ИНИЦИАЛИЗАЦИЯ ПОСЛЕ ЗАГРУЗКИ DOM
document.addEventListener('DOMContentLoaded', function() {
    const root = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    const burgerBtn = document.getElementById('burgerBtn');
    const navWrapper = document.getElementById('navWrapper');

    function closeMenu() {
        if (navWrapper) navWrapper.classList.remove('active');
        if (burgerBtn) burgerBtn.classList.remove('active');
    }

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        root.classList.add('dark-mode');
        if (document.body) document.body.classList.add('dark-mode');
    } else if (savedTheme === 'light') {
        root.classList.remove('dark-mode');
        if (document.body) document.body.classList.remove('dark-mode');
    }

    if (themeBtn) {
        const isDarkInitial = root.classList.contains('dark-mode');
        themeBtn.textContent = isDarkInitial ? '☀️' : '🌙';

        themeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const isDark = root.classList.contains('dark-mode');
            let newTheme = 'light';

            if (isDark) {
                root.classList.remove('dark-mode');
                if (document.body) document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                themeBtn.textContent = '🌙';
                newTheme = 'light';
            } else {
                root.classList.add('dark-mode');
                if (document.body) document.body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                themeBtn.textContent = '☀️';
                newTheme = 'dark';
            }

            // Отправляем выбор темы в Matomo
            if (window._paq) {
                _paq.push(['trackEvent', 'Theme', 'Toggle', newTheme]);
            }

            closeMenu();
        });
    }

    if (burgerBtn && navWrapper) {
        burgerBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            navWrapper.classList.toggle('active');
            burgerBtn.classList.toggle('active');
        });

        navWrapper.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('click', function(e) {
            if (!navWrapper.contains(e.target) && !burgerBtn.contains(e.target)) {
                closeMenu();
            }
        });
    }

    const modal = document.getElementById('notifyModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeNotifyModal();
            }
        });
    }

    const notifyForm = document.getElementById('notifyForm');
    if (notifyForm) {
        notifyForm.onsubmit = handleNotifySubmit;
    }

    // ==========================================
    // ЛОГИКА ДЫХАТЕЛЬНОГО ТРЕНАЖЕРА (МОБИЛЬНАЯ АДАПТАЦИЯ И УПРАВЛЕНИЕ КНОПКОЙ)
    // ==========================================
    const breathingToggleBtn = document.getElementById('breathingToggleBtn');
    const breathingCircle = document.getElementById('breathingCircle');
    const breathingText = document.getElementById('breathingText');
    const breathingStatus = document.getElementById('breathingStatus');

    if (breathingToggleBtn && breathingCircle && breathingText && breathingStatus) {
        // Чтение данных через dataset с запасом на getAttribute для мобильных бразуеров
        const inhaleTxt = breathingText.dataset.inhale || breathingText.getAttribute('data-inhale') || 'Вдох';
        const pauseTxt = breathingText.dataset.pause || breathingText.getAttribute('data-pause') || 'Пауза';
        const exhaleTxt = breathingText.dataset.exhale || breathingText.getAttribute('data-exhale') || 'Выдох';
        
        const startLabel = breathingToggleBtn.dataset.start || breathingToggleBtn.getAttribute('data-start') || 'Начать';
        const stopLabel = breathingToggleBtn.dataset.stop || breathingToggleBtn.getAttribute('data-stop') || 'Остановить';
        
        const counterTpl = breathingStatus.dataset.counter || breathingStatus.getAttribute('data-counter') || 'Вдох %d из 5';
        const doneTxt = breathingStatus.dataset.done || breathingStatus.getAttribute('data-done') || 'Отлично! Вы сделали 10 вдохов.';

        let isActive = false;
        let currentCycle = 0;
        const maxCycles = 5;
        let activeTimers = [];

        function clearAllTimers() {
            activeTimers.forEach(t => clearTimeout(t));
            activeTimers = [];
        }

        function addTimeout(fn, delay) {
            const timer = setTimeout(fn, delay);
            activeTimers.push(timer);
            return timer;
        }

        // Длительности фаз в мс
        const inhaleTime = 4000;
        const pauseTime = 2000;
        const exhaleTime = 4000;
        const restTime = 2000;

        function runCycle() {
            if (!isActive) return;

            currentCycle++;
            
            if (currentCycle > maxCycles) {
                stopBreathing(true);
                return;
            }

            // Обновляем счетчик под кругом
            breathingStatus.textContent = counterTpl.replace('%d', currentCycle);

            // 1. Вдох
            breathingCircle.classList.add('inhale');
            breathingCircle.classList.remove('exhale', 'pause');
            breathingText.textContent = inhaleTxt;

            // 2. Пауза после вдоха
            addTimeout(() => {
                if (!isActive) return;
                breathingCircle.classList.add('pause');
                breathingText.textContent = pauseTxt;

                // 3. Выдох
                addTimeout(() => {
                    if (!isActive) return;
                    breathingCircle.classList.remove('inhale', 'pause');
                    breathingCircle.classList.add('exhale');
                    breathingText.textContent = exhaleTxt;

                    // 4. Пауза после выдоха / Переход к следующему циклу
                    addTimeout(() => {
                        if (!isActive) return;
                        breathingCircle.classList.remove('exhale');
                        breathingCircle.classList.add('pause');
                        breathingText.textContent = pauseTxt;

                        addTimeout(() => {
                            if (isActive) runCycle();
                        }, restTime);

                    }, exhaleTime);

                }, pauseTime);

            }, inhaleTime);
        }

        function startBreathing() {
            isActive = true;
            currentCycle = 0;
            breathingToggleBtn.textContent = stopLabel;
            breathingToggleBtn.classList.add('active');

            if (window._paq) {
                _paq.push(['trackEvent', 'Breathing Exercise', 'Start']);
            }

            runCycle();
        }

        function stopBreathing(isFinished = false) {
            isActive = false;
            clearAllTimers();
            
            breathingCircle.className = 'breathing-circle';
            breathingText.textContent = '';
            breathingToggleBtn.textContent = startLabel;
            breathingToggleBtn.classList.remove('active');

            if (isFinished) {
                breathingStatus.textContent = doneTxt;
                if (window._paq) {
                    _paq.push(['trackEvent', 'Breathing Exercise', 'Completed']);
                }
            } else {
                breathingStatus.textContent = '';
                if (window._paq) {
                    _paq.push(['trackEvent', 'Breathing Exercise', 'Stop']);
                }
            }
        }

        function handleToggle(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            if (isActive) {
                stopBreathing(false);
            } else {
                startBreathing();
            }
        }

        breathingToggleBtn.addEventListener('click', handleToggle);
    }
});
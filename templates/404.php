<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>404 — Oops!</title>
    <style>
        :root {
            --bg: #EAECE8;
            --dark: #2D4C3B;
            --accent: #C58B74;
            --accent-rgb: 197, 139, 116;
            --link-color: #A64D32;
            --white: #FFFFFF;
            --text-main: #1A3326;
            --card-bg: rgba(255, 255, 255, 0.5);
            --border-color: rgba(45, 76, 59, 0.15);
            --btn-text: #FFFFFF;
            --error: #e74c3c;
            --success: #2ecc71;
            --email-highlight: #C28E5C;
        }

        .dark-mode {
            --bg: #1A2E24;
            --dark: #EAECE8;
            --accent: #D9A18C;
            --accent-rgb: 217, 161, 140;
            --link-color: #D9A18C;
            --white: #243D2F;
            --text-main: #EAECE8;
            --card-bg: rgba(45, 76, 59, 0.4);
            --border-color: rgba(234, 236, 232, 0.15);
            --btn-text: #1A2E24;
            --email-highlight: #E5C396;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            width: 100%;
        }

        body {
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-align: center;
        }

        p, h1, h2, h3, h4, h5, h6, span, a {
            overflow-wrap: break-word;
            word-break: break-word;
        }

        /* Карточка 404 */
        .error-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 48px 32px;
            border-radius: 20px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .error-title {
            font-size: 80px;
            font-weight: 800;
            line-height: 1;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .error-subtitle {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .error-text {
            font-size: 15px;
            color: var(--text-main);
            opacity: 0.85;
            margin-bottom: 28px;
        }

        .error-btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: var(--dark);
            color: var(--btn-text);
            text-decoration: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .error-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <main class="error-card">
        <div class="error-title">Oops!</div>
        <h1 class="error-subtitle">404 — Сторінку не знайдено</h1>
        <p class="error-text">Схоже, ця адреса застаріла або була вказана з помилкою.</p>
        <a href="/" class="error-btn">На головну / Home</a>
    </main>

</body>
</html>
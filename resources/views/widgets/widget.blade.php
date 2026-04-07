<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Виджет обратной связи</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 24px;
        }

        .widget {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .field {
            margin-bottom: 16px;
            padding-right: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input, textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: #fff;
            border: 0;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
        }

        .message {
            margin-top: 16px;
            padding: 12px 14px;
            border-radius: 10px;
        }

        .message.success {
            background: #dcfce7;
            color: #166534;
        }

        .message.error {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
<div class="widget">
    <h1>Оставить заявку</h1>

    <form id="ticketForm">
        <div class="field">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="field">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" required placeholder="+79990000000">
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="field">
            <label for="title">Тема</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="field">
            <label for="description">Текст</label>
            <textarea id="description" name="description" rows="5"></textarea>
        </div>

        <div class="field">
            <label for="files">Файлы</label>
            <input type="file" id="files" name="files[]" multiple>
        </div>

        <button type="submit">Отправить</button>
    </form>

    <div id="message" class="message" style="display:none;"></div>
</div>

<script>
    const form = document.getElementById('ticketForm');
    const message = document.getElementById('message');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        Array.from(document.getElementById('files').files).forEach(file => {
            formData.append('files[]', file);
        });

        console.log(form);
        console.log(formData);

        try {
            const response = await fetch('/api/tickets', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            message.style.display = 'block';

            if (!response.ok) {
                message.className = 'message error';
                message.textContent = data.message || 'Произошла ошибка при отправке заявки.';
                return;
            }

            message.className = 'message success';
            message.textContent = data.message || 'Заявка успешно отправлена.';
            form.reset();
        } catch (error) {
            message.style.display = 'block';
            message.className = 'message error';
            message.textContent = 'Ошибка сети. Попробуйте позже.';
        }
    });
</script>
</body>
</html>


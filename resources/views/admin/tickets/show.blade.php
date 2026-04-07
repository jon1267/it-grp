<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка #{{ $ticket->id }}</title>
</head>
<body>
<h1>Заявка #{{ $ticket->id }}</h1>

<p><strong>Клиент:</strong> {{ $ticket->customer?->name }}</p>
<p><strong>Email:</strong> {{ $ticket->customer?->email }}</p>
<p><strong>Телефон:</strong> {{ $ticket->customer?->phone }}</p>
<p><strong>Тема:</strong> {{ $ticket->title }}</p>
<p><strong>Текст:</strong> {{ $ticket->description }}</p>
<p><strong>Статус:</strong> {{ $ticket->status->value ?? $ticket->status }}</p>
<p><strong>Дата ответа:</strong> {{ $ticket->answered_at }}</p>

<h2>Файлы</h2>
<ul>
    @foreach ($ticket->media as $media)
        <li>
            <a href="{{ $media->getUrl() }}" target="_blank">{{ $media->file_name }}</a>
        </li>
    @endforeach
</ul>

<form method="POST" action="{{ route('admin.tickets.status', $ticket) }}">
    @csrf
    @method('PATCH')

    <select name="status">
        <option value="new" @selected($ticket->status->value === 'new')>new</option>
        <option value="processing" @selected($ticket->status->value === 'processing')>processing</option>
        <option value="closed" @selected($ticket->status->value === 'closed')>closed</option>
    </select>

    <button type="submit">Сохранить статус</button>
</form>
</body>
</html>

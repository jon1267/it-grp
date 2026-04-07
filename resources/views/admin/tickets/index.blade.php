<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки</title>
</head>
<body>
    <h1>Список заявок</h1>

    <form method="GET">
        <input type="text" name="email" placeholder="Email" value="{{ request('email') }}">
        <input type="text" name="phone" placeholder="Телефон" value="{{ request('phone') }}">
        <input type="date" name="from" value="{{ request('from') }}">
        <input type="date" name="to" value="{{ request('to') }}">
        <select name="status">
            <option value="">Все статусы</option>
            <option value="new" @selected(request('status') === 'new')>new</option>
            <option value="processing" @selected(request('status') === 'processing')>processing</option>
            <option value="closed" @selected(request('status') === 'closed')>closed</option>
        </select>
        <button type="submit">Фильтр</button>
    </form>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Тема</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td><a href="{{ route('admin.tickets.show', $ticket) }}">{{ $ticket->id }}</a></td>
                    <td>{{ $ticket->customer?->name }}</td>
                    <td>{{ $ticket->customer?->email }}</td>
                    <td>{{ $ticket->customer?->phone }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->status->value ?? $ticket->status }}</td>
                    <td>{{ $ticket->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}
</body>
</html>

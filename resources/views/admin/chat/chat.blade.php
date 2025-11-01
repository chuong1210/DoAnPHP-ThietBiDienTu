<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách phòng chat</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        h1 {
            color: #10b981;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #10b981;
            color: white;
        }

        tr:hover {
            background: #f9fafb;
        }

        a {
            color: #10b981;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>💬 Danh sách phòng chat</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Chủ đề</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->user->full_name ?? 'Không rõ' }}</td>
                    <td>{{ $room->subject }}</td>
                    <td>{{ ucfirst($room->status) }}</td>
                    <td>
                        <a href="{{ url('/chat?room_id=' . $room->id) }}">Vào chat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Chưa có phòng chat nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        const roomId = "{{ $room->id }}";

        window.Echo.private(`chat.room.${roomId}`)
            .listen('MessageSent', (e) => {
                console.log('📩 Nhận tin nhắn mới:', e);

                const messageContainer = document.querySelector('#message-container');
                const messageHtml = `
            <div class="message ${e.is_admin ? 'admin' : 'user'}">
                <strong>${e.user.name}</strong>: ${e.message}
                <div class="time">${e.created_at}</div>
            </div>
        `;
                messageContainer.insertAdjacentHTML('beforeend', messageHtml);

                // Tự động cuộn xuống cuối
                messageContainer.scrollTop = messageContainer.scrollHeight;
            });
    </script>

</body>

</html>

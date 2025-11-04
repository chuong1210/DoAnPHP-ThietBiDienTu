{{-- resources/views/admin/chat/index.blade.php --}}

@extends('admin.layouts.admin')

@section('title', 'Quản Lý Chat')

@section('styles')
    <style>
        .chat-admin-container {
            display: flex;
            height: calc(100vh - 150px);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Left Sidebar - Room List */
        .chat-rooms-sidebar {
            width: 350px;
            border-right: 2px solid #e9ecef;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
        }

        .chat-rooms-header {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .chat-rooms-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .chat-rooms-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .room-item {
            padding: 15px;
            margin-bottom: 8px;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .room-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .room-item.active {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .room-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .room-user-name {
            font-weight: 600;
            color: #333;
            font-size: 15px;
        }

        .room-time {
            font-size: 11px;
            color: #999;
        }

        .room-last-message {
            font-size: 13px;
            color: #666;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .room-unread-badge {
            background: #dc3545;
            color: white;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 8px;
        }

        .room-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            margin-top: 5px;
        }

        .room-status.open {
            background: #d4edda;
            color: #155724;
        }

        .room-status.closed {
            background: #f8d7da;
            color: #721c24;
        }

        /* Right Panel - Chat Area */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-area-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
            flex-direction: column;
        }

        .chat-area-empty i {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .chat-header {
            padding: 20px 25px;
            background: white;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-user-info h5 {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: #333;
        }

        .chat-user-info small {
            color: #666;
        }

        .chat-messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: #f8f9fa;
        }

        .chat-message {
            display: flex;
            margin-bottom: 20px;
            animation: messageSlide 0.3s ease;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-message.admin {
            justify-content: flex-end;
        }

        .chat-message.user {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 60%;
            padding: 12px 16px;
            border-radius: 16px;
            word-wrap: break-word;
            position: relative;
        }

        .chat-message.admin .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .chat-message.user .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 6px;
            display: block;
        }

        .message-sender {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
            opacity: 0.9;
        }

        .chat-input-area {
            padding: 20px 25px;
            background: white;
            border-top: 2px solid #e9ecef;
        }

        .chat-input-area .form-control {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            font-size: 14px;
        }

        .chat-input-area .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .chat-input-area .btn-primary {
            border-radius: 25px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-weight: 600;
        }

        /* Scrollbar */
        .chat-rooms-list::-webkit-scrollbar,
        .chat-messages-area::-webkit-scrollbar {
            width: 8px;
        }

        .chat-rooms-list::-webkit-scrollbar-track,
        .chat-messages-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-rooms-list::-webkit-scrollbar-thumb,
        .chat-messages-area::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .chat-rooms-list::-webkit-scrollbar-thumb:hover,
        .chat-messages-area::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Loading */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading-spinner.active {
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="chat-admin-container">
            <!-- Left Sidebar - Rooms List -->
            <div class="chat-rooms-sidebar">
                <div class="chat-rooms-header">
                    <h5><i class="fas fa-comments"></i> Danh Sách Chat</h5>
                    <small>{{ count($rooms) }} cuộc hội thoại</small>
                </div>

                <div class="chat-rooms-list" id="roomsList">
                    @forelse($rooms as $room)
                        <div class="room-item" data-room-id="{{ $room['id'] }}" data-user-name="{{ $room['user']->full_name }}"
                            data-user-email="{{ $room['user']->email }}" data-status="{{ $room['status'] }}">
                            <div class="room-item-header">
                                <span class="room-user-name">
                                    <i class="fas fa-user-circle"></i> {{ $room['user']->full_name }}
                                    @if($room['unread_count'] > 0)
                                        <span class="room-unread-badge">{{ $room['unread_count'] }}</span>
                                    @endif
                                </span>
                                <span class="room-time">{{ $room['updated_at'] }}</span>
                            </div>

                            @if($room['last_message'])
                                <div class="room-last-message">
                                    @if($room['last_message']['is_admin'])
                                        <strong>Bạn:</strong>
                                    @endif
                                    {{ $room['last_message']['message'] }}
                                </div>
                            @else
                                <div class="room-last-message text-muted">
                                    <em>Chưa có tin nhắn</em>
                                </div>
                            @endif

                            <span class="room-status {{ $room['status'] }}">
                                {{ $room['status'] === 'open' ? 'Đang mở' : 'Đã đóng' }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Chưa có cuộc trò chuyện nào</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Panel - Chat Area -->
            <div class="chat-area">
                <div class="chat-area-empty" id="emptyState">
                    <i class="fas fa-comments"></i>
                    <h5>Chọn một cuộc trò chuyện để bắt đầu</h5>
                    <p class="text-muted">Chọn khách hàng từ danh sách bên trái</p>
                </div>

                <div id="chatPanel" style="display: none; height: 100%; flex-direction: column; flex: 1;">
                    <div class="chat-header">
                        <div class="chat-user-info">
                            <h5 id="chatUserName"></h5>
                            <small id="chatUserEmail" class="text-muted"></small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-success" id="openRoomBtn" style="display: none;">
                                <i class="fas fa-lock-open"></i> Mở lại
                            </button>
                            <button class="btn btn-sm btn-danger" id="closeRoomBtn" style="display: none;">
                                <i class="fas fa-lock"></i> Đóng chat
                            </button>
                        </div>
                    </div>

                    <div class="chat-messages-area" id="chatMessagesArea">
                        <div class="loading-spinner active">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <div class="chat-input-area" id="chatInputArea">
                        <form id="adminChatForm">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" id="adminMessageInput"
                                    placeholder="Nhập tin nhắn..." autocomplete="off">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Gửi
                                </button>
                            </div>
                        </form>
                        <div class="text-center text-danger mt-2" id="closedWarning" style="display: none;">
                            <small><i class="fas fa-lock"></i> Phòng chat đã đóng. Mở lại để gửi tin nhắn.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roomItems = document.querySelectorAll('.room-item');
            const emptyState = document.getElementById('emptyState');
            const chatPanel = document.getElementById('chatPanel');
            const chatMessagesArea = document.getElementById('chatMessagesArea');
            const chatUserName = document.getElementById('chatUserName');
            const chatUserEmail = document.getElementById('chatUserEmail');
            const adminChatForm = document.getElementById('adminChatForm');
            const adminMessageInput = document.getElementById('adminMessageInput');
            const closeRoomBtn = document.getElementById('closeRoomBtn');
            const openRoomBtn = document.getElementById('openRoomBtn');
            const chatInputArea = document.getElementById('chatInputArea');
            const closedWarning = document.getElementById('closedWarning');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            let currentRoomId = null;
            let currentRoomStatus = null;
            let pusherChannel = null;

            // Handle room selection
            roomItems.forEach(item => {
                item.addEventListener('click', function () {
                    const roomId = this.dataset.roomId;
                    const userName = this.dataset.userName;
                    const userEmail = this.dataset.userEmail;
                    const status = this.dataset.status;

                    selectRoom(roomId, userName, userEmail, status);

                    // Update active state
                    roomItems.forEach(r => r.classList.remove('active'));
                    this.classList.add('active');

                    // Remove unread badge
                    const badge = this.querySelector('.room-unread-badge');
                    if (badge) badge.remove();
                });
            });

            // Select room and load messages
            async function selectRoom(roomId, userName, userEmail, status) {
                currentRoomId = roomId;
                currentRoomStatus = status;

                // Show chat panel
                emptyState.style.display = 'none';
                chatPanel.style.display = 'flex';

                // Update header
                chatUserName.textContent = userName;
                chatUserEmail.textContent = userEmail;

                // Update status buttons
                updateStatusButtons(status);

                // Load messages
                await loadMessages(roomId);

                // Setup Pusher for this room
                setupPusher(roomId);
            }

            // Load messages
            async function loadMessages(roomId) {
                try {
                    const response = await fetch(`/admin/chat/rooms/${roomId}/messages`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    const data = await response.json();
                    displayMessages(data.messages);

                } catch (error) {
                    console.error('Error loading messages:', error);
                }
            }

            // Display messages
            function displayMessages(messages) {
                chatMessagesArea.innerHTML = '';

                if (messages.length === 0) {
                    chatMessagesArea.innerHTML = `
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-comments fa-3x mb-3"></i>
                                <p>Chưa có tin nhắn nào</p>
                            </div>
                        `;
                } else {
                    messages.forEach(msg => addMessageToUI(msg));
                }

                scrollToBottom();
            }

            // Add message to UI
            function addMessageToUI(data) {
                // Remove empty state if exists
                const emptyMsg = chatMessagesArea.querySelector('.text-center');
                if (emptyMsg) emptyMsg.remove();

                // Remove loading
                const loading = chatMessagesArea.querySelector('.loading-spinner');
                if (loading) loading.remove();

                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${data.is_admin ? 'admin' : 'user'}`;

                messageDiv.innerHTML = `
                        <div class="message-bubble">
                            <div class="message-sender">${data.user.full_name}</div>
                            ${escapeHtml(data.message)}
                            <span class="message-time">${data.created_at}</span>
                        </div>
                    `;

                chatMessagesArea.appendChild(messageDiv);
                scrollToBottom();
            }

            // Send message
            adminChatForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                if (!currentRoomId || currentRoomStatus === 'closed') {
                    alert('Không thể gửi tin nhắn. Phòng chat đã đóng.');
                    return;
                }

                const message = adminMessageInput.value.trim();
                if (!message) return;

                try {
                    const response = await fetch(`/admin/chat/rooms/${currentRoomId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message })
                    });

                    const result = await response.json();

                    if (result.success) {
                        // addMessageToUI(result.message);
                        adminMessageInput.value = '';
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                    alert('Có lỗi xảy ra khi gửi tin nhắn');
                }
            });

            // Setup Pusher
            function setupPusher(roomId) {
                // Unsubscribe previous channel
                if (pusherChannel) {
                    pusherChannel.unbind_all();
                }

                const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    encrypted: true
                });

                pusherChannel = pusher.subscribe('chat.' + roomId);

                pusherChannel.bind('message.sent', function (data) {
                    console.log('New message received:', data);
                    addMessageToUI(data);
                });
            }

            // Close room
            closeRoomBtn.addEventListener('click', async function () {
                if (!currentRoomId || !confirm('Bạn có chắc muốn đóng phòng chat này?')) return;

                try {
                    const response = await fetch(`/admin/chat/rooms/${currentRoomId}/close`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();
                    if (result.success) {
                        currentRoomStatus = 'closed';
                        updateStatusButtons('closed');
                        alert('Đã đóng phòng chat');

                        // Update room item status
                        const roomItem = document.querySelector(`[data-room-id="${currentRoomId}"]`);
                        if (roomItem) {
                            roomItem.dataset.status = 'closed';
                            const statusBadge = roomItem.querySelector('.room-status');
                            statusBadge.className = 'room-status closed';
                            statusBadge.textContent = 'Đã đóng';
                        }
                    }
                } catch (error) {
                    console.error('Error closing room:', error);
                }
            });

            // Open room
            openRoomBtn.addEventListener('click', async function () {
                if (!currentRoomId) return;

                try {
                    const response = await fetch(`/admin/chat/rooms/${currentRoomId}/open`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();
                    if (result.success) {
                        currentRoomStatus = 'open';
                        updateStatusButtons('open');
                        alert('Đã mở lại phòng chat');

                        // Update room item status
                        const roomItem = document.querySelector(`[data-room-id="${currentRoomId}"]`);
                        if (roomItem) {
                            roomItem.dataset.status = 'open';
                            const statusBadge = roomItem.querySelector('.room-status');
                            statusBadge.className = 'room-status open';
                            statusBadge.textContent = 'Đang mở';
                        }
                    }
                } catch (error) {
                    console.error('Error opening room:', error);
                }
            });

            // Update status buttons
            function updateStatusButtons(status) {
                if (status === 'open') {
                    closeRoomBtn.style.display = 'inline-block';
                    openRoomBtn.style.display = 'none';
                    adminChatForm.querySelector('input').disabled = false;
                    adminChatForm.querySelector('button').disabled = false;
                    closedWarning.style.display = 'none';
                } else {
                    closeRoomBtn.style.display = 'none';
                    openRoomBtn.style.display = 'inline-block';
                    adminChatForm.querySelector('input').disabled = true;
                    adminChatForm.querySelector('button').disabled = true;
                    closedWarning.style.display = 'block';
                }
            }

            // Utility functions
            function scrollToBottom() {
                chatMessagesArea.scrollTop = chatMessagesArea.scrollHeight;
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        });
    </script>
@endsection
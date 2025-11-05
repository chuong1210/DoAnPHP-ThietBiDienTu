<?php $__env->startSection('title', 'Quản Lý Đơn Hàng'); ?>
<?php $__env->startSection('page-title', 'Hỗ Trợ Khách Hàng'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --bg-main: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --border: #CBD5E1;
            --radius: 16px;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .chat-admin-container {
            display: flex;
            height: calc(100vh - 150px);
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
        }

        /* === LEFT SIDEBAR - ROOM LIST === */
        .chat-rooms-sidebar {
            width: 360px;
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.02);
        }

        .chat-rooms-header {
            padding: 22px 20px;
            background: linear-gradient(135deg, var(--primary), #3388FF);
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .chat-rooms-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 17px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chat-rooms-header small {
            font-size: 12px;
            opacity: 0.9;
            font-weight: 500;
        }

        .chat-rooms-list {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
        }

        .room-item {
            padding: 16px;
            margin-bottom: 10px;
            background: var(--bg-main);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .room-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .room-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            background: white;
            border-color: rgba(0, 102, 255, 0.1);
        }

        .room-item:hover::before {
            transform: scaleY(1);
        }

        .room-item.active {
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.08), rgba(0, 180, 216, 0.05));
            border-color: var(--primary);
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(0, 102, 255, 0.15);
        }

        .room-item.active::before {
            transform: scaleY(1);
        }

        .room-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .room-user-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .room-time {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .room-last-message {
            font-size: 13.5px;
            color: #475569;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .room-unread-badge {
            background: #EF4444;
            color: white;
            border-radius: 50px;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
        }

        .room-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .room-status.open {
            background: #DCFCE7;
            color: #166534;
        }

        .room-status.closed {
            background: #FECACA;
            color: #991B1B;
        }

        /* === RIGHT PANEL - CHAT AREA === */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-main);
        }

        .chat-area-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-muted);
            font-size: 16px;
        }

        .chat-area-empty i {
            font-size: 72px;
            margin-bottom: 20px;
            color: #CBD5E1;
        }

        .chat-area-empty h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .chat-header {
            padding: 20px 28px;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .chat-user-info h5 {
            margin: 0;
            font-weight: 700;
            color: var(--text-dark);
            font-size: 17px;
        }

        .chat-user-info small {
            color: var(--text-muted);
            font-size: 13px;
        }

        .chat-messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
            background: var(--bg-main);
        }

        .chat-message {
            display: flex;
            margin-bottom: 22px;
            animation: messageSlide 0.35s ease-out;
        }

        @keyframes messageSlide {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chat-message.admin {
            justify-content: flex-end;
        }

        .chat-message.user {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 65%;
            padding: 14px 18px;
            border-radius: 18px;
            word-wrap: break-word;
            position: relative;
            box-shadow: var(--shadow-sm);
            line-height: 1.5;
        }

        .chat-message.admin .message-bubble {
            background: linear-gradient(135deg, var(--primary), #3388FF);
            color: white;
            border-bottom-right-radius: 6px;
        }

        .chat-message.user .message-bubble {
            background: white;
            color: var(--text-dark);
            border-bottom-left-radius: 6px;
            border: 1px solid var(--border);
  }

        .message-sender {
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 6px;
            opacity: 0.9;
        }

        .message-time {
            font-size: 11px;
            opacity: 0.75;
            margin-top: 8px;
            display: block;
            font-weight: 500;
        }

        .chat-input-area {
            padding: 22px 28px;
            background: var(--bg-card);
            border-top: 1px solid var(--border);
            box-shadow: 0 -2px 8px rgba(0,0,0,0.03);
        }

        .chat-input-area .form-control {
            border-radius: 50px;
            border: 2px solid var(--border);
            padding: 14px 20px;
            font-size: 15px;
            background: var(--bg-main);
            transition: all 0.25s ease;
        }

        .chat-input-area .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 255, 0.2);
            background: white;
        }

        .chat-input-area .btn-primary {
            border-radius: 50px;
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--primary), #3388FF);
            border: none;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
            transition: all 0.25s ease;
        }

        .chat-input-area .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 102, 255, 0.4);
        }

        .chat-input-area .btn-primary i {
            margin-right: 6px;
        }

        #closedWarning {
            font-size: 13px;
            color: #DC2626;
            font-weight: 500;
        }

        /* Scrollbar */
        .chat-rooms-list::-webkit-scrollbar,
        .chat-messages-area::-webkit-scrollbar {
            width: 6px;
        }

        .chat-rooms-list::-webkit-scrollbar-track,
        .chat-messages-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-rooms-list::-webkit-scrollbar-thumb,
        .chat-messages-area::-webkit-scrollbar-thumb {
            background: rgba(0, 102, 255, 0.3);
            border-radius: 10px;
        }

        .chat-rooms-list::-webkit-scrollbar-thumb:hover,
        .chat-messages-area::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Loading */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 30px;
        }

        .loading-spinner.active {
            display: block;
        }

        .spinner-border {
            width: 2.5rem;
            height: 2.5rem;
            color: var(--primary);
        }

        /* Button Group */
        .btn-group .btn {
            border-radius: 50px !important;
            font-size: 13px;
            padding: 6px 14px;
            font-weight: 600;
        }

        .btn-success {
            background: #10B981;
            border: none;
        }

        .btn-danger {
            background: #EF4444;
            border: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .chat-admin-container {
                flex-direction: column;
                height: auto;
                min-height: calc(100vh - 160px);
            }

            .chat-rooms-sidebar {
                width: 100%;
                max-height: 300px;
            }

            .chat-area {
                flex: 1;
            }
        }

        @media (max-width: 576px) {
            .chat-header {
                padding: 16px;
            }

            .chat-messages-area,
            .chat-input-area {
                padding: 20px 16px;
            }

            .room-item {
                padding: 14px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="chat-admin-container">
            <!-- Left Sidebar - Rooms List -->
            <div class="chat-rooms-sidebar">
                <div class="chat-rooms-header">
                    <h5>
                        <i class="fas fa-comments"></i> Danh Sách Chat
                    </h5>
                    <small><?php echo e(count($rooms)); ?> cuộc hội thoại</small>
                </div>

                <div class="chat-rooms-list" id="roomsList">
                    <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="room-item"
                             data-room-id="<?php echo e($room['id']); ?>"
                             data-user-name="<?php echo e($room['user']->full_name); ?>"
                             data-user-email="<?php echo e($room['user']->email); ?>"
                             data-status="<?php echo e($room['status']); ?>">
                            <div class="room-item-header">
                                <span class="room-user-name">
                                    <i class="fas fa-user-circle text-primary"></i>
                                    <?php echo e($room['user']->full_name); ?>

                                    <?php if($room['unread_count'] > 0): ?>
                                        <span class="room-unread-badge"><?php echo e($room['unread_count']); ?></span>
                                    <?php endif; ?>
                                </span>
                                <span class="room-time"><?php echo e(\Carbon\Carbon::parse($room['updated_at'])->format('H:i')); ?></span>
                            </div>

                            <?php if($room['last_message']): ?>
                                <div class="room-last-message">
                                    <?php if($room['last_message']['is_admin']): ?>
                                        <strong>Bạn:</strong>
                                    <?php endif; ?>
                                    <?php echo e(Str::limit($room['last_message']['message'], 50)); ?>

                                </div>
                            <?php else: ?>
                                <div class="room-last-message text-muted">
                                    <em>Chưa có tin nhắn</em>
                                </div>
                            <?php endif; ?>

                            <span class="room-status <?php echo e($room['status']); ?>">
                                <?php echo e($room['status'] === 'open' ? 'Đang mở' : 'Đã đóng'); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                            <p>Chưa có cuộc trò chuyện nào</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Panel - Chat Area -->
            <div class="chat-area">
                <div class="chat-area-empty" id="emptyState">
                    <i class="fas fa-comments"></i>
                    <h5>Chọn một cuộc trò chuyện</h5>
                    <p class="text-muted">Nhấn vào khách hàng bên trái để bắt đầu</p>
                </div>

                <div id="chatPanel" style="display: none; height: 100%; display: flex; flex-direction: column;">
                    <div class="chat-header">
                        <div class="chat-user-info">
                            <h5 id="chatUserName">—</h5>
                            <small id="chatUserEmail" class="text-muted">—</small>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" id="openRoomBtn" style="display: none;">
                                <i class="fas fa-lock-open"></i> Mở lại
                            </button>
                            <button class="btn btn-danger btn-sm" id="closeRoomBtn" style="display: none;">
                                <i class="fas fa-lock"></i> Đóng
                            </button>
                        </div>
                    </div>

                    <div class="chat-messages-area" id="chatMessagesArea">
                        <div class="loading-spinner active">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <div class="chat-input-area" id="chatInputArea">
                        <form id="adminChatForm">
                            <?php echo csrf_field(); ?>
                            <div class="input-group">
                                <input type="text" class="form-control" id="adminMessageInput"
                                    placeholder="Nhập tin nhắn của bạn..." autocomplete="off">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Gửi
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-2" id="closedWarning" style="display: none;">
                            <small><i class="fas fa-lock text-danger"></i> Phòng chat đã đóng. Vui lòng mở lại để gửi tin nhắn.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

            roomItems.forEach(item => {
                item.addEventListener('click', function () {
                    const roomId = this.dataset.roomId;
                    const userName = this.dataset.userName;
                    const userEmail = this.dataset.userEmail;
                    const status = this.dataset.status;

                    selectRoom(roomId, userName, userEmail, status);

                    roomItems.forEach(r => r.classList.remove('active'));
                    this.classList.add('active');

                    const badge = this.querySelector('.room-unread-badge');
                    if (badge) badge.remove();
                });
            });

            async function selectRoom(roomId, userName, userEmail, status) {
                currentRoomId = roomId;
                currentRoomStatus = status;

                emptyState.style.display = 'none';
                chatPanel.style.display = 'flex';

                chatUserName.textContent = userName;
                chatUserEmail.textContent = userEmail;

                updateStatusButtons(status);
                await loadMessages(roomId);
                setupPusher(roomId);
            }

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

            function displayMessages(messages) {
                chatMessagesArea.innerHTML = '';

                if (messages.length === 0) {
                    chatMessagesArea.innerHTML = `
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                            <p>Chưa có tin nhắn nào</p>
                        </div>
                    `;
                } else {
                    messages.forEach(msg => addMessageToUI(msg));
                }

                scrollToBottom();
            }

            function addMessageToUI(data) {
                const emptyMsg = chatMessagesArea.querySelector('.text-center');
                if (emptyMsg) emptyMsg.remove();

                const loading = chatMessagesArea.querySelector('.loading-spinner');
                if (loading) loading.remove();

                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${data.is_admin ? 'admin' : 'user'}`;

                messageDiv.innerHTML = `
                    <div class="message-bubble">
                        <div class="message-sender">${data.user.full_name}</div>
                        ${escapeHtml(data.message)}
                        <span class="message-time">${formatTime(data.created_at)}</span>
                    </div>
                `;

                chatMessagesArea.appendChild(messageDiv);
                scrollToBottom();
            }

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
                        adminMessageInput.value = '';
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                    alert('Có lỗi xảy ra khi gửi tin nhắn');
                }
            });

            function setupPusher(roomId) {
                if (pusherChannel) {
                    pusherChannel.unbind_all();
                }

                const pusher = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
                    cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>',
                    encrypted: true
                });

                pusherChannel = pusher.subscribe('chat.' + roomId);

                pusherChannel.bind('message.sent', function (data) {
                    addMessageToUI(data);
                });
            }

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

            function scrollToBottom() {
                chatMessagesArea.scrollTop = chatMessagesArea.scrollHeight;
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function formatTime(time) {
                return new Date(time).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Nam4\PHP\DoAnPHP-ThietBiDienTu\resources\views/admin/chat/index.blade.php ENDPATH**/ ?>
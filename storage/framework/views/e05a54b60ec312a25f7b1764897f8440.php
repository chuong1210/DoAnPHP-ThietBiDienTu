


<?php if(auth()->guard()->check()): ?>
    <div id="chatWidgetContainer">
        <!-- Chat Button -->
        <div id="chatButton" class="chat-button">
            
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
        </div>

        <!-- Chat Window -->
        <div id="chatWindow" class="chat-window" style="display: none;">
            <!-- Header -->
            <div class="chat-window-header">
                <div class="d-flex align-items-center">
                    <div class="chat-avatar">
                        <img src="https://cdn1.iconfinder.com/data/icons/user-pictures/100/supportmale-512.png"
                            alt="Support Avatar">
                    </div>
                    <div>
                        <h6 class="mb-0">Hỗ trợ trực tuyến</h6>
                        <small class="online-status">Đang hoạt động</small>
                    </div>
                </div>
                <button id="minimizeChat" class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </div>

            <!-- Messages Area -->
            <div class="chat-window-messages" id="chatWindowMessages">
                <div class="welcome-message">
                    <div class="welcome-logo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                    </div>
                    <h5>Chào mừng bạn đến với TechShop!</h5>
                    <p>Chúng tôi có thể giúp gì cho bạn hôm nay?</p>
                </div>
            </div>

            <!-- Input Area -->
            <div class="chat-window-input">
                <form id="chatWidgetForm" class="d-flex align-items-center">
                    <?php echo csrf_field(); ?>
                    <input type="text" class="form-control" id="chatWidgetInput" placeholder="Nhập tin nhắn..."
                        autocomplete="off">
                    <button type="submit" class="btn-send">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Sử dụng biến màu "Tech Blue Pro" */
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --danger: #EF4444;
            --font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        #chatWidgetContainer {
            font-family: var(--font-family);
        }

        /* Chat Button */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.25);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            z-index: 9998;
            animation: pulse-light 2.5s infinite;
        }

        .chat-button:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 12px 28px rgba(0, 102, 255, 0.35);
        }

        @keyframes pulse-light {

            0%,
            100% {
                box-shadow: 0 8px 20px rgba(0, 102, 255, 0.25);
            }

            50% {
                box-shadow: 0 8px 28px rgba(0, 180, 216, 0.4);
            }
        }

        .chat-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Chat Window */
        .chat-window {
            position: fixed;
            bottom: 110px;
            right: 30px;
            width: 380px;
            max-height: 80vh;
            background-color: var(--background);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 102, 255, 0.15);
            display: flex;
            flex-direction: column;
            z-index: 9999;
            overflow: hidden;
            border: 1px solid var(--neutral);
            transform-origin: bottom right;
            animation: scaleUp 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes scaleUp {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .chat-window-header {
            background: white;
            padding: 16px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .chat-window-header h6 {
            color: var(--text);
            font-size: 16px;
            font-weight: 700;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 12px;
            border: 2px solid var(--primary);
        }

        .chat-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .online-status {
            font-size: 13px;
            color: #10B981;
            /* Green for online */
            font-weight: 500;
        }

        .online-status::before {
            content: '●';
            margin-right: 5px;
            font-size: 10px;
        }

        .btn-icon {
            background: none;
            border: none;
            color: var(--neutral);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-icon:hover {
            background-color: var(--background);
            color: var(--primary);
        }

        .chat-window-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .welcome-message {
            margin: auto;
            text-align: center;
            color: #94A3B8;
        }

        .welcome-logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #E0F2FE;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: var(--primary);
        }

        .welcome-message h5 {
            color: var(--text);
            font-weight: 600;
        }

        .chat-message {
            display: flex;
            margin-bottom: 16px;
            max-width: 85%;
            animation: messageFadeIn 0.3s ease-out;
        }

        @keyframes messageFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-message.user {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .chat-message.admin {
            align-self: flex-start;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14.5px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .chat-message.user .message-bubble {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-bottom-right-radius: 4px;
        }

        .chat-message.admin .message-bubble {
            background: white;
            color: var(--text);
            border: 1px solid var(--neutral);
            border-bottom-left-radius: 4px;
        }

        .message-time {
            font-size: 11px;
            color: #94A3B8;
            margin: 4px 8px 0;
            flex-shrink: 0;
        }

        .chat-window-input {
            padding: 12px 20px;
            background: white;
            border-top: 1px solid #e9ecef;
            flex-shrink: 0;
        }

        .chat-window-input .form-control {
            border: none;
            background-color: var(--background);
            border-radius: 20px;
            padding: 10px 16px;
            flex-grow: 1;
            margin-right: 12px;
            font-size: 14px;
        }

        .chat-window-input .form-control:focus {
            box-shadow: none;
            background-color: white;
            border: 1px solid var(--primary);
        }

        .btn-send {
            background-color: var(--primary);
            color: white;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
            flex-shrink: 0;
        }

        .btn-send:hover {
            background-color: var(--secondary);
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .chat-window {
                width: calc(100% - 20px);
                max-height: calc(100vh - 80px);
                bottom: 90px;
                right: 10px;
            }
        }

        /* Scrollbar */
        .chat-window-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-window-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-window-messages::-webkit-scrollbar-thumb {
            background: var(--neutral);
            border-radius: 3px;
        }

        .chat-window-messages::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>

    
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatButton = document.getElementById('chatButton');
            const chatWindow = document.getElementById('chatWindow');
            const minimizeChat = document.getElementById('minimizeChat');
            const chatWidgetForm = document.getElementById('chatWidgetForm');
            const chatWidgetInput = document.getElementById('chatWidgetInput');
            const chatWindowMessages = document.getElementById('chatWindowMessages');
            const chatBadge = document.getElementById('chatBadge');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Lấy ra welcome message ban đầu
            const initialWelcomeMessage = chatWindowMessages.innerHTML;

            let roomId = null;
            let isOpen = false;
            let unreadCount = 0;

            // Toggle chat window
            chatButton.addEventListener('click', async function () {
                isOpen = !isOpen;
                chatWindow.style.display = isOpen ? 'flex' : 'none';
                this.style.display = isOpen ? 'none' : 'flex'; // Ẩn nút chat khi mở cửa sổ

                if (isOpen) {
                    await loadOrCreateRoom();
                    unreadCount = 0;
                    updateBadge();
                    // Mark as read when opening
                    if (roomId) {
                        fetch(`/chat/rooms/${roomId}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } });
                    }
                }
            });

            minimizeChat.addEventListener('click', function () {
                isOpen = false;
                chatWindow.style.display = 'none';
                chatButton.style.display = 'flex'; // Hiện lại nút chat
            });

            // Load or create chat room
            async function loadOrCreateRoom() {
                try {
                    const response = await fetch('/chat/room', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    const data = await response.json();
                    roomId = data.room.id;

                    // Load messages
                    loadMessages(data.messages);

                    // Setup Pusher
                    setupPusher();

                } catch (error) {
                    console.error('Error loading room:', error);
                }
            }

            // Load messages
            function loadMessages(messages) {
                chatWindowMessages.innerHTML = '';

                if (messages.length === 0) {
                    chatWindowMessages.innerHTML = initialWelcomeMessage;
                } else {
                    messages.forEach(msg => addMessageToUI(msg, false));
                }
                scrollToBottom();
            }

            // Add message to UI
            function addMessageToUI(data, withAnimation = true) {
                // Remove welcome message if exists
                const welcomeMsg = chatWindowMessages.querySelector('.welcome-message');
                if (welcomeMsg) {
                    welcomeMsg.remove();
                }

                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${data.is_admin ? 'admin' : 'user'}`;

                // Format time: HH:mm
                const time = new Date(data.created_at || Date.now()).toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                messageDiv.innerHTML = `
                        <div class="message-bubble">
                            ${escapeHtml(data.message)}
                        </div>
                        <span class="message-time">${time}</span>
                    `;

                if (!withAnimation) {
                    messageDiv.style.animation = 'none';
                }

                chatWindowMessages.appendChild(messageDiv);
                scrollToBottom();
            }

            // Send message
            chatWidgetForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const message = chatWidgetInput.value.trim();
                if (!message || !roomId) return;

                // Tạm thời hiển thị tin nhắn của người dùng ngay lập tức
                const optimisticMessage = {
                    message: message,
                    is_admin: false,
                    created_at: new Date().toISOString()
                };
                addMessageToUI(optimisticMessage);
                chatWidgetInput.value = '';

                try {
                    const response = await fetch(`/chat/rooms/${roomId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message })
                    });

                    if (!response.ok) {
                        // Nếu có lỗi, có thể hiển thị lại tin nhắn với trạng thái lỗi
                        console.error('Failed to send message');
                    }

                } catch (error) {
                    console.error('Error sending message:', error);
                    alert('Có lỗi xảy ra khi gửi tin nhắn');
                }
            });

            // Setup Pusher
            function setupPusher() {
                // Đảm bảo chỉ khởi tạo Pusher một lần
                if (window.pusherInstance) return;

                window.pusherInstance = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
                    cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>',
                    forceTLS: true
                });

                const channel = window.pusherInstance.subscribe('chat.' + roomId);

                channel.bind('message.sent', function (data) {
                    // Chỉ thêm tin nhắn nếu nó là từ admin (vì tin nhắn user đã được thêm bằng optimistic UI)
                    if (data.is_admin) {
                        addMessageToUI(data);

                        if (!isOpen) {
                            unreadCount++;
                            updateBadge();
                        } else {
                            // Nếu cửa sổ đang mở, gửi yêu cầu đánh dấu đã đọc
                            fetch(`/chat/rooms/${roomId}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } });
                        }
                    }
                });
            }

            // Update badge
            function updateBadge() {
                if (unreadCount > 0) {
                    chatBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                    chatBadge.style.display = 'flex';
                } else {
                    chatBadge.style.display = 'none';
                }
            }

            // Utility functions
            function scrollToBottom() {
                chatWindowMessages.scrollTop = chatWindowMessages.scrollHeight;
            }



            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function (m) { return map[m]; });
            }

            // Load unread count on page load
            async function loadUnreadCount() {
                try {
                    const response = await fetch('/chat/unread-count', {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    const data = await response.json();
                    unreadCount = data.count;
                    updateBadge();
                } catch (error) {
                    console.error('Error loading unread count:', error);
                }
            }

            loadUnreadCount();
        });
    </script>
<?php endif; ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/client/partials/chat-widget.blade.php ENDPATH**/ ?>
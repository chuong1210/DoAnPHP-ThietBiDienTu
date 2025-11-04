{{-- resources/views/client/partials/chat-widget.blade.php --}}
{{-- Component này sẽ được include vào layout.client --}}

@auth
    <div id="chatWidget">
        <!-- Chat Button -->
        <div id="chatButton" class="chat-button">
            <i class="fas fa-comments"></i>
            <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
        </div>

        <!-- Chat Window -->
        <div id="chatWindow" class="chat-window" style="display: none;">
            <div class="chat-window-header">
                <div>
                    <h6 class="mb-0"><i class="fas fa-headset"></i> Hỗ trợ trực tuyến</h6>
                    <small class="text-white-50">Chúng tôi sẵn sàng giúp bạn</small>
                </div>
                <div>
                    <button id="minimizeChat" class="btn btn-sm btn-light">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="chat-window-messages" id="chatWindowMessages">
                <div class="text-center text-muted py-4">
                    <i class="fas fa-comments fa-3x mb-2"></i>
                    <p>Bắt đầu cuộc trò chuyện</p>
                </div>
            </div>

            <div class="chat-window-input">
                <form id="chatWidgetForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" id="chatWidgetInput" placeholder="Nhập tin nhắn..."
                            autocomplete="off">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Chat Button */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            z-index: 9998;
            animation: pulse 2s infinite;
        }

        .chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            }

            50% {
                box-shadow: 0 4px 20px rgba(102, 126, 234, 0.8);
            }
        }

        .chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
        }

        /* Chat Window */
        .chat-window {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 380px;
            height: 550px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            z-index: 9999;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-window-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-window-header h6 {
            font-size: 16px;
            font-weight: 600;
        }

        .chat-window-header small {
            font-size: 12px;
        }

        .chat-window-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .chat-message {
            display: flex;
            margin-bottom: 16px;
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

        .chat-message.user {
            justify-content: flex-end;
        }

        .chat-message.admin {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 16px;
            word-wrap: break-word;
            font-size: 14px;
        }

        .chat-message.user .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .chat-message.admin .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .message-time {
            font-size: 10px;
            opacity: 0.7;
            margin-top: 4px;
            display: block;
        }

        .chat-window-input {
            padding: 16px;
            background: white;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 12px 12px;
        }

        .chat-window-input .form-control {
            border-radius: 20px;
            border: 1px solid #dee2e6;
            padding: 10px 16px;
        }

        .chat-window-input .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }

        .chat-window-input .btn-primary {
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-window {
                width: 100%;
                height: 100%;
                bottom: 0;
                right: 0;
                border-radius: 0;
            }

            .chat-button {
                bottom: 20px;
                right: 20px;
            }
        }

        /* Scrollbar */
        .chat-window-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-window-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-window-messages::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .chat-window-messages::-webkit-scrollbar-thumb:hover {
            background: #555;
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

            let roomId = null;
            let isOpen = false;
            let unreadCount = 0;

            // Toggle chat window
            chatButton.addEventListener('click', async function () {
                isOpen = !isOpen;
                chatWindow.style.display = isOpen ? 'flex' : 'none';

                if (isOpen) {
                    await loadOrCreateRoom();
                    unreadCount = 0;
                    updateBadge();
                }
            });

            minimizeChat.addEventListener('click', function () {
                isOpen = false;
                chatWindow.style.display = 'none';
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
                    chatWindowMessages.innerHTML = `
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-comments fa-3x mb-2"></i>
                                    <p>Bắt đầu cuộc trò chuyện</p>
                                </div>
                            `;
                } else {
                    messages.forEach(msg => addMessageToUI(msg));
                }

                scrollToBottom();
            }

            // Add message to UI
            function addMessageToUI(data) {
                // Remove welcome message if exists
                const welcomeMsg = chatWindowMessages.querySelector('.text-center');
                if (welcomeMsg) {
                    welcomeMsg.remove();
                }

                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${data.is_admin ? 'admin' : 'user'}`;

                const time = data.created_at ? data.created_at : new Date().toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                messageDiv.innerHTML = `
                            <div class="message-bubble">
                                ${escapeHtml(data.message)}
                                <span class="message-time">${time}</span>
                            </div>
                        `;

                chatWindowMessages.appendChild(messageDiv);
                scrollToBottom();
            }

            // Send message
            chatWidgetForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const message = chatWidgetInput.value.trim();
                if (!message || !roomId) return;

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

                    const result = await response.json();

                    if (result.success) {
                        addMessageToUI(result.message);
                        chatWidgetInput.value = '';
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                    alert('Có lỗi xảy ra khi gửi tin nhắn');
                }
            });

            // Setup Pusher
            function setupPusher() {
                const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    encrypted: true
                });

                const channel = pusher.subscribe('chat.' + roomId);

                channel.bind('message.sent', function (data) {
                    console.log('New message received:', data);
                    addMessageToUI(data);

                    // Increase unread count if window is closed
                    if (!isOpen && data.is_admin) {
                        unreadCount++;
                        updateBadge();
                    }
                });
            }
            // Update badge
            function updateBadge() {
                if (unreadCount > 0) {
                    chatBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
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
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
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
@endauth
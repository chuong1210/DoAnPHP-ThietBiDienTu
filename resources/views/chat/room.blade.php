<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat hỗ trợ khách hàng</title>

    {{-- AlpineJS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/app.js'])


    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .chat {
            width: 700px;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 85vh;
        }

        .header {
            background: #10b981;
            color: white;
            padding: 1rem;
            font-weight: bold;
            text-align: center;
        }

        .messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            background: #f9fafb;
        }

        .msg {
            margin: 8px 0;
            padding: 10px 14px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .msg.me {
            background: #10b981;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .msg.other {
            background: #e5e7eb;
            color: #111;
            margin-right: auto;
            border-bottom-left-radius: 4px;
        }

        .input-area {
            display: flex;
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            background: white;
        }

        .input-area input {
            flex: 1;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 999px;
            outline: none;
        }

        .input-area button {
            margin-left: 10px;
            background: #10b981;
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
        }

        small {
            display: block;
            font-size: 12px;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="chat" x-data="chatApp()" x-init="init()">
        <div class="header">
            💬 Hỗ trợ khách hàng - Phòng #{{ $room->id }}
        </div>

        <div class="messages" id="messages">
            <template x-for="msg in messages" :key="msg.id">
                <div :class="msg.user.id === myId ? 'msg me' : 'msg other'">
                    <div class="font-bold" x-text="msg.user.name"></div>
                    <div x-text="msg.message"></div>
                    <small x-text="msg.created_at"></small>
                </div>
            </template>
        </div>

        <div class="input-area">
            <input x-model="newMessage" @keyup.enter="send()" placeholder="Nhập tin nhắn..." />
            <button @click="send()">➤</button>
        </div>
    </div>

    <script>
        function chatApp() {
            return {
                roomId: {{ $room->id }},
                myId: {{ auth()->id() }},
                messages: [],
                newMessage: '',

              init() {
                    this.loadMessages();

                    // ✅ Đợi cho tới khi Echo sẵn sàng mới đăng ký lắng nghe
                    const waitForEcho = setInterval(() => {
                        if (typeof Echo !== 'undefined' && Echo.connector) {
                            clearInterval(waitForEcho);
                            console.log("✅ Laravel Echo đã sẵn sàng!");

                            Echo.private(`chat.room.${this.roomId}`)
                                .listen('MessageSent', (e) => {
                                    console.log("📨 Tin mới:", e);
                                    this.messages.push(e);
                                    this.scrollToBottom();
                                });
                        }
                    }, 300); // kiểm tra lại mỗi 300ms
                },


                loadMessages() {
                    fetch(`/chat/messages/${this.roomId}`)
                        .then(r => r.json())
                        .then(data => {
                            this.messages = data;
                            this.scrollToBottom();
                        })
                        .catch(err => console.error('Lỗi tải tin:', err));
                },

                send() {
                    if (!this.newMessage.trim()) return;

                    fetch(`/chat/send/${this.roomId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                message: this.newMessage
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.messages.push(data);
                            this.newMessage = '';
                            this.scrollToBottom();
                        })
                        .catch(err => console.error('🚫 Gửi tin thất bại:', err));
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('messages');
                        el.scrollTop = el.scrollHeight;
                    });
                }
            }
        }
    </script>


</body>

</html>

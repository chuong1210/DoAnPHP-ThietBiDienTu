{{-- resources/views/pusher.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="p-8">

    <div x-data="app" x-init="init" class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-green-600">Pusher + Laravel</h1>
        <button @click="send" class="bg-green-600 text-white px-4 py-2 mt-4 rounded">Gửi tin</button>

        <div class="mt-6 space-y-2">
            <template x-for="msg in messages">
                <div class="p-3 bg-green-50 border border-green-200 rounded">
                    <span x-text="msg"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Pusher JS -->
    <script src="//js.pusher.com/8.2/pusher.min.js"></script>
    <script>
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        function app() {
            return {
                messages: ['Đang kết nối Pusher...'],
                init() {
                    Echo.private('test')
                        .listen('.TestEvent', (e) => {
                            this.messages.push(e.data.message + ' [' + e.data.time + ']');
                        });
                },
                send() {
                    fetch('/test');
                }
            }
        }
    </script>

</body>

</html>

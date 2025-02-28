@extends('Partials.dashboard-template-main')
@section('dashboard-content')
    <!-- resources/views/chat.blade.php -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="chat-box">
                            <!-- Chat Header -->
                            <div class="chat-header mt-3 d-flex justify-content-between align-items-center">
                                <h4>Chat with JadiGPT</h4>
                            </div>

                            <!-- Chat Messages -->
                            <div id="chat-messages" class="border rounded p-3 my-3"
                                style="height: 400px; overflow-y: auto; background: #f8f9fa;">
                                <!-- Messages akan muncul di sini -->
                            </div>

                            <!-- Chat Input -->
                            <form id="chat-form" class="d-flex">
                                <input type="text" class="form-control me-2" id="message" name="message"
                                    placeholder="Type a message..." autocomplete="off" required>
                                <button type="submit" class="btn btn-primary"> <i class="bi bi-send-fill"></i>
                                    <span>Send</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('chat-form').addEventListener('submit', function(event) {
                event.preventDefault();
                const message = document.getElementById('message').value;
                console.log('user:', message);

                if (!message.trim()) return;

                const chatMessages = document.getElementById('chat-messages');

                // Tambahkan pesan user ke tampilan chat
                const userMessage = document.createElement('div');
                userMessage.classList.add('d-flex', 'align-items-start', 'justify-content-end',
                'my-2'); // Pesan user ke kanan
                userMessage.innerHTML = `
                    <div class="alert alert-primary mb-0 ms-auto"> <!-- Pesan di kanan -->
                        ${message}
                    </div>
                    <i class="bi bi-person-fill ms-2 text-primary"></i> <!-- Ikon user di kanan -->
                `;
                chatMessages.appendChild(userMessage);

                // Scroll ke bawah
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Kosongkan input
                document.getElementById('message').value = '';

                fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.response) {
                            const aiResponse = document.createElement('div');
                            aiResponse.classList.add('d-flex', 'align-items-start', 'my-2'); // Pesan AI di kiri
                            aiResponse.innerHTML = `
                                <i class="bi bi-slack me-2 text-success"></i> <!-- Ikon AI di kiri -->
                                <div class="alert alert-success mb-0">
                                    ${data.response}
                                </div>
                            `;
                            chatMessages.appendChild(aiResponse);
                        } else {
                            // Tampilkan pesan error jika tidak ada respons dari server
                            const errorResponse = document.createElement('div');
                            errorResponse.classList.add('d-flex', 'align-items-start', 'my-2');
                            errorResponse.innerHTML = `
                                <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
                                <div class="alert alert-danger mb-0">
                                    Failed to get a response from the server.
                                </div>
                            `;
                            chatMessages.appendChild(errorResponse);
                        }

                        // Scroll ke bawah
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(error => {
                        // Tampilkan pesan error jika terjadi kesalahan koneksi
                        console.error('Error:', error);
                        const errorResponse = document.createElement('div');
                        errorResponse.classList.add('d-flex', 'align-items-start', 'my-2');
                        errorResponse.innerHTML = `
                            <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
                            <div class="alert alert-danger mb-0">
                                There was an error sending the message.
                            </div>
                        `;
                        chatMessages.appendChild(errorResponse);

                        // Scroll ke bawah
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    });
            });
        </script>
    @endsection

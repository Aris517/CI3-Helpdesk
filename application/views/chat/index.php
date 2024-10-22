<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Aduan</h5>
                <?php if ($this->session->userdata('role') !== 'cs') : ?>
                    <a href="<?= base_url('pengaduan/juber/proses') ?>" class="btn btn-sm btn-warning ms-auto">Kembali</a>
                <?php else : ?>
                    <a href="<?= base_url('pengaduan/cs/proses') ?>" class="btn btn-sm btn-warning ms-auto">Kembali</a>
                <?php endif ?>
            </div>
            <div class="card p-3 bg-light">
                <div class="chat-header">
                    Chat
                </div>
                <div class="chat-body" id="chat-body">
                    <!-- Chat messages will be loaded here -->
                </div>
                <div class="d-flex">
                    <textarea class="form-control bg-white" id="message-input" placeholder="Type a message" rows="1"></textarea>
                    <button class="btn btn-primary ms-2" id="send-button">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Function to fetch chat messages from the server
        function loadMessages() {
            $.ajax({
                url: '<?= base_url('chat/get_message') ?>', // Replace with the URL to fetch messages
                method: 'POST',
                data: {
                    pengaduan: <?= $pengaduan->id_pengaduan ?>
                },
                success: function(response) {
                    $('#chat-body').empty();

                    response = JSON.parse(response);
                    response.messages.forEach(function(message) {
                        var messageClass = message.id_pengirim == <?= $this->session->userdata('akun') ?> ? 'sent' : 'received';
                        var messageElement = `
                            <div class="chat-message ${messageClass}">
                                <div class="message-content">
                                    ${message.isi}
                                </div>
                            </div>
                        `;
                        $('#chat-body').append(messageElement);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch messages:', error);
                }
            });
        }

        // Function to send new message to the server
        function sendMessage(content) {
            $.ajax({
                url: '<?= base_url('chat/send_message') ?>', // Replace with the URL to send messages
                method: 'POST',
                data: {
                    message: content,
                    pengaduan: <?= $pengaduan->id_pengaduan ?>
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        var messageElement = `
                            <div class="chat-message sent">
                                <div class="message-content">
                                    ${content.replace(/\n/g, '<br>')}
                                </div>
                            </div>
                        `;
                        $('#chat-body').append(messageElement);
                        $('#message-input').val('');
                    } else {
                        alert('Failed to send message');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to send message:', error);
                }
            });
        }

        // Call loadMessages() when the page loads
        loadMessages();
        setInterval(loadMessages, 500);

        // Event listener for send button
        akses = false;
        if (<?= $this->session->userdata('akun') ?> == <?= $pengaduan->id_pengadu ?>) {
            akses = <?= $pengaduan->id_pengadu ?>;
        } else if (<?= $this->session->userdata('akun') ?> == <?= $pengaduan->id_perespon ?>) {
            akses = <?= $pengaduan->id_perespon ?>;
        }
        if (<?= $this->session->userdata('akun') ?> == akses) {
            $('#send-button').click(function() {
                var messageContent = $('#message-input').val();
                if (messageContent.trim() !== '') {
                    sendMessage(messageContent);
                }

            });

            // Event listener for message input (Enter key)
            $('#message-input').keypress(function(event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault(); // Prevent new line in textarea
                    var messageContent = $('#message-input').val();
                    if (messageContent.trim() !== '') {
                        sendMessage(messageContent);
                    }
                }
            });
        }
    });
</script>
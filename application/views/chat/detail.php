<div class="container-fluid">
    <div class="card" style="background-color: lightblue" ;>
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Aduan Detail</h5>
                <?php if ($this->session->userdata('role') !== 'cs') : ?>
                    <a href="<?= base_url('pengaduan/juber/selesai') ?>" class="btn btn-sm btn-warning ms-auto">Kembali</a>
                <?php else : ?>
                    <a href="<?= base_url('pengaduan/cs/selesai') ?>" class="btn btn-sm btn-warning ms-auto">Kembali</a>
                <?php endif ?>
            </div>
            <div class="card p-3 bg-light">
                <div class="chat-header">
                    Chat
                </div>
                <div class="chat-body" id="chat-body">
                    <!-- Chat messages will be loaded here -->
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
                        // Use a synchronous AJAX request to get the role of the sender
                        $.ajax({
                            url: '<?= base_url('chat/get_role_pengirim') ?>', // Replace with the URL to fetch the role of the sender
                            method: 'POST',
                            data: {
                                pengirim: message.id_pengirim
                            },
                            async: false, // Make the request synchronous
                            success: function(response) {
                                response = JSON.parse(response);
                                var role = response.akun.role;

                                var messageClass;
                                if ('<?= $this->session->userdata('role') ?>' !== 'cs') {
                                    messageClass = role !== 'cs' ? 'sent' : 'received';
                                } else {
                                    messageClass = role === 'cs' ? 'sent' : 'received';
                                }

                                var messageElement = `
                                    <div class="chat-message ${messageClass}">
                                        <div class="message-content">
                                            ${message.isi}
                                        </div>
                                    </div>
                                `;
                                $('#chat-body').append(messageElement);
                            },
                            error: function(xhr, status, error) {
                                console.error('Failed to fetch sender role:', error);
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch messages:', error);
                }
            });
        }
        // Call loadMessages() when the page loads
        loadMessages();
    });
</script>
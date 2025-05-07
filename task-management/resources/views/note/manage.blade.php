@extends('note.master')

@section('context')
    <style>
        #chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 320px;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            z-index: 9999;
        }

        #chat-header {
            background-color: #0d6efd;
            color: #fff;
            padding: 12px 16px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }

        #chat-body {
            display: none;
            max-height: 250px;
            overflow-y: auto;
            padding: 12px;
            border-top: 1px solid #ddd;
        }

        #chat-input {
            display: none;
            border-top: 1px solid #ddd;
            padding: 8px;
            background: #f8f9fa;
        }

        #chat-input textarea {
            width: 75%;
            resize: none;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 6px;
            font-size: 14px;
            height: 40px;
        }

        #chat-input button {
            width: 22%;
            margin-left: 3%;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #chat-input button:hover {
            background-color: #0b5ed7;
        }

        #chat-body div.message {
            margin-bottom: 8px;
            font-size: 14px;
        }

        #chat-body div.message.user {
            text-align: right;
            color: #0d6efd;
        }

        .chat-messages {
            max-height: 250px;
            overflow-y: auto;
            padding: 10px;
            background: #fff;
            border: 1px solid #ccc;
        }

        .chat-bubble {
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 12px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .chat-bubble.user {
            background-color: #dcf8c6;
            align-self: flex-end;
            text-align: right;
        }

        .chat-bubble.bot {
            background-color: #f1f0f0;
            align-self: flex-start;
        }
    </style>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center text-success pt-4" id="success-msg" style="height: 60px">
                            {{ Session()->get('notification') }}</h3>
                        <h6 class="card-title">User Task List</h6>
                        <div class="table-responsive">
                            <table id="myTable" class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>Drag</th> --}}
                                        <th>SL</th>
                                        <th>Task Title</th>
                                        <th>Description</th>
                                        <th>Priority</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr data-id="{{ $note->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $note->title }}</td>
                                            <td>{{ $note->content }}</td>
                                            <td>
                                                @if ($note->priority == 1)
                                                    High
                                                @elseif($note->priority == 2)
                                                    Low
                                                @else
                                                    Medium
                                                @endif
                                            </td>
                                            <td>{{ $note->created_at ? $note->created_at->format('d/m/Y') : '' }}</td>

                                            <td>
                                                <a href="{{ route('note.edit', $note->id) }}" type="button"
                                                    class="btn btn-success m-2">Edit</a>
                                                <a href="{{ route('note.delete', $note->id) }}" type="button"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Are You Sure?')">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-------------------------------Chat Widget------------------------------------->
        <div id="chat-widget">
            <div id="chat-header">💬 Chat with Us</div>
            <div id="chat-body"></div>
            <div id="chat-input">
                <textarea id="chat-message" placeholder="Type your message..."></textarea>
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>

        <!-- Messenger Chat Plugin -->
        <div id="fb-root"></div>
        <div id="fb-customer-chat" class="fb-customerchat"></div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <script>

        // Drag and Drop Functionality Start
        $(function() {
            $("#myTable tbody").sortable({
                items: "tr",
                cursor: "move",
                opacity: 0.6,
                update: function(event, ui) {
                    let sortedIDs = $("#myTable tbody tr").map(function() {
                        return $(this).data('id');
                    }).get();

                    console.log("New Order IDs:", sortedIDs);

                    $.ajax({
                        url: '{{ route('note.updatePriority') }}',
                        method: 'POST',
                        data: {
                            sorted_ids: sortedIDs,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response.message);
                            location
                                .reload(); // (Optional) refresh page to see new priority
                        },
                        error: function(xhr) {
                            console.error("Error updating:", xhr.responseText);
                        }
                    });
                }
            }).disableSelection();
        });

        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [], // Disable initial sorting
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 6]
                    } // Disable sorting on the first and last columns
                ]
            });
        });

        // Drag and Drop Functionality End

        // Chat Widget Functionality Start
        document.getElementById('chat-header').addEventListener('click', function() {
            const body = document.getElementById('chat-body');
            const input = document.getElementById('chat-input');
            const isVisible = body.style.display === 'block';
            body.style.display = isVisible ? 'none' : 'block';
            input.style.display = isVisible ? 'none' : 'flex';
        });

        function sendMessage() {
            const message = document.getElementById('chat-message').value.trim();
            if (!message) return;

            // Show message in UI
            const chatBody = document.getElementById('chat-body');
            const userMsg = document.createElement('div');
            userMsg.classList.add('message', 'user');
            userMsg.textContent = 'You: ' + message;
            chatBody.appendChild(userMsg);
            chatBody.scrollTop = chatBody.scrollHeight;

            // Clear input
            document.getElementById('chat-message').value = '';

            // Send via AJAX
            fetch('/chatbot/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data.status);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const messageContainer = document.querySelector('.chat-messages');

            // Fetch and display messages every 5 seconds
            setInterval(fetchMessages, 5000);

            function fetchMessages() {
                fetch('/chatbot/messages')
                    .then(response => response.json())
                    .then(messages => {
                        messageContainer.innerHTML = ''; // Clear previous messages
                        messages.forEach(msg => {
                            const bubble = document.createElement('div');
                            bubble.classList.add('chat-bubble');

                            // Determine sender
                            if (msg.sender_id === null || msg.direction === 'incoming') {
                                bubble.classList.add('bot'); // FB/Page/Guest
                            } else {
                                bubble.classList.add('user');
                            }

                            bubble.textContent = msg.message;
                            messageContainer.appendChild(bubble);
                        });

                        messageContainer.scrollTop = messageContainer.scrollHeight;
                    })
                    .catch(error => {
                        console.error('Error fetching messages:', error);
                    });
            }

            fetchMessages(); // Initial fetch
        });

        // Chat Widget Functionality End
    </script>
@endsection

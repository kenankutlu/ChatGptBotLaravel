<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChatGPT Bot</title>
    <style>
        body {
            font-family: "Roboto", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0d1117;
            color: #c9d1d9;
        }

        .chat-container {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(145deg, #161b22, #0a0e13);
            border-radius: 15px;
            box-shadow: 5px 5px 15px #0a0e13, -5px -5px 15px #1a202c;
        }

        h2 {
            text-align: center;
            color: #58a6ff;
            text-shadow: 0 0 10px #58a6ff;
        }

        .message-box {
            width: calc(100% - 22px);
            padding: 10px;
            border: none;
            border-radius: 8px;
            background-color: #21262d;
            color: #c9d1d9;
            font-size: 16px;
            resize: none;
            outline: none;
            margin-top: 10px;
            box-shadow: inset 2px 2px 5px #161b22, inset -2px -2px 5px #2a2f36;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            color: #0d1117;
            background: linear-gradient(145deg, #58a6ff, #1f6feb);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 2px 2px 5px #161b22, -2px -2px 5px #1a202c;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 3px 3px 7px #0a0e13, -3px -3px 7px #2a2f36;
        }

        .chat-log {
            margin-top: 20px;
            padding: 15px;
            background: #161b22;
            border-radius: 15px;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: inset 2px 2px 5px #0a0e13, inset -2px -2px 5px #2a2f36;
        }

        .user-message,
        .bot-response {
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
        }

        .user-message {
            background: linear-gradient(145deg, #0e4429, #006d32);
            color: #c9d1d9;
            text-align: right;
            box-shadow: 2px 2px 5px #0a0e13, -2px -2px 5px #2a2f36;
        }

        .bot-response {
            background: linear-gradient(145deg, #1c1f26, #21262d);
            color: #58a6ff;
            text-align: left;
            box-shadow: 2px 2px 5px #0a0e13, -2px -2px 5px #2a2f36;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #21262d;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #58a6ff;
        }

        ::placeholder {
            color: #8b949e;
        }
    </style>
</head>

<body>

    <div class="chat-container">
        <h2>ChatGPT Bot</h2>
        <textarea id="userMessage" class="message-box" placeholder="Mesajınızı buraya yazın..."></textarea>
        <button onclick="sendMessage()">Gönder</button>

        <div id="chatLog" class="chat-log">
            <!-- Mesaj geçmişi burada görünecek -->
        </div>
    </div>

    <script>
        async function sendMessage() {
            const message = document.getElementById('userMessage').value;
            if (!message) return;

            const chatLog = document.getElementById('chatLog');
            chatLog.innerHTML += `<div class="user-message">${message}</div>`;

            const response = await fetch('/ask-chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    message
                }),
            });

            const data = await response.json();

            if (data.error) {
                chatLog.innerHTML += `<div class="bot-response">Error: Bot molada... </div>`;
            } else {
                chatLog.innerHTML += `<div class="bot-response">${data.response}</div>`;
            }

            document.getElementById('userMessage').value = '';
            chatLog.scrollTop = chatLog.scrollHeight;
        }
    </script>

</body>

</html>

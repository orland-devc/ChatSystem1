<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSU ChatBot</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1f1f1f;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 600px;
            background-color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .botImage {
            width: 100px;
            height: auto;
        }

        .chat-messages {
            max-height: 300px;
            overflow-y: auto;
        }

        #user-input {
            border: none;
            background-color: #444;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            width: calc(100% - 20px);
            margin-top: 10px;
            font-size: 16px;
        }

        #user-input:focus {
            outline: none;
        }

        #user-input::placeholder {
            color: #aaa;
        }

        #user-input:focus::placeholder {
            color: #888;
        }

        #chat-messages {
            overflow-y: auto;
            margin-top: 10px;
        }

        .chat-bubble {
            background-color: #555;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            max-width: 70%;
        }

        .user-bubble {
            background-color: #007bff;
        }
    </style>

<style>
    #chat-container {
        margin: 0 auto;
        padding: 20px 50px;
        border: 1px solid #37474f;
        border-radius: 5px;
        background-color: #444444;
        overflow-y: auto; 
        font-size: 15px;
    }
    
    #chat-container::-webkit-scrollbar {
        width: 5px;
    }
    #chat-container::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, .3);
        border-radius: 15px;
    }
    #chat-messages {
        margin-bottom: 10px;
        width: 100%;
    }
    
    #user-input {
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #37474f;
        border-radius: 5px;
        font-size: 15px;
    }
    
    .chatImage {
        border-radius: 15px;
        height: 20px;
        margin-right: 10px;
        margin-left: -30px;
        margin-bottom: -20px;
        pointer-events: none;
        user-select: none;
    }
    .botImage {
        transition: height 0.3s ease;
        height: 250px;
        pointer-events: none;
        user-select: none;
        animation: botDown 0.3s ease-in-out;
    }
    
    @keyframes typing {
        from {
            width: 0;
        }
    }
    .typing-animation {
        animation: typing 1s steps(40, end);
    }
    
    @keyframes botUp {
        0% {
            height: 250px;
        } 
        100% {
            height: 50px;
        }
    }
    @keyframes botDown {
        100% {
            height: 250px;
        } 
        0% {
            height: 50px;
        }
    }
</style>

</head>

<body>
    <div class="container">
        <div id="chat-container">
            <div class="bida">
                <center>
                    <img src="bot.png" class="botImage mb-5" alt="" id="botImage">
                    <div id="disappear">
                        <h1 style="color: #37474f; user-select: none; margin-bottom: 10px;">The First PSU ChatBot</h1>
                        <p style="margin-top: -10px; color: #607d8b; user-select: none;">Made possible by one of a kind students in <br>Pangasinan State University San Carlos City Campus</p>
                    </div>
                </center>
            </div>
            <div id="chat-messages" class="p-5 chat-messages">
                <!-- Chat messages will appear here -->
            </div>
        </div>
        <input type="text" id="user-input" class="w-full mt-3" placeholder="Type your message..." autofocus>
    </div>
</body>

</html>
<script src="{{ asset('js/queryProcessor.js') }}"></script>

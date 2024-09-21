@section('title', 'PSU Chatbot')
<x-users-layout>
    <x-slot name="header" class="bg-yellow-900">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PSU Chatbot') }} <ion-icon name="logo-reddit"></ion-icon>
        </h2>
    </x-slot>

    <div class="pt-3">
        <div class="container mx-auto">
            <div class="flex justify-center">
                <div class="w-full md:w-2/3 lg:w-1/2 bg-white rounded-lg p-6">
                    <div id="chat-container" style="height: 80vh;">
                        <div class="bida">
                            <center>
                                <img src="{{ asset('images/bot.png') }}" class="botImage mb-5" alt="" id="botImage">
                                <div id="disappear">
                                    <h1 style="color: #37474f; user-select: none; margin-bottom: 10px;">The First PSU ChatBot</h1>
                                    <p style="margin-top: -10px; color: #607d8b; user-select: none;">Made possible by one of a kind students in <br>Pangasinan State University San Carlos City Campus</p>
                                </div>
                            </center>
                        </div>
                        <div id="chat-messages" class="p-5" style="max-height: 70vh;"></div>
                    </div>
                    <input type="text" id="user-input" class="w-full mt-3" placeholder="Type your message..." autofocus>
                </div>
            </div>
        </div>
    </div>

    <div id="createTicketBG" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center hidden"></div>

    
<div id="createTicket" class="fixed bottom-10 right-10 create-ticket hidden blink" style="z-index: 999">
    <div class="opacity-80 hover:opacity-100 transition-opacity duration-300">
        <a href="#" onclick="showPostTab()" class="text-white">
            <div class="bg-blue-600 hover:bg-blue-500 shadow-md rounded-lg p-6 flex flex-col justify-center items-center">
                {{-- <i class="fas fa-ticket-alt fa-3x mb-2 my-auto"></i> --}}
                <ion-icon name="ticket" class="text-4xl text-white mb-3"></ion-icon>
                <p class="text-sm font-semibold">Create Ticket</p>
            </div>
        </a>
    </div>
</div>

<div id="" class="hidden">
    <div class="fixed top-72 right-20 ">
        <a href="#">
            <div class="flex flex-col justify-center items-center hover:opacity-0">
                <a href="#" class="bg-red-400 rounded-full px-4 text-xl text-white">&times;</a>
                <img src="{{ asset('images/haha.jpg') }}" width="200" alt="" class="blink" style="z-index: -100">
                <p class="text-sm font-semibold">HAHAHAHHA TANGINA MOO!</p>
            </div>
        </a>
    </div>
    
    <style>
        @keyframes blink {
            0% { scale: 1; }
            50% { scale: 1.1; } 
            100% { scale: 1; }
        }

        @keyframes appears {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .appears {
            animation: appears 0.3s ease-in-out;
        }

        .blink {
            animation: blink 1s infinite;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
            20%, 40%, 60%, 80% { transform: rotate(10deg); }
            100% { transform: translateX(0); }
        }

        .shake {
        animation: shake 0.5s infinite;
        }

    </style>
</div>

<!-- Add Ticket Modal -->
<div id="postTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
    <div id="postForm" class="max-w-full mx-auto sm:px-6 lg:px-8" style="width: 800px">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-6 text-gray-900 max-h-[80vh] overflow-y-auto scrollBars">
                <h1 class="text-2xl font-semibold text-gray-700 mb-4">Create New Ticket</h1>
                <a href="#" onclick="hidePostTab()" class="text-5xl hover:text-red-500 px-4 py-0 absolute" style="transform:  translate(1150%, -130%); border-radius: 0 8px 0 0">&times;</a>
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <input type="text" name="sender_id" value="{{ Auth::user()->id }}" hidden>

                        <div>
                            <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="shadow appearance-none border rounded-lg w-full py-4 px-6 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" required>
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
                            <div class="relative">
                                <select id="ticketCategory" name="category" class="shadow appearance-none border rounded-lg w-full py-4 px-6 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" required>
                                    <option value="">Select Category</option>
                                    <option value="Admissions">Admissions</option>
                                    <option value="Academic Affairs">Academic Affairs</option>
                                    <option value="Financial Aid">Financial Aid</option>
                                    <option value="Scholarships">Scholarships</option>
                                    <option value="IT Support">IT Support</option>
                                    <option value="Student Services">Student Services</option>
                                    <option value="Faculty/Staff Support">Faculty/Staff Support</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Feedback/Suggestions">Feedback/Suggestions</option>
                                </select>
                            </div>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-gray-700 font-semibold mb-2">Description</label>
                            <textarea id="content" name="content" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="attachments" class="block text-gray-700 font-semibold mb-2">Attachments (optional)</label>
                            <div class="flex items-center justify-center bg-gray-100 rounded-lg py-4">
                                <label for="attachments" class="flex flex-col items-center justify-center cursor-pointer">
                                    <div class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full mb-2 transition-colors duration-200 hover:bg-blue-600">
                                        <ion-icon name="attach-outline" class="text-2xl"></ion-icon>
                                    </div>
                                    <span class="text-sm text-gray-700">Click to upload files</span>
                                </label>
                                <input type="file" id="attachments" name="attachments[]" class="hidden" multiple onchange="previewFiles(this.files)" accept="image/*">
                            </div>
                            <div id="filePreview" class="mt-4"></div>
                            @error('attachments')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  

</x-users-layout>

<script src="{{ asset('js/queryProcessor.js') }}"></script>
<script>
        function showPostTab() {
        const postTab = document.getElementById('postTab');
        const postForm = document.getElementById('postForm');
        const createTicket = document.getElementById('createTicket');
        const createTicketBG = document.getElementById('createTicketBG');

        createTicketBG.classList.add('hidden');
        createTicket.classList.remove('blink');
        postTab.style.display = 'flex';
        postTab.classList.add('animated-show');
        postForm.classList.add('animated-pulse');
    }

    function hidePostTab() {
        const postTab = document.getElementById('postTab');
        const postForm = document.getElementById('postForm');
        postTab.classList.add('animated-vanish');
        postForm.classList.add('animated-close');

        setTimeout(() => {
            postTab.style.display = 'none';
            postTab.classList.remove('animated-pulse');
            postForm.classList.remove('animated-close');
            postTab.classList.remove('animated-vanish');
        }, 300);
    }

    document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hidePostTab();
            }
        });
</script>

<script>
    let selectedFiles = [];

    function previewFiles(files) {
        const filePreview = document.getElementById('filePreview');
        filePreview.innerHTML = '';

        selectedFiles = [...selectedFiles, ...files];

        if (selectedFiles.length === 0) {
            return;
        }

        selectedFiles.forEach((file) => {
            const reader = new FileReader();

            reader.addEventListener('load', () => {
                const imgPreview = document.createElement('div');
                imgPreview.classList.add('m-2', 'relative', 'inline-block');

                const img = document.createElement('img');
                img.src = reader.result;
                img.classList.add('max-h-32', 'object-contain', 'rounded-lg', 'border', 'border-blue-800');

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('transform', 'translate-x-2', '-translate-y-2', 'absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'focus:outline-none', 'hover:bg-red-600', 'transition-colors', 'duration-200');
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', () => {
                    imgPreview.remove();
                    selectedFiles = selectedFiles.filter(f => f !== file);
                });

                imgPreview.appendChild(img);
                imgPreview.appendChild(removeBtn);
                filePreview.appendChild(imgPreview);
            });

            reader.readAsDataURL(file);
        });
    }

</script>

<style>
    #chat-container {
        margin: 0 auto;
        padding: 20px 50px;
        border: 1px solid #37474f;
        border-radius: 5px;
        background-color: #f9f9f9;
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

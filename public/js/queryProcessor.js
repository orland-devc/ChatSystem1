let previousQueries = new Set();

function processQuery(query) {
    const lowerCaseQuery = query.toLowerCase();

    const responses = [
        { pattern: /hello|hi|good morning|hey/, response: "Hi there! How can I help you today?<br><br>" },
        { pattern: /how are you|doing|going|kamusta/, response: "I'm doing great! How can I help you today?<br><br>" },
        { pattern: /weather/, response: "The weather today is sunny." },
        { pattern: /haha/, response: "I'm glad that it made you laugh. If you need something else, feel free to ask!<br><br>" },
        { pattern: /joke/, response: "Why don't scientists trust atoms? Because they make up everything!<br><br>" },
        { pattern: /president/, response: "The president of the United States is currently Joe Biden.<br><br>" },
        { pattern: /2 \+ 2/, response: "2 + 2 equals 4.<br><br>" },
        { pattern: /thank/, response: "You're welcome! If you have any other questions or need assistance, please let me know.<br><br>" },
        { pattern: /great/, response: "That's awesome to hear! Is there anything specific you're excited about or want to talk about?<br><br>" },
        { pattern: /psu.*mission|their.*mission|mission.*psu/, response: 'Sure! Here\'s the Pangasinan State University\'s latest mission:<br><br>"The Pangasinan State University, shall provide a human-centric, resilient, and sustainable academic environment to produce dynamic, responsive, and future-ready individuals capable of meeting the requirements of the local and global communities and industries."<br><br>' },
        { pattern: /psu.*vision|their.*vision|vision.*psu/, response: 'Sure! Here\'s the Pangasinan State University\'s latest vision:<br><br>"To be a leading industry-driven State University in the ASEAN region by 2030."<br><br>' },
        { pattern: /psu.*vmgo|vmgo.*psu/, response: 'Here\'s the PSU\'s updated VMGO:<br><br><b>Vision</b><br>"To be a leading industry-driven State University in the ASEAN region by 2030"<br><br><b>Mission</b><br>"The Pangasinan State University, shall provide a human-centric, resilient, and sustainable academic environment to produce dynamic, responsive, and future-ready individuals capable of meeting the requirements of the local and global communities and industries."<br><br><b>Strategic Goals</b><br><b>• SG 1</b>: Industry-Focused and Innovation-Based Student Learning and Development <br><b>• SG 2</b>: Responsive and Sustainable Research, Community Extension, and Innovative Program <br><b>• SG 3</b>: Effective and Efficient Governance and Financial Management <br><b>• SG 4</b>: High-Performing and Engaged Human Resource <br><b>• SG 5</b>: Strategic and Functional Internationalization Program<br><br>This is the current VMGO of Pangasinan State University. If you have more concerns, feel free to ask.🥰🤖<br><br>' },
        { pattern: /good day/, response: "Good day to you as well!<br><br>" },
        { pattern: /good evening/, response: "Good evening! I hope you're having a great night so far.<br><br>" },
        { pattern: /good night/, response: "Good night! Sleep well and have pleasant dreams.<br><br>" },
        { pattern: /how are you/, response: "As an AI assistant, I don't have feelings, but I'm operating properly and ready to assist you with any questions or tasks you may have.<br><br>" },
        { pattern: /what can you do/, response: "As a campus AI assistant, I'm here to assist you with various tasks and provide information related to campus life. This includes helping you find information about admissions, academic programs, financial aid, campus events, student services, housing options, library resources, and more. If you have any specific questions or need assistance with anything related to campus activities or services, feel free to ask!<br><br>" },
        { pattern: /tell me a story/, response: "Once upon a time, in a faraway land, there lived a brave knight who embarked on a quest to slay a fearsome dragon. After many trials and tribulations, the knight finally encountered the dragon in its lair. With sword in hand and determination in his heart, the knight engaged the dragon in a fierce battle. After a long and arduous fight, the knight emerged victorious, slaying the dragon and freeing the land from its terror. The knight's bravery and perseverance became the stuff of legends, inspiring generations to come.<br><br>" },
        { pattern: /admission|admissions/, response: "Admissions for the upcoming academic year began on March 11, 2024, and will continue until September 15, 2024. To apply, please visit our university's official website and navigate to the admissions section. There, you'll find the application form, along with detailed instructions on the admission process, required documents, and deadlines. <br><br>Here are some tips to enhance your application:<br><br>1. Start the application process early to ensure you have enough time to gather all necessary documents and complete the required steps.<br><br>2. Double-check your application form for accuracy and completeness before submission.<br><br>3. Pay attention to admission deadlines and submit your application well before the deadline to avoid any last-minute issues.<br><br>4. Take advantage of any available resources, such as informational sessions, campus tours, or guidance from admissions counselors, to learn more about our university and make informed decisions.<br><br>5. Prepare for any required entrance exams or interviews in advance, and showcase your strengths and accomplishments during the process.<br><br>" },
        { pattern: /music|song/, response: "I can't play music, but I can help you with information about music-related events on campus or resources available for music students. How can I assist you further?<br><br><br>" },
        { pattern: /financial aid|scholarship|grant|loan|work-study/, response: "Our university offers various financial aid options, including scholarships, grants, loans, and work-study programs. For detailed information about financial aid opportunities and how to apply, please visit our financial aid office or check our university's official website.<br><br>" },
        { pattern: /academic programs|courses|majors/, response: "We offer a wide range of academic programs across various disciplines, including arts, sciences, engineering, business, and more. You can explore our full list of academic programs on our university's official website or contact the academic affairs office for more information.<br><br>" },
        { pattern: /campus life|clubs|organizations|events|sports|activities/, response: "Our university provides a vibrant campus life with numerous opportunities for student engagement, including clubs, organizations, cultural events, sports teams, and recreational activities. To learn more about campus life and available resources, please visit our student affairs office or check our university's official website.<br><br>" },
        { pattern: /housing|dormitory|apartment|residence/, response: "Information about on-campus housing options, including dormitories, apartments, and residence halls, can be found on our university's official website. You can also contact the housing office for assistance with housing applications, room assignments, and related inquiries.<br><br>" },
        { pattern: /student services|counseling|career services|advising|disability support|wellness|library|resources/, response: "Our university offers a variety of student services to support your academic and personal success, including counseling and wellness programs, career services, academic advising, disability support services, and more. For information about available student services and how to access them, please visit our student services center or check our university's official website.<br><br>" },
        { pattern: /library|books|journals|databases|research/, response: "Our university library provides access to a vast collection of resources, including books, journals, databases, and multimedia materials to support your academic research and learning needs. You can visit the library in person or explore online resources through our library website. Additionally, librarians are available to assist you with research inquiries and accessing library resources.<br><br>" },
        { pattern: /music|song/, response: "I can't play music, but I can help you with information about music-related events on campus or resources available for music students. How can I assist you further?<br><br>" },










    ];

    // Check if the query has been asked before
    if (previousQueries.has(lowerCaseQuery)) {
        return "Sorry, I've already provided a response to that question. Can I assist you with anything else?";
    }

    for (const { pattern, response } of responses) {
        if (pattern.test(lowerCaseQuery)) {
            // Store the query for future reference
            previousQueries.add(lowerCaseQuery);
            return response;
        }
    }

    if (query.toLowerCase().includes("create ticket")) {
        var createTicket = document.getElementById("createTicket");
        var createTicketBG = document.getElementById("createTicketBG");
        if (createTicket) {
            createTicket.classList.add('appears');
            createTicket.classList.add('hidden');
        }
    } else {
        var createTicket = document.getElementById("createTicket");
        if (createTicket) {
            createTicket.classList.remove('hidden');
        }
    }
    
    
    return "I'm sorry, I didn't understand that. Can you please rephrase? Or consider submitting a ticket for your unique concern. Kindly hit the \"Create Ticket\" on the bottom right!🥰🤖<br><br>";
}


let isTyping = false;

async function handleUserInput() {
    if (isTyping) return; 
    isTyping = true; 

    const userInput = document.getElementById("user-input").value.trim();
    if (userInput === "") {
        isTyping = false;
        return;
    }

    var botImages = document.getElementsByClassName("botImage");
    var botText = document.getElementById("disappear");
    for (var i = 0; i < botImages.length; i++) {
        var botImage = botImages[i];
        if (botImage.style.height !== "50px") {
            botImage.style.animation = "botUp 0.3s ease-out forwards";
            botImage.style.height = "50px";
            botText.style.display = "none";
        }
    }

    const chatMessages = document.getElementById("chat-messages");

    const userMessage = document.createElement("div");
    userMessage.classList.add('user-message');
    userMessage.innerHTML = "<b class='user-message'><img src='images/uploads/1b1.jpg' class='chatImage' alt=''>You</b><br>" + userInput + "<br><br>";
    document.getElementById("user-input").value = "";
    chatMessages.appendChild(userMessage);

    await sleep(1000);

    const response = processQuery(userInput);
    const botMessage = document.createElement("div");
    botMessage.classList.add('bot-message');
    botMessage.innerHTML = '<b><img src="images/PSU logo.png" class="chatImage" alt="">PSU Chatbot</b><br>';
    chatMessages.appendChild(botMessage);

    await typeWriter(response, botMessage);
    isTyping = false; 

    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function typeWriter(text, element) {
    let index = 0;
    let insideTag = false;
    let currentTag = "";

    while (index < text.length) {
        if (text[index] === '<') {
            insideTag = true;
            currentTag = "";
        }

        if (insideTag) {
            currentTag += text[index];
        } else {
            element.innerHTML += text[index];
        }

        if (text[index] === '>') {
            insideTag = false;
            // Check if it's a recognized HTML tag, then append it
            if (currentTag.startsWith("<b>") && currentTag.endsWith("</b>")) {
                element.innerHTML += "<b>";
                await sleep(5);
            } else if (currentTag.startsWith("</b>") && currentTag.endsWith("</b>")) {
                element.innerHTML += "</b>";
                await sleep(5);
            } else {
                element.innerHTML += currentTag;
            }
            currentTag = "";
        }

        index++;
        await sleep(5);

        element.scrollTop = element.scrollHeight;
    }
}


document.getElementById("user-input").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        handleUserInput();
    }
});

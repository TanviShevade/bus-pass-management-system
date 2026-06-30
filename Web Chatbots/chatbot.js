const botResponses = {
  "Hi there! How can I assist you today?": ["hello", "hi", "hey"],
  "I'm just a bot, but thanks for asking! How can I help?": ["how are you", "how are things", "how's it going"],
  "Goodbye! Have a nice day!": ["bye", "goodbye", "see you"],
  "I'm your friendly chatbot, here to help with bus pass inquiries!": ["what is your name", "who are you"],

  // Bus Pass Related Queries
  "You can apply for a bus pass by visiting our 'Apply for Pass' section on the website. Just fill in the required details and submit.": ["apply for pass", "get a bus pass", "new pass"],
  "To check your bus pass status, go to the 'Track Pass Status' section and enter your application number.": ["track pass", "check pass status", "status of my pass"],
  "Bus passes are usually approved within 2-3 working days. If it’s taking longer, please contact our support team.": ["how long does it take", "pass approval time"],
  "You can renew your bus pass from the 'Renew Pass' section on our website before the expiry date.": ["renew pass", "extend pass", "renew my pass"],
  "If your bus pass was rejected, check the reason in your account dashboard. You may need to reapply with correct details.": ["why was my pass rejected", "pass rejected", "reapply pass"],

  // Payment & Fees
  "We accept online payments through UPI, credit/debit cards, and net banking. Cash payments are not accepted.": ["payment methods", "how to pay", "bus pass payment"],


  // General Queries
  "You can contact our support team through the 'Contact Us' page or call our helpline number.": ["customer support", "contact support", "need help"],
  "Bus passes are valid for different durations (monthly, quarterly, yearly). Check the details in the 'Pass Duration' section.": ["pass validity", "pass duration", "how long is pass valid"],
  "Yes, students can apply for a discounted pass by providing a valid student ID during the application.": ["student discount", "student pass", "discounted pass"],
  "Lost your bus pass? You can request a duplicate pass from the 'Lost Pass' section on our website.": ["lost pass", "stolen pass", "need new pass"],

  // Default Response
  "I'm sorry, I don't understand that. Can you please ask something else?": ["default"]
};

function sendMessage() {
  let userInput = document.getElementById("userInput").value.toLowerCase().trim();
  if (userInput === "") return;  // Skip if input is empty

  displayMessage(userInput, "user");
  getBotResponse(userInput);

  document.getElementById("userInput").value = "";  // Clear input field
}

function displayMessage(message, sender) {
  const chatLog = document.getElementById("chatlog");
  const newMessage = document.createElement("div");
  newMessage.classList.add("message");
  newMessage.classList.add(sender === "user" ? "user-message" : "bot-message");
  newMessage.textContent = message;
  chatLog.appendChild(newMessage);
  chatLog.scrollTop = chatLog.scrollHeight;  // Scroll to the latest message
}

function getBotResponse(userMessage) {
  let botReply = "I'm sorry, I don't understand that. Can you please ask something else?";  // Default response

  // Loop through each bot response
  for (const [response, keywords] of Object.entries(botResponses)) {
    for (const keyword of keywords) {
      if (userMessage.includes(keyword)) {  // Check if userMessage contains any of the keywords
        botReply = response;
        break;  // Break once a match is found
      }
    }
  }

  displayMessage(botReply, "bot");
}

document.addEventListener("DOMContentLoaded", function () {
    const chatIcon = document.getElementById("chatIcon");
    const chatContainer = document.getElementById("chatContainer");
    const closeButton = document.querySelector(".close-btn");

    if (chatIcon) {
        chatIcon.addEventListener("click", function () {
            chatContainer.style.display = (chatContainer.style.display === "block") ? "none" : "block";
        });
    }

    if (closeButton) {
        closeButton.addEventListener("click", function () {
            chatContainer.style.display = "none";
        });
    }
});


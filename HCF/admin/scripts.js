// Variable to hold the utterance
let utterance;

// Function to activate text-to-speech
document.getElementById('activateSpeech').addEventListener('click', function() {
    // Add event listener to all elements
    document.querySelectorAll('*').forEach(item => {
        item.addEventListener('mouseover', function(event) {
            // Speak the text content of the hovered element
            speak(event.target.textContent);
        });
    });
});

// Function to stop text-to-speech
document.getElementById('stopSpeech').addEventListener('click', function() {
    if (utterance) {
        // Cancel the current utterance if it exists
        window.speechSynthesis.cancel();
    }
});

// Function to speak the given text
function speak(text) {
    // Create a new utterance
    utterance = new SpeechSynthesisUtterance(text);
    // Speak the text
    speechSynthesis.speak(utterance);
}

// Function to pause text-to-speech
function pauseSpeech() {
    // Pause the speech
    speechSynthesis.pause();
}

// Function to resume text-to-speech
function resumeSpeech() {
    // Resume the speech
    speechSynthesis.resume();
}

// Function to stop text-to-speech
function stopSpeech() {
    // Cancel the speech
    speechSynthesis.cancel();
}

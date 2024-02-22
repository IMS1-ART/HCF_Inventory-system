let currentMode = 0; // Current color scheme mode
const modes = ['light-mode', 'dark-mode', 'blue-mode', 'dyslexic-mode']; // Define color scheme modes

let currentFont = 0; // Current font style index
const fonts = ['Arial', 'Verdana', 'Open Dyslexic']; // Dyslexia-friendly font styles

function toggleColorScheme() {
    const previewDiv = document.getElementById('color-preview');
    currentMode = (currentMode + 1) % modes.length; // Cycle through modes
    const mode = modes[currentMode]; // Get the current mode
    document.body.className = mode; // Apply the new mode to the body
    previewDiv.textContent = mode; // Display the mode name as a preview
}

function toggleFontStyle() {
    const previewDiv = document.getElementById('font-preview');
    currentFont = (currentFont + 1) % fonts.length; // Cycle through font styles
    const font = fonts[currentFont]; // Get the current font style
    document.body.style.fontFamily = font; // Apply the new font style to the body
    previewDiv.textContent = font; // Display the font style name as a preview
}

function toggleSettings() {
    var settingsContent = document.getElementById("settingsContent");
    settingsContent.classList.toggle("show");
}
function changeLanguage() {
    const languageSelect = document.getElementById('language-select');
    const selectedLanguage = languageSelect.value;
    // Perform actions based on selected language
    if (selectedLanguage === 'fr') {
        translateToFrench();
    } else {
        translateToEnglish();
    }
}

function translateToFrench() {
    // Translate UI elements to French
    document.querySelector('.navbar-brand').textContent = 'Votre Site Web';
    document.querySelector('label[for="language-select"]').textContent = 'Langue :';
    document.querySelector('option[value="en"]').textContent = 'Anglais';
    document.querySelector('option[value="fr"]').textContent = 'Français';
}

function translateToEnglish() {
    // Translate UI elements to English
    document.querySelector('.navbar-brand').textContent = 'Your Website';
    document.querySelector('label[for="language-select"]').textContent = 'Language:';
    document.querySelector('option[value="en"]').textContent = 'English';
    document.querySelector('option[value="fr"]').textContent = 'French';
}

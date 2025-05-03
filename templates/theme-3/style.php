<style>
:root {
    --primary-color: <?php echo $vendor["websiteColor"] ?>;
    --primary-color-light: <?php echo $vendor["websiteColor"] . "33" ?>; /* 20% opacity */
    --primary-color-dark: <?php echo $vendor["websiteColor"] ?>; /* darker shade of primary */
    --text-color: #333;
    --text-color-light: #666;
    --bg-color: #ffffff;
    --card-bg: #ffffff;
    --border-color: #e1e1e1;
    --shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 32px rgba(0, 0, 0, 0.12);
    --border-radius: 12px;
    --transition: all 0.3s ease;
    --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

@media (prefers-color-scheme: dark) {
    :root.dark-mode-support {
        --text-color: #f0f0f0;
        --text-color-light: #b0b0b0;
        --bg-color: #121212;
        --card-bg: #1e1e1e;
        --border-color: #2d2d2d;
        --shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
    }
}

body {
    margin: 0;
    color: var(--text-color);
    font-weight: 500;
    font-family: var(--font-family);
    background-color: var(--bg-color);
    transition: var(--transition);
}

/* Scrollbar styling */
::-webkit-scrollbar {
    width: 8px;
    background-color: var(--bg-color);
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background-color: var(--primary-color);
}

/* Layout styling */
#leftSide {
    height: 100vh;
    overflow-y: auto;
    scroll-behavior: smooth;
    position: relative;
    padding: 0;
}

#rightSide {
    height: 100vh;
    overflow-y: hidden;
    position: relative;
}

.logo {
    display: block;
    margin: 0 auto;
    width: 150px;
    height: 150px;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.logo:hover {
    transform: scale(1.05);
}

.logoBg {
    background-color: var(--card-bg);
    width: 250px;
    height: 250px;
    position: absolute;
    top: 15%;
    left: 50%;
    transform: translate(-50%, 50%);
    border-radius: 50%;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.bgOver {
    background-color: rgba(0, 0, 0, 0.6);
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    backdrop-filter: blur(2px);
}

.poweredByRight {
    position: absolute;
    bottom: 25px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    border-radius: 50%;
    transition: transform 0.3s ease;
}

.poweredByRight:hover {
    transform: translateX(-50%) scale(1.1);
}

.heroLogo {
    display: block;
    margin: 0 auto;
    width: 70px;
    height: 70px;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.heroLogoBg {
    background-color: var(--card-bg);
    width: 125px;
    height: 125px;
    position: relative;
    bottom: 20px;
    left: 50%;
    border-radius: 50%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

/* Header styling */
.headerClass {
    box-sizing: border-box;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.05);
    background-color: var(--card-bg);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(8px);
}

.headerClass a {
    text-decoration: none;
    color: var(--text-color);
    position: relative;
    transition: var(--transition);
}

.headerClass a:after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--primary-color);
    transition: var(--transition);
}

.headerClass a:hover:after {
    width: 100%;
}

.headerClass a:hover {
    color: var(--primary-color);
}

/* Social media bar styling */
.socialMediaBar {
    box-sizing: border-box;
    box-shadow: var(--shadow);
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 15px;
    margin-top: 10px;
    margin-bottom: 20px;
    transition: var(--transition);
}

.socialMediaBar:hover {
    box-shadow: var(--shadow-hover);
}

.socialMediaSpan {
    border: 2px var(--primary-color) solid;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    transition: var(--transition);
}

.socialMediaSpan:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-3px);
}

/* Form elements styling */
input, select, textarea {
    margin-top: 10px;
    margin-bottom: 15px;
    border-radius: 8px !important;
    border: 1px solid var(--border-color);
    padding: 12px 15px;
    background-color: var(--card-bg);
    color: var(--text-color);
    transition: var(--transition);
    box-shadow: none;
}

input:focus, select:focus, textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-color-light);
    outline: none;
}

label {
    margin-bottom: 8px;
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-color-light);
}

button, .btn {
    border-radius: 8px !important;
    padding: 12px 20px;
    font-weight: 600;
    transition: var(--transition);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn {
    background-color: var(--primary-color);
    border: 1px solid var(--primary-color);
    position: relative;
    overflow: hidden;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    background-color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.btn:active {
    transform: translateY(0);
}

.btnPrice {
    font-size: 12px;
    font-weight: 700;
    background-color: white;
    padding: 8px 12px;
    border-radius: 6px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
}

/* Service blocks styling */
.serviceBLk {
    border: 2px solid var(--primary-color);
    border-radius: 12px !important;
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    cursor: pointer;
    height: 100%;
}

.serviceBLk:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.activeService {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}

/* Success/Failure sections */
.successBody {
    box-sizing: border-box;
    box-shadow: var(--shadow);
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    padding: 10px;
    margin-top: 15px;
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.successInfoSection {
    border: 2px solid var(--primary-color);
    border-radius: var(--border-radius);
    color: var(--text-color);
    margin-bottom: 10px;
    transition: var(--transition);
    background-color: rgba(255, 255, 255, 0.02);
    overflow: hidden;
}

.successInfoSection:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-3px);
}

/* Background sections */
.rightBg {
    background-image: url("logos/<?php echo $vendor["coverImg"] ?>");
    background-size: cover;
    background-position: center;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    transition: transform 20s ease;
    transform-origin: center;
    animation: subtleZoom 20s infinite alternate ease-in-out;
}

@keyframes subtleZoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.1); }
}

.heroBg {
    box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.5);
    background-image: url("logos/<?php echo $vendor["coverImg"] ?>");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 250px;
    position: relative;
    border-radius: 0 0 30px 30px;
    overflow: hidden;
}

/* Loading screen */
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 1000;
    display: none;
    backdrop-filter: blur(5px);
}

#loading-screen img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
    filter: drop-shadow(0 0 8px rgba(0,0,0,0.1));
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

/* Mobile styling */
.poweredMobile {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    transition: transform 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.poweredMobile:hover {
    transform: scale(1.1);
}

/* Calendar picker styling */
.flatpickr-calendar {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
    border: none;
}

.flatpickr-day.selected {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.flatpickr-day.selected:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .heroLogoBg {
        left: 50%;
    }
    
    .successInfoSection {
        padding: 10px;
    }
    
    .heroBg {
        height: 200px;
    }
    
    .logo {
        width: 100px;
        height: 100px;
    }
    
    input, select, textarea {
        font-size: 16px; /* Prevents zoom on mobile */
    }
}

/* Animation for page elements */
.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.animate-slide-up {
    animation: slideUp 0.6s ease-out forwards;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Theme images styling */
.themeInput {
    cursor: pointer;
    border-radius: 12px;
    transition: var(--transition);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    object-fit: cover;
}

.themeInput:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Form group styling */
.form-group {
    margin-bottom: 20px;
    position: relative;
}

.form-check-input {
    margin-right: 8px;
}

/* Modal styling */
.modal-content {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: var(--shadow);
}

.modal-header {
    border-bottom: 1px solid var(--border-color);
    padding: 15px 20px;
}

.modal-body {
    padding: 20px;
}

/* For terms and conditions links */
abbr {
    text-decoration: none;
    border-bottom: 1px dotted var(--primary-color);
    cursor: help;
}

/* Extra info section improvements */
div[id^="priceValue"] {
    font-weight: 700;
}

hr {
    margin: 10px 0;
    border-color: var(--border-color);
    opacity: 0.5;
}

/* QR code styling */
.text-center img[src^="https://api.qrserver.com"] {
    border-radius: 12px;
    box-shadow: var(--shadow);
    padding: 10px;
    background-color: white;
    transition: var(--transition);
}

.text-center img[src^="https://api.qrserver.com"]:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-hover);
}
</style>

<!-- Import Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Import Animation Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Import FontAwesome for better icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
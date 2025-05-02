<style>
/* === Modern Redesign - CSS Variables === */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root {
    /* Light Theme Palette - Using Vendor Color */
    --primary-color: <?php echo $vendor["websiteColor"] ?? '#007bff'; ?>; /* Use vendor color or default blue */
    --secondary-color: #6c757d; /* Gray */
    --accent-color: <?php echo $vendor["websiteColor"] && isValidColor($vendor["websiteColor"]) ? darken($vendor["websiteColor"], -20) : '#17a2b8'; ?>; /* Lighter shade of primary or Teal */
    --success-color: #28a745; /* Green */
    --danger-color: #dc3545; /* Red */
    --warning-color: #ffc107; /* Yellow */
    --info-color: #17a2b8; /* Teal */

    --bg-color: #ffffff;
    --bg-alt-color: #f8f9fa;
    --text-color: #212529;
    --text-muted-color: #6c757d;
    --border-color: #dee2e6;
    --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --card-hover-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    --border-radius: 0.5rem;
    --transition-speed: 0.3s;

    /* Typography */
    --font-family-base: 'Poppins', sans-serif;
    --font-size-base: 1rem; /* 16px */
    --line-height-base: 1.6;
    --font-weight-light: 300;
    --font-weight-normal: 400;
    --font-weight-medium: 500;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;

    /* Spacing */
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --spacing-xxl: 3rem;
}

/* === Dark Theme (using prefers-color-scheme) === */
@media (prefers-color-scheme: dark) {
    :root {
        /* Adjust primary/accent for dark mode if needed, maybe lighten */
        --primary-color: <?php echo $vendor["websiteColor"] && isValidColor($vendor["websiteColor"]) ? lighten($vendor["websiteColor"], 15) : '#3498db'; ?>;
        --secondary-color: #adb5bd;
        --accent-color: <?php echo $vendor["websiteColor"] && isValidColor($vendor["websiteColor"]) ? lighten($vendor["websiteColor"], 25) : '#20c997'; ?>;
        --success-color: #20c997;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --info-color: #3498db;

        --bg-color: #1a1a1a;
        --bg-alt-color: #2c2c2c;
        --text-color: #e9ecef;
        --text-muted-color: #adb5bd;
        --border-color: #5a6167; /* Slightly lighter border for dark mode */
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        --card-hover-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    img, video {
        opacity: 0.9;
        transition: opacity var(--transition-speed) ease-in-out;
    }
    img:hover, video:hover {
        opacity: 1;
    }

    /* Dark mode specific social icon style */
    .socialMediaSpan {
        border-color: var(--secondary-color);
        color: var(--text-color);
    }
    .socialMediaSpan:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff; /* Ensure icon is white on hover */
    }

    /* Ensure section titles use primary color in dark mode */
    #leftSide > form > .row > .col-md-12 > label,
    #leftSide > form > .row > .col-12 > span,
    #leftSide > form > .row > .col-md-6 > label {
        color: var(--primary-color);
    }

    /* Style stats section text in dark mode */
    .stats-section > div[class^="col-"] {
        color: var(--primary-color); /* Use primary color for stats numbers/text */
    }
    .stats-section > div[class^="col-"] > div {
         color: var(--text-muted-color); /* Use muted color for labels like 'Services' */
    }
}

/* === Base Styles === */
*,
*::before,
*::after {
    box-sizing: border-box;
    /* Reset margin/padding carefully if Bootstrap is used */
}

html {
    scroll-behavior: smooth;
    font-size: var(--font-size-base);
}

body {
    font-family: var(--font-family-base);
    line-height: var(--line-height-base);
    color: var(--text-color);
    background-color: var(--bg-color);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    overflow-x: hidden;
    transition: background-color var(--transition-speed) ease-in-out, color var(--transition-speed) ease-in-out;
    margin: 0; /* Ensure no default body margin */
}

/* === Typography === */
h1, h2, h3, h4, h5, h6 {
    margin-bottom: var(--spacing-md);
    font-weight: var(--font-weight-semibold);
    line-height: 1.3;
    /* color: var(--primary-color); /* Optional: Use primary color for headings */
}

h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.75rem; }
h4 { font-size: 1.5rem; }
h5 { font-size: 1.25rem; }
h6 { font-size: 1rem; }

p {
    margin-bottom: var(--spacing-md);
}

a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color var(--transition-speed) ease;
}

a:hover {
    /* color: darken(var(--primary-color), 10%); /* Needs a SASS-like function or hardcode */
    color: var(--accent-color);
    text-decoration: underline;
}

/* === Layout & Spacing (Leverage Bootstrap Grid if present) === */
/* .container, .container-fluid, .row, .col-*, etc. are likely defined by Bootstrap */

/* Add padding to sections if not handled by Bootstrap */
/* section { 
    padding-top: var(--spacing-xxl);
    padding-bottom: var(--spacing-xxl);
} */

/* === Buttons (Style Bootstrap buttons) === */
.btn {
    padding: var(--spacing-sm) var(--spacing-lg);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-medium);
    border-radius: var(--border-radius);
    transition: all var(--transition-speed) ease-in-out;
    cursor: pointer;
    user-select: none;
}

.btn-primary {
    color: #fff;
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    /* background-color: darken(var(--primary-color), 10%); */
    /* border-color: darken(var(--primary-color), 10%); */
    filter: brightness(90%);
    color: #fff;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: var(--card-hover-shadow);
}

/* Add styles for other button types (.btn-secondary, .btn-outline-primary, etc.) if needed */

/* === Forms (Style Bootstrap forms) === */
.form-group {
    margin-bottom: var(--spacing-lg);
}

.form-control {
    display: block;
    width: 100%;
    padding: var(--spacing-sm) var(--spacing-md);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-normal);
    line-height: var(--line-height-base);
    color: var(--text-color);
    background-color: var(--bg-color);
    background-clip: padding-box;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    transition: border-color var(--transition-speed) ease-in-out, box-shadow var(--transition-speed) ease-in-out;
}

.form-control:focus {
    color: var(--text-color);
    background-color: var(--bg-color);
    border-color: var(--primary-color);
    outline: 0;
    /* box-shadow: 0 0 0 0.2rem rgba(var(--primary-color), 0.25); /* Adjust focus ring if needed */
}

select.form-control {
    /* Add specific select styles if needed */
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.form-check-label {
    margin-bottom: 0; /* Align checkbox/radio labels */
}

/* === Specific Theme Elements === */

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    background-color: var(--bg-alt-color);
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background-color: var(--secondary-color);
    border: 2px solid var(--bg-alt-color);
}
::-webkit-scrollbar-thumb:hover {
    background-color: var(--primary-color);
}

/* Left & Right Side Layout */
#leftSide {
    /* height: 100vh; /* Might conflict with content flow */
    overflow-y: auto; /* Use auto instead of scroll */
    padding: var(--spacing-lg); /* Add some padding */
    background-color: var(--bg-color);
}

#rightSide {
    height: 100vh;
    overflow: hidden;
    position: relative;
    background-color: var(--bg-alt-color); /* Fallback bg */
}

.rightBg {
    background-image: url("../logos/<?php echo $vendor["coverImg"] ?? 'default-cover.jpg'; ?>");
    background-size: cover;
    background-position: center;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1;
}

.bgOver {
    background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 2;
}

/* Logo Styling */
.logoBg {
    background-color: rgba(255, 255, 255, 0.9);
    width: 200px; /* Adjusted size */
    height: 200px;
    position: absolute;
    top: 50%; /* Center vertically */
    left: 50%;
    transform: translate(-50%, -50%); /* Center horizontally/vertically */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.logo {
    display: block;
    max-width: 70%; /* Responsive logo size */
    max-height: 70%;
    height: auto;
    width: auto;
}

/* Powered By Logo */
.poweredByRight {
    position: absolute;
    bottom: var(--spacing-lg);
    left: 50%;
    transform: translateX(-50%);
    width: 40px; /* Adjusted size */
    height: 40px;
    border-radius: 50%;
    z-index: 3;
    cursor: pointer;
    opacity: 0.8;
    transition: opacity var(--transition-speed) ease;
}
.poweredByRight:hover {
    opacity: 1;
}

/* Mobile Hero Logo */
.heroLogoBg {
    background-color: var(--bg-color);
    width: 100px; /* Adjusted size */
    height: 100px;
    position: absolute; /* Position relative to heroBg */
    bottom: -50px; /* Overlap bottom edge */
    left: 50%;
    transform: translateX(-50%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid var(--bg-color);
    box-shadow: var(--card-shadow);
}

.heroLogo {
    display: block;
    max-width: 60%;
    max-height: 60%;
    height: auto;
    width: auto;
}

.heroBg {
    background-image: url("../logos/<?php echo $vendor["coverImg"] ?? 'default-cover.jpg'; ?>");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 150px; /* Adjusted height */
    position: relative;
    margin-bottom: 60px; /* Space for overlapping logo */
}
.heroBg::after { /* Overlay for mobile hero */
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4));
}

/* Header */
.headerClass {
    padding: var(--spacing-sm) var(--spacing-md);
    border-bottom: 1px solid var(--border-color);
    background-color: var(--bg-alt-color);
}
.headerClass a {
    color: var(--text-muted-color);
    font-weight: var(--font-weight-medium);
}
.headerClass a:hover {
    color: var(--primary-color);
    text-decoration: none;
}

/* Social Media Bar */
.socialMediaBar {
    background-color: var(--bg-alt-color);
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    margin-top: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}
.socialMediaBar > div[class^="col"] {
    color: var(--text-muted-color);
    font-weight: var(--font-weight-medium);
}
.socialMediaBar > div[class^="col"] div {
    font-size: 0.9em;
}

.socialIconDiv a {
    display: inline-block;
}

.socialMediaSpan {
    display: inline-flex; /* Use flex for centering */
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border: 2px solid var(--border-color);
    border-radius: 50%;
    color: var(--text-muted-color);
    transition: all var(--transition-speed) ease;
    font-size: 1rem;
}

.socialMediaSpan:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

/* Service Blocks */
.serviceBLk {
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: var(--bg-color);
    transition: all var(--transition-speed) ease;
    cursor: pointer;
    padding: var(--spacing-md) !important; /* Ensure padding */
}

.serviceBLk:hover {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: var(--card-hover-shadow);
}

.serviceBLk.activeService {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    box-shadow: var(--card-hover-shadow);
}

.serviceBLk span {
    font-weight: var(--font-weight-medium);
    display: block; /* Ensure span takes width */
    margin-bottom: var(--spacing-xs);
}
.serviceBLk label,
.serviceBLk div[id^="priceValue"] {
    font-size: 0.85em;
    color: var(--text-muted-color);
    font-weight: var(--font-weight-normal);
}
.serviceBLk:hover label,
.serviceBLk:hover div[id^="priceValue"],
.serviceBLk.activeService label,
.serviceBLk.activeService div[id^="priceValue"] {
    color: rgba(255, 255, 255, 0.8);
}

/* Selections Area (Branch, Date, Time, Extras) */
/* Target the specific spans/labels used as titles - Increased Specificity */
body #leftSide > form > .row > .col-md-12 > label,
body #leftSide > form > .row > .col-12 > span,
body #leftSide > form > .row > .col-md-6 > label {
    display: block;
    margin-bottom: var(--spacing-sm);
    font-weight: var(--font-weight-semibold);
    font-size: 1.1em;
    color: var(--primary-color);
    margin-top: var(--spacing-md); /* Add some top margin */
}

/* Extras Checkbox */
#themes-container .col-10 {
    display: flex !important;
    align-items: center;
}
#themes-container input[type="checkbox"] {
    margin-right: var(--spacing-sm);
}
#themes-container .price {
    font-weight: var(--font-weight-medium);
    color: var(--success-color);
}

/* Picture Types / Themes */
.typesBLK, .themesBLK {
    background-color: var(--bg-alt-color);
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
}
.themeInput {
    border: 2px solid transparent;
    border-radius: var(--border-radius);
    transition: all var(--transition-speed) ease;
    cursor: pointer;
}
.themeInput:hover {
    opacity: 0.8;
    border-color: var(--accent-color);
}
.themeInput[style*="border: 1px solid"] { /* Style for selected theme */
    border: 2px solid var(--primary-color);
    opacity: 0.7;
    box-shadow: 0 0 8px rgba(var(--primary-color), 0.5);
}

/* Info Section (Name, Mobile, Email) */
#info .form-group label {
    font-weight: var(--font-weight-medium);
}

/* Submit Button */
#submitBtn {
    background-color: var(--primary-color);
    color: white;
    padding: var(--spacing-sm) 0; /* Adjust padding */
    border-radius: var(--border-radius);
    transition: all var(--transition-speed) ease;
    cursor: pointer;
}
#submitBtn:hover {
    filter: brightness(90%);
    box-shadow: var(--card-hover-shadow);
}
#submitBtn .col-9 {
    font-weight: var(--font-weight-semibold);
    font-size: 1.1em;
}
#submitBtn .btnPrice {
    background-color: rgba(255, 255, 255, 0.9);
    color: var(--primary-color);
    font-weight: var(--font-weight-bold);
    border-radius: var(--border-radius);
    padding: var(--spacing-xs) var(--spacing-sm);
    font-size: 0.9em;
}

/* Success/Failure Body */
.successBody {
    background-color: var(--bg-alt-color);
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    padding: var(--spacing-lg) !important;
}
.successBody .col-12.text-center {
    font-size: 1.5em;
    font-weight: var(--font-weight-semibold);
    color: var(--primary-color);
    margin-bottom: var(--spacing-lg);
}

.successInfoSection {
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: var(--spacing-md) !important;
    margin-bottom: var(--spacing-md);
    background-color: var(--bg-color);
}
.successInfoSection label:first-child {
    font-weight: var(--font-weight-medium);
    color: var(--text-muted-color);
}
.successInfoSection label:last-child {
    font-weight: var(--font-weight-normal);
    color: var(--text-color);
}
.successInfoSection img {
    max-width: 75px;
    max-height: 75px;
    border-radius: var(--border-radius);
}

/* Loading Screen */
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: flex; /* Use flex to center */
    align-items: center;
    justify-content: center;
}
@media (prefers-color-scheme: dark) {
    #loading-screen {
        background-color: rgba(0, 0, 0, 0.8);
    }
}

#loading-screen img {
    width: 50px;
    height: 50px;
    animation: spin 1.5s linear infinite;
    /* Remove absolute positioning if using flex */
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Powered Mobile */
.poweredMobile {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-bottom: var(--spacing-xs);
}
.poweredMobile + label {
    font-size: 0.8em;
    color: var(--text-muted-color);
}

/* Modal */
.modal-content {
    border-radius: var(--border-radius);
    border: none;
    background-color: var(--bg-color);
}
.modal-header {
    background-color: var(--bg-alt-color);
    border-bottom: 1px solid var(--border-color);
    border-top-left-radius: var(--border-radius);
    border-top-right-radius: var(--border-radius);
}
.modal-title {
    color: var(--primary-color);
    font-weight: var(--font-weight-semibold);
}
.modal-body {
    color: var(--text-color);
}
.modal-footer {
    background-color: var(--bg-alt-color);
    border-top: 1px solid var(--border-color);
}

/* Responsive Adjustments */
@media (max-width: 767.98px) { /* Match Bootstrap's md breakpoint */
    #leftSide {
        height: auto; /* Allow content to determine height */
        overflow-y: visible;
    }
    #rightSide {
        display: none !important; /* Hide right side */
    }
    .heroBg {
        margin-bottom: 60px; /* Ensure space for logo */
    }
    .socialMediaBar .row {
        flex-wrap: wrap; /* Allow icons to wrap */
        justify-content: center;
    }
    .socialIconDiv {
        margin: var(--spacing-xs);
    }
}

</style>
<?php
// Helper functions for color manipulation (if needed, otherwise remove)
function darken($hex, $percent) {
    if (!preg_match('/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i', $hex, $rgb)) return $hex;
    $percent = max(-100, min(100, $percent));
    $factor = 1.0 + ($percent / 100.0);
    $r = round(hexdec($rgb[1]) * $factor);
    $g = round(hexdec($rgb[2]) * $factor);
    $b = round(hexdec($rgb[3]) * $factor);
    return sprintf("#%02x%02x%02x", max(0, min(255, $r)), max(0, min(255, $g)), max(0, min(255, $b)));
}

function lighten($hex, $percent) {
    return darken($hex, -$percent); // Lighten is darkening by a negative percentage
}
// Helper function to validate hex color codes
function isValidColor($color) {
    return preg_match('/^#([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/', $color);
}
?>
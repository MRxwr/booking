<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
:root {
    --primary-color: <?php echo $vendor["websiteColor"] ?? '#4f8cff'; ?>;
    --secondary-color: #6c757d;
    --accent-color: #ffb347;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --bg-color: #23272f;
    --bg-card: #2c313a;
    --bg-alt: #262a32;
    --text-color: #f8f9fa;
    --text-muted: #b0b8c1;
    --border-color: #353a42;
    --shadow: 0 4px 24px rgba(0,0,0,0.12);
    --radius: 1rem;
    --transition: 0.2s cubic-bezier(.4,0,.2,1);
}
@media (prefers-color-scheme: light) {
    :root {
        --bg-color: #f8f9fa;
        --bg-card: #fff;
        --bg-alt: #f1f3f6;
        --text-color: #23272f;
        --text-muted: #6c757d;
        --border-color: #e3e6ea;
    }
}
body {
    font-family: 'Poppins', sans-serif;
    background: var(--bg-color);
    color: var(--text-color);
    margin: 0;
    min-height: 100vh;
    transition: background 0.3s, color 0.3s;
}
.headerClass {
    background: var(--bg-alt);
    border-bottom: 1px solid var(--border-color);
    padding: 0.5rem 0;
}
.headerClass a {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
    transition: color var(--transition);
}
.headerClass a:hover {
    color: var(--accent-color);
}
.heroBg {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-color);
    min-height: 180px;
    position: relative;
}
.logoBg, .heroLogoBg {
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 16px rgba(0,0,0,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 140px;
    height: 140px;
    margin: -70px auto 1.5rem auto;
    position: relative;
    z-index: 2;
}
.logoBg img, .heroLogoBg img {
    max-width: 80%;
    max-height: 80%;
}
.stats-section, .row.py-3.m-0 {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin: 1.5rem 0 1rem 0;
    padding: 1.2rem 0 0.7rem 0;
    display: flex;
    justify-content: space-around;
    align-items: center;
}
.stats-section > div, .row.py-3.m-0 > div {
    color: var(--primary-color);
    font-size: 1.2rem;
    font-weight: 600;
    text-align: center;
    border-right: 1px solid var(--border-color);
    padding: 0 0.5rem;
}
.stats-section > div:last-child, .row.py-3.m-0 > div:last-child {
    border-right: none;
}
.stats-section > div > div, .row.py-3.m-0 > div > div {
    color: var(--text-muted);
    font-size: 0.95rem;
    font-weight: 400;
    margin-top: 0.2rem;
}
.socialMediaBar {
    background: var(--bg-alt);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 1rem 0.5rem;
    margin: 1.2rem 0 2rem 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.7rem;
}
.socialMediaSpan {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--bg-card);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-size: 1.3rem;
    margin: 0 0.2rem;
    transition: background var(--transition), color var(--transition), box-shadow var(--transition);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.socialMediaSpan:hover {
    background: var(--primary-color);
    color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
}
.card, .successBody, .form-control, .serviceBLk, .typesBLK, .themesBLK {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}
label, span {
    font-size: 1.05rem;
    font-weight: 500;
    color: var(--primary-color);
    margin-bottom: 0.3rem;
}
.form-control {
    color: var(--text-color);
    background: var(--bg-alt);
    border: 1.5px solid var(--border-color);
    padding: 0.7rem 1rem;
    font-size: 1rem;
    border-radius: 0.7rem;
    margin-bottom: 1.1rem;
    transition: border var(--transition), background var(--transition);
}
.form-control:focus {
    border: 1.5px solid var(--primary-color);
    background: var(--bg-card);
    outline: none;
}
.btn, #submitBtn {
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 0.7rem;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 0.8rem 0;
    margin-top: 0.7rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    transition: background var(--transition), box-shadow var(--transition);
}
.btn:hover, #submitBtn:hover {
    background: var(--accent-color);
    color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
}
.serviceBLk {
    border: 1.5px solid var(--border-color);
    background: var(--bg-alt);
    color: var(--text-color);
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.7rem;
    transition: border var(--transition), background var(--transition), color var(--transition);
}
.serviceBLk.activeService, .serviceBLk:hover {
    border: 1.5px solid var(--primary-color);
    background: var(--primary-color);
    color: #fff;
}
.typesBLK, .themesBLK {
    background: var(--bg-alt);
    border: 1.5px solid var(--border-color);
    margin-bottom: 1rem;
    padding: 1rem;
}
.price {
    color: var(--success-color);
    font-weight: 600;
    font-size: 0.98rem;
}
.successBody {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 2rem 1.2rem;
    margin: 1.5rem 0;
}
.successInfoSection {
    background: var(--bg-alt);
    border-radius: 0.7rem;
    border: 1px solid var(--border-color);
    margin-bottom: 0.7rem;
    padding: 0.7rem 1rem;
}
.successInfoSection label:first-child {
    color: var(--text-muted);
    font-weight: 500;
}
.successInfoSection label:last-child {
    color: var(--text-color);
    font-weight: 600;
}
.footer, .poweredMobile + label {
    color: var(--text-muted);
    font-size: 0.95rem;
    text-align: center;
    margin-top: 2rem;
}
::-webkit-scrollbar {
    width: 8px;
    background: var(--bg-alt);
}
::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 8px;
}
@media (max-width: 768px) {
    .logoBg, .heroLogoBg {
        width: 100px;
        height: 100px;
        margin: -50px auto 1rem auto;
    }
    .stats-section, .row.py-3.m-0 {
        flex-direction: column;
        gap: 0.7rem;
        padding: 0.7rem 0 0.3rem 0;
    }
    .socialMediaBar {
        gap: 0.3rem;
        padding: 0.7rem 0.2rem;
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
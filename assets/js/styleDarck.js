document.getElementById('btnModeDarck').addEventListener('click', function() {
    var link = document.querySelector('link[href*="style"]');
    if (link.href.match('style.css')) {
        link.href = 'assets/css/styleDarck.css';
    } else {
        link.href = 'assets/css/style.css';
    }
});
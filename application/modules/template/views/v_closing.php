<script>
(function() {
    var btn = document.getElementById('kt_aside_minimize_toggle');
    var aside = document.getElementById('kt_aside');
    if (!btn || !aside) return;

    // Restore state
    if (localStorage.getItem('aside_minimized') === '1') {
        document.body.classList.add('aside-minimize');
    }

    btn.addEventListener('click', function() {
        var minimized = document.body.classList.toggle('aside-minimize');
        localStorage.setItem('aside_minimized', minimized ? '1' : '0');
    });
})();
</script>
</body>
</html>

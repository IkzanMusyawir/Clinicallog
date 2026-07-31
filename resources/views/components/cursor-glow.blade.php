<script>
(function() {
    var glow = document.getElementById('cursorGlow');
    var dot = document.getElementById('cursorDot');
    if (!glow || !dot) return;

    var mouseX = -100, mouseY = -100;
    var glowX = -100, glowY = -100;
    var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    if (isTouch) return;

    var interactiveSelectors = '{{ $selectors ?? "a, button, input, textarea, select, [onclick]" }}';

    document.addEventListener('mousemove', function(e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
        dot.style.left = mouseX + 'px';
        dot.style.top = mouseY + 'px';
        if (!dot.classList.contains('active')) {
            dot.classList.add('active');
            glow.classList.add('active');
        }
    }, { passive: true });

    function animateGlow() {
        glowX += (mouseX - glowX) * 0.12;
        glowY += (mouseY - glowY) * 0.12;
        glow.style.left = glowX + 'px';
        glow.style.top = glowY + 'px';
        requestAnimationFrame(animateGlow);
    }
    animateGlow();

    document.addEventListener('mouseleave', function() {
        glow.classList.remove('active');
        dot.classList.remove('active');
    });
    document.addEventListener('mouseenter', function() {
        glow.classList.add('active');
        dot.classList.add('active');
    });

    document.addEventListener('mousedown', function() { dot.classList.add('clicking'); });
    document.addEventListener('mouseup', function() { dot.classList.remove('clicking'); });

    document.addEventListener('mouseover', function(e) {
        if (e.target.closest(interactiveSelectors)) {
            dot.classList.add('hover-interactive');
            glow.classList.add('hover-interactive');
        }
    }, { passive: true });
    document.addEventListener('mouseout', function(e) {
        if (e.target.closest(interactiveSelectors)) {
            dot.classList.remove('hover-interactive');
            glow.classList.remove('hover-interactive');
        }
    }, { passive: true });
})();
</script>

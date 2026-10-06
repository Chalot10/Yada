<script>
document.addEventListener('DOMContentLoaded', () => {
    const drawerToggle = document.getElementById('mobile-drawer-toggle');
    const drawerClose = document.getElementById('mobile-drawer-close');
    const drawerOverlay = document.getElementById('mobile-drawer-overlay');
    const drawer = document.getElementById('mobile-drawer');

    if(drawerToggle){
        drawerToggle.addEventListener('click', () => {
            drawerOverlay.classList.remove('hidden');
            drawer.classList.remove('translate-x-full');
        });
    }

    if(drawerClose){
        drawerClose.addEventListener('click', () => {
            drawer.classList.add('translate-x-full');
            setTimeout(()=> drawerOverlay.classList.add('hidden'), 300);
        });
    }

    if(drawerOverlay){
        drawerOverlay.addEventListener('click', e => {
            if(e.target === drawerOverlay){
                drawer.classList.add('translate-x-full');
                setTimeout(()=> drawerOverlay.classList.add('hidden'), 300);
            }
        });
    }
});
</script>

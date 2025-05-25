document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById('whatsappBtn');
    const tooltip = document.getElementById('whatsappTooltip');
    const closeBtn = document.getElementById('closeTooltip');
    const titleEl = document.getElementById('tooltip-title');
    const textEl = document.getElementById('tooltip-text');
    const contactBtn = document.getElementById('whatsappContactBtn');

    let tooltipShown = false;

    titleEl.textContent = wcfb_data.title;
    textEl.textContent = wcfb_data.text;

    btn.addEventListener('click', function () {
        if (!tooltipShown) {
            tooltip.classList.add('show');
            tooltipShown = true;
        } else {
            abrirWhatsApp();
        }
    });

    closeBtn.addEventListener('click', function () {
        tooltip.classList.remove('show');
        tooltipShown = true;
    });

    contactBtn.addEventListener('click', function () {
        abrirWhatsApp();
    });

    function abrirWhatsApp() {
        window.open(`https://wa.me/${wcfb_data.number}`, "_blank");
    }

    setTimeout(() => {
        if (!tooltipShown) {
            tooltip.classList.add('show');
            tooltipShown = true;
        }
    }, wcfb_data.delay);
});

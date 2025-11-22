document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Mobile Menu
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = mobileMenu.classList.contains('hidden') ? 'menu' : 'x';
            // Re-render icon
            mobileMenuBtn.innerHTML = `<i data-lucide="${icon}"></i>`;
            lucide.createIcons();
        });
    }

    // Before/After Slider (Home Page)
    const container = document.getElementById('before-after-container');
    if (container) {
        const wrapper = document.getElementById('before-image-wrapper');
        const handle = document.getElementById('slider-handle');
        
        const move = (e) => {
            const rect = container.getBoundingClientRect();
            const x = (e.touches ? e.touches[0].clientX : e.clientX) - rect.left;
            const pos = Math.max(0, Math.min((x / rect.width) * 100, 100));
            
            wrapper.style.clipPath = `inset(0 ${100 - pos}% 0 0)`;
            handle.style.left = `${pos}%`;
        };

        container.addEventListener('mousemove', move);
        container.addEventListener('touchmove', move);
    }

    // Quote Calculator Logic
    window.openQuote = function(initialType = '') {
        const modal = document.getElementById('quote-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Reset
        document.getElementById('quote-step-1').classList.remove('hidden');
        document.getElementById('quote-step-2').classList.add('hidden');
        document.getElementById('quote-step-3').classList.add('hidden');
        
        // Populate Services if empty (simulated from PHP/HTML structure or hardcoded for now)
        const list = document.getElementById('quote-services-list');
        if (list.children.length === 0) {
            const services = ['Tempered Glass', 'Aluminium Windows', 'Sliding Doors', 'Shopfront Glass', 'Glass Partitions', 'Shower Screens'];
            services.forEach(s => {
                const btn = document.createElement('button');
                btn.className = 'p-3 rounded border text-sm font-medium transition-colors hover:bg-gray-50 quote-service-btn';
                btn.innerText = s;
                btn.onclick = () => selectService(btn, s);
                list.appendChild(btn);
            });
        }

        if (initialType) {
            // Auto select if passed
            const btns = document.querySelectorAll('.quote-service-btn');
            btns.forEach(b => {
                if(b.innerText === initialType) selectService(b, initialType);
            });
            nextQuoteStep();
        }
    };

    window.closeQuote = function() {
        const modal = document.getElementById('quote-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    let selectedService = '';
    
    function selectService(btn, service) {
        selectedService = service;
        document.querySelectorAll('.quote-service-btn').forEach(b => {
            b.classList.remove('bg-[#0A2342]', 'text-white');
            b.classList.add('hover:bg-gray-50');
        });
        btn.classList.remove('hover:bg-gray-50');
        btn.classList.add('bg-[#0A2342]', 'text-white');
        document.getElementById('quote-next-btn').disabled = false;
    }

    window.nextQuoteStep = function() {
        document.getElementById('quote-step-1').classList.add('hidden');
        document.getElementById('quote-step-2').classList.remove('hidden');
    };

    window.prevQuoteStep = function() {
        document.getElementById('quote-step-2').classList.add('hidden');
        document.getElementById('quote-step-1').classList.remove('hidden');
    };

    window.calculateQuote = function() {
        const w = parseFloat(document.getElementById('quote-width').value) || 0;
        const h = parseFloat(document.getElementById('quote-height').value) || 0;
        const mat = document.getElementById('quote-material').value;
        
        const baseRate = 45;
        const price = (w * h * baseRate * (mat === 'Premium' ? 1.5 : 1)).toFixed(2);
        
        document.getElementById('quote-result').innerText = price;
        
        document.getElementById('quote-step-2').classList.add('hidden');
        document.getElementById('quote-step-3').classList.remove('hidden');
    };

    window.sendQuoteWhatsapp = function() {
        const price = document.getElementById('quote-result').innerText;
        const url = `https://wa.me/${pg_data.whatsapp_number}?text=Quote for ${selectedService}: RM${price}`;
        window.open(url, '_blank');
    };
});

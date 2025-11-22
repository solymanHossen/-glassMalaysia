<?php
/* Template Name: Visualizer Page */
get_header();
?>

<div class="pt-20">
    <section class="py-24 bg-[#0A2342] text-white">
        <div class="container mx-auto px-4 grid md:grid-cols-3 gap-12">
            <div>
                <div class="text-center md:text-left mb-12 animate-in">
                    <h4 class="font-bold tracking-widest text-sm mb-2 text-[#D4AF37]">DESIGN YOUR SPACE</h4>
                    <h2 class="text-3xl md:text-5xl font-bold text-white">3D Visualizer</h2>
                    <div class="w-20 h-1 mx-auto md:mx-0 mt-4 rounded bg-[#D4AF37]"></div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="text-sm font-bold text-[#D4AF37] mb-2 block">Glass Tint</label>
                        <div class="flex gap-2">
                            <button onclick="setTint('clear')" class="tint-btn px-4 py-2 border rounded capitalize bg-[#D4AF37] text-[#0A2342] border-[#D4AF37]" data-tint="clear">clear</button>
                            <button onclick="setTint('dark')" class="tint-btn px-4 py-2 border rounded capitalize border-white/20" data-tint="dark">dark</button>
                            <button onclick="setTint('blue')" class="tint-btn px-4 py-2 border rounded capitalize border-white/20" data-tint="blue">blue</button>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-[#D4AF37] mb-2 block">Frame Color</label>
                        <div class="flex gap-4">
                            <button onclick="setFrame('black')" class="frame-btn w-10 h-10 rounded-full border-2 ring-2 ring-[#D4AF37] border-white" style="background:#222" data-frame="black"></button>
                            <button onclick="setFrame('silver')" class="frame-btn w-10 h-10 rounded-full border-2 border-transparent" style="background:#ccc" data-frame="silver"></button>
                            <button onclick="setFrame('gold')" class="frame-btn w-10 h-10 rounded-full border-2 border-transparent" style="background:#D4AF37" data-frame="gold"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:col-span-2 relative aspect-video rounded-xl overflow-hidden shadow-2xl border border-white/10">
                <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&q=80&w=1200" class="absolute inset-0 w-full h-full object-cover" />
                <div id="viz-frame" class="absolute inset-8 border-[12px] z-10" style="border-color:#222; transition:0.3s">
                    <div id="viz-frame-mid" class="absolute top-1/2 w-full h-[12px] -mt-[6px]" style="background:#222"></div>
                </div>
                <div id="viz-tint" class="absolute inset-8 z-0 transition-colors duration-500" style="background:rgba(255,255,255,0.1)"></div>
            </div>
        </div>
    </section>
</div>

<script>
const tints = { clear: 'rgba(255,255,255,0.1)', dark: 'rgba(0,0,0,0.5)', blue: 'rgba(30,90,142,0.3)' };
const frames = { black: '#222', silver: '#ccc', gold: '#D4AF37' };

function setTint(tint) {
    document.getElementById('viz-tint').style.background = tints[tint];
    document.querySelectorAll('.tint-btn').forEach(btn => {
        if(btn.dataset.tint === tint) {
            btn.classList.add('bg-[#D4AF37]', 'text-[#0A2342]', 'border-[#D4AF37]');
            btn.classList.remove('border-white/20');
        } else {
            btn.classList.remove('bg-[#D4AF37]', 'text-[#0A2342]', 'border-[#D4AF37]');
            btn.classList.add('border-white/20');
        }
    });
}

function setFrame(frame) {
    document.getElementById('viz-frame').style.borderColor = frames[frame];
    document.getElementById('viz-frame-mid').style.background = frames[frame];
    document.querySelectorAll('.frame-btn').forEach(btn => {
        if(btn.dataset.frame === frame) {
            btn.classList.add('ring-2', 'ring-[#D4AF37]', 'border-white');
            btn.classList.remove('border-transparent');
        } else {
            btn.classList.remove('ring-2', 'ring-[#D4AF37]', 'border-white');
            btn.classList.add('border-transparent');
        }
    });
}
</script>

<?php get_footer(); ?>

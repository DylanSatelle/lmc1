<div class="forge-noise overflow-x-clip">
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-rust/15 bg-forge/90 backdrop-blur-xl">
        <div class="section-shell flex h-[4.25rem] items-center justify-between gap-6">
            <a href="#top" class="flex items-center"><img src="{{ asset('storage/lmc.svg') }}" alt="LMC Fencing & Gates" class="h-16 w-auto sm:h-20"></a>

            <div class="hidden items-center gap-8 lg:flex">
                <a href="#services" class="font-condensed text-sm font-medium uppercase tracking-[0.16em] text-ash transition hover:text-white">Services</a>
                <a href="#about" class="font-condensed text-sm font-medium uppercase tracking-[0.16em] text-ash transition hover:text-white">About</a>
                <a href="#process" class="font-condensed text-sm font-medium uppercase tracking-[0.16em] text-ash transition hover:text-white">Process</a>
                <a href="#testimonials" class="font-condensed text-sm font-medium uppercase tracking-[0.16em] text-ash transition hover:text-white">Reviews</a>
                <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="font-condensed text-sm font-medium uppercase tracking-[0.16em] text-ash transition hover:text-white">Admin</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="hidden border border-white/15 px-4 py-2.5 font-display text-xs font-semibold uppercase tracking-[0.14em] text-white transition hover:border-rust hover:text-rust sm:inline-flex">
                    Admin
                </a>
                <a href="#contact" class="clip-rust-sm bg-rust px-5 py-2.5 font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:bg-rust-hot">
                    Get A Quote
                </a>
            </div>
        </div>
    </nav>

    <main id="top">
        <section class="relative flex min-h-screen items-center overflow-hidden pt-24">
            <div class="absolute inset-0 bg-[linear-gradient(155deg,#0c0f12_0%,#14181e_50%,#190e08_100%)]"></div>
            <div class="absolute inset-0 bg-[repeating-linear-gradient(-52deg,transparent,transparent_72px,rgba(200,62,10,.022)_72px,rgba(200,62,10,.022)_73px)]"></div>
            <div class="absolute -right-40 top-1/2 h-[42rem] w-[42rem] -translate-y-1/2 rounded-full bg-[radial-gradient(circle,rgba(200,62,10,.18)_0%,transparent_60%)] blur-3xl"></div>
            <div class="absolute right-0 top-0 h-3/5 w-[3px] bg-gradient-to-b from-rust to-transparent"></div>

            <div class="section-shell relative grid items-center gap-16 py-16 lg:grid-cols-[1.1fr_.9fr] lg:py-24">
                <div class="pointer-events-none absolute left-[54%] top-2 z-10 hidden -translate-x-1/2 lg:block xl:left-[53%] xl:top-0">
                    <img src="{{ asset('storage/lmc.svg') }}" alt="LMC Fencing & Gates" class="h-[9rem] w-auto xl:h-[10rem]">
                </div>

                <div>
                    <div class="reveal-up mb-8 flex justify-center lg:hidden">
                        <img src="{{ asset('storage/lmc.svg') }}" alt="LMC Fencing & Gates" class="h-28 w-auto sm:h-32 lg:h-36">
                    </div>
                    <p class="section-tag reveal-up justify-center after:hidden before:block before:h-px before:w-9 before:bg-rust">Abergele, North Wales</p>
                    <h1 class="reveal-up delay-1 font-display text-6xl leading-[0.88] font-bold uppercase tracking-[-0.03em] text-white md:text-7xl xl:text-[6rem]">
                        Fencing That Looks
                        <span class="block text-rust">Built Properly</span>
                    </h1>
                    <p class="reveal-up delay-2 mt-8 max-w-xl text-lg leading-8 text-silver">
                        Custom fencing, gates, decking, pergolas and outdoor structures made on site with no shortcuts. Practical workmanship, durable materials and straight answers from first visit to final fix.
                    </p>

                    <div class="reveal-up delay-3 mt-10 flex flex-wrap items-center gap-4">
                        <a href="#contact" class="clip-rust bg-rust px-9 py-4 font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:-translate-y-0.5 hover:bg-rust-hot">
                            Request A Quote
                        </a>
                        <a href="tel:07961417550" class="border border-white/15 px-8 py-[0.95rem] font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:border-rust hover:text-rust">
                            Call Lewis
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-[3px] sm:grid-cols-2">
                    @foreach ($stats as $index => $stat)
                        <article class="steel-card group reveal-up {{ $index > 1 ? 'delay-3' : 'delay-2' }} relative overflow-hidden px-8 py-10">
                            <div class="absolute inset-y-0 left-0 w-[3px] origin-top scale-y-0 bg-rust transition duration-300 group-hover:scale-y-100"></div>
                            <div class="font-display text-6xl leading-none font-bold text-rust">{{ $stat['value'] }}</div>
                            <div class="mt-3 font-condensed text-xs font-semibold uppercase tracking-[0.22em] text-ash">{{ $stat['label'] }}</div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="overflow-hidden bg-rust py-3.5">
            <div class="ticker-track flex whitespace-nowrap hover:[animation-play-state:paused]">
                @foreach (array_merge($tickerItems, $tickerItems) as $item)
                    <div class="flex items-center">
                        <span class="px-10 font-condensed text-xs font-bold uppercase tracking-[0.24em] text-white/90">{{ $item }}</span>
                        <span class="text-white/35">?</span>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="services" class="bg-steel py-24 lg:py-32">
            <div class="section-shell">
                <div class="mb-14 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="section-tag">What We Do</p>
                        <h2 class="section-title mt-4">Our Services</h2>
                        <p class="section-subtitle mt-4">Everything is made to fit your site, your layout and your job. No off-the-shelf panels pretending to be bespoke work.</p>
                    </div>
                    <a href="#contact" class="clip-rust inline-flex w-fit bg-rust px-8 py-4 font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:bg-rust-hot">Get A Quote</a>
                </div>

                <div class="grid gap-[3px] md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($services as $service)
                        <article class="steel-card group relative overflow-hidden px-10 py-12 transition hover:bg-white/[0.03]">
                            <span class="absolute right-6 top-4 font-condensed text-7xl font-black leading-none text-white/[0.03]">{{ $service['number'] }}</span>
                            <div class="mb-7 text-rust">
                                @switch($service['icon'])
                                    @case('fence')
                                        <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="8" width="6" height="32" rx="1"/><rect x="38" y="8" width="6" height="32" rx="1"/><line x1="10" y1="16" x2="38" y2="16"/><line x1="10" y1="24" x2="38" y2="24"/><line x1="10" y1="32" x2="38" y2="32"/><line x1="18" y1="8" x2="18" y2="40"/><line x1="26" y1="8" x2="26" y2="40"/></svg>
                                        @break
                                    @case('pergola')
                                        <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 28 L24 12 L42 28"/><rect x="10" y="28" width="28" height="12"/><line x1="18" y1="28" x2="18" y2="40"/><line x1="30" y1="28" x2="30" y2="40"/></svg>
                                        @break
                                    @case('decking')
                                        <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="28" width="40" height="12" rx="1"/><line x1="12" y1="28" x2="12" y2="40"/><line x1="24" y1="28" x2="24" y2="40"/><line x1="36" y1="28" x2="36" y2="40"/><line x1="8" y1="20" x2="8" y2="28"/><line x1="24" y1="20" x2="24" y2="28"/><line x1="40" y1="20" x2="40" y2="28"/></svg>
                                        @break
                                    @case('veranda')
                                        <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="28" width="40" height="12" rx="2"/><rect x="4" y="28" width="40" height="4"/><line x1="16" y1="28" x2="16" y2="40"/><line x1="32" y1="28" x2="32" y2="40"/><path d="M10 28 V20 Q10 16 14 16 H34 Q38 16 38 20 V28"/></svg>
                                        @break
                                    @case('shed')
                                        <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="8" y="20" width="32" height="22" rx="1"/><path d="M6 22 L24 10 L42 22"/><rect x="18" y="30" width="12" height="12"/><line x1="8" y1="28" x2="16" y2="28"/><line x1="32" y1="28" x2="40" y2="28"/></svg>
                                        @break
                                    @default
                                        <svg class="h-12 w-12" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 38 Q12 26 24 30 Q36 34 42 22"/><circle cx="14" cy="18" r="5"/><path d="M14 23 L14 38"/><path d="M8 32 L20 32"/><circle cx="34" cy="12" r="4"/></svg>
                                @endswitch
                            </div>
                            <h3 class="font-display text-2xl font-semibold uppercase tracking-[0.03em] text-white">{{ $service['title'] }}</h3>
                            <p class="mt-4 text-[0.97rem] leading-8 text-ash">{{ $service['description'] }}</p>
                            <div class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-rust transition duration-300 group-hover:scale-x-100"></div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="about" class="py-28 lg:py-36">
            <div class="section-shell grid items-center gap-14 lg:grid-cols-[1fr_1fr] lg:gap-24">
                <div class="relative p-5">
                    <div class="absolute inset-0 border border-rust/25"></div>
                    <div class="absolute left-0 top-0 z-20 -translate-x-1/3 -translate-y-1/3 rounded-full border border-rust/25 bg-forge/90 p-2 shadow-xl shadow-black/30">
                        <img src="{{ asset('storage/lmc.svg') }}" alt="LMC Fencing & Gates" class="h-16 w-16 rounded-full object-contain sm:h-20 sm:w-20">
                    </div>
                    <div class="steel-card relative aspect-[4/5] overflow-hidden">
                        <div class="absolute inset-0 bg-[repeating-linear-gradient(-45deg,transparent,transparent_22px,rgba(200,62,10,.05)_22px,rgba(200,62,10,.05)_23px)]"></div>
                        @if (count($galleryImages) > 0)
                            <div class="relative h-full w-full">
                                @foreach ($galleryImages as $index => $image)
                                    <img
                                        src="{{ $image }}"
                                        alt="LMC project photo {{ $index + 1 }}"
                                        class="absolute inset-0 h-full w-full object-cover opacity-0 animate-[hero-gallery_24s_linear_infinite]"
                                        style="animation-delay: {{ $index * 4 }}s"
                                    >
                                @endforeach
                                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(12,15,18,0.12)_0%,rgba(12,15,18,0.34)_100%)]"></div>
                                <div class="absolute inset-x-0 bottom-0 p-6 text-left">
                                    <span class="font-condensed text-xs uppercase tracking-[0.24em] text-white/78">Bespoke outdoor work, built on site</span>
                                </div>
                            </div>
                        @else
                            <div class="relative flex h-full flex-col items-center justify-center gap-4 px-8 py-12 text-center">
                                <svg class="h-16 w-16 text-rust/20" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="8" y="8" width="48" height="48" rx="2"/><line x1="8" y1="24" x2="56" y2="24"/><line x1="8" y1="40" x2="56" y2="40"/><line x1="24" y1="8" x2="24" y2="56"/><line x1="40" y1="8" x2="40" y2="56"/></svg>
                                <span class="font-condensed text-xs uppercase tracking-[0.24em] text-ash/60">Bespoke outdoor work, built on site</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute bottom-0 right-0 flex h-40 w-40 translate-x-6 translate-y-6 flex-col items-center justify-center bg-rust text-center shadow-2xl shadow-rust/20">
                        <span class="font-display text-6xl leading-none font-bold text-white">14+</span>
                        <span class="px-5 font-condensed text-xs font-medium uppercase tracking-[0.18em] text-white/75">Years on the tools</span>
                    </div>
                </div>

                <div>
                    <p class="section-tag">Who We Are</p>
                    <h2 class="section-title mt-4">North Wales<br>Craftsmen</h2>
                    <p class="mt-6 text-lg leading-9 text-silver">Based in Abergele, LMC Fencing & Gates has been serving homeowners across North Wales since 2014. Everything is made to order on site using quality materials, straightforward advice and a practical eye for detail.</p>
                    <ul class="mt-8 space-y-0 border-t border-white/6">
                        <li class="flex gap-4 border-b border-white/6 py-4 text-[0.97rem] leading-8 text-ash"><span class="mt-3 h-1.5 w-1.5 shrink-0 bg-rust"></span><span>Over 1,500 satisfied customers across North Wales and beyond.</span></li>
                        <li class="flex gap-4 border-b border-white/6 py-4 text-[0.97rem] leading-8 text-ash"><span class="mt-3 h-1.5 w-1.5 shrink-0 bg-rust"></span><span>Custom-built work designed around your site, your measurements and your finish.</span></li>
                        <li class="flex gap-4 border-b border-white/6 py-4 text-[0.97rem] leading-8 text-ash"><span class="mt-3 h-1.5 w-1.5 shrink-0 bg-rust"></span><span>Free quotes with no pressure and no call centre in the middle.</span></li>
                        <li class="flex gap-4 border-b border-white/6 py-4 text-[0.97rem] leading-8 text-ash"><span class="mt-3 h-1.5 w-1.5 shrink-0 bg-rust"></span><span>Most new work comes from recommendation, which says more than a sales pitch.</span></li>
                    </ul>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#contact" class="clip-rust bg-rust px-8 py-4 font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:bg-rust-hot">Request A Quote</a>
                        <a href="tel:07961417550" class="border border-white/15 px-8 py-[0.95rem] font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:border-rust hover:text-rust">Call Lewis</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="process" class="bg-steel py-24 lg:py-28">
            <div class="section-shell">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="section-tag justify-center after:hidden before:block before:h-px before:w-9 before:bg-rust">Simple & Straightforward</p>
                    <h2 class="section-title mt-4">How It Works</h2>
                    <p class="section-subtitle mx-auto mt-4">No fuss and no bloated process. The job gets measured properly, priced clearly and built the right way.</p>
                </div>

                <div class="relative mt-16 grid gap-[3px] md:grid-cols-2 xl:grid-cols-4">
                    <div class="absolute left-[12.5%] right-[12.5%] top-[3.25rem] hidden h-px bg-[repeating-linear-gradient(90deg,var(--color-rust)_0,var(--color-rust)_8px,transparent_8px,transparent_16px)] xl:block"></div>
                    @foreach ($processSteps as $index => $step)
                        <article class="steel-card scroll-reveal relative z-10 px-8 py-12 text-center" data-scroll-reveal style="--reveal-delay: {{ $index * 120 }}ms;">
                            <div class="mx-auto flex h-[3.75rem] w-[3.75rem] items-center justify-center rounded-full bg-rust font-display text-2xl font-bold text-white">{{ $step['step'] }}</div>
                            <h3 class="mt-7 font-display text-xl font-semibold uppercase tracking-[0.05em] text-white">{{ $step['title'] }}</h3>
                            <p class="mt-4 text-[0.95rem] leading-8 text-ash">{{ $step['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="testimonials" class="py-24 lg:py-32">
            <div class="section-shell">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="section-tag justify-center after:hidden before:block before:h-px before:w-9 before:bg-rust">What Customers Say</p>
                    <h2 class="section-title mt-4">Word Of Mouth<br>Built In</h2>
                    <p class="section-subtitle mx-auto mt-4">The business keeps moving because the work speaks for itself and customers send the next customer over.</p>
                    <a href="https://www.facebook.com/lmclandscaping1" target="_blank" rel="noopener" class="mt-6 inline-flex items-center gap-3 border border-rust/30 px-6 py-3 font-display text-xs font-semibold uppercase tracking-[0.14em] text-white transition hover:border-rust hover:bg-rust/10 hover:text-rust">
                        See More Reviews On Facebook
                        <span aria-hidden="true">↗</span>
                    </a>
                </div>

                @php
                    $testimonialColumns = [[], []];

                    foreach ($testimonials as $index => $testimonial) {
                        $testimonialColumns[$index % 2][] = [
                            'index' => $index,
                            'quote' => $testimonial['quote'],
                            'author' => $testimonial['author'],
                            'location' => $testimonial['location'],
                        ];
                    }
                @endphp

                <div class="mt-16 grid gap-2 lg:grid-cols-2">
                    @foreach ($testimonialColumns as $column)
                        <div class="relative min-h-[28rem] overflow-hidden xl:min-h-[25rem]" data-testimonial-rotator data-rotation-ms="7000">
                            @foreach ($column as $columnIndex => $testimonial)
                                <article
                                    class="steel-card testimonial-panel absolute inset-0 border-t-[3px] border-rust px-8 py-10 sm:px-10 sm:py-11{{ $columnIndex === 0 ? ' is-active' : '' }}"
                                    data-testimonial-panel
                                    aria-hidden="{{ $columnIndex === 0 ? 'false' : 'true' }}"
                                >
                                    <div class="absolute right-6 top-6 font-condensed text-[0.7rem] uppercase tracking-[0.24em] text-rust sm:right-8 sm:top-8 sm:text-sm">{{ str_pad((string) ($testimonial['index'] + 1), 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="font-display text-6xl leading-none text-rust/55">&ldquo;</div>
                                    <p class="mt-4 text-[0.98rem] leading-8 text-silver italic">{{ $testimonial['quote'] }}</p>
                                    <div class="mt-8 font-condensed text-sm font-bold uppercase tracking-[0.14em] text-white">{{ $testimonial['author'] }}</div>
                                </article>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="relative overflow-hidden bg-rust py-24 lg:py-28">
            <div class="absolute inset-0 bg-[repeating-linear-gradient(-52deg,transparent,transparent_50px,rgba(0,0,0,.06)_50px,rgba(0,0,0,.06)_51px)]"></div>
            <div class="section-shell relative text-center">
                <p class="section-tag justify-center text-white/70 after:bg-white/40 before:block before:h-px before:w-9 before:bg-white/40">Ready To Get Started?</p>
                <h2 class="mt-5 font-display text-5xl leading-[0.9] font-bold uppercase text-white md:text-7xl">Free Quote.<br>No Obligation.</h2>
                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-white/80">If you are in Abergele, Rhyl, Prestatyn, Colwyn Bay, Towyn or nearby, get in touch and arrange a site visit.</p>
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="#contact" class="clip-rust bg-white px-10 py-4 font-display text-sm font-bold uppercase tracking-[0.14em] text-rust transition hover:-translate-y-0.5 hover:bg-cream">Request A Quote</a>
                    <a href="https://www.facebook.com/lmclandscaping1" target="_blank" rel="noopener" class="border-2 border-white/60 px-9 py-[0.9rem] font-display text-sm font-semibold uppercase tracking-[0.14em] text-white transition hover:border-white hover:bg-white/10">Find Us On Facebook</a>
                </div>
                <div class="mt-10 font-condensed text-base uppercase tracking-[0.12em] text-white/70">
                    Or call us directly
                    <a href="tel:07961417550" class="mt-2 block text-3xl font-bold tracking-[0.04em] text-white">07961 417 550</a>
                </div>
            </div>
        </section>

        <section id="contact" class="bg-steel py-24 lg:py-32">
            <div class="section-shell grid gap-14 lg:grid-cols-[1fr_1.35fr] lg:gap-20">
                <div>
                    <p class="section-tag">Get In Touch</p>
                    <h2 class="section-title mt-4">Request A<br>Free Quote</h2>
                    <p class="mt-6 max-w-xl text-[0.98rem] leading-8 text-ash">We will come out, measure up and give you a fair quote with no pressure attached. Direct contact, practical advice and a fast response.</p>

                    <div class="mt-10 space-y-7">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center border border-rust/30 bg-iron text-rust">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 10.8 19.79 19.79 0 0 1 0 2.1 2 2 0 0 1 2 0h3a2 2 0 0 1 2 1.72 12.8 12.8 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L6.09 7.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.8 12.8 0 0 0 2.81.7A2 2 0 0 1 22 14z"/></svg>
                            </div>
                            <div>
                                <div class="font-condensed text-xs uppercase tracking-[0.2em] text-ash">Phone</div>
                                <a href="tel:07961417550" class="mt-1 block text-lg text-white transition hover:text-rust">07961 417 550</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center border border-rust/30 bg-iron text-rust">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <div>
                                <div class="font-condensed text-xs uppercase tracking-[0.2em] text-ash">Email</div>
                                <a href="mailto:LewisMClayton1@icloud.com" class="mt-1 block text-lg text-white transition hover:text-rust">LewisMClayton1@icloud.com</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center border border-rust/30 bg-iron text-rust">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div>
                                <div class="font-condensed text-xs uppercase tracking-[0.2em] text-ash">Coverage</div>
                                <div class="mt-1 text-lg text-white">{{ implode(', ', $coverageAreas) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="steel-card px-8 py-10 md:px-12 md:py-12">
                    <h3 class="font-display text-3xl font-bold uppercase tracking-[0.02em] text-white">Send A Message</h3>

                    @if (session('quote_success'))
                        <div class="mt-6 border border-rust/40 bg-rust/10 px-5 py-4 text-sm leading-7 text-silver">
                            {{ session('quote_success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('quote-request.store') }}" class="mt-8 space-y-4">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Your Name</label>
                                <input name="name" id="name" type="text" value="{{ old('name') }}" class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition placeholder:text-ash focus:border-rust" placeholder="John Smith">
                                @error('name') <p class="mt-2 text-sm text-rust">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Phone Number</label>
                                <input name="phone" id="phone" type="tel" value="{{ old('phone') }}" class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition placeholder:text-ash focus:border-rust" placeholder="07xxx xxxxxx">
                                @error('phone') <p class="mt-2 text-sm text-rust">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="email" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Email Address</label>
                                <input name="email" id="email" type="email" value="{{ old('email') }}" class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition placeholder:text-ash focus:border-rust" placeholder="you@example.com">
                                @error('email') <p class="mt-2 text-sm text-rust">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="postcode" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Postcode</label>
                                <input name="postcode" id="postcode" type="text" value="{{ old('postcode') }}" class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] uppercase text-white outline-none transition placeholder:text-ash focus:border-rust" placeholder="LL22 7AA">
                                @error('postcode') <p class="mt-2 text-sm text-rust">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="service" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Service Required</label>
                            <select name="service" id="service" class="w-full border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition focus:border-rust">
                                <option value="">Select a service...</option>
                                @foreach ($serviceOptions as $option)
                                    <option value="{{ $option }}" @selected(old('service') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('service') <p class="mt-2 text-sm text-rust">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="mb-2 block font-condensed text-xs font-medium uppercase tracking-[0.2em] text-ash">Tell Us More</label>
                            <textarea name="message" id="message" rows="6" class="w-full resize-y border border-white/8 bg-chain px-4 py-3.5 text-[0.96rem] text-white outline-none transition placeholder:text-ash focus:border-rust" placeholder="Describe the job, rough sizes if you have them, and where you are based.">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-2 text-sm text-rust">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="clip-rust-sm inline-flex w-full items-center justify-center bg-rust px-6 py-4 font-display text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-rust-hot">
                            Send Message & Request Quote
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/6 bg-forge py-14">
        <div class="section-shell">
            <div class="grid gap-12 border-b border-white/6 pb-12 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
                <div>
                    <a href="#top" class="inline-flex items-center"><img src="{{ asset('storage/lmc.svg') }}" alt="LMC Fencing & Gates" class="h-20 w-auto"></a>
                    <p class="mt-4 max-w-sm text-[0.95rem] leading-8 text-ash">Fencing, gates, decking and outdoor timber work built on site across Abergele and North Wales.</p>
                    <a href="https://www.facebook.com/lmclandscaping1" target="_blank" rel="noopener" class="mt-5 inline-flex h-10 w-10 items-center justify-center border border-white/8 bg-iron text-ash transition hover:border-rust hover:bg-rust hover:text-white">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                </div>
                <div>
                    <h4 class="font-condensed text-sm font-bold uppercase tracking-[0.2em] text-white">Services</h4>
                    <ul class="mt-5 space-y-3 text-[0.95rem] text-ash">
                        @foreach ($services as $service)
                            <li><a href="#services" class="transition hover:text-rust">{{ $service['title'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-condensed text-sm font-bold uppercase tracking-[0.2em] text-white">Company</h4>
                    <ul class="mt-5 space-y-3 text-[0.95rem] text-ash">
                        <li><a href="#about" class="transition hover:text-rust">About Us</a></li>
                        <li><a href="#process" class="transition hover:text-rust">How It Works</a></li>
                        <li><a href="#testimonials" class="transition hover:text-rust">Testimonials</a></li>
                        <li><a href="#contact" class="transition hover:text-rust">Get A Quote</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-condensed text-sm font-bold uppercase tracking-[0.2em] text-white">Contact</h4>
                    <ul class="mt-5 space-y-3 text-[0.95rem] text-ash">
                        <li><a href="tel:07961417550" class="transition hover:text-rust">07961 417 550</a></li>
                        <li><a href="mailto:LewisMClayton1@icloud.com" class="transition hover:text-rust">LewisMClayton1@icloud.com</a></li>
                        <li>Abergele, North Wales</li>
                        <li>Covering all surrounding areas</li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col gap-4 pt-8 text-sm text-ash md:flex-row md:items-center md:justify-between">
                <p>© 2026 LMC Fencing & Gates. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="transition hover:text-white">Privacy Policy</a>
                    <a href="#" class="transition hover:text-white">Terms</a>
                </div>
            </div>
        </div>
    </footer>
</div>















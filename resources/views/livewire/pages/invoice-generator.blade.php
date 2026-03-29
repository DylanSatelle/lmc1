<div class="forge-noise min-h-screen py-10" data-invoice-offline-root data-sync-url="{{ route('admin.invoices.sync') }}">
    <div class="section-shell space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl space-y-3">
                <p class="section-tag">Invoice Generator</p>
                <p class="text-sm leading-7 text-ash">This page now keeps a local offline draft on the device. If the iPhone loses signal, the draft stays saved and can sync into admin invoices once you are back online.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('home') }}"
                    class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10"
                >
                    Home
                </a>
                <a
                    href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                    class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10"
                >
                    Admin
                </a>
                @auth
                    <a
                        href="{{ route('admin.invoices') }}"
                        class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10"
                    >
                        Invoices
                    </a>
                @endauth
                <button
                    type="button"
                    wire:click="downloadPdf"
                    data-online-required
                    class="clip-rust-sm bg-rust px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-rust-hot"
                >
                    Download PDF
                </button>
                <button
                    type="button"
                    wire:click="sendInvoiceEmail"
                    data-online-required
                    class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10"
                >
                    Send Email
                </button>
                <button
                    type="button"
                    wire:click="shareOnWhatsApp"
                    data-online-required
                    class="clip-rust-sm border border-teal-400/30 bg-teal-400/12 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-teal-200 transition hover:bg-teal-400/18"
                >
                    Share WhatsApp
                </button>
                <button
                    type="button"
                    data-offline-queue
                    class="clip-rust-sm border border-amber-400/30 bg-amber-400/12 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-amber-100 transition hover:bg-amber-400/18"
                >
                    Save Offline
                </button>
                <button
                    type="button"
                    data-offline-sync
                    data-online-required
                    class="clip-rust-sm border border-white/12 bg-white/6 px-5 py-3 font-condensed text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:border-white/25 hover:bg-white/10"
                >
                    Sync Drafts
                </button>
            </div>
        </div>

        <div class="clip-rust-sm border border-white/10 bg-white/5 px-5 py-4 text-sm text-silver">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <span><strong class="text-white">Connection:</strong> <span data-offline-status>Checking...</span></span>
                <span><strong class="text-white">Queued drafts:</strong> <span data-offline-queue-count>0</span></span>
            </div>
        </div>

        @if (session('invoice_success'))
            <div class="clip-rust-sm border border-teal-400/30 bg-teal-400/10 px-5 py-4 text-sm text-teal-100">
                {{ session('invoice_success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="clip-rust-sm border border-amber-400/30 bg-amber-400/10 px-5 py-4 text-sm text-amber-100">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid gap-8 xl:grid-cols-[minmax(0,30rem)_minmax(0,1fr)]">
            <div class="steel-card clip-rust space-y-8 p-6 lg:p-7">
                <section class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Invoice Setup</h2>
                        <span class="text-xs uppercase tracking-[0.18em] text-ash">Livewire</span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Reference</span>
                            <input wire:model.defer="reference" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Status</span>
                            <select wire:model.defer="status" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                                <option value="awaiting payment">Awaiting Payment</option>
                                <option value="part paid">Part Paid</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Invoice Date</span>
                            <input wire:model.defer="invoiceDate" type="date" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Due Date</span>
                            <input wire:model.defer="dueDate" type="date" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                    </div>

                    <label class="space-y-2">
                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Job / Site Address</span>
                        <textarea wire:model.defer="jobAddress" rows="3" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust"></textarea>
                    </label>
                </section>

                <section class="space-y-4">
                    <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">From</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Company</span>
                            <input wire:model.defer="senderCompany" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Tagline</span>
                            <input wire:model.defer="senderTagline" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Address</span>
                            <input wire:model.defer="senderAddress" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Phone</span>
                            <input wire:model.defer="senderPhone" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Email</span>
                            <input wire:model.defer="senderEmail" type="email" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Website</span>
                            <input wire:model.defer="senderWebsite" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                    </div>
                </section>

                <section class="space-y-4">
                    <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Bill To</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Customer Name</span>
                            <input wire:model.defer="clientName" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Address</span>
                            <textarea wire:model.defer="clientAddress" rows="4" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust"></textarea>
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Phone</span>
                            <input wire:model.defer="clientPhone" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Email</span>
                            <input wire:model.defer="clientEmail" type="email" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                    </div>
                </section>

                <section class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Line Items</h2>
                        <button type="button" wire:click="addItem" class="font-condensed text-xs font-semibold uppercase tracking-[0.18em] text-rust">Add Item</button>
                    </div>

                    <div class="space-y-4">
                        @foreach ($items as $index => $item)
                            <div wire:key="invoice-item-{{ $index }}" class="clip-rust-sm border border-white/8 bg-white/3 p-4">
                                <div class="mb-4 flex items-center justify-between">
                                    <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Item {{ $index + 1 }}</span>
                                    @if (count($items) > 1)
                                        <button type="button" wire:click="removeItem({{ $index }})" class="font-condensed text-xs font-semibold uppercase tracking-[0.18em] text-white/60 transition hover:text-white">Remove</button>
                                    @endif
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <label class="space-y-2 sm:col-span-2">
                                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Title</span>
                                        <input wire:model.defer="items.{{ $index }}.name" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                                    </label>
                                    <label class="space-y-2 sm:col-span-2">
                                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Description</span>
                                        <textarea wire:model.defer="items.{{ $index }}.description" rows="3" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust"></textarea>
                                    </label>
                                    <label class="space-y-2">
                                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Quantity</span>
                                        <input wire:model.defer="items.{{ $index }}.quantity" type="number" min="0.01" step="0.01" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                                    </label>
                                    <label class="space-y-2">
                                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Unit</span>
                                        <input wire:model.defer="items.{{ $index }}.unit" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                                    </label>
                                    <label class="space-y-2 sm:col-span-2">
                                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Unit Price</span>
                                        <input wire:model.defer="items.{{ $index }}.unit_price" type="number" min="0" step="0.01" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="space-y-4">
                    <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Totals & Payment</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">VAT Rate %</span>
                            <input wire:model.defer="vatRate" type="number" min="0" max="100" step="0.01" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Discount</span>
                            <input wire:model.defer="discount" type="number" min="0" step="0.01" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Payment Method</span>
                            <input wire:model.defer="paymentMethod" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Sort Code</span>
                            <input wire:model.defer="paymentSortCode" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Account Number</span>
                            <input wire:model.defer="paymentAccountNumber" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Account Name</span>
                            <input wire:model.defer="paymentAccountName" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Payment Reference</span>
                            <input wire:model.defer="paymentReference" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                    </div>

                    <label class="space-y-2">
                        <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Notes & Terms</span>
                        <textarea wire:model.defer="notes" rows="5" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust"></textarea>
                    </label>
                </section>

                <section class="space-y-4">
                    <h2 class="font-condensed text-lg font-semibold uppercase tracking-[0.18em] text-white">Delivery</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Email To</span>
                            <input wire:model.defer="emailTo" type="email" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Email Subject</span>
                            <input wire:model.defer="emailSubject" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2 sm:col-span-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">Email Message</span>
                            <textarea wire:model.defer="emailMessage" rows="4" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust"></textarea>
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">WhatsApp Number</span>
                            <input wire:model.defer="whatsAppNumber" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                        <label class="space-y-2">
                            <span class="font-condensed text-xs uppercase tracking-[0.18em] text-silver">WhatsApp Message</span>
                            <input wire:model.defer="whatsAppMessage" type="text" class="w-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white outline-none transition focus:border-rust">
                        </label>
                    </div>
                </section>
            </div>

            <div class="space-y-4">
                <div class="overflow-x-auto rounded-[1.75rem] border border-white/10 bg-[#f4f6f8] p-4 shadow-2xl shadow-black/20 lg:p-6">
                    @include('invoices.partials.styles')
                    @include('invoices.partials.document', ['invoice' => $invoice, 'logo' => asset('storage/lmc.svg')])
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            $wire.on('open-url', ({ url }) => {
                window.open(url, '_blank', 'noopener,noreferrer');
            });
        </script>
    @endscript
</div>


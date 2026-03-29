import './bootstrap';

const initScrollReveal = () => {
    const items = document.querySelectorAll('[data-scroll-reveal]');

    if (!items.length) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        items.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.2,
            rootMargin: '0px 0px -8% 0px',
        },
    );

    items.forEach((item) => observer.observe(item));
};

const initTestimonialRotator = () => {
    const rotators = document.querySelectorAll('[data-testimonial-rotator]');

    rotators.forEach((rotator) => {
        const panels = Array.from(rotator.querySelectorAll('[data-testimonial-panel]'));

        if (panels.length <= 1) {
            return;
        }

        let activeIndex = Math.max(0, panels.findIndex((panel) => panel.classList.contains('is-active')));
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const setActive = (index) => {
            panels.forEach((panel, panelIndex) => {
                const isActive = panelIndex === index;
                panel.classList.toggle('is-active', isActive);
                panel.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            });
        };

        setActive(activeIndex);

        if (prefersReducedMotion) {
            return;
        }

        const rotationMs = Number.parseInt(rotator.getAttribute('data-rotation-ms') ?? '7000', 10) || 7000;

        window.setInterval(() => {
            activeIndex = (activeIndex + 1) % panels.length;
            setActive(activeIndex);
        }, rotationMs);
    });
};

const registerServiceWorker = () => {
    if (!('serviceWorker' in navigator)) {
        return;
    }

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    }, { once: true });
};

const initOfflineInvoiceDrafts = () => {
    const root = document.querySelector('[data-invoice-offline-root]');

    if (!root) {
        return;
    }

    const draftKey = 'lmc.invoice.currentDraft';
    const queueKey = 'lmc.invoice.syncQueue';
    const syncUrl = root.getAttribute('data-sync-url');
    const statusNode = root.querySelector('[data-offline-status]');
    const queueCountNode = root.querySelector('[data-offline-queue-count]');
    const queueButton = root.querySelector('[data-offline-queue]');
    const syncButton = root.querySelector('[data-offline-sync]');
    const onlineRequiredButtons = root.querySelectorAll('[data-online-required]');
    const fieldSelector = 'input[wire\\:model\\.defer], select[wire\\:model\\.defer], textarea[wire\\:model\\.defer]';
    const fields = Array.from(root.querySelectorAll(fieldSelector));

    if (!fields.length || !syncUrl) {
        return;
    }

    let saveTimer;

    const getDraft = () => {
        try {
            return JSON.parse(window.localStorage.getItem(draftKey) ?? '{}');
        } catch {
            return {};
        }
    };

    const setDraft = (draft) => {
        window.localStorage.setItem(draftKey, JSON.stringify(draft));
    };

    const getQueue = () => {
        try {
            return JSON.parse(window.localStorage.getItem(queueKey) ?? '[]');
        } catch {
            return [];
        }
    };

    const setQueue = (queue) => {
        window.localStorage.setItem(queueKey, JSON.stringify(queue));
    };

    const updateStatusUi = () => {
        const isOnline = navigator.onLine;

        if (statusNode) {
            statusNode.textContent = isOnline ? 'Online' : 'Offline';
            statusNode.className = isOnline ? 'text-teal-200' : 'text-amber-100';
        }

        const queue = getQueue();

        if (queueCountNode) {
            queueCountNode.textContent = String(queue.length);
        }

        onlineRequiredButtons.forEach((button) => {
            button.disabled = !isOnline;
            button.classList.toggle('opacity-50', !isOnline);
            button.classList.toggle('cursor-not-allowed', !isOnline);
        });
    };

    const collectFlatDraft = () => {
        const draft = {};

        fields.forEach((field) => {
            const key = field.getAttribute('wire:model.defer');

            if (!key) {
                return;
            }

            draft[key] = field.value;
        });

        return draft;
    };

    const inflateItems = (draft) => {
        const items = [];

        Object.entries(draft).forEach(([key, value]) => {
            const match = key.match(/^items\.(\d+)\.(.+)$/);

            if (!match) {
                return;
            }

            const index = Number.parseInt(match[1], 10);
            const itemKey = match[2];

            items[index] ??= {};
            items[index][itemKey] = value;
        });

        return items
            .filter(Boolean)
            .map((item) => {
                const quantity = Number.parseFloat(item.quantity ?? '0') || 0;
                const unitPrice = Number.parseFloat(item.unit_price ?? '0') || 0;

                return {
                    name: item.name ?? '',
                    description: item.description ?? '',
                    quantity,
                    unit: item.unit ?? '',
                    unit_price: unitPrice,
                    line_total: Number((quantity * unitPrice).toFixed(2)),
                };
            });
    };

    const buildInvoicePayload = (draft) => {
        const items = inflateItems(draft);
        const subtotal = Number(items.reduce((sum, item) => sum + item.line_total, 0).toFixed(2));
        const discount = Number((Number.parseFloat(draft.discount ?? '0') || 0).toFixed(2));
        const vatRate = Number((Number.parseFloat(draft.vatRate ?? '0') || 0).toFixed(2));
        const vatAmount = Number((Math.max(subtotal - discount, 0) * (vatRate / 100)).toFixed(2));
        const totalDue = Number((Math.max(subtotal - discount, 0) + vatAmount).toFixed(2));

        return {
            reference: draft.reference ?? '',
            status: draft.status ?? 'awaiting payment',
            invoice_date: draft.invoiceDate ?? '',
            due_date: draft.dueDate ?? '',
            job_address: draft.jobAddress ?? '',
            sender: {
                company: draft.senderCompany ?? '',
                tagline: draft.senderTagline ?? '',
                address: draft.senderAddress ?? '',
                phone: draft.senderPhone ?? '',
                email: draft.senderEmail ?? '',
                website: draft.senderWebsite ?? '',
            },
            client: {
                name: draft.clientName ?? '',
                address: draft.clientAddress ?? '',
                phone: draft.clientPhone ?? '',
                email: draft.clientEmail ?? '',
            },
            items,
            totals: {
                subtotal,
                discount,
                vat_rate: vatRate,
                vat_amount: vatAmount,
                total_due: totalDue,
            },
            payment: {
                method: draft.paymentMethod ?? '',
                sort_code: draft.paymentSortCode ?? '',
                account_number: draft.paymentAccountNumber ?? '',
                account_name: draft.paymentAccountName ?? '',
                reference: draft.paymentReference ?? '',
            },
            notes: draft.notes ?? '',
            email: {
                to: draft.emailTo ?? '',
                subject: draft.emailSubject ?? '',
                body: draft.emailMessage ?? '',
            },
            whatsapp: {
                number: draft.whatsAppNumber ?? '',
                message: draft.whatsAppMessage ?? '',
            },
        };
    };

    const queueDraft = () => {
        const draft = collectFlatDraft();
        setDraft(draft);

        const payload = buildInvoicePayload(draft);

        if (!payload.reference || !payload.client.name || !payload.invoice_date || !payload.due_date || !payload.job_address) {
            return false;
        }

        const queue = getQueue().filter((item) => item.reference !== payload.reference);
        queue.push(payload);
        setQueue(queue);
        updateStatusUi();

        return true;
    };

    const applyDraftToFields = (draft) => {
        fields.forEach((field) => {
            const key = field.getAttribute('wire:model.defer');

            if (!key || !(key in draft)) {
                return;
            }

            field.value = draft[key];
            field.dispatchEvent(new Event(field.tagName === 'SELECT' ? 'change' : 'input', { bubbles: true }));
        });
    };

    const syncQueue = async () => {
        if (!navigator.onLine) {
            updateStatusUi();
            return;
        }

        const queue = getQueue();

        if (!queue.length) {
            updateStatusUi();
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch(syncUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token ?? '',
                    Accept: 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ invoices: queue }),
            });

            if (!response.ok) {
                throw new Error('Sync failed');
            }

            setQueue([]);
            updateStatusUi();
        } catch {
            updateStatusUi();
        }
    };

    applyDraftToFields(getDraft());
    updateStatusUi();

    fields.forEach((field) => {
        const eventName = field.tagName === 'SELECT' ? 'change' : 'input';

        field.addEventListener(eventName, () => {
            window.clearTimeout(saveTimer);
            saveTimer = window.setTimeout(() => {
                const draft = collectFlatDraft();
                setDraft(draft);

                if (!navigator.onLine) {
                    queueDraft();
                }

                updateStatusUi();
            }, 200);
        });
    });

    queueButton?.addEventListener('click', () => {
        queueDraft();
    });

    syncButton?.addEventListener('click', () => {
        syncQueue();
    });

    window.addEventListener('online', () => {
        updateStatusUi();
        syncQueue();
    });

    window.addEventListener('offline', () => {
        queueDraft();
        updateStatusUi();
    });

    if (navigator.onLine) {
        syncQueue();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initScrollReveal();
        initTestimonialRotator();
        registerServiceWorker();
        initOfflineInvoiceDrafts();
    }, { once: true });
} else {
    initScrollReveal();
    initTestimonialRotator();
    registerServiceWorker();
    initOfflineInvoiceDrafts();
}

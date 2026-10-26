/**
 * Logika halaman pemilihan tiket dan checkout (Alpine.js).
 * Harga hanya untuk tampilan; total yang sah dihitung ulang di server.
 */
export default (tickets, storeUrl, eventId) => ({
    tickets,
    qty: Object.fromEntries(tickets.map((t) => [t.id, 0])),
    open: false,
    loading: false,
    error: "",

    get lines() {
        return this.tickets
            .filter((t) => this.qty[t.id] > 0)
            .map((t) => ({
                ...t,
                qty: this.qty[t.id],
                subtotal: t.price * this.qty[t.id],
            }));
    },

    get count() {
        return this.lines.reduce((sum, l) => sum + l.qty, 0);
    },

    get total() {
        return this.lines.reduce((sum, l) => sum + l.subtotal, 0);
    },

    rupiah(value) {
        return Number(value) === 0
            ? "Gratis"
            : "Rp " + Number(value).toLocaleString("id-ID");
    },

    step(ticket, delta) {
        const next = this.qty[ticket.id] + delta;
        this.qty[ticket.id] = Math.max(0, Math.min(ticket.max, next));
    },

    openCheckout() {
        this.error = "";
        this.open = true;
    },

    async submit() {
        if (this.loading || this.count === 0) return;

        this.loading = true;
        this.error = "";

        try {
            const response = await fetch(storeUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({
                    event_id: eventId,
                    items: this.lines.map((l) => ({
                        tiket_id: l.id,
                        jumlah: l.qty,
                    })),
                }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                this.error = data.errors
                    ? Object.values(data.errors).flat()[0]
                    : data.message ||
                      "Pesanan belum bisa diproses. Coba lagi sebentar lagi.";
                return;
            }

            window.location.href = data.redirect;
        } catch (e) {
            this.error =
                "Koneksi terputus. Periksa internet kamu lalu coba lagi.";
        } finally {
            this.loading = false;
        }
    },
});

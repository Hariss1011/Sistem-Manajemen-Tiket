/**
 * Logika pemilihan tiket dan checkout BengTix.
 *
 * Catatan:
 * - Harga dan total pada frontend hanya untuk tampilan.
 * - Validasi stok, harga, dan transaksi wajib dilakukan ulang di server.
 * - Endpoint diharapkan mengembalikan JSON dengan properti `redirect`
 *   setelah pesanan berhasil dibuat.
 */

export default (tickets, storeUrl, eventId) => ({
    tickets: Array.isArray(tickets) ? tickets : [],
    storeUrl,
    eventId,

    qty: Object.fromEntries(
        (Array.isArray(tickets) ? tickets : []).map((ticket) => [ticket.id, 0]),
    ),

    open: false,
    loading: false,
    error: "",

    /**
     * Daftar tiket yang dipilih beserta subtotalnya.
     */
    get lines() {
        return this.tickets
            .filter((ticket) => Number(this.qty[ticket.id]) > 0)
            .map((ticket) => {
                const quantity = Number(this.qty[ticket.id]) || 0;

                return {
                    ...ticket,
                    qty: quantity,
                    subtotal: Number(ticket.price) * quantity,
                };
            });
    },

    /**
     * Total jumlah tiket.
     */
    get count() {
        return this.lines.reduce((sum, line) => sum + line.qty, 0);
    },

    /**
     * Total harga untuk tampilan frontend.
     */
    get total() {
        return this.lines.reduce((sum, line) => sum + line.subtotal, 0);
    },

    /**
     * Format angka menjadi mata uang Rupiah.
     */
    rupiah(value) {
        const amount = Number(value);

        if (!Number.isFinite(amount) || amount < 0) {
            return "Rp 0";
        }

        if (amount === 0) {
            return "Gratis";
        }

        return (
            "Rp " +
            amount.toLocaleString("id-ID", {
                maximumFractionDigits: 0,
            })
        );
    },

    /**
     * Mengubah jumlah tiket dengan batas stok dan batas pembelian.
     */
    step(ticket, delta) {
        if (!ticket || !this.tickets.some((item) => item.id === ticket.id)) {
            return;
        }

        const current = Number(this.qty[ticket.id]) || 0;
        const stock = Math.max(0, Number(ticket.stock) || 0);
        const maxPurchase = Math.max(0, Number(ticket.max) || 0);
        const limit = Math.min(stock, maxPurchase);

        const change = Number(delta);

        if (!Number.isFinite(change)) {
            return;
        }

        const next = current + change;

        this.qty[ticket.id] = Math.max(0, Math.min(limit, Math.trunc(next)));

        this.error = "";
    },

    /**
     * Membuka dialog konfirmasi jika ada tiket yang dipilih.
     */
    openCheckout() {
        if (this.loading) {
            return;
        }

        if (this.count <= 0) {
            this.error = "Pilih minimal satu tiket terlebih dahulu.";
            return;
        }

        this.error = "";
        this.open = true;
    },

    /**
     * Menangani error validasi Laravel.
     */
    getErrorMessage(data, status) {
        if (status === 419) {
            return "Sesi Anda telah kedaluwarsa. Muat ulang halaman, lalu coba kembali.";
        }

        if (status === 401) {
            return "Silakan masuk kembali sebelum melakukan pemesanan.";
        }

        if (status === 403) {
            return "Anda tidak memiliki izin untuk melakukan pemesanan ini.";
        }

        if (data?.errors && typeof data.errors === "object") {
            const messages = Object.values(data.errors).flat();
            const firstMessage = messages.find(
                (message) => typeof message === "string" && message.trim(),
            );

            if (firstMessage) {
                return firstMessage;
            }
        }

        if (typeof data?.message === "string" && data.message.trim()) {
            return data.message;
        }

        return "Pesanan belum dapat diproses. Silakan coba kembali.";
    },

    /**
     * Mengirim pesanan ke server.
     */
    async submit() {
        if (this.loading) {
            return;
        }

        if (this.count <= 0) {
            this.error = "Pilih minimal satu tiket terlebih dahulu.";
            return;
        }

        const csrfElement = document.querySelector('meta[name="csrf-token"]');

        const csrfToken = csrfElement?.content;

        if (!csrfToken) {
            this.error =
                "Token keamanan tidak ditemukan. Muat ulang halaman dan coba kembali.";
            return;
        }

        this.loading = true;
        this.error = "";

        try {
            const response = await fetch(this.storeUrl, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({
                    event_id: this.eventId,
                    items: this.lines.map((line) => ({
                        tiket_id: line.id,
                        jumlah: line.qty,
                    })),
                }),
            });

            let data = {};

            try {
                data = await response.json();
            } catch {
                data = {};
            }

            if (!response.ok) {
                this.error = this.getErrorMessage(data, response.status);
                return;
            }

            if (
                typeof data.redirect !== "string" ||
                data.redirect.trim() === ""
            ) {
                this.error =
                    "Pesanan mungkin telah diproses, tetapi alamat tujuan tidak diterima. Periksa daftar pesanan sebelum mencoba lagi.";
                return;
            }

            // Hanya izinkan redirect ke halaman pada origin yang sama.
            let redirectUrl;

            try {
                redirectUrl = new URL(data.redirect, window.location.origin);
            } catch {
                this.error = "Alamat tujuan pesanan tidak valid.";
                return;
            }

            if (redirectUrl.origin !== window.location.origin) {
                this.error = "Alamat tujuan pesanan tidak valid.";
                return;
            }

            window.location.assign(redirectUrl.href);
        } catch (error) {
            this.error =
                "Koneksi bermasalah. Periksa internet Anda, lalu coba kembali.";
        } finally {
            this.loading = false;
        }
    },
});

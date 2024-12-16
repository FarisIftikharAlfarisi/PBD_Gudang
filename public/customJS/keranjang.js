let pesanan = [];
let totalPembayaran = 0;

document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.getElementById("searchBar");
    const items = document.querySelectorAll(".item-card");

    // Event listener untuk pencarian
    searchBar.addEventListener("input", function () {
        const query = this.value.trim().toLowerCase(); // Cari dalam format lowercase
        items.forEach((item) => {
            const name = item.dataset.name.toLowerCase(); // Convert data-name ke lowercase untuk pencocokan
            const stock = item.dataset.stock;
            const price = item.dataset.price;
            const kodepart = item.dataset.kodepart.toLowerCase();

            // Menampilkan item jika nama barang cocok dengan query pencarian
            item.style.display =
                kodepart.includes(query) ||
                name.includes(query) ||
                stock.includes(query) ||
                price.includes(query)
                    ? "block"
                    : "none";
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.getElementById("searchBar");
    const items = document.querySelectorAll(".item-card");
    const listPesanan = document.getElementById("listPesanan");
    const totalPembayaranEl = document.getElementById("totalPembayaran");
    const modalBeli = new bootstrap.Modal(document.getElementById("modalBeli"));
    const confirmBeliBtn = document.getElementById("confirmBeli");
    const clearBeliBtn = document.getElementById("clearBeli");
    const barangIdInput = document.getElementById("barangId");
    const jumlahBeliInput = document.getElementById("jumlahBeli");

    document.querySelectorAll(".btn-beli").forEach((button) => {
        button.addEventListener("click", function () {
            const barangId = this.getAttribute("data-id");
            barangIdInput.value = barangId;
            jumlahBeliInput.value = 1;
        });
    });

    confirmBeliBtn.addEventListener("click", () => {
        const barangId = barangIdInput.value;
        const jumlahBeli = parseInt(jumlahBeliInput.value);
        const barangEl = document.querySelector(
            `.item-card[data-id="${barangId}"]`
        );
        const barangName = barangEl.dataset.name;
        const hargaBarang = parseInt(barangEl.dataset.price);

        tambahKePesanan(barangId, barangName, hargaBarang, jumlahBeli);
        modalBeli.hide();
    });

    function tambahKePesanan(barangId, barangName, hargaBarang, jumlahBeli) {
        const existingItem = pesanan.find((item) => item.id === barangId);

        if (existingItem) {
            existingItem.jumlah += jumlahBeli;
            existingItem.subTotal += hargaBarang * jumlahBeli;
        } else {
            pesanan.push({
                id: barangId,
                name: barangName,
                jumlah: jumlahBeli,
                harga: hargaBarang,
                subTotal: hargaBarang * jumlahBeli,
            });
        }

        renderPesanan();
    }

    function renderPesanan() {
        listPesanan.innerHTML = ""; // Kosongkan daftar pesanan
        totalPembayaran = 0;

        pesanan.forEach((item, index) => {
            const li = document.createElement("li");
            li.className =
                "list-group-item d-flex justify-content-between align-items-center";

            // Konten daftar pesanan dengan input diskon
            li.innerHTML = `
                <div>
                    ${item.name}<br>
                    ${item.jumlah} x
                    <span class="harga-bersih" data-index="${index}">
                        ${(item.diskon
                            ? item.harga - item.diskon
                            : item.harga
                        ).toLocaleString("id-ID")}
                    </span>
                    = <span class="harga-subtotal" data-index="${index}">
                        ${item.subTotal.toLocaleString("id-ID")}
                       </span>
                </div>
                <div>
                    <p>Diskon (Rp)</p>
                    <input type="number" class="form-control d-inline-block"
                           value="${item.diskon}"
                           data-index="${index}" />
                </div>
                <button class="btn btn-danger btn-sm" data-index="${index}">
                    <i class="bi bi-trash3"></i>
                </button>
            `;

            listPesanan.appendChild(li);

            totalPembayaran += item.subTotal;
        });

        totalPembayaranEl.innerText = `Rp ${totalPembayaran.toLocaleString(
            "id-ID"
        )}`;

        // Event listener untuk input diskon
        document.querySelectorAll('input[type="number"]').forEach((input) => {
            input.addEventListener("input", function () {
                const index = parseInt(this.getAttribute("data-index"));
                const diskonBaru = parseInt(this.value) || 0;

                // Update diskon, harga bersih, dan subtotal
                pesanan[index].diskon = diskonBaru;
                pesanan[index].subTotal =
                    (pesanan[index].harga - diskonBaru) * pesanan[index].jumlah;

                // Update hanya harga bersih dan subtotal di DOM
                updateHargaDOM(index);
            });
        });

        // Event listener untuk tombol hapus
        document.querySelectorAll(".btn-danger").forEach((button) => {
            button.addEventListener("click", function () {
                const index = parseInt(this.getAttribute("data-index"));
                hapusDariPesanan(index);
            });
        });
    }

    // Fungsi untuk mengupdate harga bersih dan subtotal di DOM
    function updateHargaDOM(index) {
        const item = pesanan[index];

        // Update harga bersih
        const hargaBersihEl = document.querySelector(
            `.harga-bersih[data-index="${index}"]`
        );
        hargaBersihEl.innerText = (item.harga - item.diskon).toLocaleString(
            "id-ID"
        );

        // Update subtotal
        const hargaSubtotalEl = document.querySelector(
            `.harga-subtotal[data-index="${index}"]`
        );
        hargaSubtotalEl.innerText = item.subTotal.toLocaleString("id-ID");

        // Hitung ulang total pembayaran
        totalPembayaran = pesanan.reduce((sum, item) => sum + item.subTotal, 0);
        totalPembayaranEl.innerText = `Rp ${totalPembayaran.toLocaleString(
            "id-ID"
        )}`;
    }

    function hapusDariPesanan(index) {
        pesanan.splice(index, 1); // Hapus item berdasarkan indeks
        renderPesanan(); // Render ulang daftar pesanan
    }

    const submitPesananBtn = document.getElementById("submitPesanan");

    submitPesananBtn.addEventListener("click", () => {
        if (pesanan.length === 0) {
            alert("Tidak ada pesanan untuk dikonfirmasi.");
            return;
        }

        // Ambil elemen input customer
        const inputPesanan = document.getElementById("inputPesanan");
        const inputTotalPembayaran = document.getElementById(
            "inputTotalPembayaran"
        );
        const inputCustomer = document.getElementById("inputCustomer");

        // Ambil data customer dari form
        const pelangganTetap = document.getElementById("loyalCustomer");
        const namaPelanggan = document.getElementById("namaPelanggan");
        const telpPelanggan = document.getElementById("telpPelanggan");

        let customerData = {};
        if(!pelangganTetap && !namaPelanggan && !telpPelanggan){
            // jika kedua checkbox tidak dipilih
            customerData = {
                type: "PelangganBiasa",
            }
        }
        else if (pelangganTetap && pelangganTetap.value) {
            // Jika pelanggan tetap dipilih
            customerData = {
                type: "PelangganTetap",
                id: pelangganTetap.value,
            };
        } else if (namaPelanggan && telpPelanggan) {
            // Jika pelanggan baru diisi
            customerData = {
                type: "PelangganBaru",
                nama: namaPelanggan.value,
                telepon: telpPelanggan.value,
            };
        } else {
            alert("Harap lengkapi data customer.");
            return;
        }

        // Isi data pesanan dan customer ke dalam input tersembunyi
        inputPesanan.value = JSON.stringify(pesanan);
        inputTotalPembayaran.value = totalPembayaran;
        inputCustomer.value = JSON.stringify(customerData);

        // Submit form ke server
        const form = document.getElementById("formPesanan");
        form.submit();
    });
});

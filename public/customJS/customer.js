document.addEventListener("DOMContentLoaded", () => {
    const pelangganTetap = document.getElementById("PelangganTetap");
    const pelangganBaru = document.getElementById("PelangganBaru");
    const showLoyalCustSelect = document.getElementById("showLoyalCustSelect");
    const formNewCustomer = document.getElementById("showFormNewCustomer");

    // Menangani event ketika "Pelanggan Tetap" dipilih
    pelangganTetap.addEventListener("change", function () {
        if (this.checked) {
            pelangganBaru.disabled = true;

            // Fetch data pelanggan tetap dari route
            fetch("/get-loyal-customer")
                .then((response) => response.json()) // Konversi response ke JSON
                .then((data) => {
                    // Membuat elemen <select> dan mengisi data dari server
                    let selectHTML = `
                    <label for="loyalCustomer">Pilih Pelanggan Tetap:</label>
                    <select id="loyalCustomer" name="loyalCustomer" class="form-control">
                        <option value="">-- Pilih Pelanggan --</option>
                `;

                    // Looping data pelanggan tetap dan menambahkan ke <option>
                    data.forEach((customer) => {
                        selectHTML += `
                        <option value="${customer.id}">${customer.Nama_Pelanggan}</option>
                    `;
                    });

                    selectHTML += `</select>`; // Menutup tag select

                    // Menambahkan form select ke dalam div
                    showLoyalCustSelect.innerHTML = selectHTML;
                })
                .catch((error) => {
                    console.error(
                        "Error fetching data pelanggan tetap:",
                        error
                    );
                    showLoyalCustSelect.innerHTML =
                        "<p>Error memuat data pelanggan.</p>";
                });
        } else {
            pelangganBaru.disabled = false; // Mengaktifkan kembali opsi pelanggan baru
            showLoyalCustSelect.innerHTML = ""; // Menghapus form select
        }
    });

    // Fungsi menampilkan form pelanggan baru
    pelangganBaru.addEventListener("change", function () {
        if (this.checked) {
            pelangganTetap.disabled = true;
            formNewCustomer.innerHTML = `
                <div class="mt-3">
                    <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" id="namaPelanggan" name="namaPelanggan" class="form-control" placeholder="Masukkan nama pelanggan">

                    <label for="telpPelanggan" class="form-label mt-2">Nomor Telepon</label>
                    <input type="tel" id="telpPelanggan" name="telpPelanggan" class="form-control" placeholder="Masukkan nomor telepon">
                </div>
            `;
        } else {
            pelangganTetap.disabled = false;
            formNewCustomer.innerHTML = ""; // Kosongkan form jika checkbox di-uncheck
        }
    });

    // Menonaktifkan "Pelanggan Baru" jika "Pelanggan Tetap" dipilih
    pelangganTetap.addEventListener("change", function () {
        if (this.checked) {
            pelangganBaru.disabled = true;
            formNewCustomer.innerHTML = ""; // Pastikan form pelanggan baru hilang
        } else {
            pelangganBaru.disabled = false;
        }
    });
});

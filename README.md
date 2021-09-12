# Soal 1

## Flow  
Untuk flow bisnis dari aplikasi restoran ini adalah dengan menyediakan smartphone pada masing - masing table (meja) tempat customer makan. dan aplikasi restoran ini sudah terhubung dengan bagian aplikasi di dapur.  
- Customer memesan makanan. Order Status : booking
- Chef membuat masakan. Order Status : processed
- Chef selesai memasak dan waiter mengantar ke customer, jika pesanan lengkap status menjadi selesai / done. Order Status : done
- Jika ada penambahan menu maka customer mengupdate melalui aplikasi menu yang ingin ditambah. Maka flow kembali dari step awal
- Setelah selesai maka customer dapat membayar dengan berbagai macam metode pembayaran

## Skema Database 

![alt text](https://github.com/romascudeto/test-loyalto/blob/master/db-loyalto.png)

Keterangan :  
### m_category_menu  
Table untuk mengkategorikan menu makanan / minuman. contoh : Makanan, Minuman, Snack, dsb

### m_menu  
Table untuk menu makanan / minuman beserta harga dan . contoh : Nasi Goreng / Rp 30.000, Mie Goreng / Rp 25.000  

### m_payment_category  
Table untuk mengkategorikan pembayaran. contoh : Cash, E-Wallet, Credit Card, Debit Card, dsb

### m_payment  
Table untuk jenis pembayaran . contoh : Cash, OVO, GoPay, Credit Card Citibank, Debit Card BCA, dsb

### m_waiter  
Table untuk pegawai yang melayani

### m_customer  
Table untuk customer, default 0 untuk guest / tamu tanpa nama

### t_order  
Table untuk informasi order dari customer, semua data yang memiliki relasi dengan table lain, datanya ikut dimasukan ke table order ini (denormalisasi). misalnya data cust_name, data pembayarannya. Di table ini juga terdapat status yang menunjukkan progress dari order, seperti "booking", "processed", "done". Juga terdapat status untuk cetak struk melalui print_status.

### t_order_items  
Table untuk detail transaksi dari order berupa list menu yang di pesan oleh customer berikut quantitynya.

## Skema Teknologi  





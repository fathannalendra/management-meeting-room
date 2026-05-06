Meeting Room Management App

Aplikasi sederhana untuk manajemen pemesanan ruang meeting berbasis web.

Project ini dibuatdengan fokus pada penyelesaian masalah, struktur kode yang rapi, validasi jadwal, dan fitur pendukung untuk memudahkan pengecekan ketersediaan ruangan.

---

1. Tech Stack

- PHP
- CodeIgniter 3
- MySQL / MariaDB
- Bootstrap 5
- DataTables
- jQuery

---

2.Features

#1. Booking Meeting Room
User dapat membuat booking ruang meeting dengan mengisi:
- Ruangan
- Nama pemesan
- Tanggal meeting
- Jam mulai
- Jam selesai
- Agenda meeting

#2. Setiap ruangan memiliki informasi:
- Nama ruangan
- Kapasitas ruangan
- Fasilitas ruangan

#3. User dapat mengecek apakah ruangan tersedia pada tanggal dan jam tertentu sebelum melakukan booking.

#4. Sistem akan menolak booking jika jadwal bentrok dengan booking lain pada ruangan yang sama.

Contoh:
- Booking lama: 10:00 - 11:00
- Booking baru: 10:30 - 11:30

Maka sistem akan menolak booking baru karena jadwal sama.

#5. Aplikasi menampilkan meeting yang sedang berlangsung pada hari ini berdasarkan waktu saat ini.

#6. User dapat mengubah data booking selama meeting belum dimulai.

#7.Booking tidak dapat diedit jika jadwal meeting sudah dimulai atau sudah lewat.

#8. Data booking tidak dihapus permanen dari database. Sistem hanya mengubah status `is_delete` menjadi `1`.
Tujuannya agar data historis tetap tersimpan untuk kebutuhan audit atau tracking.

#9. DataTables Integration
List booking menggunakan DataTables sehingga mendukung:
- Search
- Pagination
- Sorting
- Show entries

•	Meeting Room Management App

Aplikasi sederhana untuk manajemen pemesanan ruang meeting berbasis web menggunakan CodeIgniter 3.

•	Tech Stack :
- PHP
- CodeIgniter 3
- MySQL / MariaDB
- Bootstrap 5
- DataTables
- jQuery

•	Features

1.	Booking Meeting Room :
User dapat membuat booking ruang meeting dengan mengisi:
- Ruangan
- Nama pemesan
- Tanggal meeting
- Jam mulai
- Jam selesai
- Agenda meeting

2.	Room List with Capacity :
Setiap ruangan memiliki informasi:
- Nama ruangan
- Kapasitas ruangan
- Fasilitas ruangan

3.	Check Room Availability :
User dapat mengecek apakah ruangan tersedia pada tanggal dan jam tertentu sebelum melakukan booking.

4.	Schedule Conflict Validation :
Sistem akan menolak booking jika jadwal bentrok dengan booking lain pada ruangan yang sama.

Contoh:
- Booking lama: 10:00 - 11:00
- Booking baru: 10:30 - 11:30

Maka sistem akan menolak booking baru karena jadwal sama.

5.	Ongoing Meeting Today :
Aplikasi menampilkan meeting yang sedang berlangsung pada hari ini berdasarkan waktu saat ini.

6.	Edit Booking :
User dapat mengubah data booking selama meeting belum dimulai.

7.	Locked Past / Started Meeting :
Booking tidak dapat diedit jika jadwal meeting sudah dimulai atau sudah lewat.

8.	Soft Delete :
Data booking tidak dihapus permanen dari database. Sistem hanya mengubah status `is_delete` menjadi `1`.

Tujuannya agar data historis tetap tersimpan untuk kebutuhan audit atau tracking.

9.	DataTables Integration :
List booking menggunakan DataTables sehingga mendukung:
- Search
- Pagination
- Sorting
- Show entries

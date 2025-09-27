Dokumentasi ini menjelaskan standar foldering untuk file **Blade Template** pada proyek Laravel.  
Tujuannya agar kode lebih terorganisir, mudah dikelola, dan konsisten di seluruh fitur.

---
Di dalamnya, folder dibagi berdasarkan **fungsionalitas (fitur)**.  
Setiap fitur memiliki folder sendiri yang berisi:

- **Fiturexample/** → Tampilan yang di include pada index
|   - **index.blade.php** → Tampilan utama/daftar
|   - **example.blade.php** → Tampilan yang di include pada index
|   - **example.blade.php** → Tampilan yang di include pada index
|   - **example.blade.php** → Tampilan yang di include pada index
|   - **modals/** → File modal yang hanya dipakai di fitur tersebut
   |   - **create.blade.php** → Form tambah data
   |   - **edit.blade.php** → Form edit data
   |   - **show.blade.php** → Tampilan detai
   <!-- jika mengggunakan halaman tersendiri (tidak menggunakan modal) maka harus di masukan kedalam folder manage -->
   - **manage/** → File modal yang hanya dipakai di fitur tersebut
   |   - **create.blade.php** → Form tambah data
   |   - **edit.blade.php** → Form edit data
   |   - **show.blade.php** → Tampilan detail



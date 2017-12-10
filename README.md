POS Tagger Bahasa Indonesia

Program ini merupakan program pemberian Part Of Speech (POS) tag pada suatu kalimat bahasa Indonesia secara otomatis.
Corpus yang digunakan terdiri dari 1 juta kalimat Bahasa Indonesia, didapat dari (<a href="http://www.panl10n.net/english/outputs/Indonesia/UI/0802/UI-1M-tagged.zip
">LINK</a>)


Cara penggunaan :
1. Clone repository ini menggunakan Git
	command : git clone https://github.com/6miramira/POS-Tagger-Bahasa-Indonesia.git
	
2. Ubah config base_url pada application/config/config > base_url tempat menyimpan di htdocs

3. Gunakan apache / xampp, kemudian buka localhost/apache anda di url browser. Contoh : http://localhost/pos_tag/index.php


I/O Testing
   - Input satu kalimat bahasa Indonesia, baik diakhiri maupun tidak diakhiri tanda baca titik (.).
   - Output berupa kalimat masukan beserta POS Tag untuk setiap katanya.
   - Selamat mencoba!
   - Please tell me if something wrong.
   
   
   
Note :
   - Bisa menggunakan corpus lain dengan format seperti berikut:
       [kata] [tag]
       [kata] [tag]

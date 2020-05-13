
#  Grabber Covid19-Sidoarjo


Service App ini saya dedikasikan untuk tempat kelahiran saya, Kab. Sidoarjo.
Mengingat website [covid19.sidoarjokab.go.id](https://covid19.sidoarjokab.go.id) ini belum memiliki Documentation API.saya berinisiatif membuat Service app untuk websie ini, sekaligus membuat dokumentasi yang memudahkan developer untuk menggunakan service ini.

  
  

##  Cara Install pada server sendiri.

- Copy github ini dengan perintah `git clone https://github.com/madebyaris/covid19-sidoarjo.git`

- kemudian jalankan perintah composer `composer install`, bila anda belum mengintall composer, anda dapat kesini(https://getcomposer.org/doc/00-intro.md).

- kemudian pergi ke browser dan ketik {url-domain-ip-anda}/process-data-covid.php

- masuk ke folder json, dan anda akan mendapatkan hasil dari grabbing data.

  
  

##  Cara Menggunakan

Kalian dapat menggunakanya tanpa perlu menginstall pada server kalian sendiri, cukup pergi ke
https://covid19-sidoarjo.herokuapp.com/ Ini adalah website yang saya sediakan untuk kalian pelajari.
Mohon untuk tidak melakukan abuse pada proses data, untuk menjaga agar website ini berjalan dengan baik.

  

Cara untuk mendapatkan data json :
- https://covid19-sidoarjo.herokuapp.com/json/kecamatan.json <- Mengamil total semua kecamatan
- https://covid19-sidoarjo.herokuapp.com/json/{nama-kecamatan}.json <- Mengambil total dari kecamatan terkait.

  

###  List Kecamatan di Sidoarjo :

- sidoarjo

- buduran

- candi

- gedangan

- tanggulangin

- porong

- jabon

- taman

- krembung

- wonoayu

- tulangan

- krian

- prambon

- sukodono

- sedati

- waru

- balongbendo

- tarik

- luar-wilayah

- tanpa-wilayah

  

#  Disclaimer

Saya sangat menyarankan untuk mengganti nama file dari `process-data-covid.php` menjadi nama file yang sulit diakses, misal : `NooB69-process.php` dan lainya, untuk menghindari abusive resource dari orang yang tidak bertanggung jawab.

Semua data merupakan data dari [covid19.sidoarjokab.go.id](https://covid19.sidoarjokab.go.id/), adanya perbedaan data yang ditampilkan dengan data nasional, saya tidak bertanggung jawab.

  
  

#  UP NEXT

- Membuat route mode dengan contoh {nama-domain}/kecamatan/{nama-kecamatan}

- Membuat keamanan dan optimasi kode.

	- Buat simple password / secret code untuk process-data-covid.php

	- Optimasi dan mempercantik kode.

- Menambah data untuk kelengkapan covid19.

  
  

#  Copyright

https://Madebyaris.com(https://Madebyaris.com)
Contact me via arissetia.m@gmail.com
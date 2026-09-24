function pilihKamar(namaKamar) {
    document.getElementById('kamarPilihan').value = namaKamar;
    document.getElementById('reservasi').scrollIntoView({ behavior: 'smooth' });
}
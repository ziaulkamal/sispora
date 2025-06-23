document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', function () {
      let val = input.value;

      // ONLYNUMBER: hanya angka 0-9
      if (input.classList.contains('onlynumber')) {
        val = val.replace(/[^0-9]/g, '');
      }

      // NUMBER: angka + 1 titik, titik tidak di awal
      if (input.classList.contains('number')) {
        // Hapus semua karakter selain angka dan titik
        val = val.replace(/[^0-9.]/g, '');

        // Hilangkan semua titik kecuali yang pertama
        let parts = val.split('.');
        if (parts.length > 1) {
          val = parts[0] + '.' + parts.slice(1).join('');
        }

        // Cegah titik di awal (contoh: ".123" => "123")
        if (val.startsWith('.')) {
          val = val.substring(1);
        }
      }

      // MAXCHAR: batasi jumlah karakter
      const maxCharClass = Array.from(input.classList).find(cls => cls.startsWith('maxchar-'));
      if (maxCharClass) {
        const maxChar = parseInt(maxCharClass.split('-')[1]);
        if (!isNaN(maxChar)) {
          val = val.substring(0, maxChar);
        }
      }

      input.value = val;
    });
  });
});

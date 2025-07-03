// File: peruntukanSelect.js

/**
 * Memuat opsi Peruntukan ke dalam elemen <select id="peruntukan">
 */
function loadPeruntukanOptions() {
    const $select = $('#peruntukan');
    if (!$select.length) return;

    $.ajax({
        url: '/web/probabilities',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $select.empty().append('<option value="">-- Pilih Peruntukan --</option>');
            data.forEach(function (item) {
                $select.append(
                    $('<option>', {
                        value: item.id,
                        text: item.label
                    })
                );
            });
        }
    });
}

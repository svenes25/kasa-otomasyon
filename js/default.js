$(document).ready(function() {
	$('#slide').owlCarousel({
		loop: false,
		dots: true,
		responsiveClass:true,
		responsive:{
			400:{
				items:1,
			},
			700:{
				items:2,
			},
			1000:{
				items:3,
			}
		}
	});
});
$(document).ready(function() {
    $('#mesaiForm').on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting the traditional way
        $.ajax({
            type: 'POST',
            url: '', // Same URL to handle the POST request
            data: $(this).serialize(), // Serialize form data
            success: function(response) {
                let res = JSON.parse(response);
                if(res.durum == 1) {
                    $('.btn.m').text('Mesai Bitir');
                } else {
                    $('.btn.m').text('Mesai Başlat');
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    });
});
$(document).ready(function() {
    $('#filtreleButton2').click(function() {
        var filtreIndex = $('#filtre').val();
        $.ajax({
            url: 'filter_analiz.php',
            type: 'POST',
            data: { index: filtreIndex },
            success: function(response) {
                $('#productDetails2').html(response);
            },
            error: function() {
                $('#productDetails2').html('<div class="alert alert-danger">Bir hata oluştu.</div>');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    showSection('analiz');

    // Tüm link elemanlarını al
    var links = document.querySelectorAll('.sidebar');

    // Her bir link için tıklama olayı ekle
    links.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            // Linkin data-section özelliğini al
            var section = link.getAttribute('data-section');
            showSection(section);
        });
    });

    function showSection(section) {
        // Tüm bölümleri gizle
        var sections = document.querySelectorAll('.panel > div');
        sections.forEach(function(sec) {
            sec.style.display = 'none';
        });

        // İlgili bölümü göster
        var activeSection = document.querySelector('.' + section);
        if (activeSection) {
            activeSection.style.display = 'block';
        }
    }
});
$(document).ready(function() {
    $('#filtreleButton').click(function() {
        var urunID = $('#urun').val();
        $.ajax({
            url: 'filter_products.php',
            type: 'POST',
            data: { urun: urunID },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.error) {
                    $('#productDetails').html('<div class="alert alert-danger">' + data.error + '</div>');
                } else {
                    var html = '<form method="POST" enctype="multipart/form-data">';
                    html += '<input type="text" value="' + data.isim + '" name="gisim">';
                    html += '<input type="number" value="' + data.fiyat + '" min="1" name="gfiyat">';
                    html += '<input type="file" name="resim">';
                    html += '<input type="hidden" value="' + urunID + '" name="urun">';
                    html += '<input type="submit" value="Güncelle" name="guncelle">';
                    html += '</form>';
                    $('#productDetails').html(html);
                }
            },
            error: function() {
                $('#productDetails').html('<div class="alert alert-danger">Bir hata oluştu.</div>');
            }
        });
    });
});
$(document).ready(function() {
    $('#filtreleButton2').click(function() {
        var filtreIndex = $('#filtre').val();
        $.ajax({
            url: 'filter_analiz.php',
            type: 'POST',
            data: { index: filtreIndex },
            success: function(response) {
                $('#productDetails2').html(response);
            },
            error: function() {
                $('#productDetails2').html('<div class="alert alert-danger">Bir hata oluştu.</div>');
            }
        });
    });
});
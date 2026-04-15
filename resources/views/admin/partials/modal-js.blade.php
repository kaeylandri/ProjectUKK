<script>
function bukaModal(id) {
    var d = aspirasi[id];
    if (!d) { console.error('Data tidak ditemukan:', id); return; }

    document.getElementById('m-d-nama').textContent      = d.nama;
    document.getElementById('m-d-kelas').textContent     = d.kelas;
    document.getElementById('m-d-kategori').textContent  = d.kategori;
    document.getElementById('m-d-lokasi').textContent    = d.lokasi;
    document.getElementById('m-d-deskripsi').textContent = d.deskripsi;
    document.getElementById('m-d-prioritas').textContent = d.prioritas;
    document.getElementById('m-d-tanggal').textContent   = d.tanggal;

    document.getElementById('formUmpanBalik').action = '/admin/aspirasi/' + id;
    document.getElementById('m-status').value = d.status;

    var fotoWrap = document.getElementById('m-foto-wrap');
    var fotoImg  = document.getElementById('m-foto-img');
    var fotoLink = document.getElementById('m-foto-tab-link');
    if (d.foto && d.foto.trim() !== '') {
        fotoImg.src   = d.foto;
        fotoLink.href = d.foto;
        document.getElementById('fs-foto-link').href = d.foto;
        fotoWrap.style.display = 'block';
    } else {
        fotoWrap.style.display = 'none';
        fotoImg.src = '';
    }

    var prevWrap = document.getElementById('m-prev-wrap');
    if (d.umpanBalik && d.umpanBalik.trim() !== '') {
        document.getElementById('m-prev-petugas').textContent = 'Petugas: ' + (d.petugas || '-');
        document.getElementById('m-prev-ub').textContent      = d.umpanBalik;
        document.getElementById('m-petugas').value            = d.petugas || '';
        document.getElementById('m-umpan-balik').value        = d.umpanBalik;
        prevWrap.style.display = 'block';
    } else {
        prevWrap.style.display = 'none';
        document.getElementById('m-petugas').value     = '';
        document.getElementById('m-umpan-balik').value = '';
    }

    var overlay = document.getElementById('modalOverlay');
    overlay.classList.add('open');
    overlay.scrollTop = 0;
}

function tutupModal() {
    document.getElementById('modalOverlay').classList.remove('open');
}

function kirimUmpanBalik() {
    var p = document.getElementById('m-petugas').value.trim();
    var u = document.getElementById('m-umpan-balik').value.trim();
    if (!p) { alert('Nama petugas wajib diisi!'); document.getElementById('m-petugas').focus(); return; }
    if (u.length < 10) { alert('Umpan balik minimal 10 karakter!'); document.getElementById('m-umpan-balik').focus(); return; }
    document.getElementById('formUmpanBalik').submit();
}

function bukaFoto(url) {
    document.getElementById('fs-foto-img').src  = url;
    document.getElementById('fs-foto-link').href = url;
    document.getElementById('modalFotoFS').classList.add('open');
}

function perbesarFoto() {
    var src = document.getElementById('m-foto-img').src;
    if (src && src !== window.location.href) bukaFoto(src);
}

function tutupFotoFS() {
    document.getElementById('modalFotoFS').classList.remove('open');
}

document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});
document.getElementById('modalFotoFS').addEventListener('click', function(e) {
    if (e.target === this) tutupFotoFS();
});
document.addEventListener('keydown', function(e) {
    if (e.key !== 'Escape') return;
    if (document.getElementById('modalFotoFS').classList.contains('open')) {
        tutupFotoFS();
    } else {
        tutupModal();
    }
});
</script>

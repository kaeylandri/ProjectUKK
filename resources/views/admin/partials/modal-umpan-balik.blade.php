{{-- Modal Umpan Balik --}}
<div id="modalOverlay" class="modal-overlay">
  <div class="modal-box">
    <div class="modal-head">
      <h3>Detail &amp; Umpan Balik Pengaduan</h3>
      <button class="modal-close" onclick="tutupModal()">&#x2715;</button>
    </div>
    <div class="modal-body">

      {{-- Tabel detail --}}
      <table class="detail-table">
        <tr class="detail-head"><td colspan="2">Detail Aspirasi</td></tr>
        <tr><td>Nama Siswa</td> <td id="m-d-nama"></td></tr>
        <tr><td>Kelas</td>      <td id="m-d-kelas"></td></tr>
        <tr><td>Kategori</td>   <td id="m-d-kategori"></td></tr>
        <tr><td>Lokasi</td>     <td id="m-d-lokasi"></td></tr>
        <tr><td style="vertical-align:top;">Deskripsi</td>
            <td id="m-d-deskripsi" style="white-space:pre-wrap;line-height:1.5;"></td></tr>
        <tr><td>Prioritas</td>  <td id="m-d-prioritas"></td></tr>
        <tr><td>Tanggal</td>    <td id="m-d-tanggal"></td></tr>
      </table>

      {{-- Foto Bukti --}}
      <div id="m-foto-wrap" class="foto-wrap" style="display:none;">
        <div class="foto-head">
          <span>&#128247; Foto Bukti dari Siswa</span>
          <div class="foto-actions">
            <button onclick="perbesarFoto()" class="btn btn-primary btn-sm">&#128269; Perbesar</button>
            <a id="m-foto-tab-link" href="#" target="_blank"
               onclick="event.stopPropagation()" class="btn btn-sm">&#128279; Tab Baru</a>
          </div>
        </div>
        <div class="foto-body" onclick="perbesarFoto()">
          <img id="m-foto-img" src="" alt="Foto Bukti" title="Klik untuk perbesar">
        </div>
        <div class="foto-hint">Klik foto untuk melihat ukuran penuh</div>
      </div>

      {{-- Umpan balik sebelumnya --}}
      <div id="m-prev-wrap"
           style="display:none;background:#f0fdf4;border:1px solid #bbf7d0;
                  border-radius:8px;padding:.65rem .9rem;margin-bottom:.9rem;">
        <div style="font-size:.72rem;font-weight:600;color:#166534;
                    text-transform:uppercase;letter-spacing:.04em;margin-bottom:.35rem;">
          &#10003; Umpan Balik Sebelumnya
        </div>
        <div id="m-prev-petugas" style="font-size:.78rem;color:#166534;margin-bottom:.2rem;font-weight:500;"></div>
        <div id="m-prev-ub" style="font-size:.83rem;color:#1e293b;"></div>
      </div>

      {{-- Form --}}
      <form id="formUmpanBalik" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
          <label>Status Penyelesaian <span class="req">*</span></label>
          <select id="m-status" name="status">
            <option value="menunggu">Menunggu</option>
            <option value="diproses">Sedang Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="ditolak">Ditolak</option>
          </select>
        </div>
        <div class="form-group">
          <label>Nama Petugas <span class="req">*</span></label>
          <input type="text" id="m-petugas" name="petugas" placeholder="Nama petugas yang menangani">
        </div>
        <div class="form-group">
          <label>Umpan Balik / Keterangan <span class="req">*</span></label>
          <textarea id="m-umpan-balik" name="umpan_balik" rows="4"
            placeholder="Tuliskan umpan balik atau langkah penanganan..."></textarea>
          <div class="hint">Minimal 10 karakter.</div>
        </div>
      </form>
    </div>
    <div class="modal-foot">
      <button class="btn" onclick="tutupModal()">Batal</button>
      <button class="btn btn-success" onclick="kirimUmpanBalik()">&#10003; Simpan</button>
    </div>
  </div>
</div>

{{-- Foto Fullscreen --}}
<div id="modalFotoFS" class="foto-fs" onclick="tutupFotoFS()">
  <div class="foto-fs-ctrl">
    <a id="fs-foto-link" href="#" target="_blank" onclick="event.stopPropagation()" class="btn btn-sm"
       style="background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.2);">
      &#128279; Buka Tab Baru
    </a>
    <button onclick="tutupFotoFS()" class="btn btn-sm"
            style="background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.2);">
      &#x2715; Tutup
    </button>
  </div>
  <img id="fs-foto-img" src="" alt="Foto" onclick="event.stopPropagation()">
  <p>Tekan ESC atau klik area gelap untuk menutup</p>
</div>

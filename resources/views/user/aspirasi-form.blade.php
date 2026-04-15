@extends('layouts.user')
@section('title','Buat Pengaduan')

@section('content')
<div class="page-header">
    <h1>Buat Pengaduan Baru</h1>
    <p>Nama: <strong>{{ auth()->user()->name }}</strong> &nbsp;&middot;&nbsp; Kelas: <strong>{{ auth()->user()->kelas ?? '-' }}</strong></p>
</div>

@if($errors->any())
<div class="alert-er">
    <span>&#9888;</span>
    <ul style="padding-left:1rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="card" style="max-width:700px;">
    <div class="card-head"><h2>Formulir Pengaduan Sarana</h2></div>
    <div class="card-body">
        <form action="{{ route('user.aspirasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-label">Detail Sarana</div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kategori Sarana <span class="req">*</span></label>
                    <select name="kategori_sarana">
                        <option value="">— Pilih Kategori —</option>
                        <optgroup label="Ruangan">
                            <option value="Ruang Kelas"          {{ old('kategori_sarana')=='Ruang Kelas'?'selected':'' }}>Ruang Kelas</option>
                            <option value="Laboratorium"         {{ old('kategori_sarana')=='Laboratorium'?'selected':'' }}>Laboratorium</option>
                            <option value="Perpustakaan"         {{ old('kategori_sarana')=='Perpustakaan'?'selected':'' }}>Perpustakaan</option>
                            <option value="Toilet / Kamar Mandi" {{ old('kategori_sarana')=='Toilet / Kamar Mandi'?'selected':'' }}>Toilet / Kamar Mandi</option>
                            <option value="Kantin"               {{ old('kategori_sarana')=='Kantin'?'selected':'' }}>Kantin</option>
                            <option value="Aula / Gedung Serbaguna" {{ old('kategori_sarana')=='Aula / Gedung Serbaguna'?'selected':'' }}>Aula / Gedung Serbaguna</option>
                        </optgroup>
                        <optgroup label="Peralatan">
                            <option value="Meja & Kursi"         {{ old('kategori_sarana')=='Meja & Kursi'?'selected':'' }}>Meja &amp; Kursi</option>
                            <option value="Papan Tulis"          {{ old('kategori_sarana')=='Papan Tulis'?'selected':'' }}>Papan Tulis</option>
                            <option value="Proyektor / LCD"      {{ old('kategori_sarana')=='Proyektor / LCD'?'selected':'' }}>Proyektor / LCD</option>
                            <option value="Komputer"             {{ old('kategori_sarana')=='Komputer'?'selected':'' }}>Komputer</option>
                            <option value="AC / Kipas Angin"     {{ old('kategori_sarana')=='AC / Kipas Angin'?'selected':'' }}>AC / Kipas Angin</option>
                        </optgroup>
                        <optgroup label="Fasilitas Luar">
                            <option value="Lapangan Olahraga"    {{ old('kategori_sarana')=='Lapangan Olahraga'?'selected':'' }}>Lapangan Olahraga</option>
                            <option value="Taman / Lingkungan"   {{ old('kategori_sarana')=='Taman / Lingkungan'?'selected':'' }}>Taman / Lingkungan</option>
                            <option value="Parkir"               {{ old('kategori_sarana')=='Parkir'?'selected':'' }}>Parkir</option>
                        </optgroup>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('kategori_sarana')<div class="err-msg">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Lokasi / Nomor Ruangan <span class="req">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="cth: Ruang XII RPL 1, Gedung A Lt.2">
                    @error('lokasi')<div class="err-msg">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Masalah <span class="req">*</span></label>
                <textarea name="deskripsi" rows="4" id="deskripsi"
                    placeholder="Jelaskan kondisi kerusakan atau masalah secara detail...">{{ old('deskripsi') }}</textarea>
                <div class="hint" id="charHint">Minimal 20 karakter.</div>
                @error('deskripsi')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            
            <div class="form-group">
                <label>Foto Bukti <span style="font-weight:400;color:#94a3b8;">(opsional)</span></label>
                <input type="file" name="foto" id="fotoInput" accept="image/jpg,image/jpeg,image/png" onchange="previewFoto(this)">
                <div class="hint">Format: JPG, JPEG, PNG. Maks. 2MB.</div>
                <div id="fotoPreview" class="foto-preview">
                    <img id="fotoImg" src="" alt="Preview">
                    <div style="margin-top:.3rem;font-size:.73rem;color:#94a3b8;">
                        Preview &mdash; <a href="#" onclick="clearFoto();return false;" style="color:#ef4444;">Hapus</a>
                    </div>
                </div>
                @error('foto')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            <div class="section-label">Tingkat Prioritas</div>

            <div class="form-group">
                <div class="pri-group">
                    @foreach([
                        ['value'=>'rendah','icon'=>'🟢','label'=>'Rendah','desc'=>'Tidak mengganggu kegiatan'],
                        ['value'=>'sedang','icon'=>'🟡','label'=>'Sedang','desc'=>'Sedikit mengganggu'],
                        ['value'=>'tinggi','icon'=>'🔴','label'=>'Tinggi','desc'=>'Sangat mengganggu / berbahaya'],
                    ] as $p)
                    <label class="pri-label">
                        <input type="radio" name="prioritas" value="{{ $p['value'] }}"
                            {{ old('prioritas','sedang')==$p['value']?'checked':'' }}>
                        <div class="pri-box">
                            <div class="pi">{{ $p['icon'] }}</div>
                            <div class="pt">{{ $p['label'] }}</div>
                            <div class="pd">{{ $p['desc'] }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('prioritas')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:.6rem;padding-top:1rem;border-top:1px solid #f1f5f9;margin-top:.5rem;">
                <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                <button type="reset" class="btn" onclick="clearFoto()">Reset</button>
                <a href="{{ route('user.dashboard') }}" class="btn" style="margin-left:auto;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const desc = document.getElementById('deskripsi');
const hint = document.getElementById('charHint');
desc.addEventListener('input', function() {
    var n = this.value.length;
    hint.style.color = n < 20 ? '#ef4444' : '#16a34a';
    hint.textContent = n + ' karakter (minimal 20).';
});

function previewFoto(input) {
    if (input.files && input.files[0]) {
        if (input.files[0].size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            clearFoto(); return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('fotoImg').src = e.target.result;
            document.getElementById('fotoPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearFoto() {
    document.getElementById('fotoInput').value = '';
    document.getElementById('fotoPreview').style.display = 'none';
    document.getElementById('fotoImg').src = '';
}
</script>
@endpush

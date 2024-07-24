@extends('layouts.app')

@section('title', 'Input Alamat')

@section('content')
<h2>Input Alamat</h2>
<form id="address-form">
    <div class="form-group">
        <label for="alamat">Alamat:</label>
        <input type="text" class="form-control" id="alamat" name="alamat" required>
    </div>
    <div class="form-group">
        <label for="kel">Kelurahan:</label>
        <input type="text" class="form-control" id="kel" name="kel" required>
    </div>
    <div class="form-group">
        <label for="kec">Kecamatan:</label>
        <input type="text" class="form-control" id="kec" name="kec" required>
    </div>
    <div class="form-group">
        <label for="kota">Kota:</label>
        <input type="text" class="form-control" id="kota" name="kota" required>
    </div>
    <div class="form-group">
        <label for="prov">Provinsi:</label>
        <input type="text" class="form-control" id="prov" name="prov" required>
    </div>
    <div class="form-group">
        <label for="kodepos">Kode Pos:</label>
        <input type="text" class="form-control" id="kodepos" name="kodepos" pattern="\d{5}" required>
    </div>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>
<div id="response-message" class="mt-3"></div>

<script>
document.getElementById('address-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    fetch('/api/addresses', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('response-message').innerHTML =
                `<div class="alert alert-success">${data}</div>`;
            document.getElementById('address-form').reset();
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('response-message').innerHTML =
                `<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>`;
        });
});
</script>
@endsection
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
@include('backbone.headerpicpknow', [
    'showMenu' => false, // Menyembunyikan menu pada halaman login
    'userProfile' => ['name' => 'User', 'role' => 'Guest', 'lastLogin' => ''],
    'menuItems' => [],
    'konfirmasi' => 'Konfirmasi',
    'pesanKonfirmasi' => 'Apakah Anda yakin ingin keluar?',
    'kelolaProgram' => false,
    'showConfirmation' => false, // Pastikan variabel ini ada untuk header
    ])

<div class="container">
    <h1>Kelola Kelompok Keahlian</h1>
    <p>ASTRAtech memiliki banyak program studi, di dalam program studi terdapat kelompok keahlian.</p>

    <!-- Search and Filters -->
    <div class="input-wrapper mb-4">
        <form id="searchForm" class="d-flex">
            <input
                type="text"
                id="searchQuery"
                class="form-control"
                placeholder="Cari"
                style="border-radius: 20px; height: 40px; border: none; width: 50%;"
            >
            <select id="searchFilterSort" class="form-select mx-2">
                @foreach($dataFilterSort as $filter)
                    <option value="{{ $filter['Value'] }}">{{ $filter['Text'] }}</option>
                @endforeach
            </select>
            <select id="searchFilterStatus" class="form-select mx-2">
                @foreach($dataFilterStatus as $filter)
                    <option value="{{ $filter['Value'] }}">{{ $filter['Text'] }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary px-4" onclick="handleSearch()">Cari</button>
        </form>
    </div>

    <!-- Button Tambah -->
    <div class="text-end mb-4">
        <button class="btn btn-success" onclick="handleAdd()">Tambah</button>
    </div>
 <!-- Data Table -->
 <div id="dataContainer" class="row"></div>

<!-- Pagination -->
<div id="pagination" class="d-flex justify-content-center mt-4"></div>
</div>

<script>
    
const apiLink = "{{ route('kelola_kk.getTempDataKK') }}";
console.log(apiLink);
var data = @json($data);
console.log("ayamansdf");

async function fetchData(params = {}) {
    console.log('Fetching data with params:', params);
    try {
        const response = await fetch(apiLink + '?' + new URLSearchParams(params));
        if (!response.ok) {
            throw new Error('Data tidak ditemukan');
        }
        const data = await response.json();
        console.log('Response data:', data);
        renderData(data);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('dataContainer').innerHTML = <p class="text-center">${error.message}</p>;
    }
}

function renderData(data) {
        const container = document.getElementById('dataContainer');
        container.innerHTML = '';
        console.log("data kk", data);
        if (data.length === 0) {
            container.innerHTML = '<p class="text-center">Tidak ada data!</p>';
        } else {
            data.forEach(item => {
                container.innerHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="/path-to-images/${item.Gambar}" class="card-img-top" alt="${item['Nama Kelompok Keahlian']}">
                            <div class="card-body">
                                <h5 class="card-title">${item['Nama Kelompok Keahlian']}</h5>
                                <p class="card-text">${item.Deskripsi}</p>
                                <p class="card-text"><strong>Status:</strong> ${item.Status}</p>
                                <button class="btn btn-danger" onclick="deleteData(${item.Key})">Hapus</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
    }

    async function deleteData(id) {
        const response = await fetch(/kelola-kk/deleteKK/${id}, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const result = await response.json();
        alert(result.message);
        fetchData();
    }

    function handleSearch() {
        const query = document.getElementById('searchQuery').value;
        const sort = document.getElementById('searchFilterSort').value;
        const status = document.getElementById('searchFilterStatus').value;
        fetchData({ query, sort, status, page: 1 });
    }

   
    // Initial fetch
    fetchData();
    
</script>

@include('backbone.footer')
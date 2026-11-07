<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocabularies</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 font-sans">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mt-5">
            <h1 class="font-semibold text-gray-800 text-xl">Vocabularies</h1>
                <button id="logoutBtn" class="bg-red-500 hover:bg-red-700 rounded transition text-white py-1 px-3 font-semibold">Logout</button>
        </div>
        <div class="rounded-2xl shadow-md bg-white px-10 py-6 mt-10">
            <table class="w-full border-collapse text-left  ">
                <a href="/vocabularies/create" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-1 px-3 transition rounded">Tambah Kosakata</a>
                <p><br></p>
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-3 border-b">Kata</th>
                        <th class="p-3 border-b">Kelas Kata</th>
                        <th class="p-3 border-b">Arti</th>
                        <th class="p-3 border-b">Contoh</th>
                        <th class="p-3 border-b text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="vocabTableBody">
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-500" >Memuat data..</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        //cek token
        const token = localStorage.getItem('auth_token');
        if(!token){
            window.location.href = '/';
        }
        //ambil element table
        const tableBody = document.getElementById('vocabTableBody');

        //ambil data dari API
        async function fetchVocabularies() {
            try{
                const response = await fetch('http://localhost:8000/api/vocabularies', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer '+ token //token
                    }
                });

                //jika token kadaluarsa, tendang ke login
                if(response.status === 401){
                    localStorage.removeItem('auth_token');
                    window.location = '/';
                    return;
                }

                const result = await response.json();
                //API mengembalian array
                renderTable(result);
            }catch(error){
                console.error('Gagal mengambil data', error);
                tableBody.innerHTML=`<tr><td colspan="4" class="text-center p-4 text-red-500">Gagal menghubungi server.</td></tr>`;
            }
        }

        //fungsi menampilkan data ke table
        function renderTable(data){
            tableBody.innerHTML = ''; //kosongkan table dulu

            if(data.length === 0){
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center p-4 text-gray-500">Belum ada kosakata</td></tr>`;
                return;
            }

            //looping setiap data dari API
            data.forEach(vocab => {
                const row = `
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="p-3 font-semibold text-gray-800">${ vocab.word }</td>
                        <td class="p-3 font-semibold text-gray-800">${ vocab.part_of_speech || '-'}</td>
                        <td class="p-3  text-gray-800">${ vocab.meaning }</td>
                        <td class="p-3  text-gray-800">${ vocab.example || '-' }</td>
                        <td class="p-3">${ vocab.is_mastered ? '<span class="bg-green-100 text-green-700 px-2 py-1">Hafal</span>' : '<span class="bg-yellow-100 text-yellow-700 px-2 py-1">Belum</span>'}</td>
                    </tr>`;
                tableBody.innerHTML += row;
            });
        }

        //logout
        document.getElementById('logoutBtn').addEventListener('click', function(){
            localStorage.removeItem('auth_token'); //hapus token
            window.location = '/'; // kembali ke login
        });
        //jalankan fungsi saat page dimuat
        fetchVocabularies();
    </script>
</body>
</html>
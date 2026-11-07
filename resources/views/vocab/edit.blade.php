<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kosakata</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 font-sans">
    <div class="max-w-2xl mx-auto py-6 px-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="font-semibold text-gray-700">Edit Kosakata</h1>
            <button id="logoutBtn" class="bg-red-500 hover:bg-red-700 rounded font-semibold py-1 px-3 transition text-white">Logout</button>
        </div>
        <div class="rounded-lg shadow-md bg-white py-6 px-10 " >
            <form id="createForm">
                <div id="errorMessage" class="hidden bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm "></div>
                <div>
                    <label for="">Kata</label><br>
                    <input class="w-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition border border-gray-500 " type="text" name="word" id="word">
                </div>
                <br>
                <div>
                    <label for="">Kelas Kata</label><br>
                    <input class="w-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition border border-gray-500 " type="text" name="part_of_speech" id="part_of_speech">
                </div>
                <br>
                <div>
                    <label for="">Arti</label><br>
                    <input class="w-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition border border-gray-500 " type="text" name="meaning" id="meaning">
                </div>
                <br>
                <div>
                    <label for="">Contoh</label><br>
                    <textarea rows="5" class="w-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition border border-gray-500 " name="example" id="example"></textarea>
                </div>
                <br>
                <div>
                    <label for="">Status</label><br>
                    <select class="w-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition border border-gray-500 "  name="is_mastered" id="is_mastered">
                        <option value="0">Belum Hafal</option>
                        <option value="1">Sudah Hafal</option>
                    </select>
                </div>
                <br>
                <button class="bg-green-500 hover:bg-green-700 rounded transition text-white font-semibold py-1 px-3 " type="submit">Simpan</button>
            </form>
        </div>
    </div>
    <script>
        //ambil id dari blade
        const vocabId = "{{ $id }}";
        //cek token
        const token = localStorage.getItem('auth_token');
        if(!token){
            window.location.href = '/'
        }


        //logout
        document.getElementById('logoutBtn').addEventListener('click', async function() {
            localStorage.removeItem('auth_token');
            window.location = '/';
        })

        //fungis ambil data lama
        async function fetchOldData(){
            try{
                const response = await fetch(`http://localhost:8000/api/vocabularies/${vocabId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                });

                const data = await response.json();
                if(response.ok){
                    //isi form dengan dari dari API
                    document.getElementById('word').value = data.word;
                    document.getElementById('part_of_speech').value = data.part_of_speech || '';
                    document.getElementById('meaning').value = data.meaning;
                    document.getElementById('example').value = data.example || '';
                    document.getElementById('is_mastered').value = data.is_mastered? '1':'0';
                }else{
                    errorMessage.classList.remove('hidden');
                    errorMessage.innerText = 'Gagal mengambil data kosakata';
                }
            }catch(error){
                console.error('Error: ', error);
            }
        }
        //jalankan fungsi ambil data saat dimuat
        fetchOldData();


        //form submit
        document.getElementById('createForm').addEventListener('submit', async function(e){
            e.preventDefault(); //mencegah reload

            const errorMessage = document.getElementById('errorMessage');
            errorMessage.classList.add('hidden') //sembunyikan error jika tidak ada

            //ambil data
            const word = document.getElementById('word').value;
            const part_of_speech = document.getElementById('part_of_speech').value;
            const meaning = document.getElementById('meaning').value;
            const example = document.getElementById('example').value;
            const is_mastered = document.getElementById('is_mastered').value;

            try{
                const response = await fetch(`http://localhost:8000/api/vocabularies/${vocabId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                        body: JSON.stringify({
                        word: word,
                        part_of_speech: part_of_speech,
                        meaning: meaning,
                        example: example,
                        is_mastered: is_mastered
                    })
                });

                if(response.ok){
                    alert('Kosakata berhasil diubah');
                    window.location.href = '/vocabularies';
                }else{
                    const data = await response.json();
                    errorMessage.classList.remove('hidden');
                    errorMessage.innerText = 'Gagal mengubah data, pastikan Kata dan Arti terisi';
                }
            }catch(error){
                console.error('Error: ', error);
                errorMessage.classList.remove('hidden');
                errorMessage.innerText = 'Gagal menghubungi API. Pastikan API aktif';
            }
        })
    </script>
</body>
</html>
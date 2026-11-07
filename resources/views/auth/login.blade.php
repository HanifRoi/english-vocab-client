<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 font-sans">
    <div class="max-w-xl mx-auto py-25 px-10">
        <div class="py-6 px-10 flex justify-center items-center">
            <h1 class="font-semibold text-gray-800 text-xl">Login</h1>
        </div>
        <div class="bg-white rounded-2xl shadow-md px-10 py-6">
             <form id="loginForm">
                @csrf
                <div id="errorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm"></div>
                <div class="mb-2">
                    <label class="block font-semibold text-gray-800" for="">Email</label><br>
                    <input class="focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg border border-gray-500 w-full transition" type="email" name="email" id="email">
                </div>
                <br>
                <div class="mb-10">
                    <label class="block font-semibold text-gray-800" for="">Password</label><br>
                    <input class="rounded-lg border border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition w-full" type="password" name="password" id="password">
                </div>
                <button class="mt-3 bg-green-500 hover:bg-green-700 font-semibold text-white rounded transition py-1 px-3" type="submit">Login</button>
                <p>Belum punya akun? <a href="/register" class="text-blue-500 hover:text-blue-700">daftar disini</a> </p>
            </form>
        </div>
       
    </div>
    <script>
        //mencari form dan memasang alarm
        document.getElementById('loginForm').addEventListener('submit', async function(e){
            //mencegah halaman reload
            e.preventDefault();

            //mengambil data dari input
            const email= document.getElementById('email').value;
            const password= document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            //proses mengirim data ke API (FETCH)
            try {
                const response = await fetch('http://localhost:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', //mengirim data JSON
                        'Accept': 'application/json' //memberi tahu agar balas dengan JSON juga
                    },

                    //mengubah data Object jadi JSON
                    body: JSON.stringify({
                        email: email,
                        password: password,
                    })
                });

                //menerima balasan dari API
                const data = await response.json();

                if(response.ok){
                    localStorage.setItem('auth_token', data.access_token) //simpan token
                    alert('Login Berhasil');
                    window.location.href = '/vocabularies';
                }else{
                    errorMessage.classList.remove('hidden'); //memunculkan kotak merah
                    errorMessage.innerText = data.message || 'Email atau password salah';
                }

            } catch (error) {
                //jika server mati
                console.error('Error:', error);
                errorMessage.classList.remove('hidden');
                errorMessage.innerText = 'Gagal menghubungi server, Pastikan API Backend menyala';
            }
        });
    </script>
</body>
</html>
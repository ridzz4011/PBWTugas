<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembelian Tiket Pesawat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <header class="bg-cover bg-center h-64" style="background-image: url('./images/bandara.jpg');">
    <div class="h-full bg-gray-900 bg-opacity-50 flex items-center justify-center">
      <h1 class="text-4xl font-bold text-white">Pendaftaran Rute Penerbangan</h1>
    </div>
  </header>
  <main class="container mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto">
      <form method="post" action="result.php" class="space-y-4">
        <div>
          <label class="block font-medium mb-1" for="airline">Maskapai</label>
          <select id="airline" name="airline" class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400" required>
            <option value="">Pilih maskapai</option>
            <?php
              $airlines = ['Lion Air','Batik Air','Garuda Indonesia','Citilink','Sriwijaya Air'];
              foreach($airlines as $air) echo "<option value='$air'>$air</option>";
            ?>
          </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1" for="origin">Bandara Asal</label>
            <select id="origin" name="origin" class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400" required>
              <option value="">Pilih asal</option>
              <?php
                $originAirports = ['Soekarno Hatta','Husein Sastranegara','Abdul Rachman Saleh','Juanda'];
                sort($originAirports);
                foreach($originAirports as $o) echo "<option value='$o'>$o</option>";
              ?>
            </select>
          </div>
          <div>
            <label class="block font-medium mb-1" for="destination">Bandara Tujuan</label>
            <select id="destination" name="destination" class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400" required>
              <option value="">Pilih tujuan</option>
              <?php
                $destAirports = ['Ngurah Rai','Hasanuddin','Inanwatan','Sultan Iskandar Muda'];
                sort($destAirports);
                foreach($destAirports as $d) echo "<option value='$d'>$d</option>";
              ?>
            </select>
          </div>
        </div>
        <div>
          <label class="block font-medium mb-1" for="flight_date">Tanggal Penerbangan</label>
          <input type="text" id="flight_date" name="flight_date" class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 flatpickr" placeholder="Pilih tanggal penerbangan" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-3 font-semibold hover:bg-green-700 transition">Proses Pendaftaran</button>
      </form>
    </div>
  </main>
  <script>
    // Tanggal
    flatpickr('.flatpickr',{altInput:true,altFormat:'F j, Y',dateFormat:'Y-m-d',minDate:'today'});
  </script>
</body>
</html>

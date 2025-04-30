<?php
session_start();
require 'db.php';
// define data
$taxMap = [
  'Soekarno Hatta'=>65000,'Husein Sastranegara'=>50000,'Abdul Rachman Saleh'=>40000,'Juanda'=>30000,
  'Ngurah Rai'=>85000,'Hasanuddin'=>70000,'Inanwatan'=>90000,'Sultan Iskandar Muda'=>60000
];
$priceList = [
  'Lion Air'=>['Ngurah Rai'=>1200000,'Hasanuddin'=>1100000,'Inanwatan'=>1300000,'Sultan Iskandar Muda'=>1150000],
  'Batik Air'=>['Ngurah Rai'=>1500000,'Hasanuddin'=>1400000,'Inanwatan'=>1600000,'Sultan Iskandar Muda'=>1450000],
  'Garuda Indonesia'=>['Ngurah Rai'=>1800000,'Hasanuddin'=>1700000,'Inanwatan'=>1900000,'Sultan Iskandar Muda'=>1750000],
  'Citilink'=>['Ngurah Rai'=>1000000,'Hasanuddin'=>950000,'Inanwatan'=>1050000,'Sultan Iskandar Muda'=>980000],
  'Sriwijaya Air'=>['Ngurah Rai'=>1300000,'Hasanuddin'=>1250000,'Inanwatan'=>1350000,'Sultan Iskandar Muda'=>1280000]
];
// retrieve POST
$airline = htmlspecialchars($_POST['airline'] ?? '');
$origin = $_POST['origin'] ?? '';
$destination = $_POST['destination'] ?? '';
$flightDate = $_POST['flight_date'] ?? '';
// calc
$basePrice = $priceList[$airline][$destination] ?? 0;
$tax = ($taxMap[$origin] ?? 0) + ($taxMap[$destination] ?? 0);
$total = $basePrice + $tax;
$ticketNumber = rand(10000000,99999999);
$bookingDate = date('Y-m-d H:i:s');
// insert into DB
$stmt = $pdo->prepare("INSERT INTO bookings (ticket_number, airline, origin, destination, flight_date, base_price, tax, total, booked_at)
                       VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->execute([$ticketNumber, $airline, $origin, $destination, $flightDate, $basePrice, $tax, $total, $bookingDate]);
// fetch history
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pendaftaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <main class="container mx-auto p-6">
    <!-- Detail Pesanan -->
    <div class="bg-white mb-6 rounded-lg shadow p-6">
      <h2 class="text-2xl font-bold mb-4">Hasil Pendaftaran Rute Penerbangan</h2>
      <h3 class="text-xl font-semibold mb-2">Detail Penerbangan</h3>
      <table class="w-full border-collapse">
        <?php foreach([
          'Maskapai'=>$airline,
          'Asal Penerbangan'=>$origin,
          'Tujuan Penerbangan'=>$destination,
          'Tanggal Penerbangan'=>$flightDate,
          'Harga Tiket'=>'Rp '.number_format($basePrice,0,',','.'),
          'Pajak'=>'Rp '.number_format($tax,0,',','.'),
          'Total Harga Tiket'=>'Rp '.number_format($total,0,',','.')
        ] as $label=>$val): ?>
        <tr><td class="py-2 px-4 font-medium"><?= $label ?></td><td class="py-2 px-4"><?= $val ?></td></tr>
        <?php endforeach; ?>
      </table>
    </div>
    <!-- Detail Pajak -->
    <div class="bg-white mb-6 rounded-lg shadow p-6">
      <h3 class="text-xl font-semibold mb-2">Detail Pajak</h3>
      <table class="w-full border-collapse mb-4">
        <tr class="bg-gray-100"><th class="py-2 px-4 text-left">Bandara</th><th class="py-2 px-4 text-left">Pajak</th></tr>
        <tr><td class="py-2 px-4"><?php echo $origin ?></td><td class="py-2 px-4">Rp <?php echo number_format($taxMap[$origin],0,',','.') ?></td></tr>
        <tr><td class="py-2 px-4"><?php echo $destination ?></td><td class="py-2 px-4">Rp <?php echo number_format($taxMap[$destination],0,',','.') ?></td></tr>
        <tr class="font-bold"><td class="py-2 px-4">Total Pajak</td><td class="py-2 px-4">Rp <?php echo number_format($tax,0,',','.') ?></td></tr>
      </table>
      <p>Tanggal pendaftaran: <?php echo date('d-m-Y H:i:s', strtotime($bookingDate)) ?></p>
      <div class="mt-6 flex gap-4">
        <a href="bookflight.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Kembali ke Form Pendaftaran</a>
      </div>
    </div>
    <!-- Riwayat Booking -->
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-xl font-semibold mb-4">Riwayat Booking</h3>
      <?php
        $hist = $pdo->query("SELECT ticket_number, airline, origin, destination, flight_date, total, booked_at FROM bookings ORDER BY booked_at DESC");
        echo '<table class="w-full border-collapse"><tr class="bg-gray-100"><th class="py-2 px-4 text-left">No Tiket</th><th class="py-2 px-4 text-left">Maskapai</th><th class="py-2 px-4 text-left">Rute</th><th class="py-2 px-4 text-left">Tanggal Terbang</th><th class="py-2 px-4 text-left">Total</th><th class="py-2 px-4 text-left">Waktu Booking</th></tr>';
        foreach($hist as $row) {
            echo '<tr>' .
                 "<td class='py-2 px-4'>{$row['ticket_number']}</td>" .
                 "<td class='py-2 px-4'>{$row['airline']}</td>" .
                 "<td class='py-2 px-4'>{$row['origin']} - {$row['destination']}</td>" .
                 "<td class='py-2 px-4'>{$row['flight_date']}</td>" .
                 "<td class='py-2 px-4'>Rp " . number_format($row['total'],0,',','.') . "</td>" .
                 "<td class='py-2 px-4'>{$row['booked_at']}</td>" .
                 '</tr>';
        }
        echo '</table>';
      ?>
    </div>
  </main>
</body>
</html>

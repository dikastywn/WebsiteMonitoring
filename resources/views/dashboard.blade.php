<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Kualitas Air</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
  <div class="max-w-7xl mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-blue-800">Monitoring Kualitas Air</h1>
      <button class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
    </div>

    <!-- Kartu Sensor -->
    <div class="grid grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded-2xl shadow text-center border-t-4 border-blue-500">
        <h2 class="text-lg font-semibold text-gray-600">pH</h2>
        <p id="ph-value" class="text-3xl font-bold text-blue-600">-</p>
        <p id="ph-status" class="text-green-600 font-semibold">Normal</p>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow text-center border-t-4 border-red-500">
        <h2 class="text-lg font-semibold text-gray-600">Suhu (°C)</h2>
        <p id="suhu-value" class="text-3xl font-bold text-red-600">-</p>
        <p id="suhu-status" class="text-green-600 font-semibold">Normal</p>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow text-center border-t-4 border-green-500">
        <h2 class="text-lg font-semibold text-gray-600">Kekeruhan (NTU)</h2>
        <p id="kekeruhan-value" class="text-3xl font-bold text-green-600">-</p>
        <p id="kekeruhan-status" class="text-green-600 font-semibold">Normal</p>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow text-center border-t-4 border-purple-500">
        <h2 class="text-lg font-semibold text-gray-600">Tinggi Air (cm)</h2>
        <p id="tinggi-value" class="text-3xl font-bold text-purple-600">-</p>
        <p id="tinggi-status" class="text-green-600 font-semibold">Normal</p>
      </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-lg font-semibold mb-4 flex items-center">
        📊 Grafik Perubahan Sensor
      </h2>
      <canvas id="sensorChart" height="100"></canvas>

      <!-- Tombol Navigasi Grafik -->
      <div class="flex justify-center items-center gap-4 mt-4">
        <button id="prev-btn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
          ⏪ Sebelumnya
        </button>
        <button id="next-btn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
          Berikutnya ⏩
        </button>
      </div>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('sensorChart').getContext('2d');

    // === Generate Dummy Data Awal (50 data, tapi tampilkan 15 pertama) ===
    const dummyLabels = [];
    const dummyPH = [];
    const dummySuhu = [];
    const dummyKekeruhan = [];
    const dummyTinggi = [];

    const now = new Date();
    for (let i = 49; i >= 0; i--) {
      const t = new Date(now.getTime() - i * 3000);
      dummyLabels.push(t.toLocaleTimeString('id-ID', { hour12: false }));
      dummyPH.push(6.5 + Math.random() * 1.2);
      dummySuhu.push(27 + Math.random() * 8);
      dummyKekeruhan.push(10 + Math.random() * 90);
      dummyTinggi.push(110 + Math.random() * 40);
    }

    let startIndex = 0;
    const viewSize = 15;

    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dummyLabels.slice(startIndex, startIndex + viewSize),
        datasets: [
          {
            label: 'pH',
            borderColor: 'blue',
            backgroundColor: 'blue',
            data: dummyPH.slice(startIndex, startIndex + viewSize),
            fill: false,
            tension: 0.3,
            pointRadius: 3
          },
          {
            label: 'Suhu',
            borderColor: 'red',
            backgroundColor: 'red',
            data: dummySuhu.slice(startIndex, startIndex + viewSize),
            fill: false,
            tension: 0.3,
            pointRadius: 3
          },
          {
            label: 'Kekeruhan',
            borderColor: 'green',
            backgroundColor: 'green',
            data: dummyKekeruhan.slice(startIndex, startIndex + viewSize),
            fill: false,
            tension: 0.3,
            pointRadius: 3
          },
          {
            label: 'Tinggi Air',
            borderColor: 'purple',
            backgroundColor: 'purple',
            data: dummyTinggi.slice(startIndex, startIndex + viewSize),
            fill: false,
            tension: 0.3,
            pointRadius: 3
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Tombol navigasi grafik
    document.getElementById('prev-btn').addEventListener('click', () => {
      if (startIndex > 0) {
        startIndex--;
        updateChartView();
      }
    });

    document.getElementById('next-btn').addEventListener('click', () => {
      if (startIndex + viewSize < dummyLabels.length) {
        startIndex++;
        updateChartView();
      }
    });

    function updateChartView() {
      chart.data.labels = dummyLabels.slice(startIndex, startIndex + viewSize);
      chart.data.datasets[0].data = dummyPH.slice(startIndex, startIndex + viewSize);
      chart.data.datasets[1].data = dummySuhu.slice(startIndex, startIndex + viewSize);
      chart.data.datasets[2].data = dummyKekeruhan.slice(startIndex, startIndex + viewSize);
      chart.data.datasets[3].data = dummyTinggi.slice(startIndex, startIndex + viewSize);
      chart.update();
    }

    // === Fungsi Update Status Normal / Bahaya ===
    function updateStatus(ph, suhu, kekeruhan, tinggi) {
      const phStatus = document.getElementById('ph-status');
      if (ph < 6.8 || ph > 7.8) {
        phStatus.textContent = "Bahaya";
        phStatus.className = "text-red-600 text-center font-semibold";
      } else {
        phStatus.textContent = "Normal";
        phStatus.className = "text-green-600 text-center font-semibold";
      }

      const suhuStatus = document.getElementById('suhu-status');
      if (suhu < 28 || suhu > 33) {
        suhuStatus.textContent = "Bahaya";
        suhuStatus.className = "text-red-600 text-center font-semibold";
      } else {
        suhuStatus.textContent = "Normal";
        suhuStatus.className = "text-green-600 text-center font-semibold";
      }

      const kekeruhanStatus = document.getElementById('kekeruhan-status');
      if (kekeruhan > 60) {
        kekeruhanStatus.textContent = "Bahaya";
        kekeruhanStatus.className = "text-red-600 text-center font-semibold";
      } else {
        kekeruhanStatus.textContent = "Normal";
        kekeruhanStatus.className = "text-green-600 text-center font-semibold";
      }

      const tinggiStatus = document.getElementById('tinggi-status');
      if (tinggi < 115 || tinggi > 135) {
        tinggiStatus.textContent = "Bahaya";
        tinggiStatus.className = "text-red-600 text-center font-semibold";
      } else {
        tinggiStatus.textContent = "Normal";
        tinggiStatus.className = "text-green-600 text-center font-semibold";
      }
    }

    // === Nilai Awal ===
    const lastPH = dummyPH.at(-1);
    const lastSuhu = dummySuhu.at(-1);
    const lastKekeruhan = dummyKekeruhan.at(-1);
    const lastTinggi = dummyTinggi.at(-1);

    document.getElementById('ph-value').innerText = lastPH.toFixed(1);
    document.getElementById('suhu-value').innerText = lastSuhu.toFixed(1) + "°C";
    document.getElementById('kekeruhan-value').innerText = lastKekeruhan.toFixed(1) + " NTU";
    document.getElementById('tinggi-value').innerText = lastTinggi.toFixed(1) + " cm";
    updateStatus(lastPH, lastSuhu, lastKekeruhan, lastTinggi);

    // === Realtime Fetch Data ===
    async function fetchData() {
      try {
        const response = await fetch('/api/sensor/latest');
        const data = await response.json();

        const now = new Date();
        const timeLabel = now.toLocaleTimeString('id-ID', { hour12: false });

        dummyLabels.push(timeLabel);
        dummyPH.push(data.ph);
        dummySuhu.push(data.suhu);
        dummyKekeruhan.push(data.kekeruhan);
        dummyTinggi.push(data.tinggi_air);

        if (dummyLabels.length > 50) {
          dummyLabels.shift();
          dummyPH.shift();
          dummySuhu.shift();
          dummyKekeruhan.shift();
          dummyTinggi.shift();
        }

        if (startIndex + viewSize >= dummyLabels.length) {
          startIndex = Math.max(0, dummyLabels.length - viewSize);
        }

        updateChartView();

        document.getElementById('ph-value').innerText = data.ph.toFixed(1);
        document.getElementById('suhu-value').innerText = data.suhu.toFixed(1) + "°C";
        document.getElementById('kekeruhan-value').innerText = data.kekeruhan.toFixed(1) + " NTU";
        document.getElementById('tinggi-value').innerText = data.tinggi_air.toFixed(1) + " cm";
        updateStatus(data.ph, data.suhu, data.kekeruhan, data.tinggi_air);
      } catch (err) {
        console.error('Gagal fetch data:', err);
      }
    }

    setInterval(fetchData, 20000);
  </script>
</body>
</html>

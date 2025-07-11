<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard COVID-19 Sidoarjo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card.positive {
            border-left: 5px solid #e74c3c;
        }

        .stat-card.odp {
            border-left: 5px solid #f39c12;
        }

        .stat-card.pdp {
            border-left: 5px solid #3498db;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.positive .stat-icon {
            color: #e74c3c;
        }

        .stat-card.odp .stat-icon {
            color: #f39c12;
        }

        .stat-card.pdp .stat-icon {
            color: #3498db;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 1rem;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .chart-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .districts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .district-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .district-card:hover {
            transform: translateY(-3px);
        }

        .district-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
            text-transform: capitalize;
        }

        .district-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            text-align: center;
        }

        .district-stat {
            padding: 8px;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .district-stat.positive {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .district-stat.recovered {
            background: rgba(39, 174, 96, 0.1);
            color: #27ae60;
        }

        .district-stat.death {
            background: rgba(52, 73, 94, 0.1);
            color: #34495e;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: white;
            font-size: 1.2rem;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 10px;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #2980b9;
        }

        .last-updated {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .chart-section {
                grid-template-columns: 1fr;
            }

            .districts-grid {
                grid-template-columns: 1fr;
            }
        }

        .progress-bar {
            height: 6px;
            background: #ecf0f1;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-virus"></i> Dashboard COVID-19 Sidoarjo</h1>
            <p>Pantau perkembangan COVID-19 di Kabupaten Sidoarjo secara real-time</p>
        </div>

        <div class="last-updated">
            <i class="fas fa-clock"></i> Terakhir diperbarui: <span id="lastUpdated">Loading...</span>
        </div>

        <div class="stats-grid">
            <div class="stat-card positive">
                <div class="stat-icon">
                    <i class="fas fa-virus"></i>
                </div>
                <div class="stat-number" id="totalPositive">-</div>
                <div class="stat-label">Positif</div>
                <div class="progress-bar">
                    <div class="progress-fill" id="positiveProgress"></div>
                </div>
            </div>

            <div class="stat-card odp">
                <div class="stat-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-number" id="totalOdp">-</div>
                <div class="stat-label">ODP</div>
                <div class="progress-bar">
                    <div class="progress-fill" id="odpProgress"></div>
                </div>
            </div>

            <div class="stat-card pdp">
                <div class="stat-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="stat-number" id="totalPdp">-</div>
                <div class="stat-label">PDP</div>
                <div class="progress-bar">
                    <div class="progress-fill" id="pdpProgress"></div>
                </div>
            </div>
        </div>

        <div class="chart-section">
            <div class="chart-container">
                <h3 class="chart-title">Distribusi Kasus COVID-19</h3>
                <canvas id="distributionChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="chart-title">Top 5 Kecamatan</h3>
                <canvas id="topDistrictsChart"></canvas>
            </div>
        </div>

        <div class="districts-grid" id="districtsGrid">
            <div class="loading">
                <i class="fas fa-spinner fa-spin"></i> Memuat data kecamatan...
            </div>
        </div>

        <div class="footer">
            <p>© 2024 COVID-19 Dashboard Sidoarjo | Dibuat dengan ❤️ untuk masyarakat Sidoarjo</p>
            <p>
                <a href="https://github.com/madebyaris/covid19-sidoarjo" target="_blank">
                    <i class="fab fa-github"></i> Source Code
                </a>
            </p>
        </div>
    </div>

    <script>
        // Global variables
        let totalData = {};
        let districtData = {};
        let charts = {};

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadTotalData();
            loadDistrictData();
            updateLastUpdated();
        });

        // Load total COVID data
        async function loadTotalData() {
            try {
                const response = await fetch('json/kecamatan.json');
                const data = await response.json();
                totalData = data;
                updateTotalStats(data);
                createDistributionChart(data);
            } catch (error) {
                console.error('Error loading total data:', error);
            }
        }

        // Load district data
        async function loadDistrictData() {
            const districts = [
                'sidoarjo', 'buduran', 'candi', 'gedangan', 'tanggulangin', 'porong',
                'jabon', 'taman', 'krembung', 'wonoayu', 'tulangan', 'krian',
                'prambon', 'sukodono', 'sedati', 'waru', 'balongbendo', 'tarik'
            ];

            try {
                const promises = districts.map(async (district) => {
                    const response = await fetch(`json/${district}.json`);
                    const data = await response.json();
                    return { name: district, data: data[0] };
                });

                const results = await Promise.all(promises);
                districtData = results.reduce((acc, item) => {
                    acc[item.name] = item.data;
                    return acc;
                }, {});

                renderDistrictCards(results);
                createTopDistrictsChart(results);
            } catch (error) {
                console.error('Error loading district data:', error);
            }
        }

        // Update total statistics
        function updateTotalStats(data) {
            document.getElementById('totalPositive').textContent = data.positif.toLocaleString();
            document.getElementById('totalOdp').textContent = data.odp.toLocaleString();
            document.getElementById('totalPdp').textContent = data.pdp.toLocaleString();

            // Update progress bars
            const total = data.positif + data.odp + data.pdp;
            document.getElementById('positiveProgress').style.width = `${(data.positif / total) * 100}%`;
            document.getElementById('odpProgress').style.width = `${(data.odp / total) * 100}%`;
            document.getElementById('pdpProgress').style.width = `${(data.pdp / total) * 100}%`;
        }

        // Create distribution chart
        function createDistributionChart(data) {
            const ctx = document.getElementById('distributionChart').getContext('2d');
            charts.distribution = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Positif', 'ODP', 'PDP'],
                    datasets: [{
                        data: [data.positif, data.odp, data.pdp],
                        backgroundColor: ['#e74c3c', '#f39c12', '#3498db'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Create top districts chart
        function createTopDistrictsChart(districts) {
            const sortedDistricts = districts
                .sort((a, b) => parseInt(b.data.positif) - parseInt(a.data.positif))
                .slice(0, 5);

            const ctx = document.getElementById('topDistrictsChart').getContext('2d');
            charts.topDistricts = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sortedDistricts.map(d => d.name.charAt(0).toUpperCase() + d.name.slice(1)),
                    datasets: [{
                        label: 'Kasus Positif',
                        data: sortedDistricts.map(d => parseInt(d.data.positif)),
                        backgroundColor: '#e74c3c',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Render district cards
        function renderDistrictCards(districts) {
            const container = document.getElementById('districtsGrid');
            container.innerHTML = '';

            districts.forEach(district => {
                const card = document.createElement('div');
                card.className = 'district-card';
                card.innerHTML = `
                    <div class="district-name">${district.name.charAt(0).toUpperCase() + district.name.slice(1)}</div>
                    <div class="district-stats">
                        <div class="district-stat positive">
                            <div><strong>${district.data.positif}</strong></div>
                            <div>Positif</div>
                        </div>
                        <div class="district-stat recovered">
                            <div><strong>${district.data.sembuh}</strong></div>
                            <div>Sembuh</div>
                        </div>
                        <div class="district-stat death">
                            <div><strong>${district.data.meninggal}</strong></div>
                            <div>Meninggal</div>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        // Update last updated time
        function updateLastUpdated() {
            const now = new Date();
            const formatted = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('lastUpdated').textContent = formatted;
        }

        // Auto-refresh every 5 minutes
        setInterval(() => {
            loadTotalData();
            loadDistrictData();
            updateLastUpdated();
        }, 300000);
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Three D Bakery Management System</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary-green: #A8D5BA;
      --secondary-green: #81C784;
      --light-cream: #FFF8F0;
      --soft-white: #FAFAFA;
      --light-gray: #E8E8E8;
      --medium-gray: #B0B0B0;
      --dark-gray: #6B6B6B;
      --text-primary: #2D2D2D;
      --text-secondary: #666666;
      --accent-green: #56AB91;
      --success: #4CAF50;
      --warning: #FF9800;
      --error: #F44336;
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
      --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-cream);
      color: var(--text-primary);
      line-height: 1.6;
    }

    /* ============================================
       SIDEBAR
       ============================================ */

    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 280px;
      height: 100vh;
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
      padding: 30px 20px;
      overflow-y: auto;
      z-index: 1000;
      box-shadow: var(--shadow-lg);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 40px;
      font-size: 24px;
      font-weight: 700;
      color: white;
    }

    .logo i {
      font-size: 28px;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 16px;
      margin-bottom: 8px;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 14px;
      font-weight: 500;
    }

    .menu-item:hover,
    .menu-item.active {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      transform: translateX(4px);
    }

    .menu-item i {
      width: 20px;
      text-align: center;
    }

    /* ============================================
       HEADER
       ============================================ */

    .header {
      position: fixed;
      top: 0;
      left: 280px;
      right: 0;
      height: 80px;
      background: white;
      padding: 0 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow-sm);
      z-index: 999;
    }

    .search-bar {
      display: flex;
      align-items: center;
      gap: 12px;
      background: var(--soft-white);
      padding: 10px 16px;
      border-radius: 12px;
      width: 300px;
      border: 1px solid var(--light-gray);
      transition: all 0.3s ease;
    }

    .search-bar:focus-within {
      border-color: var(--primary-green);
      box-shadow: 0 0 0 3px rgba(168, 213, 186, 0.1);
    }

    .search-bar input {
      flex: 1;
      border: none;
      background: transparent;
      outline: none;
      font-size: 14px;
      color: var(--text-primary);
    }

    .search-bar input::placeholder {
      color: var(--medium-gray);
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .header-icon {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      background: var(--soft-white);
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      border: 1px solid var(--light-gray);
      font-size: 18px;
    }

    .header-icon:hover {
      background: var(--primary-green);
      color: white;
      transform: scale(1.05);
    }

    .notification-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      width: 24px;
      height: 24px;
      background: var(--error);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 700;
    }

    .profile-section {
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      position: relative;
    }

    .profile-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--primary-green);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      font-size: 16px;
    }

    .profile-info {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .profile-info .name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
    }

    .profile-info .role {
      font-size: 12px;
      color: var(--text-secondary);
    }

    /* Dropdown Menu */
    .profile-dropdown {
      display: none;
      position: absolute;
      top: 60px;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: var(--shadow-md);
      min-width: 180px;
      z-index: 1001;
    }

    .profile-dropdown.active {
      display: block;
    }

    .dropdown-item {
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--text-primary);
      text-decoration: none;
      font-size: 13px;
      cursor: pointer;
      border-bottom: 1px solid var(--light-gray);
      transition: all 0.3s ease;
    }

    .dropdown-item:last-child {
      border-bottom: none;
    }

    .dropdown-item:hover {
      background: var(--soft-white);
      color: var(--primary-green);
    }

    .dropdown-item.logout {
      color: var(--error);
    }

    .dropdown-item.logout:hover {
      background: rgba(244, 67, 54, 0.1);
    }

    /* ============================================
       MAIN CONTENT
       ============================================ */

    .main-content {
      margin-left: 280px;
      margin-top: 80px;
      padding: 30px;
      min-height: calc(100vh - 80px);
    }

    /* ============================================
       DASHBOARD TITLE
       ============================================ */

    .dashboard-header {
      margin-bottom: 30px;
    }

    .dashboard-header h1 {
      font-size: 28px;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 8px;
    }

    .dashboard-header p {
      color: var(--text-secondary);
      font-size: 14px;
    }

    /* ============================================
       SUMMARY CARDS
       ============================================ */

    .summary-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: var(--shadow-sm);
      transition: all 0.3s ease;
      border: 1px solid var(--light-gray);
    }

    .card:hover {
      box-shadow: var(--shadow-md);
      transform: translateY(-4px);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 16px;
    }

    .card-title {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-secondary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .card-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .card-icon.green {
      background: rgba(168, 213, 186, 0.2);
      color: var(--primary-green);
    }

    .card-icon.blue {
      background: rgba(100, 150, 200, 0.2);
      color: #6496C8;
    }

    .card-icon.orange {
      background: rgba(255, 152, 0, 0.2);
      color: var(--warning);
    }

    .card-icon.red {
      background: rgba(244, 67, 54, 0.2);
      color: var(--error);
    }

    .card-value {
      font-size: 32px;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 8px;
    }

    .card-subtitle {
      font-size: 12px;
      color: var(--text-secondary);
    }

    .card-subtitle.positive {
      color: var(--success);
    }

    .card-subtitle.negative {
      color: var(--error);
    }

    /* ============================================
       GRID LAYOUT (2 COLUMN)
       ============================================ */

    .dashboard-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
      margin-bottom: 30px;
    }

    .chart-container {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--light-gray);
      position: relative;
      height: 400px;
    }

    .chart-title {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .chart-wrapper {
      position: relative;
      height: 320px;
    }

    /* ============================================
       CUSTOMER LIST
       ============================================ */

    .customer-list {
      max-height: 400px;
      overflow-y: auto;
    }

    .customer-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 16px;
      border-bottom: 1px solid var(--light-gray);
      transition: all 0.3s ease;
    }

    .customer-item:last-child {
      border-bottom: none;
    }

    .customer-item:hover {
      background: var(--soft-white);
      border-radius: 8px;
    }

    .customer-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--primary-green);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 14px;
      flex-shrink: 0;
    }

    .customer-info {
      flex: 1;
    }

    .customer-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 2px;
    }

    .customer-details {
      font-size: 12px;
      color: var(--text-secondary);
    }

    .customer-time {
      font-size: 12px;
      color: var(--medium-gray);
      text-align: right;
    }

    /* ============================================
       SECOND GRID ROW
       ============================================ */

    .dashboard-grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 30px;
    }

    .bar-chart-container {
      height: 350px;
    }

    /* ============================================
       EMPLOYEE DEPOSITS LIST
       ============================================ */

    .deposit-list {
      max-height: 350px;
      overflow-y: auto;
    }

    .deposit-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px;
      border-bottom: 1px solid var(--light-gray);
      transition: all 0.3s ease;
    }

    .deposit-item:last-child {
      border-bottom: none;
    }

    .deposit-item:hover {
      background: var(--soft-white);
      border-radius: 8px;
    }

    .deposit-employee {
      flex: 1;
    }

    .deposit-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 2px;
    }

    .deposit-date {
      font-size: 12px;
      color: var(--text-secondary);
    }

    .deposit-info {
      text-align: right;
    }

    .deposit-amount {
      font-size: 14px;
      font-weight: 700;
      color: var(--success);
      margin-bottom: 4px;
    }

    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .badge.success {
      background: rgba(76, 175, 80, 0.15);
      color: var(--success);
    }

    .badge.pending {
      background: rgba(255, 152, 0, 0.15);
      color: var(--warning);
    }

    /* ============================================
       BOTTOM STATS
       ============================================ */

    .bottom-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    /* ============================================
       SCROLLBAR
       ============================================ */

    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background: var(--soft-white);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--light-gray);
      border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--primary-green);
    }

    /* ============================================
       RESPONSIVE
       ============================================ */

    @media (max-width: 1024px) {
      .dashboard-grid,
      .dashboard-grid-2 {
        grid-template-columns: 1fr;
      }

      .sidebar {
        width: 240px;
      }

      .header {
        left: 240px;
      }

      .main-content {
        margin-left: 240px;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -280px;
        transition: left 0.3s ease;
        width: 280px;
      }

      .sidebar.active {
        left: 0;
      }

      .header {
        left: 0;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .search-bar {
        width: 200px;
      }

      .summary-cards {
        grid-template-columns: 1fr;
      }

      .chart-container {
        height: 300px;
      }

      .chart-wrapper {
        height: 240px;
      }

      .header-right {
        gap: 12px;
      }
    }

    /* ============================================
       ANIMATIONS
       ============================================ */

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .card {
      animation: slideIn 0.3s ease forwards;
    }

    .summary-cards .card:nth-child(1) { animation-delay: 0.05s; }
    .summary-cards .card:nth-child(2) { animation-delay: 0.1s; }
    .summary-cards .card:nth-child(3) { animation-delay: 0.15s; }
    .summary-cards .card:nth-child(4) { animation-delay: 0.2s; }
  </style>
</head>
<body>

  <!-- ============================================
       SIDEBAR
       ============================================ -->

  <aside class="sidebar">
    <div class="logo">
      <i class="fas fa-cupcake"></i>
      <span>Three D Bakery</span>
    </div>

    <a href="#" class="menu-item active">
      <i class="fas fa-home"></i>
      <span>Dashboard</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-shopping-bag"></i>
      <span>Pesanan</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-users"></i>
      <span>Pelanggan</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-user-tie"></i>
      <span>Karyawan</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-box"></i>
      <span>Produk</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-credit-card"></i>
      <span>Pembayaran</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-chart-bar"></i>
      <span>Laporan</span>
    </a>
    <a href="#" class="menu-item">
      <i class="fas fa-cog"></i>
      <span>Pengaturan</span>
    </a>
  </aside>

  <!-- ============================================
       HEADER
       ============================================ -->

  <header class="header">
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Cari pesanan, pelanggan...">
    </div>

    <div class="header-right">
      <div class="header-icon">
        <i class="fas fa-bell"></i>
        <span class="notification-badge">3</span>
      </div>

      <div class="profile-section" onclick="toggleProfileDropdown()">
        <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'OWNER', 0, 2)) }}</div>
        <div class="profile-info">
          <div class="name">{{ auth()->user()->name ?? 'Owner' }}</div>
          <div class="role">{{ ucfirst(auth()->user()->role ?? 'Owner') }}</div>
        </div>
        <i class="fas fa-chevron-down"></i>

        <!-- Profile Dropdown -->
        <div class="profile-dropdown" id="profileDropdown">
          <a href="#" class="dropdown-item">
            <i class="fas fa-user-circle"></i>
            <span>Profile Saya</span>
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
          </a>
          <form method="POST" action="{{ route('logout') }}" class="dropdown-item logout" onclick="this.form.submit(); return false;">
            @csrf
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- ============================================
       MAIN CONTENT
       ============================================ -->

  <main class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <h1>Dashboard</h1>
      <p>Selamat datang kembali! Berikut adalah ringkasan bisnis Anda hari ini.</p>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Total Pemesanan</div>
          <div class="card-icon green">
            <i class="fas fa-shopping-bag"></i>
          </div>
        </div>
        <div class="card-value">{{ $totalPenjualan ?? '1.284' }}</div>
        <div class="card-subtitle positive">↑ 12% dari bulan lalu</div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Pendapatan Bulan Ini</div>
          <div class="card-icon blue">
            <i class="fas fa-chart-line"></i>
          </div>
        </div>
        <div class="card-value">Rp {{ $totalPenjualan ?? '45.2M' }}</div>
        <div class="card-subtitle positive">↑ 8% dari bulan lalu</div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Pesanan Belum Lunas</div>
          <div class="card-icon orange">
            <i class="fas fa-hourglass-end"></i>
          </div>
        </div>
        <div class="card-value">{{ $pesananBelumLunas ?? '247' }}</div>
        <div class="card-subtitle negative">Perlu Perhatian</div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Setoran Karyawan</div>
          <div class="card-icon red">
            <i class="fas fa-wallet"></i>
          </div>
        </div>
        <div class="card-value">Rp 8.5M</div>
        <div class="card-subtitle positive">↑ 5% dari kemarin</div>
      </div>
    </div>

    <!-- Charts Grid -->
    <div class="dashboard-grid">
      <!-- Line Chart -->
      <div class="chart-container">
        <h3 class="chart-title">Grafik Total Pemesanan</h3>
        <div class="chart-wrapper">
          <canvas id="orderChart"></canvas>
        </div>
      </div>

      <!-- Customer List -->
      <div class="card">
        <h3 class="chart-title">Pelanggan yang Pesan</h3>
        <div class="customer-list">
          <div class="customer-item">
            <div class="customer-avatar">AM</div>
            <div class="customer-info">
              <div class="customer-name">Ahmad Mansur</div>
              <div class="customer-details">12 pesanan</div>
            </div>
            <div class="customer-time">5 min lalu</div>
          </div>

          <div class="customer-item">
            <div class="customer-avatar">SR</div>
            <div class="customer-info">
              <div class="customer-name">Siti Rahma</div>
              <div class="customer-details">8 pesanan</div>
            </div>
            <div class="customer-time">15 min lalu</div>
          </div>

          <div class="customer-item">
            <div class="customer-avatar">RW</div>
            <div class="customer-info">
              <div class="customer-name">Rinto Wijaya</div>
              <div class="customer-details">24 pesanan</div>
            </div>
            <div class="customer-time">32 min lalu</div>
          </div>

          <div class="customer-item">
            <div class="customer-avatar">DN</div>
            <div class="customer-info">
              <div class="customer-name">Dewi Nurjanah</div>
              <div class="customer-details">5 pesanan</div>
            </div>
            <div class="customer-time">1 jam lalu</div>
          </div>

          <div class="customer-item">
            <div class="customer-avatar">TR</div>
            <div class="customer-info">
              <div class="customer-name">Andi Trianto</div>
              <div class="customer-details">18 pesanan</div>
            </div>
            <div class="customer-time">2 jam lalu</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Second Grid Row -->
    <div class="dashboard-grid-2">
      <!-- Bar Chart -->
      <div class="chart-container bar-chart-container">
        <h3 class="chart-title">Grafik Setor Karyawan</h3>
        <div class="chart-wrapper">
          <canvas id="depositChart"></canvas>
        </div>
      </div>

      <!-- Deposit List -->
      <div class="card">
        <h3 class="chart-title">Setoran Karyawan Terbaru</h3>
        <div class="deposit-list">
          <div class="deposit-item">
            <div class="deposit-employee">
              <div class="deposit-name">Budi Santoso</div>
              <div class="deposit-date">21 April 2026</div>
            </div>
            <div class="deposit-info">
              <div class="deposit-amount">Rp 2.5M</div>
              <span class="badge success">Sudah Disetor</span>
            </div>
          </div>

          <div class="deposit-item">
            <div class="deposit-employee">
              <div class="deposit-name">Hendra Wijaya</div>
              <div class="deposit-date">21 April 2026</div>
            </div>
            <div class="deposit-info">
              <div class="deposit-amount">Rp 1.8M</div>
              <span class="badge success">Sudah Disetor</span>
            </div>
          </div>

          <div class="deposit-item">
            <div class="deposit-employee">
              <div class="deposit-name">Siti Maryanto</div>
              <div class="deposit-date">20 April 2026</div>
            </div>
            <div class="deposit-info">
              <div class="deposit-amount">Rp 3.2M</div>
              <span class="badge success">Sudah Disetor</span>
            </div>
          </div>

          <div class="deposit-item">
            <div class="deposit-employee">
              <div class="deposit-name">Eka Prasetya</div>
              <div class="deposit-date">20 April 2026</div>
            </div>
            <div class="deposit-info">
              <div class="deposit-amount">Rp 1.5M</div>
              <span class="badge success">Sudah Disetor</span>
            </div>
          </div>

          <div class="deposit-item">
            <div class="deposit-employee">
              <div class="deposit-name">Bambang Setiawan</div>
              <div class="deposit-date">19 April 2026</div>
            </div>
            <div class="deposit-info">
              <div class="deposit-amount">Rp 2.1M</div>
              <span class="badge success">Sudah Disetor</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Stats -->
    <div class="bottom-stats">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Total Produk</div>
          <div class="card-icon green">
            <i class="fas fa-box"></i>
          </div>
        </div>
        <div class="card-value">{{ $totalProduk ?? '256' }}</div>
        <div class="card-subtitle">Aktif dalam sistem</div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Total Karyawan</div>
          <div class="card-icon blue">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="card-value">18</div>
        <div class="card-subtitle">Karyawan aktif</div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Total Pelanggan</div>
          <div class="card-icon orange">
            <i class="fas fa-user-friends"></i>
          </div>
        </div>
        <div class="card-value">{{ $totalPelanggan ?? '542' }}</div>
        <div class="card-subtitle">Pelanggan terdaftar</div>
      </div>

      <div class="card">
        <div class="card-header">
          <div class="card-title">Pesanan Hari Ini</div>
          <div class="card-icon red">
            <i class="fas fa-calendar-day"></i>
          </div>
        </div>
        <div class="card-value">{{ $pesananHariIni ?? '84' }}</div>
        <div class="card-subtitle">Pesanan aktif</div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
  <script>
    // Toggle Profile Dropdown
    function toggleProfileDropdown() {
      const dropdown = document.getElementById('profileDropdown');
      dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      const profileSection = document.querySelector('.profile-section');
      const dropdown = document.getElementById('profileDropdown');
      if (!profileSection.contains(e.target)) {
        dropdown.classList.remove('active');
      }
    });

    // Line Chart - Total Pesanan
    const orderCtx = document.getElementById('orderChart').getContext('2d');
    
    const orderChart = new Chart(orderCtx, {
      type: 'line',
      data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
          label: 'Jumlah Pesanan',
          data: [120, 145, 165, 150, 190, 210, 180],
          borderColor: '#A8D5BA',
          backgroundColor: 'rgba(168, 213, 186, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 6,
          pointBackgroundColor: '#81C784',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointHoverRadius: 8,
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
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              color: '#666666',
              font: {
                size: 12,
                weight: 500
              }
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false
            },
            ticks: {
              color: '#666666',
              font: {
                size: 12,
                weight: 500
              }
            }
          }
        }
      }
    });

    // Bar Chart - Setor Karyawan
    const depositCtx = document.getElementById('depositChart').getContext('2d');
    
    const depositChart = new Chart(depositCtx, {
      type: 'bar',
      data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
          label: 'Setoran (Juta)',
          data: [2.5, 3.2, 2.8, 3.5, 4.1, 5.2, 4.8],
          backgroundColor: [
            'rgba(168, 213, 186, 0.8)',
            'rgba(168, 213, 186, 0.8)',
            'rgba(168, 213, 186, 0.8)',
            'rgba(129, 199, 132, 0.8)',
            'rgba(129, 199, 132, 0.8)',
            'rgba(86, 171, 145, 0.8)',
            'rgba(129, 199, 132, 0.8)'
          ],
          borderColor: '#81C784',
          borderWidth: 1,
          borderRadius: 8,
          hoverBackgroundColor: '#56AB91'
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
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              color: '#666666',
              font: {
                size: 12,
                weight: 500
              },
              callback: function(value) {
                return 'Rp ' + value + 'M';
              }
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false
            },
            ticks: {
              color: '#666666',
              font: {
                size: 12,
                weight: 500
              }
            }
          }
        }
      }
    });

    // Menu active state
    document.querySelectorAll('.menu-item').forEach(item => {
      item.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
      });
    });
  </script>
</body>
</html>

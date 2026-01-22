<?php
// app/Views/layout/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Base path for public assets
$base_url = ".";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($page_title) ? $page_title . " - Botola Pro" : "Botola Pro Inwi"; ?>
    </title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Inter:wght@400;600&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo-area">
                <div class="mobile-header-controls"
                    style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <a href="index.php">
                        <img src="<?php echo $base_url; ?>/images/botola_logo.png" alt="Botola Pro" class="main-logo">
                    </a>
                    <button id="mobile-menu-btn"
                        style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; display: none;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>

            <nav class="side-nav">
                <a href="index.php"
                    class="<?php echo (!isset($current_page) || $current_page == 'index') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-table-list"></i> Classement
                </a>
                <a href="index.php?controller=home&action=calendar"
                    class="<?php echo (isset($current_page) && $current_page == 'calendar') ? 'active' : ''; ?>">
                    <i class="fa-regular fa-calendar-days"></i> Calendrier
                </a>
                <a href="index.php?controller=home&action=stats"
                    class="<?php echo (isset($current_page) && $current_page == 'stats') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-bar"></i> Statistiques
                </a>

                <div style="border-top: 1px solid #333; margin: 10px 0;"></div>

                <a href="index.php?controller=ticket&action=index"
                    class="<?php echo (isset($current_page) && $current_page == 'ticketing') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-ticket"></i> Billetterie
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php?controller=ticket&action=my_tickets"
                        class="<?php echo (isset($current_page) && $current_page == 'my_tickets') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-receipt"></i> Mes Tickets
                    </a>

                    <!-- Admin Link -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="index.php?controller=admin&action=index"
                            class="<?php echo (isset($current_page) && $current_page == 'admin') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-lock"></i> Administration
                        </a>
                    <?php endif; ?>

                <?php else: ?>
                    <a href="index.php?controller=auth&action=login"
                        class="<?php echo (isset($current_page) && $current_page == 'login') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-user"></i> Se connecter
                    </a>
                <?php endif; ?>
            </nav>

            <div class="sidebar-footer">
                <p>Saison 2024-2025</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>
                    <?php echo isset($page_title) ? $page_title : "Botola Pro Inwi"; ?>
                </h1>
                <div class="user-status">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span>Bonjour, <strong>
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </strong></span>
                        <a href="index.php?controller=auth&action=logout"
                            style="color: #ff6b6b; text-decoration: none; margin-left: 15px; font-size: 0.9rem;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    <?php else: ?>
                        <span style="color: #666; font-style: italic;">Non connecté</span>
                    <?php endif; ?>
                </div>
            </header>

            <div class="content-wrapper">
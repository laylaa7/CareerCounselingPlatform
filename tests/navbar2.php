<?php
session_start();
$_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : 'Nour B';
?>

<style>
    .navbar {
        background-color: #ffffff;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: 60px;
        z-index: 1000;
    }
    .left-nav-section {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    .logo {
        font-size: 1.2rem;
        font-weight: bold;
        color: #3949ab;
    }
    .nav-links {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 1rem;
    }
    .nav-links a {
        text-decoration: none;
        color: #333;
    }
    .profile-nav-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .profile-nav-name {
        margin-right: 0.5rem;
    }
    .dropdown img {
        width: 35px;
        height: 35px;
    }
    .dropdown img {
        width: 35px;
        height: 35px;
    }
    .profile-nav-name {
        margin-right: 0.5rem;
    }
    .dropdown {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 4px;
        margin-top: 0.5rem;
    }
    .dropdown-content a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }
    .dropdown-active .dropdown-content {
        display: block;
    }
    .dropdown-arrow {
        padding: 0.5rem;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .dropdown-active .dropdown-arrow {
        transform: rotate(180deg);
    }
    .menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    @media screen and (max-width: 768px) {
        .left-section {
            gap: 1rem;
        }
        .search-bar {
            display: none;
        }
        .nav-links {
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            flex-direction: column;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
        }
        .nav-links.active {
            display: flex;
        }
        .nav-links li {
            width: 100%;
            text-align: center;
        }
        .nav-links a {
            padding: 1rem;
            display: block;
        }
        .menu-toggle {
            display: block;
        }
        .profile-section {
            margin-left: auto;
        }
    }
</style>

<nav class="navbar">
    <div class="left-nav-section">
        <div class="logo">Compass</div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
        </ul>
    </div>
    <div class="profile-nav-section">
        <span class="profile-nav-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
        <div class="dropdown" id="profile-dropdown">
            <img src="../../public/assets/images/profile.png" alt="Profile" class="profile-img">
            <span class="dropdown-arrow">▼</span>
            <div class="dropdown-content">
                <a href="../../src/pages/UserProfile.php">Edit Profile</a>
                <a id="logout-link" >Log Out</a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('profile-dropdown');
    const dropdownArrow = dropdown.querySelector('.dropdown-arrow');

    dropdownArrow.addEventListener('click', (e) => {
        e.stopPropagation(); 
        dropdown.classList.toggle('dropdown-active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('dropdown-active');
        }
    });

    dropdown.querySelector('.dropdown-content').addEventListener('click', (e) => {
        e.stopPropagation();
    });

    dropdown.querySelectorAll('.dropdown-content a:not(#logout-link)').forEach(link => {
        link.addEventListener('click', () => {
            dropdown.classList.remove('dropdown-active');
        });
    });

    // Logout confirmation
    document.querySelector('#logout-link')?.addEventListener('click', function(e) {
        if (confirm('Are you sure you want to log out?')) {
             
             return window.location.href = '../index.php';
        }
        e.preventDefault();
        return false;
    });

    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    menuToggle?.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });

    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
        });
    });
});
</script>

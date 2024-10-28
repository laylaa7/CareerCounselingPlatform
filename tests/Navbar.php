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
    .logo {
        display: flex;
        align-items: center;
        font-size: 1.2rem;
        font-weight: bold;
        color: #3949ab;
    }
    .logo-icon {
        margin-right: 0.5rem;
    }
    .nav-links {
        display: flex;
        list-style: none;
    }
    .nav-links li {
        margin-left: 1.5rem;
    }
    .nav-links a {
        text-decoration: none;
        color: #333;
    }
    .dropdown {
        position: relative;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .back-btn {
        background-color: #3949ab;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }
    .menu-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
    }
    @media screen and (max-width: 768px) {
        .nav-links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .nav-links.active {
            display: flex;
        }
        .nav-links li {
            margin: 0;
            text-align: center;
        }
        .nav-links a {
            display: block;
            padding: 1rem;
        }
        .menu-toggle {
            display: block;
        }
        .dropdown-content {
            position: static;
            box-shadow: none;
            background-color: #f1f1f1;
        }
    }
</style>

<nav class="navbar">
    <div class="logo">
        <span class="logo-icon">☰</span>
        Career Counseling
    </div>
    <ul class="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#services">Services</a></li>
        <!-- <li><a href="#portfolio">Portfolio</a></li>
        <li><a href="#team">Team</a></li>
        <li><a href="#blog">Blog</a></li>
        <li class="dropdown">
            <a href="#dropdown">Dropdown ▼</a>
            <div class="dropdown-content">
                <a href="#item1">Item 1</a>
                <a href="#item2">Item 2</a>
                <a href="#item3">Item 3</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#listing-dropdown">Listing Dropdown ▼</a>
            <div class="dropdown-content">
                <a href="#listing1">Listing 1</a>
                <a href="#listing2">Listing 2</a>
                <a href="#listing3">Listing 3</a>
            </div>
        </li> -->
        <li><a href="#contact">Contact</a></li>
    </ul>
    
  
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Close mobile menu when a link is clicked
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });
    });
</script>
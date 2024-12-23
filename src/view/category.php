
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Interview Simulator</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f5f5f5;
            }
            .container {
                margin-top: 120px;
                background-color: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .category-list {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }
            .category-card {
                background-color: #f8f9fa;
                padding: 20px;
                border-radius: 5px;
                text-align: center;
                transition: transform 0.2s;
                cursor: pointer;
            }
            .category-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 10px;
            }
            .button:hover {
                background-color: #0056b3;
            }
            
        </style>
    </head>
    <body>
    <header>
        <nav class="navbar">
            <?php require_once __DIR__ . "/../../tests/Navbar2.php"; ?>
        </nav>
    </header>
        <div class="container">
            <h1>Welcome to the Interview Simulator</h1>
            <p>Select a category to begin your practice:</p>
            
            <div class="category-list">
            <div class="category-card">
                    <h3>General</h3>
                    <p>Practice general interview questions</p>
                    <a href="?category=General" class="button">Start Practice</a>
                </div>
                <div class="category-card">
                    <h3>Technical Interview</h3>
                    <p>Practice coding and technical questions</p>
                    <a href="?category=technical" class="button">Start Practice</a>
                </div>
                
                <div class="category-card">
                    <h3>Behavioral Interview</h3>
                    <p>Practice soft skills questions</p>
                    <a href="?category=behavioral" class="button">Start Practice</a>
                </div>
                
               
            </div>
        </div>
    </body>
    </html>
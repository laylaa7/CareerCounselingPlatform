<nav class="navbar">
    <?php require_once __DIR__ . "/../../tests/Navbar2.php"; ?>
</nav>

<div class="hero-search">
    <div class="search-heading">
        <h1>Find Your Next Opportunity</h1>
        <p>Search thousands of jobs from top companies</p>
    </div>
    <form method="POST" class="search-form">
        <div class="search-fields">
            <div class="search-group">
                <i class="search-icon">🔍</i>
                <input 
                    type="text" 
                    name="keywords" 
                    placeholder="Job title or keyword (e.g. Software Engineer, Marketing)" 
                    required 
                    class="search-input"
                >
            </div>
            <div class="search-group">
                <i class="search-icon">📍</i>
                <input 
                    type="text" 
                    name="geo_code" 
                    placeholder="Location code (e.g. 103644278)" 
                    required 
                    class="search-input"
                >
            </div>
            <button type="submit" class="search-button">Search Jobs</button>
        </div>
    </form>
</div>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keywords = $_POST['keywords'];
    $geo_code = $_POST['geo_code'];
    
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://fresh-linkedin-profile-data.p.rapidapi.com/search-jobs",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'keywords' => $keywords,
            'geo_code' => (int)$geo_code,
            'date_posted' => 'Any time',
            'sort_by' => 'Most relevant',
            'start' => 0
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: fresh-linkedin-profile-data.p.rapidapi.com",
            "x-rapidapi-key: 643413f730msh7326ab12817356dp11fc56jsn035ccd4e1125"
        ],
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        echo "<div class='error-message'>Error: " . htmlspecialchars($err) . "</div>";
    } else {
        $jobs = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "<div class='error-message'>JSON Decode Error: " . htmlspecialchars(json_last_error_msg()) . "</div>";
            exit;
        }
        
        if (isset($jobs['data']) && is_array($jobs['data'])) {
            echo "<div class='results-summary'>Showing " . count($jobs['data']) . " jobs matching your search</div>";
            echo "<div class='jobs-container'>";
            foreach ($jobs['data'] as $job) {
                echo "<div class='job-card'>";
                echo "<div class='job-header'>";
                echo "<h3>" . htmlspecialchars($job['job_title'] ?? 'No Title') . "</h3>";
                echo "<span class='company-name'>" . htmlspecialchars($job['company'] ?? 'Unknown') . "</span>";
                echo "</div>";
                
                if (isset($job['job_url'])) {
                    echo "<a href='" . htmlspecialchars($job['job_url']) . "' class='view-job-btn' target='_blank'>View Job</a>";
                } else {
                    echo "<p class='no-link'>No link available for this job.</p>";
                }
                
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='no-jobs-message'>No jobs found matching your search criteria. Try adjusting your keywords or location.</div>";
        }
    }
} ?>

<style>
    .hero-search {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
        padding: 4rem 2rem;
        margin-top: 60px;
        text-align: center;
        color: white;
    }

    .search-heading h1 {
        font-size: 2.5rem;
        margin: 0 0 0.5rem 0;
        font-weight: 600;
    }

    .search-heading p {
        font-size: 1.1rem;
        margin: 0 0 2rem 0;
        opacity: 0.9;
    }

    .search-form {
        max-width: 900px;
        margin: 0 auto;
    }

    .search-fields {
        display: flex;
        gap: 1rem;
        background: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .search-group {
        flex: 1;
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-style: normal;
        color: #666;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
    }

    .search-button {
        background: #1a73e8;
        color: white;
        padding: 0 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
        white-space: nowrap;
    }

    .search-button:hover {
        background: #1557b0;
    }

    .results-summary {
        text-align: center;
        color: #4a5568;
        margin: 2rem 0;
        font-size: 1.1rem;
    }

    .jobs-container {
        max-width: 1200px;
        margin: 2rem auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 0 1rem;
    }

    .job-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .job-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .job-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }

    .job-header h3 {
        margin: 0 0 0.5rem 0;
        color: #2d3748;
        font-size: 1.25rem;
        line-height: 1.4;
    }

    .company-name {
        color: #4a5568;
        font-size: 1rem;
        font-weight: 500;
    }

    .view-job-btn {
        display: inline-block;
        background: #1a73e8;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        font-weight: 500;
        margin-top: auto;
        transition: background-color 0.2s ease;
    }

    .view-job-btn:hover {
        background: #1557b0;
    }

    .no-link {
        color: #718096;
        text-align: center;
        margin-top: auto;
        font-style: italic;
    }

    .error-message, .no-jobs-message {
        background: #fed7d7;
        color: #c53030;
        padding: 1rem;
        border-radius: 6px;
        margin: 2rem auto;
        max-width: 600px;
        text-align: center;
    }

    .no-jobs-message {
        background: #e2e8f0;
        color: #4a5568;
    }

    @media (max-width: 768px) {
        .hero-search {
            padding: 2rem 1rem;
            margin-top: 60px;
        }

        .search-heading h1 {
            font-size: 1.8rem;
        }

        .search-fields {
            flex-direction: column;
            padding: 1rem;
        }

        .search-button {
            width: 100%;
            padding: 1rem;
        }
        
        .jobs-container {
            grid-template-columns: 1fr;
        }
    }
</style>
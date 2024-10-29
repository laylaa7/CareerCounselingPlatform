<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Questions</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #f3f2ef;
            color: rgba(0, 0, 0, 0.9);
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .header {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .header h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .question-container {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .question {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .answer-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .button {
            background-color: #0a66c2;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 24px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .button:hover {
            background-color: #004182;
        }

        .button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .progress {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: #666;
        }

        .progress-bar {
            flex-grow: 1;
            height: 4px;
            background-color: #e0e0e0;
            margin: 0 1rem;
            border-radius: 2px;
        }

        .progress-fill {
            height: 100%;
            background-color: #0a66c2;
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .overview {
            font-size: 0.9rem;
            color: #666;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
        }

        @media (max-width: 640px) {
            .container {
                margin: 1rem auto;
            }

            .header, .question-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Common Interview Questions</h1>
            <div class="progress">
                <span id="current-question">1</span>/<span id="total-questions">5</span>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
            </div>
        </div>

        <div class="question-container" id="question-container">
            <div class="question" id="question-text"></div>
            <textarea class="answer-input" id="answer-input" rows="4" placeholder="Type your answer here..."></textarea>
            <button class="button" id="next-button">Next Question</button>
        </div>
    </div>

    <script>
       
    </script>
</body>
</html>
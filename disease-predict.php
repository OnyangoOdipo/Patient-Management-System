<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        if ($input === null || !isset($input['symptoms'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid input.']);
            exit;
        }

        $url = 'http://localhost:5000/predict';
        $data = array('symptoms' => $input['symptoms']);
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Error occurred while fetching the prediction.']);
            exit;
        }

        $response = json_decode($result, true);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease Prediction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #007bb5;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            font-size: 1.1em;
            color: #007bb5;
        }
        input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #007bb5;
            border-radius: 4px;
        }
        button {
            background-color: #007bb5;
            color: white;
            cursor: pointer;
            font-size: 1.1em;
        }
        button:hover {
            background-color: #005f8c;
        }
        .result {
            margin-top: 20px;
            background-color: #f1f8fc;
            padding: 20px;
            border-radius: 8px;
        }
        .result h2 {
            color: #007bb5;
        }
        .result p, .result ul {
            margin: 5px 0;
            color: #555;
        }
        .result ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .warning {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffcccb;
            border: 1px solid #e57373;
            border-radius: 8px;
        }
        .warning p {
            margin: 0;
            font-weight: bold;
            color: #e57373;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            label, input, button {
                font-size: 0.9em;
            }
            button {
                font-size: 1em;
            }
            .result {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Disease Prediction</h1>
        <form id="symptoms-form">
            <label for="symptoms">Enter Symptoms (comma separated)</label>
            <input type="text" id="symptoms" name="symptoms">
            <button type="button" id="submit-btn">Predict</button>
        </form>
        <div id="warning" class="warning" style="display: none;">
            <p>Please note<br>
                This AI-based diagnosis is not a substitute for professional medical advice, diagnosis, or treatment. Always seek the advice of your physician or other qualified health provider with any questions you may have regarding a medical condition. By clicking 'Agree', you acknowledge that you have read and understood this warning.</p><br>
            <button id="agree-btn">Agree</button>
        </div>
        <div id="results"></div>
    </div>

    <script>
        document.getElementById('submit-btn').addEventListener('click', function() {
            document.getElementById('warning').style.display = 'block';
        });

        document.getElementById('agree-btn').addEventListener('click', function() {
            document.getElementById('warning').style.display = 'none';

            const symptoms = document.getElementById('symptoms').value;
            fetch('disease-predict.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ symptoms: symptoms.split(',') })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('results').innerHTML = '<div class="result"><h2>Error</h2><p>' + data.error + '</p></div>';
                } else {
                    let resultHTML = '<div class="result">';
                    resultHTML += '<h2>Prediction Result</h2>';
                    resultHTML += '<p><strong>Disease</strong>: ' + data.prediction + '</p>';
                    resultHTML += '<p><strong>Description</strong>: ' + data.description + '</p>';
                    resultHTML += '<p><strong>Precautions</strong></p><ul>';
                    data.precautions.forEach(item => resultHTML += '<li>' + item + '</li>');
                    resultHTML += '</ul><p><strong>Medications</strong></p><ul>';
                    data.medications.forEach(item => resultHTML += '<li>' + item + '</li>');
                    resultHTML += '</ul><p><strong>Diets</strong></p><ul>';
                    data.diets.forEach(item => resultHTML += '<li>' + item + '</li>');
                    resultHTML += '</ul><p><strong>Recommendations</strong></p><ul>';
                    data.workouts.forEach(item => resultHTML += '<li>' + item + '</li>');
                    resultHTML += '</ul></div>';
                    document.getElementById('results').innerHTML = resultHTML;
                }
            })
            .catch(error => {
                document.getElementById('results').innerHTML = '<div class="result"><h2>Error</h2><p>' + error.message + '</p></div>';
            });
        });
    </script>
</body>
</html>

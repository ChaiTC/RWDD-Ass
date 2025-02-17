<?php
// Include the database connection
include 'connection.php';
include 'sidebar.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer'])) {
    $user_answers = $_POST['answer'];
    $score = 0;
    $total_questions = count($user_answers);
    $correct_answers = [];

    // Fetch correct answers
    $question_ids = implode(',', array_keys($user_answers));
    $sql = "SELECT * FROM quiz_option_table WHERE question_id IN ($question_ids) AND is_correct = 1";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $correct_answers[$row['question_id']] = $row['option_id'];
        }
    }

    // Check user answers
    foreach ($user_answers as $question_id => $selected_option) {
        if (isset($correct_answers[$question_id]) && $correct_answers[$question_id] == $selected_option) {
            $score++;
        }
    }

    // Calculate percentage
    $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;
} else {
    $score = 0;
    $percentage = 0;
    $total_questions = 0;
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="submit_style.css"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Load Chart.js -->
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Quiz Results</h2>
        <p>Total Questions: <strong><?php echo $total_questions; ?></strong></p>
        <p>Correct Answers: <strong><?php echo $score; ?></strong></p>
        <p>Score Percentage: <strong><?php echo round($percentage, 2); ?>%</strong></p>

        <!-- Chart Container -->
        <div class="chart-container">
            <canvas id="scoreChart"></canvas>
        </div>

        <a href="quizz_Page.php">
            <button class="retry-btn">Try Again</button>
        </a>
    </div>

    <script src="submit_script.js"></script> <!-- Link to external JS -->
    <script>
        // Pass PHP variables to JavaScript
        const score = <?php echo $score; ?>;
        const totalQuestions = <?php echo $total_questions; ?>;
    </script>

</body>
</html>


<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$score = 0;
$total_questions = 0;
$correct_answers = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer'])) {
    $user_answers = $_POST['answer'];
    $total_questions = count($user_answers);


    $question_ids = implode(',', array_keys($user_answers));
    $sql = "SELECT * FROM quiz_option_table WHERE question_id IN ($question_ids) AND is_correct = 1";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $correct_answers[$row['question_id']] = $row['option_id'];
        }
    }

 
    foreach ($user_answers as $question_id => $selected_option) {
        if (isset($correct_answers[$question_id]) && $correct_answers[$question_id] == $selected_option) {
            $score++;
        }
    }

  
    $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;


    $stmt = $connection->prepare("INSERT INTO quiz_results_table (user_id, total_score, result_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $score);
    $stmt->execute();
    $stmt->close();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="submit_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <h2>Quiz Results</h2>
    <p>Total Questions: <strong><?php echo $total_questions; ?></strong></p>
    <p>Correct Answers: <strong><?php echo $score; ?></strong></p>
    <p>Score Percentage: <strong><?php echo round($percentage, 2); ?>%</strong></p>

    <div class="chart-container">
        <canvas id="scoreChart"></canvas>
    </div>

    <a href="quiz_page.php">
        <button class="retry-btn">Try Again</button>
    </a>

    <?php include 'footer.php'; ?>
</div>

<script src="submit_script.js"></script>
<script>
   
    const score = <?php echo $score; ?>;
    const totalQuestions = <?php echo $total_questions; ?>;
</script>
<script src="sidebar.js"></script>

</body>
</html>




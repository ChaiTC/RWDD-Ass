<?php
// Include the database connection
include 'connection.php';
include 'sidebar.php';
include 'header.php';

// Fetch random questions from quiz_questions_table
$sql = "SELECT * FROM quiz_questions_table ORDER BY RAND() LIMIT 5";
$result = $connection->query($sql);

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[$row['question_id']] = [
            'question' => $row['question'],
            'options' => []
        ];
    }
}

// Fetch corresponding options from quiz_option_table
$question_ids = implode(',', array_keys($questions));
if (!empty($question_ids)) {
    $option_sql = "SELECT * FROM quiz_option_table WHERE question_id IN ($question_ids)";
    $option_result = $connection->query($option_sql);

    if ($option_result->num_rows > 0) {
        while ($row = $option_result->fetch_assoc()) {
            $questions[$row['question_id']]['options'][] = $row;
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Quiz</title>
    <link rel="stylesheet" href="quiz_style.css"> 
</head>
<body>



    <div class="main-content">
        <h2>Quiz</h2>
        <form action="submit.php" method="POST">
            <div id="quiz-container">
                <?php $index = 0; ?>
                <?php foreach ($questions as $question_id => $question): ?>
                    <div class="question" data-index="<?php echo $index; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                        <p><strong><?php echo $question['question']; ?></strong></p>
                        <?php foreach ($question['options'] as $option): ?>
                            <label class="option-label">
                                <input type="radio" name="answer[<?php echo $question_id; ?>]" value="<?php echo $option['option_id']; ?>" class="option-input">
                                <span class="option-text"><?php echo $option['option_text']; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </div>

            <button type="button" id="prev-btn" disabled>Previous</button>
            <button type="button" id="next-btn">Next</button>
            <input type="submit" id="submit-btn" value="Submit" style="display: none;">
        </form>
    </div>

    <script src="quiz_script.js"></script> <!-- Link to external JavaScript -->
</body>
</html>


const questions = [
  { question: "What is a budget?", answer: "A plan for saving and spending money" },
  { question: "What is the difference between needs and wants?", answer: "Needs are things you can't live without, wants are things you can live without" },
  { question: "Which of the following is an example of a need?", answer: "Rent or mortgage" },
  { question: "What should you do if you don’t have enough money to pay for something you want?", answer: "Save up money for it" },
  { question: "What is one good way to save money?", answer: "Save a portion of your income regularly" }
];

let score = 0;

function nextQuestion(questionIndex) {
  const selectedOption = document.querySelector(`input[name="question${questionIndex}"]:checked`);
  if (selectedOption) {
    // Check answer and increment score
    if (selectedOption.value === questions[questionIndex - 1].answer) {
      score++;
    }
  }

  // Hide the current question
  document.getElementById(`question${questionIndex}`).classList.remove('active');

  // Show next question
  if (questionIndex < questions.length) {
    document.getElementById(`question${questionIndex + 1}`).classList.add('active');
  } else {
    // Enable the submit button after the last question
    document.getElementById('submit-btn').disabled = false;
  }
}

function previousQuestion(questionIndex) {
  // Hide the current question
  document.getElementById(`question${questionIndex}`).classList.remove('active');

  // Show the previous question
  if (questionIndex > 1) {
    document.getElementById(`question${questionIndex - 1}`).classList.add('active');
  }
}

function submitQuiz() {
  const feedbackDiv = document.querySelector('.feedback');
  const scoreDiv = document.querySelector('.score');

  // Feedback based on score
  if (score === 5) {
    feedbackDiv.innerHTML = "<span style='color: #4caf50;'>Excellent! You understand budgeting perfectly!</span>";
  } else if (score >= 3) {
    feedbackDiv.innerHTML = "<span style='color: #007bff;'>Good job! You're on your way to better budgeting!</span>";
  } else {
    feedbackDiv.innerHTML = "<span style='color: #f44336;'>Keep learning! You can improve your budgeting knowledge.</span>";
  }

  scoreDiv.innerHTML = `Your score: ${score} out of 5.`;

  // Show results page
  document.getElementById('results').style.display = 'block';
  document.querySelector('.container').style.display = 'none';
}

function retryQuiz() {
  score = 0;
  document.querySelector('.container').style.display = 'block';
  document.getElementById('results').style.display = 'none';
  document.getElementById('question1').classList.add('active');
  document.getElementById('submit-btn').disabled = true;
}

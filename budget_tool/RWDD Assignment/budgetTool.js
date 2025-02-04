let totalIncome = 0;
let totalExpenses = 0;

// Function to update the summary
function updateSummary() {
  const balance = totalIncome - totalExpenses;

  document.getElementById('total-income').textContent = totalIncome.toFixed(2);
  document.getElementById('total-expenses').textContent = totalExpenses.toFixed(2);
  document.getElementById('balance').textContent = balance.toFixed(2);

  const tipsElement = document.getElementById('tips');
  if (balance < 0) {
    tipsElement.textContent = 'Your expenses exceed your income! Consider cutting down unnecessary expenses.';
  } else if (balance <= 1000) {
    tipsElement.textContent = 'You have a balanced budget. Ensure to save some income for future goals!';
  } else {
    tipsElement.textContent = 'Great job! Keep saving and maintaining a positive balance!';
  }
}

// Add income
document.getElementById('add-income').addEventListener('click', () => {
  const incomeInput = document.getElementById('income-amount');
  const income = parseFloat(incomeInput.value);

  if (!isNaN(income) && income > 0) {
    totalIncome += income;
    incomeInput.value = '';
    updateSummary();
  } else {
    alert('Please enter a valid income amount.');
  }
});

// Add expense
document.getElementById('add-expense').addEventListener('click', () => {
  const expenseInput = document.getElementById('expense-amount');
  const expense = parseFloat(expenseInput.value);

  if (!isNaN(expense) && expense > 0) {
    totalExpenses += expense;
    expenseInput.value = '';
    updateSummary();
  } else {
    alert('Please enter a valid expense amount.');
  }
});
vv
var totalIncome = 0;
var totalExpenses = 0;

// Fetch latest income from database
function fetchIncome() {
  fetch('fetch_income.php')
    .then(function(response) {
      return response.text();
    })
    .then(function(data) {
      totalIncome = parseFloat(data) || 0;
      updateSummary();
    })
    .catch(function(error) {
      console.error('Error fetching income:', error);
    });
}

// Fetch total expenses from database
function fetchExpenses() {
  fetch('fetch_expenses.php')
    .then(function(response) {
      return response.text();
    })
    .then(function(data) {
      totalExpenses = parseFloat(data) || 0;
      updateSummary();
    })
    .catch(function(error) {
      console.error('Error fetching expenses:', error);
    });
}

// Function to update the summary
function updateSummary() {
  var balance = totalIncome - totalExpenses;

  document.getElementById('total-income').textContent = totalIncome.toFixed(2);
  document.getElementById('total-expenses').textContent = totalExpenses.toFixed(2);
  document.getElementById('balance').textContent = balance.toFixed(2);

  var tipsElement = document.getElementById('tips');
  if (balance < 0) {
    tipsElement.textContent = 'Your expenses exceed your income! Consider cutting down unnecessary expenses.';
  } else if (balance <= 1000) {
    tipsElement.textContent = 'You have a balanced budget. Ensure to save some income for future goals!';
  } else {
    tipsElement.textContent = 'Great job! Keep saving and maintaining a positive balance!';
  }
}

// Add income (updates DB instead of adding locally)
document.getElementById('add-income').addEventListener('click', function() {
  var incomeInput = document.getElementById('income-amount');
  var income = parseFloat(incomeInput.value);

  if (!isNaN(income) && income > 0) {
    fetch('save_income.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'income=' + income + '&income_frequency=Monthly'
    })
    .then(function(response) {
      if (response.ok) {
        fetchIncome(); // Refresh the income display
        incomeInput.value = '';
      } else {
        alert('Error saving income.');
      }
    });
  } else {
    alert('Please enter a valid income amount.');
  }
});

// Add expense (updates DB instead of adding locally)
document.getElementById('add-expense').addEventListener('click', function() {
  var expenseInput = document.getElementById('expense-amount');
  var expense = parseFloat(expenseInput.value);

  if (!isNaN(expense) && expense > 0) {
    fetch('save_expense.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'expense=' + expense
    })
    .then(function(response) {
      if (response.ok) {
        fetchExpenses(); // Refresh the expense display
        expenseInput.value = '';
      } else {
        alert('Error saving expense.');
      }
    });
  } else {
    alert('Please enter a valid expense amount.');
  }
});

// Sidebar toggle function
function toggleSidebar() {
  document.querySelector('.sidebar').classList.toggle('open');
}

// Fetch initial data on page load
fetchIncome();
fetchExpenses();

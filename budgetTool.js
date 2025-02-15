var totalIncome = 0, totalExpenses = 0;

// Fetch and update income
function fetchIncome() {
    fetch("fetch_income.php")
        .then(response => response.text())
        .then(data => {
            totalIncome = parseFloat(data) || 0;
            updateUI("total-income", totalIncome);
            updateSummary();
        })
        .catch(error => console.error("Error fetching income:", error));
}

// Fetch and update expenses
function fetchExpenses() {
    fetch("fetch_expenses.php")
        .then(response => response.text())
        .then(data => {
            totalExpenses = parseFloat(data) || 0;
            updateUI("total-expenses", totalExpenses);
            updateSummary();
        })
        .catch(error => console.error("Error fetching expenses:", error));
}

// Update balance and tips
function updateSummary() {
    let balance = totalIncome - totalExpenses;
    updateUI("balance", balance);

    let tips = balance < 0 ? 
        "Your expenses exceed your income! Consider cutting down unnecessary expenses." :
        balance <= 1000 ? 
        "You have a balanced budget. Ensure to save some income for future goals!" :
        "Great job! Keep saving and maintaining a positive balance!";
    
    const tipsElement = document.getElementById("tips");
    if (tipsElement) tipsElement.textContent = tips;
}

// Helper function to update UI elements
function updateUI(id, value) {
    const element = document.getElementById(id);
    if (element) element.textContent = value.toFixed(2);
}

// Handle adding income
function addIncome() {
  let incomeInput = document.getElementById("income_amount");
  let incomeValue = incomeInput?.value.trim();  

  if (!incomeValue || isNaN(incomeValue) || parseFloat(incomeValue) <= 0) {
      alert("Please enter a valid income amount greater than 0.");
      return;
  }

  let income = parseFloat(incomeValue);
  console.log("Sending income:", income); // Debugging

  fetch("save_income.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `income=${encodeURIComponent(income)}`
  })
  .then(response => response.text())
  .then(data => {
      console.log("Server response:", data); // Debugging
      if (data.trim() === "success") {
          fetchIncome();
          incomeInput.value = ""; 
      } else {
          alert("Error: " + data);
      }
  })
  .catch(error => console.error("Fetch error:", error));
}



// Handle clearing income
function clearIncome() {
    if (!confirm("Are you sure you want to clear your income?")) return;

    fetch("clear_income.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("Income cleared successfully!");
            totalIncome = 0;  // Reset total income
            updateUI("total-income", 0);
            updateSummary();
        } else {
            alert("Error: " + data);
        }
    })
    .catch(error => console.error("Fetch error:", error));
}

// Handle adding expenses
function addExpense() {
    let expenseInput = document.getElementById("expense-amount");
    let expense = parseFloat(expenseInput?.value);

    if (isNaN(expense) || expense <= 0) return alert("Please enter a valid expense amount.");

    fetch("save_expense.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `expense=${encodeURIComponent(expense)}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            fetchExpenses();
            if (expenseInput) expenseInput.value = "";
        } else {
            alert("Error: " + data);
        }
    })
    .catch(error => console.error("Fetch error:", error));
}

// Handle clearing expenses
function clearExpenses() {
    if (!confirm("Are you sure you want to clear all your expenses?")) return;

    fetch("clear_expenses.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
    .then(response => response.text())
    .then(data => {
        console.log("Response from clear_expense.php:", data); // Debugging

        if (data.trim() === "success") {
            alert("Expenses cleared successfully!");
            totalExpenses = 0;  // Reset expenses
            updateUI("total-expenses", 0);
            updateSummary();
            fetchExpenses();  // Refresh from DB
        } else {
            alert("Error: " + data);
        }
    })
    .catch(error => console.error("Fetch error:", error));
}

function toggleSidebar() {
  const sidebar = document.querySelector(".sidebar");
  if (sidebar) {
      sidebar.classList.toggle("hidden");
  } else {
      console.error("Sidebar not found.");
  }
}

// Attach event listeners when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  const menuBtn = document.querySelector(".menu-btn");
  const sidebar = document.querySelector(".sidebar");

  menuBtn.addEventListener("click", function () {
    sidebar.classList.toggle("active");
  });
});

    const addIncomeBtn = document.getElementById("add-income");
    if (addIncomeBtn) addIncomeBtn.addEventListener("click", addIncome);

    const clearIncomeBtn = document.getElementById("clear-income");
    if (clearIncomeBtn) clearIncomeBtn.addEventListener("click", clearIncome);

    const addExpenseBtn = document.getElementById("add-expense");
    if (addExpenseBtn) addExpenseBtn.addEventListener("click", addExpense);

    const clearExpenseBtn = document.getElementById("clear-expense");
    if (clearExpenseBtn) {
        console.log("Clear Expenses button found and event listener attached.");
        clearExpenseBtn.addEventListener("click", clearExpenses);
    } else {
        console.error("Clear Expenses button not found.");
    }


// Fetch initial data
fetchIncome();
fetchExpenses();

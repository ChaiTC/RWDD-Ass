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
    
    document.getElementById("tips").textContent = tips;
}

// Helper function to update UI elements
function updateUI(id, value) {
    document.getElementById(id).textContent = value.toFixed(2);
}

// Handle adding income
function addIncome() {
    let income = parseFloat(document.getElementById("income_amount").value);
    if (isNaN(income) || income <= 0) return alert("Please enter a valid income amount.");

    fetch("save_income.php", {
        method: "POST",
        body: `income=${income}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            fetchIncome();
            document.getElementById("income_amount").value = "";
        } else {
            alert("Error: " + data);
        }
    })
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
    let expense = parseFloat(document.getElementById("expense-amount").value);
    if (isNaN(expense) || expense <= 0) return alert("Please enter a valid expense amount.");

    fetch("save_expense.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `expense=${expense}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            fetchExpenses();
            document.getElementById("expense-amount").value = "";
        } else {
            alert("Error: " + data);
        }
    })
    .catch(error => console.error("Fetch error:", error));
}

// Attach event listeners when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("add-income")?.addEventListener("click", addIncome);
    document.getElementById("clear-income")?.addEventListener("click", clearIncome);
    document.getElementById("add-expense")?.addEventListener("click", addExpense);
});

// Fetch initial data
fetchIncome();
fetchExpenses();

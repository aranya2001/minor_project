// Sample transactions for testing
const transactions = [
    { id: 1, text: 'Salary', amount: 2000 },
    { id: 2, text: 'Groceries', amount: -50 },
    { id: 3, text: 'Dinner', amount: -30 },
    { id: 4, text: 'Freelance Work', amount: 300 },
];

// Function to display transactions
function displayTransactions() {
    const transactionsList = document.querySelector('.transactions');
    transactionsList.innerHTML = '';

    transactions.forEach(transaction => {
        const sign = transaction.amount < 0 ? '-' : '+';
        const item = document.createElement('div');
        item.classList.add(transaction.amount < 0 ? 'expense' : 'income');
        item.innerHTML = `
            ${transaction.text} <span>${sign}$${Math.abs(transaction.amount).toFixed(2)}</span>
        `;
        transactionsList.appendChild(item);
    });
}

// Function to calculate and display balance
function displayBalance() {
    const balance = document.querySelector('.balance');
    const total = transactions.reduce((acc, transaction) => acc + transaction.amount, 0).toFixed(2);
    balance.innerHTML = `<h2>Balance: $${total}</h2>`;
}

// Function to add a new transaction
function addTransaction() {
    const text = document.getElementById('text').value;
    const amount = parseFloat(document.getElementById('amount').value);

    if (text.trim() === '' || isNaN(amount)) {
        alert('Please enter valid text and amount.');
        return;
    }

    const newTransaction = {
        id: transactions.length + 1,
        text,
        amount,
    };

    transactions.push(newTransaction);
    displayTransactions();
    displayBalance();

    // Clear input fields after adding transaction
    document.getElementById('text').value = '';
    document.getElementById('amount').value = '';
}

// Initial display
displayTransactions();
displayBalance();

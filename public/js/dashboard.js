document.addEventListener('DOMContentLoaded', function() {
    // Stock Movement Chart
    const stockCtx = document.getElementById('stockMovementChart').getContext('2d');
    new Chart(stockCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Entradas',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: '#2ecc71',
                tension: 0.1
            }, {
                label: 'Saídas',
                data: [28, 48, 40, 19, 86, 27],
                borderColor: '#e74c3c',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Eletrônicos', 'Móveis', 'Materiais', 'Outros'],
            datasets: [{
                data: [300, 150, 100, 80],
                backgroundColor: [
                    '#2ecc71',
                    '#27ae60',
                    '#82e0aa',
                    '#a9dfbf'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
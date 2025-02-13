const ApiService = {
    async fetchTransactions() {
        try {
            const response = await fetch('/painel/transacoes');
            const data = await response.json();
            return {
                success: data.success,
                buys: data.buys || [],
                sells: data.sells || [],
                message: data.message
            };
        } catch (error) {
            console.error('Erro buscando transações:', error);
            throw error;
        }
    }
};

const DataProcessor = {
    initializeMonthData() {
        return Array(12).fill(0);
    },

    processTransactions(transactions) {
        const monthlyData = this.initializeMonthData();
        const monthlyQuantities = this.initializeMonthData();

        transactions.forEach(transaction => {
            const date = new Date(transaction.buy_date || transaction.sale_date || transaction.created_at);
            const month = date.getMonth();
            monthlyData[month] += parseFloat(transaction.total_price);
            monthlyQuantities[month] += parseInt(transaction.amount);
        });

        return {
            values: monthlyData,
            quantities: monthlyQuantities
        };
    },

    getTodayMovements(buys, sells) {
        const today = new Date().toISOString().split('T')[0];
        const todayBuys = buys.filter(buy => {
            const buyDate = new Date(buy.buy_date || buy.created_at).toISOString().split('T')[0];
            return buyDate === today;
        });

        const todaySells = sells.filter(sell => {
            const sellDate = new Date(sell.sale_date || sell.created_at).toISOString().split('T')[0];
            return sellDate === today;
        });

        return todayBuys.length + todaySells.length;
    },

    getUniqueProducts(transactions) {
        const productIds = new Set();
        transactions.forEach(t => productIds.add(t.product_id));
        return productIds.size;
    },

    getRecentActivities(buys, sells) {
        const activities = [
            ...buys.map(buy => ({
                product_id: buy.product_id,
                type: 'entrada',
                quantity: buy.amount,
                total: buy.total_price,
                date: buy.buy_date || buy.created_at,
                created_at: buy.created_at
            })),
            ...sells.map(sell => ({
                product_id: sell.product_id,
                type: 'saída',
                quantity: sell.amount,
                total: sell.total_price,
                date: sell.sale_date || sell.created_at,
                created_at: sell.created_at
            }))
        ];

        return activities
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            .slice(0, 5);
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    },

    formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('pt-BR');
    },

    getCurrentMonthStats(sells) {
        const currentMonth = new Date().getMonth();
        return sells.filter(t => {
            const transactionMonth = new Date(t.sale_date || t.created_at).getMonth();
            return transactionMonth === currentMonth;
        });
    },

    getTotalBalance(buys, sells) {
        const totalBuys = buys.reduce((sum, buy) => sum + parseFloat(buy.total_price), 0);
        const totalSells = sells.reduce((sum, sell) => sum + parseFloat(sell.total_price), 0);
        return totalSells - totalBuys;
    },

    processMonthlyComparison(buys, sells) {
        const monthlyBuys = Array(12).fill(0);
        const monthlySells = Array(12).fill(0);

        buys.forEach(buy => {
            const month = new Date(buy.buy_date || buy.created_at).getMonth();
            monthlyBuys[month] += parseFloat(buy.total_price);
        });

        sells.forEach(sell => {
            const month = new Date(sell.sale_date || sell.created_at).getMonth();
            monthlySells[month] += parseFloat(sell.total_price);
        });

        return { buys: monthlyBuys, sells: monthlySells };
    }
};

const ChartManager = {
    stockMovementChart: null,
    comparisonChart: null,

    async initialize() {
        try {
            const data = await ApiService.fetchTransactions();
            if (data.success) {
                const processedBuys = DataProcessor.processTransactions(data.buys);
                const processedSells = DataProcessor.processTransactions(data.sells);

                this.initializeStockMovementChart(processedBuys.quantities, processedSells.quantities);
                this.initializeComparisonChart(data.buys, data.sells);
                this.updateDashboardStats(data.buys, data.sells);
                this.updateRecentActivities(data.buys, data.sells);
            }
        } catch (error) {
            console.error('Erro ao inicializar gráficos:', error);
            this.showError('Erro ao carregar dados dos gráficos');
        }
    },

    initializeStockMovementChart(buyQuantities, sellQuantities) {
        const ctx = document.getElementById('stockMovementChart').getContext('2d');
        this.stockMovementChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Entradas',
                    data: buyQuantities,
                    borderColor: '#2ecc71',
                    tension: 0.1
                }, {
                    label: 'Saídas',
                    data: sellQuantities,
                    borderColor: '#e74c3c',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    },

    initializeComparisonChart(buys, sells) {
        const monthlyData = DataProcessor.processMonthlyComparison(buys, sells);
        const ctx = document.getElementById('categoriesChart').getContext('2d');
        
        this.comparisonChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [
                    {
                        label: 'Compras',
                        data: monthlyData.buys,
                        backgroundColor: 'rgba(46, 204, 113, 0.5)',
                        borderColor: 'rgb(46, 204, 113)',
                        borderWidth: 1
                    },
                    {
                        label: 'Vendas',
                        data: monthlyData.sells,
                        backgroundColor: 'rgba(231, 76, 60, 0.5)',
                        borderColor: 'rgb(231, 76, 60)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${DataProcessor.formatCurrency(context.raw)}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return DataProcessor.formatCurrency(value);
                            }
                        }
                    }
                }
            }
        });
    },

    updateDashboardStats(buys, sells) {
        const totalProducts = DataProcessor.getUniqueProducts([...buys, ...sells]);
        document.getElementById('total-products').textContent = totalProducts;
        
        const currentMonthSells = DataProcessor.getCurrentMonthStats(sells);
        const monthlyRevenue = currentMonthSells.reduce((sum, sell) => sum + parseFloat(sell.total_price), 0);
        document.getElementById('low-stock').textContent = DataProcessor.formatCurrency(monthlyRevenue);

        const todayMovements = DataProcessor.getTodayMovements(buys, sells);
        document.getElementById('today-movements').textContent = todayMovements;

        const balance = DataProcessor.getTotalBalance(buys, sells);
        const totalValueElement = document.getElementById('total-value');
        totalValueElement.textContent = DataProcessor.formatCurrency(balance);
        totalValueElement.style.color = balance >= 0 ? '#2ecc71' : '#e74c3c';
    },

    updateRecentActivities(buys, sells) {
        const activities = DataProcessor.getRecentActivities(buys, sells);
        const tbody = document.getElementById('recent-activities');
        tbody.innerHTML = '';

        if (activities.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="5" class="text-center">Nenhuma atividade recente encontrada</td>';
            tbody.appendChild(row);
            return;
        }

        activities.forEach(activity => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <i class="fas ${activity.type === 'entrada' ? 'fa-arrow-down text-success' : 'fa-arrow-up text-danger'} me-2"></i>
                        <span>ID: ${activity.product_id}</span>
                    </div>
                </td>
                <td>
                    <span class="badge ${activity.type === 'entrada' ? 'bg-success' : 'bg-danger'}">
                        ${activity.type === 'entrada' ? 'Compra' : 'Venda'}
                    </span>
                </td>
                <td>${activity.quantity} un.</td>
                <td>${DataProcessor.formatDate(activity.date)}</td>
                <td>${DataProcessor.formatCurrency(activity.total)}</td>
            `;
            tbody.appendChild(row);
        });
    },

    showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger alert-dismissible fade show';
        errorDiv.innerHTML = `
            <strong>Erro!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.querySelector('.container-fluid').prepend(errorDiv);
    }
};

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    ChartManager.initialize();
});
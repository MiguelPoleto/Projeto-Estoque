//API Service
const ApiService = {
    async fetchTransactions() {
        try {
            const response = await fetch('/painel/transacoes');
            return await response.json();
        } catch (error) {
            console.error('Erro buscando transações:', error);
            throw error;
        }
    }
};

// Data Processor
const DataProcessor = {
    initializeMonthData() {
        return Array(12).fill(0);
    },

    parseDate(dateString) {
        return new Date(dateString);
    },

    calculateTransactionValue(transaction) {
        const price = parseFloat(transaction.price);
        const amount = parseInt(transaction.amount);
        return price * amount;
    },

    processTransactions(transactions) {
        const monthlyData = this.initializeMonthData();
        const monthlyQuantities = this.initializeMonthData();

        transactions.forEach(transaction => {
            const date = this.parseDate(transaction.buy_date || transaction.created_at);
            const month = date.getMonth();
            const value = this.calculateTransactionValue(transaction);
            monthlyData[month] += value;
            monthlyQuantities[month] += parseInt(transaction.amount);
        });

        return {
            values: monthlyData,
            quantities: monthlyQuantities
        };
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    }
};

// Chart Manager
const ChartManager = {
    stockMovementChart: null,
    categoriesChart: null,

    async initialize() {
        try {
            const data = await ApiService.fetchTransactions();
            if (data.success) {
                const processedBuys = DataProcessor.processTransactions(data.buys);
                const processedSells = DataProcessor.processTransactions(data.sells);

                this.initializeStockMovementChart(processedBuys.quantities, processedSells.quantities);
                
                this.updateDashboardStats(processedBuys.values, processedSells.values);
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
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Movimentação de Estoque (Quantidade)'
                    }
                }
            }
        });
    },

    updateDashboardStats(buyValues, sellValues) {
        const totalBuys = buyValues.reduce((a, b) => a + b, 0);
        const totalSells = sellValues.reduce((a, b) => a + b, 0);
        
        document.getElementById('total-value').textContent = 
            DataProcessor.formatCurrency(totalSells - totalBuys);
    },

    showError(message) {
        console.error(message);
    }
};

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    ChartManager.initialize();
});
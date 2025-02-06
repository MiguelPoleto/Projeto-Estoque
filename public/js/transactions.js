// API calls handling
const ApiService = {
    async fetchBuys() {
        try {
            const response = await fetch(`transacoes/compras`);
            const data = await response.json();
            return data.success ? data.buys : [];
        } catch (error) {
            console.error('Erro buscando as compras:', error);
            throw error;
        }
    },

    async fetchSells() {
        try {
            const response = await fetch(`transacoes/vendas`);
            const data = await response.json();
            return data.success ? data.sells : [];
        } catch (error) {
            console.error('Erro buscando as vendas:', error);
            throw error;
        }
    }
};

// Transictions data processing
const TransactionsProcessor = {
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

    processTransictions(transactions) {
        const monthlyData = this.initializeMonthData();

        transactions.forEach(transaction => {
            const date = this.parseDate(transaction.buy_date || transaction.created_at);
            const month = date.getMonth();
            const value = this.calculateTransactionValue(transaction);
            monthlyData[month] += value;
        });
        return monthlyData;
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    },

    formatChartData(buyData, sellData) {
        const chartData = [['Mês', 'Compras', 'Vendas']];
        const monthNames = [
            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
            'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
        ];

        for (let i = 0; i < 12; i++) {
            chartData.push([
                monthNames[i],
                buyData[i],
                sellData[i]
            ]);
        }

        return chartData;
    }
};

// Responsive chart handling
const ResponsiveChart = {
    chart: null,
    data: null,
    options: {
        title: 'Transações Mensais',
        curveType: 'function',
        legend: { position: 'bottom' },
        hAxis: {
            title: 'Mês'
        },
        vAxis: {
            title: 'Valor (R$)',
            format: 'currency'
        },
        colors: ['#e74c3c', '#2ecc71'],
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        chartArea: {
            width: '80%',
            height: '70%'
        },
        fontSize: 12,
        responsive: true
    },

    initialize(chartData) {
        this.data = google.visualization.arrayToDataTable(chartData);
        this.chart = new google.visualization.LineChart(
            document.getElementById('curve_chart')
        );
        this.drawChart();
        this.setupResizeListener();
    },

    drawChart() {
        if (this.chart && this.data) {
            const container = document.getElementById('curve_chart');
            const parent = container.parentElement;
            container.style.width = '100%';
            container.style.height = '500px';

            this.adjustOptionsForSize(parent.offsetWidth);
            this.chart.draw(this.data, this.options);
        }
    },

    adjustOptionsForSize(width) {
        if (width < 600) {
            this.options.fontSize = 10;
            this.options.chartArea.width = '60%';
            this.options.chartArea.height = '60%';
        } else if (width < 900) {
            this.options.fontSize = 11;
            this.options.chartArea.width = '70%';
            this.options.chartArea.height = '65%';
        } else {
            this.options.fontSize = 12;
            this.options.chartArea.width = '80%';
            this.options.chartArea.height = '70%';
        }
    },

    setupResizeListener() {
        let resizeTimeout;

        const resizeObserver = new ResizeObserver(entries => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.drawChart();
            }, 250);
        });

        const container = document.getElementById('curve_chart').parentElement;
        resizeObserver.observe(container);

        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            const sidebarObserver = new MutationObserver(() => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    this.drawChart();
                }, 250);
            });

            sidebarObserver.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class', 'style']
            });
        }
    }
};

//Transaction visualization
const TransactionsVisualizer = {
    async initializeChart() {
        try {
            const [buys, sells] = await Promise.all([
                ApiService.fetchBuys(),
                ApiService.fetchSells()
            ]);

            const montlhyBuys = TransactionsProcessor.processTransictions(buys);
            const montlhySells = TransactionsProcessor.processTransictions(sells);

            const chartData = TransactionsProcessor.formatChartData(montlhyBuys, montlhySells);
            ResponsiveChart.initialize(chartData);

            this.updateTotals(montlhyBuys, montlhySells);
        } catch (error) {
            console.error('Erro ao inicializar o gráfico:', error);
            this.showError('Erro ao carregar os dados. Por favor, tente novamente.');
        }
    },

    updateTotals(buyData, sellsData) {
        const totalBuys = buyData.reduce((a, b) => a + b, 0);
        const totalSells = sellsData.reduce((a, b) => a + b, 0);
        const totalProfit = totalSells - totalBuys;

        const buysElement = document.getElementById('total-buys');
        const sellsElement = document.getElementById('total-sells');
        const profitElement = document.getElementById('total-profit');

        if (buysElement) {
            buysElement.textContent = TransactionsProcessor.formatCurrency(totalBuys);
        }
        if (sellsElement) {
            sellsElement.textContent = TransactionsProcessor.formatCurrency(totalSells);
        }

        if (profitElement) {
            profitElement.textContent = TransactionsProcessor.formatCurrency(totalProfit);
            profitElement.classList.remove('text-success', 'text-danger');
            profitElement.classList.add(totalProfit >= 0 ? 'text-success' : 'text-danger');
        }
    },

    showError(message) {
        console.error(message);
    }
};


// Initialize application
document.addEventListener("DOMContentLoaded", async () => {
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(() => {
        TransactionsVisualizer.initializeChart();
    });
})
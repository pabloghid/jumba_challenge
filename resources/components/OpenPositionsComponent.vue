<template>
    <div v-if="loading" class="d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>
    <div v-else>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4 text-center">
                <select class="btn btn-secondary" v-model="selectedAsset" @change="loadData(selectedAsset)">
                    <option v-for="asset in assets" :value="asset.id"
                        class="form-select-option">{{
                            asset.tracker_symbol }}</option>
                </select>
            </div>
        </div>
        <div v-if="data.labels && data.labels.length > 0" class="open-positions-chart">
            <Line :data="data" :options="options" />
        </div>
    </div>
</template>
  
<script>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'
import axios from 'axios'

ChartJS.defaults.font.size = 15;
ChartJS.defaults.font.family = "Lato";
ChartJS.register(CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend)

function formatDateArray(dateArray) {
    if (!dateArray) {
        return [];
    }
    return dateArray.map(date => {
        const [year, month, day] = date.split('-');
        return `${day}/${month}/${year}`;
    });
}

export default {
    name: 'OpenPositionsComponent',
    components: {
        Line
    },
    data() {
        return {
            assets: [],
            selectedAsset: 24,
            data: {},
            options: {},
            chartInitialized: false,
            loading: true
        };
    },
    async created() {
        await this.loadAssets();
        await this.loadData(this.selectedAsset);
        this.loading = false;
    },
    methods: {
        async loadAssets() {
            const assetResponse = await axios.get('/api/assets');
            this.assets = assetResponse.data;
            this.loading = false;
        },
        async loadData(selectedAsset) {
            const assetDataResponse = await axios.get(`api/assetdata/${selectedAsset}`);
            const data = assetDataResponse.data;

            const labels = formatDateArray(data.map(item => item.date))
            const quantity = data.map(item => item.balance_quantity)
            const prices = data.map(item => item.trade_average_price)

            /* Carrega os dados para o gráfico */
            this.data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Quantidade de Saldo',
                        yAxisID: 'quantity',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        data: quantity,
                        tension: '0.2'
                    },
                    {
                        label: 'Preço Médio',
                        yAxisID: 'price',
                        borderColor: 'green',
                        data: prices.map(price => {
                            return parseFloat(price.toFixed(2));
                        }),
                        tension: '0.2'
                    }
                ],
            };
            this.options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Data',
                            color: 'white',
                        },
                        ticks: {
                            color: 'white'
                        }
                    },
                    quantity: {
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            color: 'white',
                            text: 'Quantidade de saldo'
                        },
                        ticks: {
                            beginAtZero: true,
                            color: 'white',
                            callback: function (value, index, values) {
                                if (value >= 1e6) {
                                    value = value / 1e6 + 'M'
                                }
                                return value.toLocaleString();
                            }
                        }
                    },
                    price: {
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            color: 'white',
                            text: 'Preço médio'
                        },
                        ticks: {
                            beginAtZero: true,
                            color: 'white',
                            callback: function (value, index, values) {
                                return 'R$ ' + value.toFixed(2);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            };
        },
    },

}
</script>

<style scoped>
.open-positions-chart {
    position: relative;
    height: 60vh;
    width: 80vw;
    display: block;
    box-sizing: border-box;
}
</style>
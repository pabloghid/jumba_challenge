<template>
    <div>
        <select class="dropdown bootstrap-select" v-model="selectedAsset" @change="loadData(selectedAsset)">
            <option v-for="(asset, index) in assets" :value="asset.tracker_symbol" :selected="index === 1">{{
                asset.tracker_symbol }}</option>
        </select>
        <div>
            <p v-if="data.labels && data.labels.length > 0">
                <Line :data="data" :options="options" />
            </p>
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
    name: 'App',
    components: {
        Line
    },
    data() {
        return {
            assets: [],
            selectedAsset: 'ABEV3',
            data: {},
            options: {},
            chartInitialized: false
        };
    },
    async created() {
        await this.loadAssets();
        await this.loadData(this.selectedAsset);
    },
    methods: {
        async loadAssets() {
            const assetResponse = await axios.get('/api/assets');
            this.assets = assetResponse.data
        },
        async loadData(selectedAsset) {
            const assetDataResponse = await axios.get(`api/assetdata/${selectedAsset}`);
            const data = assetDataResponse.data;

            const labels = formatDateArray(data.map(item => item.date))
            const values = data.map(item => item.balance_value)
            const prices = data.map(item => item.trade_average_price)


            console.log(labels)
            console.log(values)
            console.log(prices)

            /* Carrega os dados para o gráfico */
            this.data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Balance Value',
                        backgroundColor: '#f87979',
                        data: values
                    },
                    {
                        label: 'Trade Average Price',
                        backgroundColor: '#36a2eb',
                        data: prices
                    }
                ],
            };
            this.options = {
                responsive: true,
                maintainAspectRatio: false
            };
            
        },
    },

}
</script>
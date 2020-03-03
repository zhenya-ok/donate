<template>
    <div>
        <router-link :to="{ name: 'main', params: {}}" class="b-breadcrumb__link">
            Главная
        </router-link>
        <div>
            <div v-if="firstDonateUser">
                Больше всего доната от пользователя {{ firstDonateUser.name }} сумма {{ firstDonateUser.sum }}
            </div>
            <div v-if="totalSum">
                Сумма за все время {{ totalSum }}
            </div>
            <div v-if="totalMonthSum">
                Сумма за текущий месяц {{ totalMonthSum }}
            </div>
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </div>
</template>

<script>

    export default {
        data () {
            return {
                totalSum: false,
                totalMonthSum: false,
                firstDonateUser: false,
            }
        },
        mounted () {
            this.$http
                .post('/ajax/getDataDashboard', {}, {emulateJSON: true})
                .then((response) => {
                    const data = response.body;
                    if(data.monthSum){
                        this.totalMonthSum = data.monthSum.sum;
                    }
                    if(data.totalSum){
                        this.totalSum = data.totalSum.sum;
                    }
                    if(data.firstDonateUser){
                        this.firstDonateUser = data.firstDonateUser;
                    }
                    if(data.chart){
                        let dataChart = {};
                        let chartValues = [];
                        data.chart.forEach(function(item){
                            const date = new Date(item.createdAt.date);
                            const tmpDate = date.getDate()+'-'+(date.getMonth())+'-'+date.getFullYear();
                            if(dataChart[tmpDate] == undefined){
                                dataChart[tmpDate] = 0;
                            }
                            dataChart[tmpDate] += parseFloat(item.cost);
                        });
                        console.log(dataChart)
                        let now = new Date();
                        let nowStatic = new Date();
                        now.setMonth(now.getMonth() - 1);
                        // только для текущего месяца
                        // now.setDate(1)
                        while (now <= nowStatic) {
                            const tmpDate = now.getDate()+'-'+(now.getMonth())+'-'+now.getFullYear();
                            console.log(dataChart[tmpDate], tmpDate)
                            chartValues.push([tmpDate, dataChart[tmpDate] !== undefined ? dataChart[tmpDate] : 0]);
                            now.setDate(now.getDate()+1)
                        }
                        console.log(chartValues)
                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Статистика за послединй месяц'
                            },
                            xAxis: {
                                type: 'category',
                                labels: {
                                    rotation: -45,
                                    style: {
                                        fontSize: '13px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Сумма'
                                }
                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                pointFormat: '<b>{point.y:.1f}</b>'
                            },
                            series: [{
                                name: 'Сумма',
                                data: chartValues,
                                dataLabels: {
                                    enabled: true,
                                    rotation: -90,
                                    color: '#FFFFFF',
                                    align: 'right',
                                    format: '{point.y:.1f}', // one decimal
                                    y: 10, // 10 pixels down from the top
                                    style: {
                                        fontSize: '13px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }
                            }]
                        });
                    }
                });

        }
    }
</script>

<style scoped>

</style>
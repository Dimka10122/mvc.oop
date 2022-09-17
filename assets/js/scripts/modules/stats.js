define(["assets/js/scripts/lib/chart"], function (chart) {
    return function (stats) {
        const field = document.getElementById('chart-field').getContext('2d');
        const chartStat = new Chart(field, {
            type: 'bar',
            data: {
                labels: ['Visits'],
                datasets: [{
                    label: 'The MVC site statistics',
                    backgroundColor: 'rgb(98,180,53)',
                    data: [stats]
                }]
            },
        });
    }
});
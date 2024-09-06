const data = {
    labels: dataForChart.map(item => item.label),
    datasets: [{
        label: 'My First Dataset',
        data: dataForChart.map(item => item.nilai),
        backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(75, 192, 192)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
            '#344C64',
            'rgb(54, 162, 235)'
        ]
    }]
};

console.log(dataForChart)


const config = {
    type: 'polarArea',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed !== null) {
                            label += context.parsed;
                        }
                        return label;
                    }
                }
            }
        }
    },
};

// Langkah 3: Inisialisasi chart
window.onload = function() {
    const ctx = document.getElementById('myPolarAreaChart').getContext('2d');
    new Chart(ctx, config);
};
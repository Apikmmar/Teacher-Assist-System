const data = {
    labels: ['Passed', 'Failed'],
    datasets: [{
        label: 'Students',
        data: [passedStudents, failedStudents],
        backgroundColor: [
            'rgba(0, 150, 136, 0.7)',
            'rgba(244, 67, 54, 0.7)',
        ],
        hoverBackgroundColor: [
            'rgba(0, 150, 136, 0.9)',
            'rgba(244, 67, 54, 0.9)',
        ],
        borderWidth: 0,
        hoverOffset: 6,
        borderRadius: 6,
    }]
};

const config = {
    type: 'pie',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                enabled: true,
            },
        },
    },
};

const examPieChart = new Chart(
    document.getElementById('examPieChart'),
    config
);

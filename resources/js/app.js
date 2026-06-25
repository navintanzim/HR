import './bootstrap';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('leaveBarChart');
    if (!ctx || !window.leaveBarData) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Paid Total',
                'Paid Used',
                'Half Days',
                'Paid Remaining',
                'Unpaid Total',
                'Unpaid Used',
                'Unpaid Remaining',
            ],
            datasets: [{
                label: 'Days',
                data: [
                    window.leaveBarData.paidTotal,
                    window.leaveBarData.paidUsed,
                    window.leaveBarData.halfDays,
                    window.leaveBarData.paidRemaining,
                    window.leaveBarData.unpaidTotal,
                    window.leaveBarData.unpaidUsed,
                    window.leaveBarData.unpaidRemaining,
                ],
                backgroundColor: [
                    '#2563EB',
                    '#DC2626',
                    '#9333EA',
                    '#16A34A',
                    '#0EA5E9',
                    '#F59E0B',
                    '#6B7280',
                ],
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.raw} days`,
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                    },
                    title: {
                        display: true,
                        text: 'Days',
                    },
                },
            },
        },
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('attendanceBarChart');
    if (!ctx || !window.attendanceData) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Early', 'On Time', 'Late', 'Very Late', 'Absent'],
            datasets: [{
                label: 'Days',
                data: [
                    window.attendanceData.early,
                    window.attendanceData.onTime,
                    window.attendanceData.late,
                    window.attendanceData.veryLate,
                    window.attendanceData.absent,
                ],
                backgroundColor: [
                    '#16A34A',
                    '#2563EB',
                    '#F59E0B',
                    '#DC2626',
                    '#6B7280',
                ],
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.raw} days`,
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    title: { display: true, text: 'Days' },
                },
            },
        },
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const ctxMonthly = document.getElementById('attendanceMonthlyBarChart');
    if (!ctxMonthly || !window.attendanceMonthlyData) return;

    new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: ['Early', 'On Time', 'Late', 'Very Late', 'Absent'],
            datasets: [{
                label: 'Days',
                data: [
                    window.attendanceMonthlyData.early,
                    window.attendanceMonthlyData.onTime,
                    window.attendanceMonthlyData.late,
                    window.attendanceMonthlyData.veryLate,
                    window.attendanceMonthlyData.absent,
                ],
                backgroundColor: [
                    '#16A34A',
                    '#2563EB',
                    '#F59E0B',
                    '#DC2626',
                    '#6B7280',
                ],
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.raw} days`,
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    title: { display: true, text: 'Days' },
                },
            },
        },
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const ctxMonthly = document.getElementById('attendanceWeeklyBarChart');
    if (!ctxMonthly || !window.attendanceWeeklyData) return;

    new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: ['Early', 'On Time', 'Late', 'Very Late', 'Absent'],
            datasets: [{
                label: 'Days',
                data: [
                    window.attendanceWeeklyData.early,
                    window.attendanceWeeklyData.onTime,
                    window.attendanceWeeklyData.late,
                    window.attendanceWeeklyData.veryLate,
                    window.attendanceWeeklyData.absent,
                ],
                backgroundColor: [
                    '#16A34A',
                    '#2563EB',
                    '#F59E0B',
                    '#DC2626',
                    '#6B7280',
                ],
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.raw} days`,
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    title: { display: true, text: 'Days' },
                },
            },
        },
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const lifetimeBtn = document.getElementById('toggleLifetimeBtn');
    const weeklyBtn = document.getElementById('toggleWeeklyBtn');
    const monthlyBtn = document.getElementById('toggleMonthlyBtn');

    const lifetimeContainer = document.getElementById('lifetimeChartContainer');
    const weeklyContainer = document.getElementById('weeklyChartContainer');
    const monthlyContainer = document.getElementById('monthlyChartContainer');

    if (!lifetimeBtn || !weeklyBtn || !monthlyBtn || !lifetimeContainer || !weeklyContainer || !monthlyContainer) {
        return;
    }

    lifetimeBtn.addEventListener('click', () => {
        lifetimeContainer.style.display = lifetimeContainer.style.display === 'none' ? '' : 'none';
        weeklyContainer.style.display = 'none';
        monthlyContainer.style.display = 'none';
    });

    weeklyBtn.addEventListener('click', () => {
        
        weeklyContainer.style.display = weeklyContainer.style.display === 'none' ? '' : 'none';
        lifetimeContainer.style.display = 'none';
        monthlyContainer.style.display = 'none';
    });
    monthlyBtn.addEventListener('click', () => {
        
        monthlyContainer.style.display = monthlyContainer.style.display === 'none' ? '' : 'none';
        weeklyContainer.style.display = 'none';
        lifetimeContainer.style.display = 'none';
    });
});


@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold mb-4">Dashboard Keluhan</h1>

    <div class="max-w-md bg-white rounded-lg shadow dark:bg-gray-800 p-6">
        <!-- Chart Header -->
        <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Complain Status Overview</h5>

        <!-- Checkbox filter -->
        <div class="flex mb-4" id="complainStatusFilter">
            <div class="flex items-center me-4">
                <input id="submitted" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                <label for="submitted" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Submitted</label>
            </div>
            <div class="flex items-center me-4">
                <input id="processed" type="checkbox" value="2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                <label for="processed" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Processed</label>
            </div>
            <div class="flex items-center me-4">
                <input id="done" type="checkbox" value="3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                <label for "done" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Done</label>
            </div>
        </div>

        <!-- Donut Chart -->
        <div id="complaint-status-chart" class="py-6"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Data for the chart
    let chartData = [{{ $submitted }}, {{ $processed }}, {{ $done }}];

    // ApexChart Options
    const getChartOptions = (seriesData) => {
        return {
            series: seriesData,
            chart: {
                height: 320,
                type: 'donut',
            },
            labels: ["Submitted", "Processed", "Done"],
            colors: ["#1C64F2", "#16BDCA", "#FDBA8C"],
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: "Total Complaints",
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + " Complaints";
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
            }
        };
    };

    // Render the chart
    const chart = new ApexCharts(document.getElementById("complaint-status-chart"), getChartOptions(chartData));
    chart.render();

    // Checkbox filtering
    const checkboxes = document.querySelectorAll('#complainStatusFilter input[type="checkbox"]');

    function handleCheckboxChange() {
        let updatedData = [0, 0, 0]; // Reset data

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                switch (checkbox.value) {
                    case '1':
                        updatedData[0] = {{ $submitted }};
                        break;
                    case '2':
                        updatedData[1] = {{ $processed }};
                        break;
                    case '3':
                        updatedData[2] = {{ $done }};
                        break;
                }
            }
        });

        // Update chart with filtered data
        chart.updateSeries(updatedData);
    }

    // Add event listeners to checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
    });
</script>
@endsection

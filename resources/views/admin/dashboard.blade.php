@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Complaint dashboard</h1>

        <div class="flex justify-center mt-6">
            <div class="flex-1 max-w-md bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 me-4">
                <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Complain Status Overview</h5>

                <div id="complaint-status-chart" class="py-6"></div>
            </div>
            <div
                class="w-full max-w-md p-6 m-6 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Latest Complaint</h5>
                    <a href="{{ route('complaints.index') }}"
                        class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                        View all
                    </a>
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $latestcomplaints->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{ $latestcomplaints->title }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $latestcomplaints->status->name }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let chartData = [{{ $submitted }}, {{ $processed }}, {{ $done }}];

        const getChartOptions = (seriesData) => {
            return {
                series: seriesData,
                chart: {
                    height: 320,
                    type: 'donut',
                },
                labels: ["Submitted", "Processed", "Complete"],
                colors: ["#1C64F2", "#16BDCA", "#FDBA8C"],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: "Total Complaints",
                                    formatter: function(w) {
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

        const chart = new ApexCharts(document.getElementById("complaint-status-chart"), getChartOptions(chartData));
        chart.render();

        const checkboxes = document.querySelectorAll('#complainStatusFilter input[type="checkbox"]');

        function handleCheckboxChange() {
            let updatedData = [0, 0, 0];

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

            chart.updateSeries(updatedData);
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', handleCheckboxChange);
        });
    </script>
@endsection

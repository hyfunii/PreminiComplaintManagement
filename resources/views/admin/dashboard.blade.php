@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Dashboard Keluhan</h1>

        <div class="flex justify-between">
            <!-- Complain Status Overview -->
            <div class="flex-1 max-w-md bg-white rounded-lg shadow dark:bg-gray-800 p-6 me-4">
                <!-- Chart Header -->
                <h5 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Complain Status Overview</h5>

                <!-- Checkbox filter -->
                <div class="flex mb-4" id="complainStatusFilter">
                    <div class="flex items-center me-4">
                        <input id="submitted" type="checkbox" value="1"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="submitted"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Submitted</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input id="processed" type="checkbox" value="2"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="processed"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Processed</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input id="done" type="checkbox" value="3"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="done" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Done</label>
                    </div>
                </div>

                <!-- Donut Chart -->
                <div id="complaint-status-chart" class="py-6"></div>
            </div>

            <!-- Chart Ringkasan Status -->
            <div class="flex-1 max-w-md bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <ul class="flex flex-wrap text-xs font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800"
                    id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                    <li class="me-1">
                        <button id="about-tab" data-tabs-target="#about" type="button" role="tab"
                            aria-controls="about" aria-selected="true"
                            class="inline-block p-2 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">Tentang
                            Aplikasi</button>
                    </li>
                    <li class="me-1">
                        <button id="services-tab" data-tabs-target="#services" type="button" role="tab"
                            aria-controls="services" aria-selected="false"
                            class="inline-block p-2 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Fitur</button>
                    </li>
                    <li class="me-1">
                        <button id="statistics-tab" data-tabs-target="#statistics" type="button" role="tab"
                            aria-controls="statistics" aria-selected="false"
                            class="inline-block p-2 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Statistik</button>
                    </li>
                </ul>
                <div id="defaultTabContent">
                    <div class="hidden p-2 bg-white rounded-lg dark:bg-gray-800" id="about" role="tabpanel"
                        aria-labelledby="about-tab">
                        <h2 class="mb-2 text-xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            Aplikasi Manajemen Pengaduan</h2>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Aplikasi ini dirancang untuk memudahkan
                            warga dalam melaporkan berbagai permasalahan, termasuk:</p>
                        <ul class="list-disc list-inside mb-2 text-gray-500 dark:text-gray-400">
                            <li>Pengaduan mengenai infrastruktur.</li>
                            <li>Pengaduan terkait layanan kesehatan.</li>
                            <li>Pengaduan mengenai layanan publik.</li>
                        </ul>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Dengan aplikasi ini, warga dapat dengan
                            cepat dan mudah melaporkan keluhan mereka, sehingga pihak terkait dapat mengambil
                            tindakan yang diperlukan untuk menyelesaikan masalah tersebut.</p>
                        <a href="#"
                            class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">
                            Pelajari lebih lanjut
                            <svg class="w-2 h-2 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                    <div class="hidden p-2 bg-white rounded-lg dark:bg-gray-800" id="services" role="tabpanel"
                        aria-labelledby="services-tab">
                        <h2 class="mb-2 text-lg font-extrabold tracking-tight text-gray-900 dark:text-white">Fitur
                            Aplikasi</h2>
                        <ul role="list" class="space-y-2 text-gray-500 dark:text-gray-400">
                            <li class="flex items-center space-x-2 rtl:space-x-reverse">
                                <svg class="flex-shrink-0 w-3 h-3 text-blue-600 dark:text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                <span class="leading-tight">Pengajuan keluhan yang mudah dan cepat</span>
                            </li>
                            <li class="flex items-center space-x-2 rtl:space-x-reverse">
                                <svg class="flex-shrink-0 w-3 h-3 text-blue-600 dark:text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                <span class="leading-tight">Notifikasi untuk status keluhan</span>
                            </li>
                            <li class="flex items-center space-x-2 rtl:space-x-reverse">
                                <svg class="flex-shrink-0 w-3 h-3 text-blue-600 dark:text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                <span class="leading-tight">Riwayat pengaduan yang transparan</span>
                            </li>
                        </ul>
                    </div>
                    <div class="hidden p-2 bg-white rounded-lg dark:bg-gray-800" id="statistics" role="tabpanel"
                        aria-labelledby="statistics-tab">
                        <h2 class="mb-2 text-lg font-extrabold tracking-tight text-gray-900 dark:text-white">
                            Statistik Pengaduan</h2>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Berikut adalah beberapa statistik menarik
                            tentang pengaduan yang diterima:</p>
                        <ul class="space-y-2 text-gray-500 dark:text-gray-400">
                            <li><strong>Total Pengaduan:</strong> 500</li>
                            <li><strong>Pengaduan Diselesaikan:</strong> 350</li>
                            <li><strong>Pengaduan Terbuka:</strong> 150</li>
                        </ul>
                    </div>
                </div>
            </div>
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



    <div data-dial-init class="fixed right-6 bottom-6 group">
        <div id="speed-dial-menu-dropdown-square"
            class="flex flex-col justify-end hidden py-1 mb-4 space-y-2 bg-white border border-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
            <ul class="text-sm text-gray-500 dark:text-gray-300">
                <li>
                    <a href="#"
                        class="flex items-center px-5 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 18 18">
                            <path
                                d="M14.419 10.581a3.564 3.564 0 0 0-2.574 1.1l-4.756-2.49a3.54 3.54 0 0 0 .072-.71 3.55 3.55 0 0 0-.043-.428L11.67 6.1a3.56 3.56 0 1 0-.831-2.265c.006.143.02.286.043.428L6.33 6.218a3.573 3.573 0 1 0-.175 4.743l4.756 2.491a3.58 3.58 0 1 0 3.508-2.871Z" />
                        </svg>
                        <span class="text-sm font-medium">Share</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center px-5 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 20h10a1 1 0 0 0 1-1v-5H4v5a1 1 0 0 0 1 1Z" />
                            <path
                                d="M18 7H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2v-3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-1-2V2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3h14Z" />
                        </svg>
                        <span class="text-sm font-medium">Print</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center px-5 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                            <path
                                d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="text-sm font-medium">Save</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center px-5 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="M5 9V4.13a2.96 2.96 0 0 0-1.293.749L.879 7.707A2.96 2.96 0 0 0 .13 9H5Zm11.066-9H9.829a2.98 2.98 0 0 0-2.122.879L7 1.584A.987.987 0 0 0 6.766 2h4.3A3.972 3.972 0 0 1 15 6v10h1.066A1.97 1.97 0 0 0 18 14V2a1.97 1.97 0 0 0-1.934-2Z" />
                            <path
                                d="M11.066 4H7v5a2 2 0 0 1-2 2H0v7a1.969 1.969 0 0 0 1.933 2h9.133A1.97 1.97 0 0 0 13 18V6a1.97 1.97 0 0 0-1.934-2Z" />
                        </svg>
                        <span class="text-sm font-medium">Copy</span>
                    </a>
                </li>
            </ul>
        </div>
        <button type="button" data-dial-toggle="speed-dial-menu-dropdown-square"
            aria-controls="speed-dial-menu-dropdown-square" aria-expanded="false"
            class="flex items-center justify-center ml-auto text-white bg-blue-700 rounded-lg w-14 h-14 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 16 3">
                <path
                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
            </svg>
            <span class="sr-only">Open actions menu</span>
        </button>
    </div>


@endsection

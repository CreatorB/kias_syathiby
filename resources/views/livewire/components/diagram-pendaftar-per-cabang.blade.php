<div>
    @push('vendorCSS')
        <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/vendors/css/charts/apexcharts.css') }}">
    @endpush

    @push('pageCSS')
        <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/plugins/charts/chart-apex.css') }}">
    @endpush

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-end">
            <h4 class="card-title">Pendaftar Per Cabang</h4>
            <div class="d-flex align-items-center">
                <span>Tahun {{ $tahunPsb }}</span>
            </div>
        </div>

        <div class="card-body">
            <div id="customer-chart" class="mt-2 mb-1"></div>
            <div class="pt-25">
                @foreach ($santriPerProgram as $santri)
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <i data-feather="stop-circle" class="font-medium-1" style="color:{{ $santri->warna }}"></i>
                        <span class="fw-bold ms-75">{{ $santri->nama_program }}</span>
                    </div>
                    <span>{{ $santri->santri->count() }}</span>
                </div>
                @endforeach

                <br>
                <button class="btn btn-sm btn-primary">
                    <i data-feather='bar-chart-2'></i>
                    Total Pendaftar : {{ $jumlahPendaftar }} Santri
                </button>
            </div>
        </div>
    </div>

    @push('vendorJS')
        <script src="{{ asset('style/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    @endpush

    @push('pageJS')
        <script>
            $(window).on('load', function() {
                'use strict';

                var $textHeadingColor = '#5e5873';
                var $strokeColor = '#ebe9f1';
                var $labelColor = '#e7eef7';
                var $avgSessionStrokeColor2 = '#ebf0f7';
                var $budgetStrokeColor2 = '#dcdae3';
                var $goalStrokeColor2 = '#51e5a8';
                var $revenueStrokeColor2 = '#d0ccff';
                var $textMutedColor = '#b9b9c3';
                var $salesStrokeColor2 = '#df87f2';
                var $white = '#fff';
                var $earningsStrokeColor2 = '#28c76f66';
                var $earningsStrokeColor3 = '#28c76f33';
                var $primaryColor = '#1277BF';
                var $warningColor = '#ff9f43';
                var $dangerColor = '#ea5455';
                var $successColor = '#28c76f';
                var $infoColor = '#00cfe8';
                var $pinkColor = '#ee82ee';
                var $darkColor = '#404040';

                var customerChartOptions;

                var customerChart;

                var $customerChart = document.querySelector('#customer-chart');


                // Customer Chart
                // -----------------------------
                customerChartOptions = {
                    chart: {
                        type: 'pie',
                        height: 325,
                        toolbar: {
                            show: false
                        }
                    },
                    labels: [
                        <?php
                        foreach ($santriPerProgram as $santri) {
                            echo '"' . $santri->nama_program . '",';
                        }
                        ?>
                    ],
                    series:
                    [
                        <?php
                        foreach ($santriPerProgram as $santri) {
                            echo $santri->santri->count() . ',';
                        }
                        ?>
                    ],
                    dataLabels: {
                        enabled: true,
                    },
                    legend: {
                        show: false
                    },
                    stroke: {
                        width: 2
                    },
                    colors: [$primaryColor, $warningColor, $dangerColor, $successColor, $infoColor, $pinkColor, $darkColor]
                };
                customerChart = new ApexCharts($customerChart, customerChartOptions);
                customerChart.render();

            });
        </script>
    @endpush
</div>

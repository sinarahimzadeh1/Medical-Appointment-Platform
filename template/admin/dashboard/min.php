<?php
// 1
$days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];

$reservations = array_fill_keys($days, 0);
foreach ($data as $row) {
    $reservations[$row['week']] = (int) $row['count'];
}

$days_array = array_keys($reservations);
$reservations_array = array_values($reservations);

?>

<script>
    // 1
    var days = <?php echo json_encode($days_array, JSON_UNESCAPED_UNICODE); ?>;
    var reservations = <?php echo json_encode($reservations_array); ?>;
    var options = {
        series: [{
            name: 'تعداد رزرو',
            data: reservations.reverse()
        }],
        chart: {
            type: 'bar',
            height: 240,
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                columnWidth: '40%', 
                borderRadius: 2,  
            }
        },
        xaxis: {
            categories: days.reverse(),
            labels: {
                style: {
                    fontFamily: 'Tahoma',
                    textAlign: 'right',
                    fontSize: '12px', // اندازه فونت کمتر برای زیبایی بیشتر
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontFamily: 'Tahoma',
                    fontSize: '12px', // اندازه فونت کمتر برای زیبایی بیشتر
                }
            }
        },
        tooltip: {
            enabled: true,
        },
        fill: {
            opacity: 0.7, // میزان شفافیت پر شدن هر ستون (به نظر مینیمال‌تر می‌آید)
        }
    };
    var chart = new ApexCharts(document.querySelector("#analytics-bar-chart1"), options);
    chart.render();

</script>



<?php
// 2
$months = [
    1 => 'فروردین',
    2 => 'اردیبهشت',
    3 => 'خرداد',
    4 => 'تیر',
    5 => 'مرداد',
    6 => 'شهریور',
    7 => 'مهر',
    8 => 'آبان',
    9 => 'آذر',
    10 => 'دی',
    11 => 'بهمن',
    12 => 'اسفند'
];
$monthCounts = [
    'فروردین' => 0,
    'اردیبهشت' => 0,
    'خرداد' => 0,
    'تیر' => 0,
    'مرداد' => 0,
    'شهریور' => 0,
    'مهر' => 0,
    'آبان' => 0,
    'آذر' => 0,
    'دی' => 0,
    'بهمن' => 0,
    'اسفند' => 0
];
foreach ($reservedTimes as $row) {
    $date = $row['date'];
    $monthName = getPersianMonthName($date);

    if (isset($monthCounts[$monthName])) {
        $monthCounts[$monthName]++;
    }
}

echo "<script>
    var chartCategories = " . json_encode(array_values($months), JSON_UNESCAPED_UNICODE) . ";
    var chartData = " . json_encode(array_values($monthCounts)) . ";
</script>";
?>
<script>
    // 2
    var options = {
        chart: {
            type: 'bar',
            height: 225,
            toolbar: {
                show: false,
            },
        },
        series: [{
            name: 'گردش مالی',
            data: chartData.reverse()
        }],
        xaxis: {
            categories: chartCategories.reverse(),
            labels: {
                style: {
                    fontFamily: 'iransans',
                    fontSize: '14px'
                }
            }
        },
        colors: ['#7C3AED'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '50%'
            }
        },
        dataLabels: {
            enabled: false
        },
        yaxis: {
            labels: {
                style: {
                    fontFamily: 'Tahoma',
                    fontSize: '12px', // اندازه فونت کمتر برای زیبایی بیشتر
                }
            }
        },
        tooltip: {
            enabled: true,
        },
        fill: {
            opacity: 0.7, // میزان شفافیت پر شدن هر ستون (به نظر مینیمال‌تر می‌آید)
        }
    };

    var chart = new ApexCharts(document.querySelector("#staff_turnover1"), options);
    chart.render();

</script>